<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Live Rider Tracking | Abuyog Andrea Pizza</title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #fff8ee;
            color: #222;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #111;
            color: white;
            padding: 17px 22px;
            font-size: 20px;
            font-weight: bold;
        }

        .navbar span {
            color: #ed1c24;
        }

        .container {
            max-width: 1100px;
            margin: 25px auto;
            padding: 0 16px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        h1 {
            margin-top: 0;
            font-size: 25px;
        }

        .description {
            color: #666;
            line-height: 1.6;
        }

        .status {
            display: inline-block;
            padding: 8px 12px;
            background: #fff0c2;
            color: #7a4b00;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status.active {
            background: #dcfce7;
            color: #166534;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        button,
        .back-link {
            border: none;
            border-radius: 8px;
            padding: 12px 17px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .start-btn {
            color: white;
            background: #ed1c24;
        }

        .stop-btn {
            color: white;
            background: #333;
        }

        .back-link {
            display: inline-block;
            background: #eee;
            color: #222;
        }

        button:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        #map {
            height: 440px;
            width: 100%;
            border-radius: 12px;
            z-index: 1;
        }

        #message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            background: #f3f4f6;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .details {
            margin-top: 12px;
            color: #555;
            font-size: 14px;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .card {
                padding: 16px;
            }

            #map {
                height: 350px;
            }

            button,
            .back-link {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        ABUYOG ANDREA <span>PIZZA</span>
    </header>

    <main class="container">
        <section class="card">
            <h1>📍 Live Rider Tracking</h1>

            <p class="description">
                Ibahagi ang iyong kasalukuyang lokasyon upang makita ng
                customer kung nasaan ang rider habang inihahatid ang order.
            </p>

            <p>
                <strong>Delivery ID:</strong>
                #{{ $delivery->id }}
            </p>

            <p>
                <strong>Delivery Status:</strong>
                {{ ucwords(str_replace('_', ' ', $delivery->status)) }}
            </p>

            <span id="sharingStatus" class="status">
                GPS sharing is stopped
            </span>

            <div class="buttons">
                <button
                    type="button"
                    id="startBtn"
                    class="start-btn"
                >
                    ▶ Start GPS Sharing
                </button>

                <button
                    type="button"
                    id="stopBtn"
                    class="stop-btn"
                    disabled
                >
                    ■ Stop Sharing
                </button>

                <a
                    href="{{ route('rider.dashboard') }}"
                    class="back-link"
                >
                    ← Back to Dashboard
                </a>
            </div>

            <div id="message" role="status" aria-live="polite">
                Pindutin ang Start GPS Sharing at payagan ang browser
                na gamitin ang lokasyon ng device.
            </div>

            <div class="details">
                <div>
                    <strong>Latitude:</strong>
                    <span id="latitude">Not available</span>
                </div>

                <div>
                    <strong>Longitude:</strong>
                    <span id="longitude">Not available</span>
                </div>

                <div>
                    <strong>Last successful update:</strong>
                    <span id="lastUpdated">Not available</span>
                </div>
            </div>
        </section>

        <section class="card">
            <h2>Your Current Location</h2>
            <div id="map"></div>
        </section>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const updateUrl = @json(
            route('rider.deliveries.live-location.update', [
                'delivery' => $delivery->id
            ])
        );

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const message = document.getElementById('message');
        const sharingStatus = document.getElementById('sharingStatus');

        let watchId = null;
        let isSharing = false;
        let isSending = false;
        let lastSentAt = 0;
        let riderMarker = null;
        let riderAccuracyCircle = null;

        const map = L.map('map').setView([10.747, 125.011], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function showMessage(text) {
            message.textContent = text;
        }

        function updateStatus(active) {
            sharingStatus.textContent = active
                ? 'GPS sharing is active'
                : 'GPS sharing is stopped';

            sharingStatus.classList.toggle('active', active);
            startBtn.disabled = active;
            stopBtn.disabled = !active;
        }

        async function sendLocation(position) {
            if (!isSharing || isSending) {
                return;
            }

            const now = Date.now();

            // Avoid sending updates too frequently.
            if (now - lastSentAt < 3000) {
                return;
            }

            isSending = true;

            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            try {
                const response = await fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'Failed to save your location.'
                    );
                }

                lastSentAt = Date.now();

                document.getElementById('latitude').textContent =
                    latitude.toFixed(6);

                document.getElementById('longitude').textContent =
                    longitude.toFixed(6);

                document.getElementById('lastUpdated').textContent =
                    new Date().toLocaleTimeString();

                showMessage('Your location has been shared successfully.');

            } catch (error) {
                showMessage('Location update error: ' + error.message);
            } finally {
                isSending = false;
            }
        }

        function handlePosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const point = [latitude, longitude];

            if (!riderMarker) {
                riderMarker = L.marker(point)
                    .addTo(map)
                    .bindPopup('Your current location');

                riderAccuracyCircle = L.circle(point, {
                    radius: position.coords.accuracy || 0,
                    color: '#ed1c24',
                    fillOpacity: 0.1
                }).addTo(map);

                map.setView(point, 16);
            } else {
                riderMarker.setLatLng(point);
                riderAccuracyCircle.setLatLng(point);
                riderAccuracyCircle.setRadius(
                    position.coords.accuracy || 0
                );
            }

            sendLocation(position);
        }

        function handlePositionError(error) {
            const messages = {
                1: 'Location permission denied. Allow location access in your browser.',
                2: 'Your current location is unavailable. Check GPS settings.',
                3: 'Getting your location timed out. Please try again.'
            };

            showMessage(
                messages[error.code] || 'Unable to get your location.'
            );
        }

        startBtn.addEventListener('click', function () {
            if (!navigator.geolocation) {
                showMessage('This browser does not support GPS location.');
                return;
            }

            if (!window.isSecureContext) {
                showMessage(
                    'GPS requires HTTPS or localhost. Open the site securely.'
                );
                return;
            }

            if (isSharing) {
                return;
            }

            isSharing = true;
            lastSentAt = 0;
            updateStatus(true);

            showMessage('Requesting your current GPS location...');

            watchId = navigator.geolocation.watchPosition(
                handlePosition,
                handlePositionError,
                {
                    enableHighAccuracy: true,
                    maximumAge: 3000,
                    timeout: 20000
                }
            );
        });

        stopBtn.addEventListener('click', function () {
            isSharing = false;

            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }

            updateStatus(false);

            showMessage(
                'GPS sharing stopped. The last saved location remains in the database.'
            );
        });

        window.addEventListener('beforeunload', function () {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
            }
        });

        updateStatus(false);
    </script>
</body>
</html>