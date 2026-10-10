<?php
    $chatbotIsAdmin = auth()->check()
        && strtolower((string) auth()->user()->role) === 'admin';
?>

<div
    id="andrea-chatbot"
    data-chatbot-role="<?php echo e($chatbotIsAdmin ? 'admin' : 'customer'); ?>"
>
    <button
        type="button"
        id="chatbot-toggle"
        aria-label="Open Andrea chat"
        aria-expanded="false"
    >
        💬 <span>Ask Andrea</span>
    </button>

    <section id="chatbot-window" aria-label="Andrea Assistant" hidden>
        <header class="chat-header">
            <div class="chat-avatar">🍕</div>

            <div class="chat-heading">
                <strong><?php echo e($chatbotIsAdmin ? 'Andrea Admin Assistant' : 'Andrea Assistant'); ?></strong>
                <small>Abuyog Andrea Pizza</small>
                <span>● Ready to help</span>
            </div>

            <button type="button" id="chatbot-close" aria-label="Close chat">
                ×
            </button>
        </header>

        <div id="chatbot-messages" aria-live="polite">
            <div class="chat-message bot chatbot-welcome">
                <?php if($chatbotIsAdmin): ?>
                    <strong>Hi, Admin! 🍕</strong>
                    <p>
                        Maaari kitang tulungan sa order summary, pizza inventory,
                        sales report, deliveries, at customer feedback.
                    </p>
                <?php else: ?>
                    <strong>Hi! Welcome sa Abuyog Andrea Pizza! 🍕</strong>
                    <p>
                        Ako si Andrea. Maaari kitang tulungan sa menu, prices,
                        ordering, payment, delivery, at order tracking.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="chat-quick-actions">
            <?php if($chatbotIsAdmin): ?>
                <button type="button" data-message="Order Summary">📊 Orders</button>
                <button type="button" data-message="Pizza Inventory">📦 Inventory</button>
                <button type="button" data-message="Sales Report">💰 Sales</button>
                <button type="button" data-message="Show Deliveries">🚚 Deliveries</button>
                <button type="button" data-message="Customer Feedback">⭐ Feedback</button>
            <?php else: ?>
                <button type="button" data-action="available">🍕 Available pizzas</button>
                <button type="button" data-action="menu">📋 Full menu</button>
                <button type="button" data-action="track">📦 Track my order</button>
                <button type="button" data-action="faq">❓ FAQs</button>
                <button type="button" data-action="support">☎️ Support</button>
            <?php endif; ?>
        </div>

        <form id="chatbot-form">
            <input
                type="text"
                id="chatbot-input"
                placeholder="Type your message..."
                maxlength="1000"
                autocomplete="off"
                required
            >
            <button type="submit" id="chatbot-send" aria-label="Send message">
                ➤
            </button>
        </form>

        <div class="chat-disclaimer">
            Responses are based on available system records.
        </div>
    </section>
</div>

<style>
#andrea-chatbot {
    --green: #16834a;
    --green-dark: #116638;
    --green-light: #eaf8ef;
    --border: #dce9df;
    font-family: Arial, Helvetica, sans-serif;
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 99999;
}

#andrea-chatbot *,
#andrea-chatbot *::before,
#andrea-chatbot *::after {
    box-sizing: border-box;
}

#chatbot-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-left: auto;
    padding: 14px 20px;
    border: 0;
    border-radius: 30px;
    background: var(--green);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    box-shadow: 0 5px 20px #0003;
    cursor: pointer;
}

#chatbot-toggle:hover,
#chatbot-send:hover {
    background: var(--green-dark);
}

#chatbot-window {
    position: absolute;
    right: 0;
    bottom: 70px;
    display: flex;
    flex-direction: column;
    width: 370px;
    height: 590px;
    max-height: calc(100dvh - 115px);
    overflow: hidden;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: 0 12px 45px #0002;
}

#chatbot-window[hidden] {
    display: none !important;
}

