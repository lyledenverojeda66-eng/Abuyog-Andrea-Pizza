<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * ADMIN CHATBOT
     * Only authenticated admins may use this endpoint.
     */
    public function adminChat(Request $request): JsonResponse
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'reply' => 'Unauthorized access.',
            ], 403);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $text = $this->normalizeText($validated['message']);

        try {
            // FULL MENU: admins can see unavailable pizzas.
            if ($this->matchesAny($text, [
                'show full menu',
                'full menu',
                'show all pizzas',
                'show all pizza',
                'all pizzas',
                'all pizza',
                'complete menu',
                'entire menu',
                'view full menu',
                'ipakita ang buong menu',
                'ipakita ang lahat ng pizza',
            ])) {
                return $this->pizzaListResponse(
                    Pizza::query()->orderBy('name')->get(),
                    'all',
                    true
                );
            }

            // AVAILABLE PIZZAS
            if ($this->matchesAny($text, [
                'available pizzas',
                'available pizza',
                'show available pizzas',
                'show available pizza',
                'available na pizza',
                'available na pizzas',
                'pizza list',
                'list pizzas',
            ])) {
                return $this->pizzaListResponse(
                    $this->availablePizzas(),
                    'available',
                    true
                );
            }

            // PIZZA PRICES
            if ($this->matchesAny($text, [
                'pizza prices',
                'pizza price',
                'prices',
                'price list',
                'how much',
                'magkano',
                'presyo',
            ])) {
                $pizza = $this->findPizzaMention($text);

                if ($pizza) {
                    return response()->json([
                        'success' => true,
                        'reply' => $this->pizzaReply($pizza),
                    ]);
                }

                $pizzas = Pizza::query()->orderBy('name')->get();

                $lines = $pizzas->map(function (Pizza $pizza) {
                    return $pizza->name . ' - ₱'
                        . number_format((float) $pizza->price, 2)
                        . ' ('
                        . ($this->isAvailable($pizza)
                            ? 'Available'
                            : 'Out of stock')
                        . ')';
                });

                return response()->json([
                    'success' => true,
                    'reply' => $lines->isEmpty()
                        ? 'Wala pang pizza sa menu natin.'
                        : "PIZZA PRICES\n\n" . $lines->implode("\n"),
                ]);
            }

            // GREETING
            if ($this->matchesAny($text, [
                'hi',
                'hello',
                'hey',
                'kamusta',
                'kumusta',
                'good morning',
                'good afternoon',
                'good evening',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Hello, Admin! Ako si Andrea, ang iyong Admin Assistant. Maaari kitang tulungan sa orders, pizza inventory, deliveries, reports, at customer feedback.',
                    'suggestions' => [
                        'Order summary',
                        'Pizza inventory',
                        'Delivery overview',
                        'Sales report',
                        'Customer feedback',
                    ],
                ]);
            }

            // ORDER SUMMARY
            if ($this->matchesAny($text, [
                'order summary',
                'total orders',
                'order overview',
                'how many orders',
                'order statistics',
                'orders',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => "ORDER SUMMARY\n\n"
                        . 'Total orders: ' . Order::count() . "\n"
                        . 'Pending orders: '
                        . Order::where('status', 'pending')->count(),
                    'action' => [
                        'label' => 'View Admin Orders',
                        'url' => route('admin.orders'),
                    ],
                ]);
            }

            // PIZZA INVENTORY
            if ($this->matchesAny($text, [
                'pizza inventory',
                'inventory',
                'stock',
                'pizzas',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => "PIZZA INVENTORY\n\n"
                        . 'Total pizza records: ' . Pizza::count() . "\n"
                        . 'Available pizzas: '
                        . $this->availablePizzas()->count(),
                    'action' => [
                        'label' => 'Manage Pizzas',
                        'url' => route('admin.pizzas'),
                    ],
                ]);
            }

            // DELIVERIES
            if ($this->matchesAny($text, [
                'delivery overview',
                'deliveries',
                'delivery',
                'rider',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Maaari mong tingnan ang delivery status at rider assignments sa Admin Deliveries page.',
                    'action' => [
                        'label' => 'View Deliveries',
                        'url' => route('admin.deliveries'),
                    ],
                ]);
            }

            // SALES REPORT
            if ($this->matchesAny($text, [
                'sales report',
                'sales',
                'revenue',
                'reports',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Buksan ang Admin Reports page para makita ang sales reports.',
                    'action' => [
                        'label' => 'View Reports',
                        'url' => route('admin.reports'),
                    ],
                ]);
            }

            // CUSTOMER FEEDBACK
            if ($this->matchesAny($text, [
                'customer feedback',
                'feedback',
                'complaints',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Buksan ang Admin Feedback page para suriin ang customer feedback at concerns.',
                    'action' => [
                        'label' => 'View Feedback',
                        'url' => route('admin.feedback'),
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'reply' => 'Subukan ang order summary, pizza inventory, deliveries, sales report, customer feedback, Show Full Menu, o Pizza Prices.',
                'suggestions' => [
                    'Order summary',
                    'Pizza inventory',
                    'Delivery overview',
                    'Sales report',
                    'Customer feedback',
                    'Show Full Menu',
                    'Pizza Prices',
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Admin chatbot error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'reply' => 'May temporary problem sa Admin Assistant. Pakisubukan ulit.',
            ], 500);
        }
    }

    /**
     * CUSTOMER CHATBOT
     * Does not provide internal admin reports or stock statistics.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $text = $this->normalizeText($validated['message']);

        // IMPORTANT:
        // Check admin-only requests before menu, prices, and fallback handlers.
        if ($this->matchesAny($text, [
            'order summary',
            'total orders',
            'order overview',
            'how many orders',
            'how many orders do we have',
            'number of orders',
            'order statistics',
            'order count',
            'pizza inventory',
            'inventory',
            'inventory records',
            'stock count',
            'stock levels',
            'sales report',
            'total sales',
            'sales',
            'revenue',
            'customer feedback',
            'feedback',
            'complaints',
            'admin report',
            'admin details',
            'total customers',
            'customer list',
        ])) {
            return response()->json([
                'success' => true,
                'reply' => 'Pasensya na, customer assistant lang ako at hindi ako makakapagpakita ng internal admin reports, order statistics, o inventory records. Maaari kitang tulungan sa menu, prices, ordering, delivery, at payment.',
                'suggestions' => [
                    'Available Pizzas',
                    'Pizza Prices',
                    'How to Order',
                    'Track Order',
                    'Contact Us',
                ],
            ]);
        }

        try {
            // GREETING
            if ($this->matchesAny($text, [
                'hi',
                'hello',
                'hey',
                'kamusta',
                'kumusta',
                'good morning',
                'good afternoon',
                'good evening',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Hi! Welcome sa Abuyog Andrea Pizza! 🍕 Ako si Andrea. Maaari kitang tulungan sa menu, prices, ordering, payment, delivery, at order tracking.',
                    'suggestions' => [
                        'Available Pizzas',
                        'Show Full Menu',
                        'Pizza Prices',
                        'How to Order',
                    ],
                ]);
            }

            // HOW TO ORDER
            // Includes common Filipino and Taglish variations.
            if ($this->matchesAny($text, [
                'how to order',
                'how do i order',
                'how can i order',
                'how can i place an order',
                'how do i place an order',
                'place an order',
                'i want to order',
                'i want to buy pizza',
                'paano umorder',
                'paano mag order',
                'paano magorder',
                'paano mag order ng pizza',
                'paano ako maka order',
                'paano ako makapag order',
                'paano ako makapagorder',
                'paano ako makaka order',
                'paano ako makaka pag order',
                'paano ako maka pag order',
                'paano ako makakapag order',
                'paano ako makakapagorder',
                'paano po ako maka order',
                'paano po ako makapag order',
                'paano po ako maka pag order',
                'paano po mag order',
                'paano ako mag order',
                'paano po umorder',
                'gusto ko umorder',
                'gusto kong umorder',
                'gusto ko mag order',
                'gusto ko ng pizza',
                'gusto kong bumili ng pizza',
                'order now',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => "Madali lang umorder sa Abuyog Andrea Pizza! 🍕\n\n"
                        . "1. Pindutin ang Menu o Order Now.\n"
                        . "2. Piliin ang pizza na available.\n"
                        . "3. Pindutin ang Add to Cart at piliin ang quantity.\n"
                        . "4. Buksan ang Cart at suriin ang items at total.\n"
                        . "5. Mag-checkout at ilagay ang delivery details.\n"
                        . "6. Piliin ang available na payment method.\n"
                        . "7. Suriin ang order details at kumpirmahin ang order.",
                    'action' => [
                        'label' => 'Order Now',
                        'url' => route('menu'),
                    ],
                    'suggestions' => [
                        'Show me the menu',
                        'Pizza Prices',
                        'Payment Options',
                    ],
                ]);
            }

            // CUSTOMER-SAFE FULL MENU
            // Only available pizzas are shown.
            if ($this->matchesAny($text, [
                'full menu',
                'show full menu',
                'show me the menu',
                'show me menu',
                'show all pizza',
                'show all pizzas',
                'all pizzas',
                'all pizza',
                'complete menu',
                'entire menu',
                'lahat ng pizza',
                'lahat ng pizzas',
                'ipakita ang buong menu',
                'ipakita ang lahat ng pizza',
                'view full menu',
            ])) {
                return $this->pizzaListResponse(
                    $this->availablePizzas(),
                    'available',
                    false
                );
            }

            // AVAILABLE PIZZAS
            if ($this->matchesAny($text, [
                'available pizza',
                'available pizzas',
                'show available',
                'show available pizza',
                'show available pizzas',
                'available na pizza',
                'available na pizzas',
                'may available',
                'ano ang available',
                'anong pizza ang available',
                'what pizzas are available',
                'menu',
                'view menu',
                'pizza list',
                'list pizzas',
                'ipakita ang available na pizza',
            ])) {
                return $this->pizzaListResponse(
                    $this->availablePizzas(),
                    'available',
                    false
                );
            }

            // CUSTOMER PRICE LIST
            if ($this->matchesAny($text, [
                'price',
                'prices',
                'pizza price',
                'pizza prices',
                'how much',
                'magkano',
                'presyo',
                'cost',
            ])) {
                $pizza = $this->findAvailablePizzaMention($text);

                if ($pizza) {
                    return response()->json([
                        'success' => true,
                        'reply' => $this->pizzaReply($pizza),
                    ]);
                }

                $pizzas = $this->availablePizzas();

                $lines = $pizzas->map(function (Pizza $pizza) {
                    return $pizza->name . ' — ₱'
                        . number_format((float) $pizza->price, 2);
                });

                return response()->json([
                    'success' => true,
                    'reply' => $lines->isEmpty()
                        ? 'Wala pang available na pizza sa menu natin.'
                        : "Narito ang current prices ng available na pizza:\n"
                            . $lines->implode("\n"),
                ]);
            }

            // SPECIFIC AVAILABLE PIZZA
            $pizza = $this->findAvailablePizzaMention($text);

            if ($pizza) {
                return response()->json([
                    'success' => true,
                    'reply' => $this->pizzaReply($pizza),
                ]);
            }

            // CUSTOMER ORDER TRACKING
            if ($this->matchesAny($text, [
                'track order',
                'track my order',
                'order status',
                'where is my order',
                'status ng order',
                'nasaan ang order',
                'tracking',
            ])) {
                $isCustomer = Auth::check()
                    && Auth::user()->role === 'customer';

                return response()->json([
                    'success' => true,
                    'reply' => $isCustomer
                        ? 'Para makita ang order status mo, buksan ang My Orders.'
                        : 'Mag-login gamit ang customer account para makita at ma-track ang orders mo.',
                    'action' => $isCustomer
                        ? [
                            'label' => 'My Orders',
                            'url' => route('orders'),
                        ]
                        : [
                            'label' => 'Log in',
                            'url' => route('login'),
                        ],
                ]);
            }

            // DELIVERY INFORMATION
            if ($this->matchesAny($text, [
                'delivery',
                'deliver',
                'delivery fee',
                'shipping',
                'rider',
                'nagdedeliver',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Para mag-order for delivery, piliin ang pizza sa Menu at ilagay ang delivery details sa checkout. Tingnan ang order summary para sa applicable delivery fee.',
                ]);
            }

            // PAYMENT INFORMATION
            if ($this->matchesAny($text, [
                'payment',
                'payment options',
                'payment method',
                'how to pay',
                'pay',
                'gcash',
                'cash',
                'cash on delivery',
                'cod',
                'bayad',
                'magbayad',
                'paano magbayad',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Piliin ang payment method na available sa checkout at sundin ang instructions bago kumpletuhin ang payment.',
                ]);
            }

            // STORE LOCATION
            if ($this->matchesAny($text, [
                'location',
                'address',
                'where are you',
                'where is the store',
                'store location',
                'saan kayo',
                'saan ang store',
                'saan located',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => "Makikita mo kami sa P2W6+GXX Andrea's Pizza, Avenida Rizal St, Bito, Abuyog, 6510 Hilagang Leyte.",
                ]);
            }

            // CONTACT AND CUSTOMER CONCERNS
            if ($this->matchesAny($text, [
                'contact',
                'contact us',
                'contact number',
                'customer service',
                'support',
                'concern',
                'concerns',
                'complaint',
                'help',
                'tulong',
                'problema',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'May concern ka? Pumunta sa Contact page para makipag-ugnayan sa amin.',
                    'action' => [
                        'label' => 'Contact Us',
                        'url' => route('contact'),
                    ],
                ]);
            }

            // THANK YOU
            if ($this->matchesAny($text, [
                'thank you',
                'thanks',
                'salamat',
            ])) {
                return response()->json([
                    'success' => true,
                    'reply' => 'You’re welcome! Salamat sa pagbisita sa Abuyog Andrea Pizza. Enjoy your pizza! 🍕',
                ]);
            }

            // DEFAULT REPLY
            return response()->json([
                'success' => true,
                'reply' => 'Hi! 🍕 Ako si Andrea. Maaari kitang tulungan sa menu, prices, ordering, delivery, payment, at order tracking.',
                'suggestions' => [
                    'Available Pizzas',
                    'Show Full Menu',
                    'Pizza Prices',
                    'How to Order',
                    'Track Order',
                    'Contact Us',
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot message error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'reply' => 'Sorry, nagkaroon ng temporary problem. Pakisubukan ulit.',
            ], 500);
        }
    }

    /**
     * PUBLIC MENU API
     * Only available pizzas are returned.
     */
    public function menu(Request $request): JsonResponse
    {
        try {
            $pizzas = $this->availablePizzas();

            return response()->json([
                'success' => true,
                'pizzas' => $pizzas
                    ->map(fn (Pizza $pizza) => $this->formatPublicPizza($pizza))
                    ->values(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot menu error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'pizzas' => [],
                'message' => 'Unable to load the menu right now.',
            ], 500);
        }
    }

    /**
     * CUSTOMER ORDER TRACKING API
     * Customers can track their own orders only.
     */
    public function trackOrder(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'reply' => 'Mag-login muna para ma-track ang order mo.',
                'login_url' => route('login'),
            ], 401);
        }

        if (Auth::user()->role !== 'customer') {
            return response()->json([
                'success' => false,
                'reply' => 'Customer accounts only.',
            ], 403);
        }

        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:100'],
        ]);

        try {
            $order = Order::query()
                ->where('order_number', trim($validated['order_number']))
                ->where('user_id', Auth::id())
                ->with(['delivery', 'payment'])
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'reply' => 'Hindi namin makita ang order na iyon sa account mo. Pakitingnan ang order number at subukan ulit.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'reply' => 'Nahanap namin ang order mo!',
                'order' => [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'total_amount' => (float) $order->total_amount,
                    'payment_status' => optional($order->payment)->status ?? 'pending',
                    'delivery_status' => optional($order->delivery)->status,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot tracking error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'reply' => 'Hindi makuha ang tracking information ngayon. Pakisubukan ulit.',
            ], 500);
        }
    }

    /**
     * FORMAT PIZZA LIST RESPONSE
     */
    private function pizzaListResponse(
        $pizzas,
        string $type,
        bool $isAdmin = false
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'reply' => $pizzas->isEmpty()
                ? 'Wala pang pizza na maipapakita sa menu natin.'
                : ($type === 'all' && $isAdmin
                    ? 'Narito ang buong pizza menu natin, kasama ang out-of-stock na pizza.'
                    : 'Narito ang mga available na pizza! Pili ka lang ng favorite mo. 🍕'),
            'pizzas' => $pizzas
                ->map(fn (Pizza $pizza) => $isAdmin
                    ? $this->formatAdminPizza($pizza)
                    : $this->formatPublicPizza($pizza))
                ->values(),
            'menu_type' => $type,
        ]);
    }

    /**
     * GET AVAILABLE PIZZAS
     */
    private function availablePizzas()
    {
        return Pizza::query()
            ->where('status', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();
    }

    /**
     * CHECK AVAILABILITY
     */
    private function isAvailable(Pizza $pizza): bool
    {
        return (bool) $pizza->status && (int) $pizza->stock > 0;
    }

    /**
     * PUBLIC PIZZA FORMAT
     * No exact stock count is returned.
     */
    private function formatPublicPizza(Pizza $pizza): array
    {
        return [
            'id' => $pizza->id,
            'name' => $pizza->name,
            'description' => $pizza->description,
            'price' => (float) $pizza->price,
            'image_url' => $this->getPizzaImageUrl($pizza->image),
            'available' => $this->isAvailable($pizza),
        ];
    }

    /**
     * ADMIN PIZZA FORMAT
     */
    private function formatAdminPizza(Pizza $pizza): array
    {
        return [
            'id' => $pizza->id,
            'name' => $pizza->name,
            'description' => $pizza->description,
            'price' => (float) $pizza->price,
            'image_url' => $this->getPizzaImageUrl($pizza->image),
            'stock' => (int) $pizza->stock,
            'available' => $this->isAvailable($pizza),
            'status' => $this->isAvailable($pizza)
                ? 'Available'
                : 'Out of stock',
        ];
    }

    /**
     * FIND PIZZA IMAGE
     */
    private function getPizzaImageUrl(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        $filename = basename(str_replace('\\', '/', $image));
        $path = public_path('image/pizzas/' . $filename);

        if (!is_file($path)) {
            Log::warning('Chatbot pizza image missing', [
                'image' => $filename,
                'path' => $path,
            ]);

            return null;
        }

        return asset('image/pizzas/' . rawurlencode($filename));
    }

    /**
     * FIND A PIZZA BY NAME FOR ADMIN USE.
     */
    private function findPizzaMention(string $text): ?Pizza
    {
        $pizzas = Pizza::query()
            ->orderByRaw('LENGTH(name) DESC')
            ->get();

        foreach ($pizzas as $pizza) {
            $name = $this->normalizeText($pizza->name);

            if ($name !== '' && str_contains($text, $name)) {
                return $pizza;
            }
        }

        return null;
    }

    /**
     * FIND ONLY AVAILABLE PIZZAS FOR CUSTOMER MESSAGES.
     */
    private function findAvailablePizzaMention(string $text): ?Pizza
    {
        $pizzas = $this->availablePizzas()
            ->sortByDesc(fn (Pizza $pizza) => mb_strlen($pizza->name));

        foreach ($pizzas as $pizza) {
            $name = $this->normalizeText($pizza->name);

            if ($name !== '' && str_contains($text, $name)) {
                return $pizza;
            }
        }

        return null;
    }

    /**
     * SINGLE PIZZA RESPONSE
     */
    private function pizzaReply(Pizza $pizza): string
    {
        return $pizza->name . ' ay ₱'
            . number_format((float) $pizza->price, 2)
            . '. '
            . ($this->isAvailable($pizza)
                ? 'Available ngayon.'
                : 'Out of stock sa ngayon.');
    }

    /**
     * NORMALIZE USER INPUT
     */
    private function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);

        $text = str_replace(
            ['&', '-', '_'],
            [' and ', ' ', ' '],
            $text
        );

        $text = preg_replace(
            '/[^\p{L}\p{N}\s]/u',
            ' ',
            $text
        ) ?? $text;

        return trim(
            preg_replace('/\s+/u', ' ', $text) ?? $text
        );
    }

    /**
     * CHECK WHETHER MESSAGE CONTAINS A PHRASE.
     */
    private function matchesAny(string $text, array $phrases): bool
    {
        foreach ($phrases as $phrase) {
            $phrase = $this->normalizeText($phrase);

            if (
                $phrase !== ''
                && preg_match(
                    '/(^|\s)' . preg_quote($phrase, '/') . '($|\s)/u',
                    $text
                )
            ) {
                return true;
            }
        }

        return false;
    }
}
