
{{-- resources/views/orders/live-tracking.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Live Rider Tracking | Abuyog Andrea Pizza</title>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        :root {
            --red: #ed1c24;
            --cream: #fff8ee;
            --muted: #6b7280;
            --border: #eee5dc;
            --green: #168447;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: #252525;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        /* Phone-sized page */
        .tracking-page {
            width: 100%;
            max-width: 430px;
            margin: 12px auto 24px;
            padding: 10px;
        }

        .tracking-header {
            margin-bottom: 12px;
        }

        .tracking-header h1 {
            margin: 0 0 6px;
            font-size: 22px;
            line-height: 1.3;
            font-weight: 800;
        }

        .tracking-header p {
            margin: 0 0 10px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .tracking-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 10px;
            align-items: start;
        }

        .card {
            min-width: 0;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 11px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .035);
        }

        .card-heading {
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        .card-heading h2 {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
        }

        .card-heading p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        #trackingMap {
            width: 100%;
            height: 230px;
            background: #e9e9e9;
            z-index: 1;
        }

        .map-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 9px 12px;
            padding: 10px 12px;
            font-size: 10px;
            line-height: 1.4;
            border-bottom: 1px solid var(--border);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            flex: 0 0 9px;
            border-radius: 50%;
        }

        .legend-rider {
            background: var(--green);
        }

        .legend-customer {
            background: var(--red);
        }

        /* Delivery proof photo */
        .proof-section {
            padding: 12px;
            border-top: 1px solid var(--border);
            background: #fff;
        }

        .proof-section h2 {
            margin: 0 0 6px;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 800;
        }

        .proof-description {
            margin: 0 0 10px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .proof-image-link {
            display: block;
            width: 100%;
            max-width: 100%;
        }

        .proof-image {
            display: block;
            width: 100%;
            max-width: 100%;
            max-height: 220px;
            object-fit: contain;
            object-position: center;
            background: #f8f8f8;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .proof-placeholder {
            padding: 12px;
            border: 1px dashed #d6d3d1;
            border-radius: 8px;
            background: #fafaf9;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        /* Order information */
        .details-card {
            padding: 12px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 100%;
            padding: 6px 9px;
            border-radius: 20px;
            background: #fff0d5;
            color: #8a5200;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            overflow-wrap: anywhere;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            flex: 0 0 7px;
            border-radius: 50%;
            background: #e99a00;
        }

        .order-number {
            margin: 11px 0 4px;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .muted {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .location-block {
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
        }

        .location-block:last-of-type {
            border-bottom: 0;
        }

        .location-title {
            margin: 0 0 5px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .location-address {
            margin: 0;
            color: #424242;
            font-size: 12px;
            line-height: 1.55;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .coordinates {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .last-updated {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            background: #f8f8f8;
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .last-updated strong {
            display: block;
            margin-bottom: 3px;
        }

        .tracking-message {
            margin-top: 9px;
            padding: 10px;
            border-radius: 8px;
            background: #f5f5f5;
            color: #444;
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .tracking-message.error {
            background: #fff0f0;
            color: #a5161c;
        }

        .tracking-message.success {
            background: #eaf8ef;
            color: #176b36;
        }

        .action-button,
        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            background: #16a34a;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            transition: background .2s ease;
            cursor: pointer;
        }

        .back-btn {
            margin-bottom: 10px;
        }

        .action-button {
            display: flex;
            width: 100%;
            margin-top: 12px;
            text-align: center;
        }

        .action-button:hover,
        .back-btn:hover {
            background: #15803d;
            color: #fff;
        }

        .back-btn span {
            font-size: 16px;
            line-height: 1;
        }

        .refresh-note {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
            text-align: center;
        }

        @media (max-width: 480px) {
            .tracking-page {
                width: 100%;
                max-width: 430px;
                margin: 8px auto 18px;
                padding: 9px;
            }

            #trackingMap {
                height: 215px;
            }

            .tracking-header h1 {
                font-size: 21px;
            }

            .card-heading,
            .details-card,
            .proof-section {
                padding: 11px;
            }

            .leaflet-control-attribution {
                font-size: 8px !important;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    @php
        $delivery = $order->delivery;
        $proofPhoto = $delivery?->proof_photo;

        $proofPhotoUrl = $proofPhoto
            ? asset('storage/' . ltrim($proofPhoto, '/'))
            : null;
    @endphp

    <main class="tracking-page">

        <header class="tracking-header">

            <a href="{{ route('orders') }}" class="back-btn">
                <span>←</span>
                Back to My Orders
            </a>

            <h1>📍 Live Rider Tracking</h1>

            <p>
                Track your rider's current location and view your order's
                delivery destination and proof of delivery.
            </p>
        </header>

        <div class="tracking-grid">

            {{-- MAP AND DELIVERY PROOF --}}
            <section class="card">

                <div class="card-heading">
                    <h2>Delivery Map</h2>
                    <p>
                        The rider's location updates automatically when
                        new GPS coordinates are available.
                    </p>
                </div>

                <div id="trackingMap"></div>

                <div class="map-legend">
                    <div class="legend-item">
                        <span class="legend-dot legend-rider"></span>
                        Rider's Current Location
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot legend-customer"></span>
                        Delivery Destination
                    </div>
                </div>

                <div class="proof-section">

                    <h2>Delivery Proof Photo</h2>

                    <p class="proof-description">
                        This photo is provided by your rider as proof
                        that your order was delivered.
                        Click the image to view it in full size.
                    </p>

                    @if ($proofPhotoUrl)
                        <a
                            href="{{ $proofPhotoUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="proof-image-link"
                        >
                            <img
                                src="{{ $proofPhotoUrl }}"
                                alt="Proof of Delivery for Order {{ $order->order_number ?? $order->id }}"
                                class="proof-image"
                                loading="lazy"
                                onerror="this.style.display='none'; this.parentElement.nextElementSibling.style.display='block';"
                            >
                        </a>

                        <div class="proof-placeholder" style="display:none;">
                            The delivery proof photo could not be loaded.
                            Please try again later or contact customer support.
                        </div>
                    @else
                        <div class="proof-placeholder">
                            @if (($order->status ?? '') === 'delivered')
                                The delivery proof photo is not available.
                                Please contact customer support if you need
                                assistance.
                            @else
                                The delivery proof photo will appear here
                                after your rider completes the delivery
                                and uploads the photo.
                            @endif
                        </div>
                    @endif

                </div>
            </section>

            {{-- DELIVERY INFORMATION --}}
            <aside class="card">

                <div class="card-heading">
                    <h2>Delivery Information</h2>
                    <p>Order details and delivery location.</p>
                </div>

                <div class="details-card">

                    <span class="status-pill">
                        <span class="status-dot"></span>
                        {{ ucwords(str_replace('_', ' ', $order->status ?? 'processing')) }}
                    </span>

                    <div class="order-number">
                        {{ $order->order_number ?? ('Order #' . $order->id) }}
                    </div>

                    <p class="muted">
                        Order ID: {{ $order->id }}
                    </p>

                    <div class="location-block">
                        <p class="location-title">Delivery Address</p>

                        <p class="location-address" id="customerAddress">
                            {{ $order->delivery_address ?? 'No delivery address provided.' }}
                        </p>

                        <p class="coordinates" id="customerCoordinates">
                            Searching for delivery address...
                        </p>
                    </div>

                    <div class="location-block">
                        <p class="location-title">Rider</p>

                        <p class="location-address" id="riderName">
                            Loading rider information...
                        </p>
                    </div>

                    <div class="location-block">
                        <p class="location-title">Rider's Current Location</p>

                        <p class="location-address" id="riderCurrentLocation">
                            Waiting for GPS location...
                        </p>

                        <p class="coordinates" id="riderCoordinates"></p>
                    </div>

                    <div class="last-updated">
                        <strong>Last GPS Update</strong>
                        <span id="lastUpdated">Waiting for rider GPS...</span>
                    </div>

                    <div
                        class="tracking-message"
                        id="trackingMessage"
                        role="status"
                        aria-live="polite"
                    >
                        Connecting to rider location...
                    </div>

                    <p class="refresh-note">
                        Automatic refresh every 10 seconds
                    </p>

                </div>
            </aside>

        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locationUrl = @json(
                route('orders.live-location', ['orderId' => $order->id])
            );

            const customerAddress = @json($order->delivery_address ?? '');

            const messageElement =
                document.getElementById('trackingMessage');

            const updatedElement =
                document.getElementById('lastUpdated');

            const riderNameElement =
                document.getElementById('riderName');

            const riderPlaceElement =
                document.getElementById('riderCurrentLocation');

            const riderCoordinatesElement =
                document.getElementById('riderCoordinates');

            const customerCoordinatesElement =
                document.getElementById('customerCoordinates');

            if (typeof L === 'undefined') {
                messageElement.textContent =
                    'The map could not be loaded. Please check your internet connection.';

                messageElement.classList.add('error');
                return;
            }

            const map = L.map('trackingMap')
                .setView([10.747, 125.010], 13);

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            const riderIcon = L.divIcon({
                className: '',
                html: '<div style="width:30px;height:30px;background:#168447;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px #888;display:flex;align-items:center;justify-content:center;font-size:16px;">🛵</div>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            const customerIcon = L.divIcon({
                className: '',
                html: '<div style="width:28px;height:28px;background:#ed1c24;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px #888;display:flex;align-items:center;justify-content:center;font-size:14px;">🏠</div>',
                iconSize: [28, 28],
                iconAnchor: [14, 14]
            });

            let riderMarker = null;
            let customerMarker = null;
            let routeLine = null;
            let riderPosition = null;
            let customerPosition = null;
            let mapHasFitted = false;
            let requestInProgress = false;
            let lastGeocodeTime = 0;
            let lastGeocodePosition = null;

            async function geocodeAddress(address) {
                if (!address || !address.trim()) {
                    return null;
                }

                try {
                    const url = new URL(
                        'https://nominatim.openstreetmap.org/search'
                    );

                    url.searchParams.set('q', address);
                    url.searchParams.set('format', 'jsonv2');
                    url.searchParams.set('limit', '1');
                    url.searchParams.set('countrycodes', 'ph');

                    const response = await fetch(url.toString(), {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!response.ok) return null;

                    const results = await response.json();

                    if (!results.length) return null;

                    return {
                        lat: Number(results[0].lat),
                        lon: Number(results[0].lon)
                    };
                } catch (error) {
                    console.error('Address lookup error:', error);
                    return null;
                }
            }

            function distanceInMeters(a, b) {
                if (!a || !b) return Infinity;

                const radians = degrees => degrees * Math.PI / 180;

                const dLat = radians(b.lat - a.lat);
                const dLon = radians(b.lon - a.lon);

                const h =
                    Math.sin(dLat / 2) ** 2 +
                    Math.cos(radians(a.lat)) *
                    Math.cos(radians(b.lat)) *
                    Math.sin(dLon / 2) ** 2;

                return 6371000 * 2 *
                    Math.atan2(Math.sqrt(h), Math.sqrt(1 - h));
            }

            async function updateRiderPlaceName(position) {
                const now = Date.now();

                const moved = lastGeocodePosition
                    ? distanceInMeters(lastGeocodePosition, position)
                    : Infinity;

                if (
                    lastGeocodeTime &&
                    (now - lastGeocodeTime < 30000 || moved < 150)
                ) {
                    return;
                }

                lastGeocodeTime = now;
                lastGeocodePosition = { ...position };

                try {
                    const url = new URL(
                        'https://nominatim.openstreetmap.org/reverse'
                    );

                    url.searchParams.set('format', 'jsonv2');
                    url.searchParams.set('lat', position.lat);
                    url.searchParams.set('lon', position.lon);
                    url.searchParams.set('zoom', '18');
                    url.searchParams.set('addressdetails', '1');

                    const response = await fetch(url.toString(), {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!response.ok) {
                        throw new Error('Place lookup failed');
                    }

                    const data = await response.json();
                    const a = data.address || {};

                    const road = a.road || a.pedestrian || a.footway;

                    const locality =
                        a.suburb || a.village || a.town ||
                        a.city || a.municipality;

                    const region = a.state_district || a.state;
                    const parts = [];

                    if (road) parts.push(road);

                    if (locality && locality !== road) {
                        parts.push(locality);
                    }

                    if (region && !parts.includes(region)) {
                        parts.push(region);
                    }

                    riderPlaceElement.textContent =
                        parts.length
                            ? parts.join(', ')
                            : (
                                data.display_name ||
                                'GPS is available, but the place name is unavailable.'
                            );

                } catch (error) {
                    console.error('Rider place lookup error:', error);

                    riderPlaceElement.textContent =
                        'Place name unavailable. Check the GPS coordinates below.';
                }
            }

            function updateMarkers() {
                if (riderPosition) {
                    const point = [
                        riderPosition.lat,
                        riderPosition.lon
                    ];

                    if (!riderMarker) {
                        riderMarker = L.marker(point, {
                            icon: riderIcon
                        }).addTo(map);

                        riderMarker.bindPopup(
                            "Rider's Current Location"
                        );
                    } else {
                        riderMarker.setLatLng(point);
                    }
                }

                if (customerPosition) {
                    const point = [
                        customerPosition.lat,
                        customerPosition.lon
                    ];

                    if (!customerMarker) {
                        customerMarker = L.marker(point, {
                            icon: customerIcon
                        }).addTo(map);

                        customerMarker.bindPopup(
                            'Customer Delivery Address'
                        );
                    } else {
                        customerMarker.setLatLng(point);
                    }
                }

                if (routeLine) {
                    map.removeLayer(routeLine);
                    routeLine = null;
                }

                if (riderPosition && customerPosition) {
                    routeLine = L.polyline([
                        [riderPosition.lat, riderPosition.lon],
                        [customerPosition.lat, customerPosition.lon]
                    ], {
                        color: '#ed1c24',
                        weight: 3,
                        opacity: .8,
                        dashArray: '7, 8'
                    }).addTo(map);
                }

                if (!mapHasFitted) {
                    const points = [];

                    if (riderPosition) {
                        points.push([
                            riderPosition.lat,
                            riderPosition.lon
                        ]);
                    }

                    if (customerPosition) {
                        points.push([
                            customerPosition.lat,
                            customerPosition.lon
                        ]);
                    }

                    if (points.length === 2) {
                        map.fitBounds(points, {
                            padding: [25, 25]
                        });

                        mapHasFitted = true;
                    } else if (points.length === 1) {
                        map.setView(points[0], 15);
                        mapHasFitted = true;
                    }
                }
            }

            async function fetchRiderLocation() {
                if (requestInProgress) return;

                requestInProgress = true;

                try {
                    const response = await fetch(locationUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-store'
                    });

                    if (!response.ok) {
                        throw new Error(
                            'Location request failed: ' + response.status
                        );
                    }

                    const data = await response.json();

                    riderNameElement.textContent =
                        data.rider_name ||
                        'A rider has been assigned to your order.';

                    if (
                        data.available &&
                        data.latitude !== null &&
                        data.longitude !== null &&
                        Number.isFinite(Number(data.latitude)) &&
                        Number.isFinite(Number(data.longitude))
                    ) {
                        riderPosition = {
                            lat: Number(data.latitude),
                            lon: Number(data.longitude)
                        };

                        riderCoordinatesElement.textContent =
                            'Latitude: ' +
                            riderPosition.lat.toFixed(6) +
                            ' | Longitude: ' +
                            riderPosition.lon.toFixed(6);

                        updatedElement.textContent =
                            data.updated_at || 'GPS location received';

                        messageElement.textContent =
                            "The rider's GPS location has been received successfully.";

                        messageElement.classList.remove('error');
                        messageElement.classList.add('success');

                        updateMarkers();
                        updateRiderPlaceName(riderPosition);

                    } else {
                        updatedElement.textContent =
                            'No GPS update available yet';

                        riderPlaceElement.textContent =
                            'Waiting for the rider to share their GPS location...';

                        riderCoordinatesElement.textContent = '';

                        messageElement.textContent =
                            "The rider's GPS location is not available yet. Make sure the rider's device location is enabled and the coordinates are being sent to the system.";

                        messageElement.classList.remove('success');
                        messageElement.classList.add('error');
                    }

                } catch (error) {
                    console.error('Live tracking error:', error);

                    messageElement.textContent =
                        "Unable to retrieve the rider's current location. Please try again.";

                    messageElement.classList.remove('success');
                    messageElement.classList.add('error');

                } finally {
                    requestInProgress = false;
                }
            }

            async function loadCustomerLocation() {
                if (!customerAddress || !customerAddress.trim()) {
                    customerCoordinatesElement.textContent =
                        'No delivery address is available for this order.';

                    return;
                }

                const result = await geocodeAddress(customerAddress);

                if (!result) {
                    customerCoordinatesElement.textContent =
                        'The address could not be located on the map. Please verify the delivery address.';

                    return;
                }

                customerPosition = result;

                customerCoordinatesElement.textContent =
                    'Latitude: ' + result.lat.toFixed(6) +
                    ' | Longitude: ' + result.lon.toFixed(6);

                updateMarkers();
            }

            loadCustomerLocation();
            fetchRiderLocation();

            // Keep refreshing rider location every 10 seconds.
            setInterval(fetchRiderLocation, 10000);

            // Ensure Leaflet renders correctly after the compact layout loads.
            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>

</body>
</html>