.chat-header {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 15px;
    color: #fff;
    background: linear-gradient(135deg, #16834a, #116638);
    flex-shrink: 0;
}

.chat-avatar {
    display: grid;
    place-items: center;
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #fff;
    font-size: 24px;
}

.chat-heading {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 4px;
}

.chat-heading strong {
    font-size: 15px;
}

.chat-heading small,
.chat-heading span {
    font-size: 11px;
}

#chatbot-close {
    padding: 0 5px;
    border: 0;
    background: transparent;
    color: #fff;
    font-size: 29px;
    cursor: pointer;
}

#chatbot-messages {
    flex: 1;
    min-height: 0;
    padding: 10px;
    overflow-y: auto;
    background: #f6faf7;
}

.chat-message {
    width: fit-content;
    max-width: 94%;
    margin-bottom: 8px;
    padding: 9px 11px;
    border-radius: 14px;
    font-size: 13px;
    line-height: 1.5;
    overflow-wrap: anywhere;
    white-space: pre-wrap;
}

.chat-message.bot {
    color: #26372c;
    background: #fff;
    border: 1px solid #e3eee6;
    border-bottom-left-radius: 4px;
}

.chat-message.user {
    margin-left: auto;
    color: #fff;
    background: var(--green);
    border-bottom-right-radius: 4px;
}

.chat-message.error {
    color: #9a2525;
    border-color: #f2caca;
}

.chatbot-welcome {
    display: block;
    width: fit-content;
    max-width: 94%;
    white-space: normal;
}

.chatbot-welcome strong {
    display: block;
    margin-bottom: 4px;
}

.chatbot-welcome p {
    margin: 4px 0 0;
}

.chat-quick-actions {
    display: flex;
    flex-shrink: 0;
    flex-wrap: nowrap;
    gap: 7px;
    padding: 8px;
    overflow-x: auto;
    background: #fff;
    border-top: 1px solid #eef2ef;
}

.chat-quick-actions button {
    flex-shrink: 0;
    padding: 7px 9px;
    border: 1px solid #b9dfc6;
    border-radius: 20px;
    color: var(--green-dark);
    background: var(--green-light);
    font-size: 11px;
    cursor: pointer;
}

#chatbot-form {
    display: flex;
    flex-shrink: 0;
    gap: 8px;
    padding: 9px;
    background: #fff;
    border-top: 1px solid #e6eee8;
}

#chatbot-input {
    min-width: 0;
    flex: 1;
    padding: 11px 13px;
    border: 1px solid #d5e3d9;
    border-radius: 22px;
    outline: none;
    font-size: 13px;
}

#chatbot-send {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border: 0;
    border-radius: 50%;
    background: var(--green);
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}

#chatbot-send:disabled {
    opacity: .55;
    cursor: wait;
}

.chat-disclaimer {
    flex-shrink: 0;
    padding: 0 8px 8px;
    text-align: center;
    color: #7a877e;
    background: #fff;
    font-size: 10px;
}

.pizza-card-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
    width: 100%;
    margin: 7px 0 12px;
}

.pizza-card {
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: 13px;
    background: #fff;
}

.pizza-card img {
    display: block;
    width: 100%;
    height: 135px;
    object-fit: cover;
}

.pizza-card-content {
    padding: 10px;
}

.pizza-card-name {
    margin: 0 0 5px;
    color: var(--green-dark);
    font-size: 14px;
}

.pizza-card-price {
    margin-bottom: 6px;
    color: #202820;
    font-size: 17px;
    font-weight: 700;
}

.support-links {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 10px;
}

.support-links a {
    display: inline-block;
    padding: 8px 11px;
    border-radius: 8px;
    color: #fff;
    background: var(--green);
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
}

@media (max-width: 480px) {
    #andrea-chatbot {
        right: 12px;
        bottom: 12px;
    }

    #chatbot-window {
        position: fixed;
        right: 8px;
        bottom: 78px;
        width: calc(100vw - 16px);
        height: min(600px, calc(100dvh - 100px));
        max-height: calc(100dvh - 100px);
    }

    #chatbot-toggle {
        padding: 12px 16px;
    }
}
</style>

<script>
(function () {
    const root = document.getElementById('andrea-chatbot');

    if (!root || root.dataset.initialized === 'true') {
        return;
    }

    root.dataset.initialized = 'true';

    const isAdmin = root.dataset.chatbotRole === 'admin';
    const isLoggedIn = <?php echo json_encode(auth()->check(), 15, 512) ?>;

    const routes = {
        customerMessage: <?php echo json_encode(route('chatbot.message'), 15, 512) ?>,
        adminMessage: <?php echo json_encode(route('admin.chatbot.message'), 15, 512) ?>,
        menu: <?php echo json_encode(route('chatbot.menu'), 15, 512) ?>,
        tracking: <?php echo json_encode(route('chatbot.track-order'), 15, 512) ?>,
        menuPage: <?php echo json_encode(route('menu'), 15, 512) ?>,
        ordersPage: <?php echo json_encode(route('orders'), 15, 512) ?>,
        contactPage: <?php echo json_encode(route('contact'), 15, 512) ?>,
        loginPage: <?php echo json_encode(route('login'), 15, 512) ?>
    };

    const csrfToken = <?php echo json_encode(csrf_token(), 15, 512) ?>;

    const toggle = root.querySelector('#chatbot-toggle');
    const windowEl = root.querySelector('#chatbot-window');
    const closeButton = root.querySelector('#chatbot-close');
    const messages = root.querySelector('#chatbot-messages');
    const form = root.querySelector('#chatbot-form');
    const input = root.querySelector('#chatbot-input');
    const sendButton = root.querySelector('#chatbot-send');

    let busy = false;
    let trackingMode = false;

    function openChat() {
        windowEl.hidden = false;
        toggle.setAttribute('aria-expanded', 'true');
        input.focus();
    }

    function closeChat() {
        windowEl.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
    }

    function normalizeText(value) {
        return String(value || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^\p{L}\p{N}\s&-]/gu, ' ')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function addMessage(text, type = 'bot') {
        const bubble = document.createElement('div');
        bubble.className = 'chat-message ' + type;
        bubble.textContent = String(text || '');
        messages.appendChild(bubble);
        messages.scrollTop = messages.scrollHeight;
        return bubble;
    }

    function addSupportLinks(links) {
        const wrapper = document.createElement('div');
        wrapper.className = 'support-links';

        links.forEach(function (item) {
            const link = document.createElement('a');
            link.href = item.url;
            link.textContent = item.label;
            wrapper.appendChild(link);
        });

        messages.appendChild(wrapper);
        messages.scrollTop = messages.scrollHeight;
    }

    /*
     * Important: route admin commands before customer shortcuts.
     * The backend must still enforce admin authorization.
     */
    function isAdminCommand(text) {
        const normalized = normalizeText(text);

        const patterns = [
            /\b(order summary|total orders|order overview|order statistics|order count|number of orders|how many orders)\b/,
            /\b(pizza inventory|show inventory|inventory records|inventory|stock count|stock levels|available stock)\b/,
            /\b(sales report|show sales report|total sales|revenue)\b/,
            /\b(customer feedback|show feedback|complaints)\b/,
            /\b(delivery overview|show deliveries|deliveries|rider assignments)\b/,
            /\b(admin dashboard|admin orders|admin menu)\b/
        ];

        return patterns.some(function (pattern) {
            return pattern.test(normalized);
        });
    }

    function isAdminGreeting(text) {
        const normalized = normalizeText(text);

        return /\b(hi|hello|hey)\b/.test(normalized)
            && /\b(admin|chatbot|assistant)\b/.test(normalized);
    }

    async function sendToChatbot(message, adminRequest = false) {
        const endpoint = adminRequest
            ? routes.adminMessage
            : routes.customerMessage;

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.reply || data.message || 'Hindi makuha ang sagot. Pakisubukan ulit.'
            );
        }

        if (data.reply) {
            addMessage(data.reply);
        }

        if (data.action && data.action.url) {
            addSupportLinks([data.action]);
        }

        if (Array.isArray(data.actions) && data.actions.length) {
            addSupportLinks(data.actions);
        }

        return data;
    }

    async function showPizzaCards(availableOnly = false) {
        const loading = addMessage('Loading pizza menu...');

        try {
            const url = new URL(routes.menu, window.location.origin);

            if (!availableOnly) {
                url.searchParams.set('all', '1');
            }

            const response = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();

            if (!response.ok || !Array.isArray(data.pizzas)) {
                throw new Error(data.message || 'Hindi ma-load ang menu.');
            }

            loading.remove();

            let pizzas = data.pizzas;

            if (availableOnly) {
                pizzas = pizzas.filter(function (pizza) {
                    if (typeof pizza.available === 'boolean') {
                        return pizza.available;
                    }

                    return Number(pizza.stock) > 0
                        && !['inactive', 'unavailable', 'out of stock', '0', 'false']
                            .includes(String(pizza.status || '').toLowerCase());
                });
            }

            if (!pizzas.length) {
                addMessage('Walang available na pizza sa ngayon.');
                return;
            }

            const list = document.createElement('div');
            list.className = 'pizza-card-list';

            pizzas.forEach(function (pizza) {
                const card = document.createElement('article');
                card.className = 'pizza-card';

                if (pizza.image_url) {
                    const image = document.createElement('img');
                    image.src = pizza.image_url;
                    image.alt = pizza.name || 'Pizza';
                    image.loading = 'lazy';
                    image.onerror = function () {
                        image.remove();
                    };
                    card.appendChild(image);
                }

                const content = document.createElement('div');
                content.className = 'pizza-card-content';

                const name = document.createElement('h4');
                name.className = 'pizza-card-name';
                name.textContent = '🍕 ' + (pizza.name || 'Pizza');

                const price = document.createElement('div');
                price.className = 'pizza-card-price';

                const amount = Number(pizza.price);
                price.textContent = '₱' + (
                    Number.isFinite(amount) ? amount : 0
                ).toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                const orderLink = document.createElement('a');
                orderLink.className = 'support-links';
                orderLink.href = routes.menuPage;
                orderLink.textContent = 'Order Now →';

                content.append(name, price, orderLink);
                card.appendChild(content);
                list.appendChild(card);
            });

            messages.appendChild(list);
            messages.scrollTop = messages.scrollHeight;
        } catch (error) {
            if (loading.parentNode) {
                loading.remove();
            }

            addMessage(error.message || 'May problema sa pag-load ng menu.', 'error');
        }
    }

    async function trackOrder(orderNumber = '') {
        if (!isLoggedIn) {
            addMessage('Mag-login muna para ma-track ang order mo.');
            addSupportLinks([{ label: 'Log in', url: routes.loginPage }]);
            trackingMode = false;
            return;
        }

        if (!orderNumber) {
            trackingMode = true;
            input.placeholder = 'Enter your order number...';
            addMessage('Ilagay ang order number mo para ma-check ang status.');
            input.focus();
            return;
        }

        const waiting = addMessage('Checking your order...');
        busy = true;
        sendButton.disabled = true;

        try {
            const response = await fetch(routes.tracking, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ order_number: orderNumber })
            });

            const data = await response.json();
            waiting.remove();

            if (!response.ok) {
                throw new Error(data.reply || data.message || 'Hindi mahanap ang order.');
            }

            if (data.reply) {
                addMessage(data.reply);
            } else if (data.order) {
                addMessage(
                    'Order #: ' + (data.order.order_number || orderNumber)
                    + '\nStatus: ' + (data.order.status || 'Pending')
                );
            }

            addSupportLinks([
                { label: 'View my orders', url: routes.ordersPage }
            ]);
        } catch (error) {
            if (waiting.parentNode) {
                waiting.remove();
            }

            addMessage(error.message || 'Hindi ma-track ang order.', 'error');
        } finally {
            busy = false;
            sendButton.disabled = false;
            trackingMode = false;
            input.placeholder = 'Type your message...';
        }
    }

    async function handleMessage(message) {
        const normalized = normalizeText(message);

        /*
         * This must run before menu, prices, delivery, and greeting
         * shortcuts so that admin commands use the admin endpoint.
         */
        if (isAdmin && (isAdminCommand(normalized) || isAdminGreeting(normalized))) {
            await sendToChatbot(message, true);
            return;
        }

        if (!isAdmin && isAdminCommand(normalized)) {
            addMessage(
                'Pasensya na, para lamang sa admin ang inventory, sales report, order summary, deliveries, at admin feedback.'
            );
            return;
        }

        if (
            /\b(show full menu|full menu|show menu|available pizzas|available pizza|menu|lahat ng pizza)\b/
                .test(normalized)
        ) {
            await showPizzaCards(
                /\b(available pizzas|available pizza)\b/.test(normalized)
            );
            return;
        }

        if (
            /\b(track my order|track order|order tracking|track my order status)\b/
                .test(normalized)
        ) {
            await trackOrder('');
            return;
        }

        if (/\b(faq|faqs|frequently asked questions)\b/.test(normalized)) {
            addMessage(
                'FAQs\n\n'
                + '🍕 Menu: Piliin ang Full Menu o Available Pizzas.\n'
                + '🛒 Ordering: Pumunta sa Menu, piliin ang pizza, at mag-checkout.\n'
                + '💳 Payment: Sundin ang payment options sa checkout.\n'
                + '📦 Tracking: Mag-login at ilagay ang order number.\n'
                + '☎️ Support: Buksan ang Contact page.'
            );

            addSupportLinks([
                { label: 'Menu', url: routes.menuPage },
                { label: 'Contact Us', url: routes.contactPage }
            ]);
            return;
        }

        await sendToChatbot(message, false);
    }

    async function submitMessage(message) {
        const text = String(message || '').trim();

        if (!text || busy) {
            return;
        }

        openChat();
        addMessage(text, 'user');

        const waiting = addMessage('Sandali lang, naghahanda ako ng sagot...');
        busy = true;
        sendButton.disabled = true;

        try {
            await handleMessage(text);
        } catch (error) {
            addMessage(error.message || 'May problema sa chatbot.', 'error');
        } finally {
            if (waiting.parentNode) {
                waiting.remove();
            }

            busy = false;
            sendButton.disabled = false;
            input.value = '';
            input.placeholder = 'Type your message...';
            input.focus();
        }
    }

    toggle.addEventListener('click', function () {
        if (windowEl.hidden) {
            openChat();
        } else {
            closeChat();
        }
    });

    closeButton.addEventListener('click', closeChat);

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const value = input.value.trim();

        if (!value || busy) {
            return;
        }

        if (trackingMode) {
            addMessage(value, 'user');
            input.value = '';
            trackOrder(value);
            return;
        }

        submitMessage(value);
    });

    root.querySelectorAll('[data-action]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (busy) {
                return;
            }

            const action = button.dataset.action;

            if (action === 'available') {
                addMessage('Ipakita ang available na pizza.', 'user');
                showPizzaCards(true);
            } else if (action === 'menu') {
                addMessage('Ipakita ang buong menu.', 'user');
                showPizzaCards(false);
            } else if (action === 'track') {
                addMessage('Track my order.', 'user');
                trackOrder('');
            } else if (action === 'faq') {
                addMessage('FAQs', 'user');
                submitMessage('FAQs');
            } else if (action === 'support') {
                addMessage('Customer support', 'user');
                addSupportLinks([
                    { label: 'Contact Us', url: routes.contactPage }
                ]);
            }
        });
    });

    root.querySelectorAll('[data-message]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!busy) {
                submitMessage(button.dataset.message);
            }
        });
    });
})();
</script><?php /**PATH C:\xampp\htdocs\abuyog-andrea-pizza\resources\views/partials/chatbot.blade.php ENDPATH**/ ?>