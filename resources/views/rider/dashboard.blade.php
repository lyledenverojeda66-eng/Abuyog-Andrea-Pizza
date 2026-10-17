
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rider Dashboard | Abuyog Andrea Pizza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6f4;
            color: #24332b;
            font-size: 13px;
        }

        header {
            background: #176b3a;
            color: white;
            padding: 16px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        header h1 {
            margin: 0;
            font-size: 21px;
        }

        header p {
            margin: 5px 0 0;
            color: #e0f2e7;
            font-size: 12px;
        }

        main {
            max-width: 1000px;
            margin: 22px auto;
            padding: 0 15px;
        }

        button {
            font-family: inherit;
            border: none;
            border-radius: 7px;
            padding: 11px 15px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        button:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            background: white;
            color: #176b3a;
        }

        .logout-btn:hover {
            background: #e8f5ec;
        }

        .welcome {
            margin-bottom: 20px;
        }

        .welcome h2 {
            margin: 0 0 7px;
            font-size: 22px;
        }

        .welcome p {
            margin: 0;
            color: #526158;
            font-size: 13px;
        }

        .notice {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 14px;
            line-height: 1.6;
        }

        .success {
            background: #d9f7e3;
            color: #176b3a;
            border: 1px solid #b7ebc8;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .delivery-card {
            background: white;
            border: 1px solid #e0e8e2;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 18px;
            box-shadow: 0 3px 12px #00000008;
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            border-bottom: 1px solid #e6ece8;
            padding-bottom: 13px;
            margin-bottom: 15px;
        }

        .card-heading h3 {
            margin: 0;
            font-size: 16px;
            overflow-wrap: anywhere;
        }

        .card-heading p {
            margin: 6px 0 0;
            color: #68756c;
            font-size: 12px;
        }

        .status {
            display: inline-block;
            border-radius: 20px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            background: #edf0ed;
            color: #39463d;
        }

        .paid {
            background: #d9f7e3;
            color: #176b3a;
        }

        .pending {
            background: #fff0c2;
            color: #805b00;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 10px;
        }

        .detail-box {
            padding: 12px;
            border-radius: 8px;
            background: #f7f9f7;
            overflow-wrap: anywhere;
            line-height: 1.6;
        }

        .detail-box strong {
            display: block;
            margin-bottom: 5px;
            color: #176b3a;
            font-size: 12px;
        }

        .items {
            margin-top: 17px;
            line-height: 1.7;
        }

        .section-title {
            display: block;
            margin-bottom: 10px;
            color: #176b3a;
            font-size: 14px;
            font-weight: bold;
        }

        .items ul {
            margin: 0;
            padding-left: 20px;
        }

        .delivery-action,
        .payment-action {
            border-top: 1px solid #e6ece8;
            padding-top: 15px;
            margin-top: 17px;
        }

        .hint {
            margin: 7px 0 10px;
            color: #68756c;
            font-size: 12px;
            line-height: 1.6;
        }

        .action-form {
            display: block;
            width: 100%;
        }

        .update-btn,
        .confirm-btn {
            display: block;
            width: 100%;
            padding: 13px 15px;
            border-radius: 8px;
            background: #176b3a;
            color: white;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            transition: background .2s;
        }

        .update-btn:hover,
        .confirm-btn:hover {
            background: #10552d;
        }

        .proof-panel {
            display: none;
            margin-top: 12px;
            padding: 14px;
            background: #f7f9f7;
            border: 1px solid #dce5de;
            border-radius: 10px;
        }

        .proof-panel.visible {
            display: block;
        }

        .photo-options {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin: 12px 0;
        }

        .photo-option {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            background: white;
            border: 1px solid #cbd8ce;
            border-radius: 7px;
            color: #176b3a;
            font-size: 12px;
        }

        .photo-option:hover {
            background: #e8f5ec;
        }

        .file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .preview-container {
            display: none;
            margin: 12px 0;
            text-align: center;
        }

        .preview-container.visible {
            display: block;
        }

        .proof-photo {
            display: block;
            width: 220px;
            max-width: 100%;
            max-height: 250px;
            margin: 10px auto;
            border: 1px solid #dce5de;
            border-radius: 8px;
            object-fit: cover;
        }

        .selected-file {
            color: #176b3a;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .cancel-btn {
            width: 100%;
            margin-top: 8px;
            padding: 10px;
            background: transparent;
            color: #68756c;
            border: 1px solid #dce5de;
        }

        .cancel-btn:hover {
            background: #edf0ed;
        }

        .proof-link {
            display: inline-block;
            margin-top: 8px;
            color: #176b3a;
            font-weight: bold;
            text-decoration: none;
        }

        .proof-link:hover {
            text-decoration: underline;
        }

        .empty {
            text-align: center;
            padding: 35px 18px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e0e8e2;
        }

        .empty h3 {
            color: #176b3a;
            margin-top: 0;
        }

        .empty p {
            color: #68756c;
            line-height: 1.6;
        }

        /* Live camera modal */

        .camera-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, .82);
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .camera-box {
            background: white;
            width: 100%;
            max-width: 500px;
            max-height: 95vh;
            overflow-y: auto;
            padding: 18px;
            border-radius: 12px;
        }

        .camera-box h3 {
            margin: 0 0 12px;
            font-size: 17px;
            color: #176b3a;
        }

        #camera-video {
            display: block;
            width: 100%;
            max-height: 60vh;
            background: #111;
            border-radius: 8px;
            object-fit: contain;
        }

        #camera-error {
            color: #b91c1c;
            font-size: 12px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .capture-btn {
            width: 100%;
            margin-top: 12px;
            background: #176b3a;
            color: white;
        }

        .close-camera-btn {
            width: 100%;
            margin-top: 8px;
            background: #e5e7eb;
            color: #333;
        }

        @media (max-width: 600px) {
            header {
                padding: 14px;
            }

            header h1 {
                font-size: 18px;
            }

            main {
                margin: 15px auto;
                padding: 0 10px;
            }

            .welcome h2 {
                font-size: 19px;
            }

            .delivery-card {
                padding: 13px;
            }

            .details {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .detail-box {
                padding: 9px;
                font-size: 12px;
            }

            .card-heading h3 {
                font-size: 14px;
            }

            .update-btn,
            .confirm-btn {
                padding: 13px 10px;
            }
        }

        @media (max-width: 360px) {
            .details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>
    <div>
        <h1>🍕 Abuyog Andrea Pizza</h1>
        <p>Rider Delivery Dashboard</p>
    </div>

    <form class="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout-btn" type="submit">Logout</button>
    </form>
</header>

<main>
    <section class="welcome">
        <h2>Welcome, {{ auth()->user()->name }}!</h2>
        <p>Manage your assigned deliveries and update their status.</p>
    </section>

    @if (session('success'))
        <div class="notice success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="notice error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @forelse ($deliveries as $delivery)

        @php
            $order = $delivery->order;
            $payment = $order?->payment;

            $currentStatus = $delivery->status ?? 'pending';

            $deliveryStatus = ucwords(
                str_replace('_', ' ', $currentStatus)
            );

            $paymentStatus = strtolower(
                $payment?->status
                ?? $delivery->payment_status
                ?? 'pending'
            );

            $paymentMethod = strtolower(trim(
                $payment?->method
                ?? $order?->payment_method
                ?? ''
            ));

            $isCod = in_array($paymentMethod, [
                'cash_on_delivery',
                'cod',
                'cash on delivery',
            ], true);

            $isGcash = in_array($paymentMethod, [
                'gcash',
                'g-cash',
            ], true);

            $nextStatuses = [
                'pending' => [
                    'preparing' => 'Start Preparing',
                ],
                'preparing' => [
                    'ready_for_pickup' => 'Mark Ready for Pickup',
                ],
                'ready_for_pickup' => [
                    'picked_up' => 'Confirm Pickup',
                ],
                'picked_up' => [
                    'out_for_delivery' => 'Start Delivery',
                ],
                'out_for_delivery' => [
                    'delivered' => 'Mark as Delivered',
                ],
                'delivered' => [],
            ];

            $availableStatuses = $nextStatuses[$currentStatus] ?? [];
            $nextStatusValue = array_key_first($availableStatuses);

            $nextStatusLabel = $nextStatusValue
                ? $availableStatuses[$nextStatusValue]
                : null;

            $proofPhotoUrl = $delivery->proof_photo
                ? asset('storage/' . ltrim($delivery->proof_photo, '/'))
                : null;
        @endphp

        <article class="delivery-card">

            <div class="card-heading">
                <div>
                    <h3>
                        Order #{{ $order?->order_number ?? $delivery->order_id }}
                    </h3>
                    <p>Delivery ID: {{ $delivery->id }}</p>
                </div>

                <span class="status {{ $currentStatus === 'delivered' ? 'paid' : '' }}">
                    {{ $deliveryStatus }}
                </span>
            </div>

            <div class="details">
                <div class="detail-box">
                    <strong>Customer</strong>
                    {{ $order?->user?->name ?? 'N/A' }}
                </div>

                <div class="detail-box">
                    <strong>Contact Number</strong>
                    {{ $order?->contact_number ?? 'N/A' }}
                </div>

                <div class="detail-box">
                    <strong>Delivery Address</strong>
                    {{ $order?->delivery_address ?? 'N/A' }}
                </div>

                <div class="detail-box">
                    <strong>Order Total</strong>
                    ₱{{ number_format((float) ($order?->total_amount ?? 0), 2) }}
                </div>

                <div class="detail-box">
                    <strong>Payment Method</strong>
                    {{ strtoupper(str_replace(
                        '_',
                        ' ',
                        $payment?->method
                        ?? $order?->payment_method
                        ?? 'N/A'
                    )) }}
                </div>

                <div class="detail-box">
                    <strong>Payment Status</strong>
                    <span class="status {{ $paymentStatus === 'paid' ? 'paid' : 'pending' }}">
                        {{ ucfirst($paymentStatus) }}
                    </span>
                </div>
            </div>

            <div class="items">
                <strong class="section-title">Ordered Items</strong>

                @if ($order && $order->orderItems->isNotEmpty())
                    <ul>
                        @foreach ($order->orderItems as $item)
                            <li>
                                {{ $item->pizza?->name ?? 'Pizza' }}
                                × {{ $item->quantity }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No order items found.</p>
                @endif
            </div>

            <div class="delivery-action">
                <strong class="section-title">Delivery Actions</strong>

                @if ($currentStatus === 'delivered')

                    <span class="status paid">✓ Delivery Completed</span>

                    @if ($proofPhotoUrl)
                        <p class="hint"><strong>Delivery Proof Photo</strong></p>

                        <a href="{{ $proofPhotoUrl }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <img
                                class="proof-photo"
                                src="{{ $proofPhotoUrl }}"
                                alt="Delivery proof photo"
                                loading="lazy"
                            >
                        </a>

                        <a class="proof-link"
                           href="{{ $proofPhotoUrl }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            View Full-Size Photo
                        </a>
                    @else
                        <p class="hint">
                            No delivery proof photo is recorded for this delivery.
                        </p>
                    @endif

                @elseif ($nextStatusValue === 'delivered')

                    <p class="hint">
                        A delivery proof photo is required before completing this delivery.
                    </p>

                    <button
                        type="button"
                        class="update-btn"
                        onclick="showProofPanel({{ $delivery->id }})"
                    >
                        ✓ Mark as Delivered
                    </button>

                    <form
                        id="delivery-form-{{ $delivery->id }}"
                        class="action-form proof-panel"
                        method="POST"
                        action="{{ route('rider.deliveries.update-status', $delivery->id) }}"
                        enctype="multipart/form-data"
                        onsubmit="return validateProofSubmission(event, this)"
                    >
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="status" value="delivered">

                        <strong class="section-title">Delivery Proof Photo</strong>

                        <p class="hint">
                            Take a photo or select an image. Accepted formats: JPG, JPEG,
                            PNG, or WEBP. Maximum file size: 5 MB.
                        </p>

                        <input
                            class="file-input"
                            type="file"
                            id="upload-{{ $delivery->id }}"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        <input
                            class="file-input"
                            type="file"
                            id="proof-photo-{{ $delivery->id }}"
                            name="proof_photo"
                            accept="image/jpeg,image/png,image/webp"
                            required
                        >

                        <div class="photo-options">
                            <button
                                type="button"
                                class="photo-option"
                                onclick="openPhotoPicker({{ $delivery->id }}, 'camera')"
                            >
                                📷 Take Photo
                            </button>

                            <button
                                type="button"
                                class="photo-option"
                                onclick="openPhotoPicker({{ $delivery->id }}, 'upload')"
                            >
                                Choose Photo
                            </button>
                        </div>

                        <div
                            id="preview-container-{{ $delivery->id }}"
                            class="preview-container"
                        >
                            <p
                                class="selected-file"
                                id="selected-file-{{ $delivery->id }}"
                            ></p>

                            <img
                                id="preview-{{ $delivery->id }}"
                                class="proof-photo"
                                alt="Delivery proof preview"
                            >
                        </div>

                        <button type="submit" class="confirm-btn">
                            Submit Proof and Complete Delivery
                        </button>

                        <button
                            type="button"
                            class="cancel-btn"
                            onclick="hideProofPanel({{ $delivery->id }})"
                        >
                            Cancel
                        </button>
                    </form>

                @elseif ($nextStatusValue === 'out_for_delivery')

                    <p class="hint">
                        Open Google Maps for directions to the customer. The application
                        will submit the delivery status and redirect to live rider tracking.
                    </p>

                    <form
                        class="action-form"
                        method="POST"
                        action="{{ route('rider.deliveries.update-status', $delivery->id) }}"
                        data-delivery-address="{{ $order?->delivery_address ?? '' }}"
                        onsubmit="return handleStartDelivery(event, this)"
                    >
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="status" value="out_for_delivery">

                        <button type="submit" class="update-btn">
                            📍 Start Delivery
                        </button>
                    </form>

                @elseif ($nextStatusValue)

                    <form
                        class="action-form"
                        method="POST"
                        action="{{ route('rider.deliveries.update-status', $delivery->id) }}"
                        onsubmit="return confirmStatusUpdate()"
                    >
                        @csrf
                        @method('PUT')

                        <input
                            type="hidden"
                            name="status"
                            value="{{ $nextStatusValue }}"
                        >

                        <button type="submit" class="update-btn">
                            {{ $nextStatusLabel }}
                        </button>
                    </form>

                @else

                    <p class="hint">No further delivery action is available.</p>

                @endif
            </div>

            <div class="payment-action">
                <strong class="section-title">Payment Confirmation</strong>

                @if ($isCod)

                    @if ($paymentStatus === 'paid')

                        <span class="status paid">✓ COD Payment Received</span>

                    @elseif ($payment && $paymentStatus !== 'failed')

                        <form
                            method="POST"
                            action="{{ route('rider.deliveries.confirm-payment', $delivery->id) }}"
                            onsubmit="return confirm('Confirm that you have actually received the cash payment?');"
                        >
                            @csrf
                            @method('PUT')

                            <button type="submit" class="confirm-btn">
                                Confirm COD Payment Received
                            </button>
                        </form>

                        <p class="hint">
                            Confirm only after you have actually received the cash from the customer.
                        </p>

                    @else

                        <span class="status pending">Payment Failed</span>

                    @endif

                @elseif ($isGcash)

                    @if ($paymentStatus === 'paid')

                        <span class="status paid">✓ GCash Payment Approved</span>

                        <p class="hint">
                            The administrator has verified the GCash payment.
                        </p>

                    @else

                        <span class="status pending">GCash Payment Pending</span>

                        <p class="hint">
                            The administrator must verify and approve the GCash payment.
                        </p>

                    @endif

                @elseif ($paymentStatus === 'paid')

                    <span class="status paid">✓ Payment Marked as Paid</span>

                @elseif ($payment)

                    <span class="status pending">{{ ucfirst($paymentStatus) }}</span>

                    <p class="hint">
                        Contact the administrator if you have questions about the payment status.
                    </p>

                @else

                    <p class="hint">
                        No payment record is linked to this order yet.
                        Please contact the administrator.
                    </p>

                @endif
            </div>

        </article>

    @empty

        <section class="empty">
            <h3>No Assigned Deliveries</h3>
            <p>
                You currently have no assigned orders.
                Please contact the administrator to receive delivery assignments.
            </p>
        </section>

    @endforelse
</main>

<!-- Live camera interface -->
<div
    id="camera-modal"
    class="camera-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="camera-title"
>
    <div class="camera-box">
        <h3 id="camera-title">Take Delivery Proof Photo</h3>

        <video
            id="camera-video"
            autoplay
            playsinline
            muted
        ></video>

        <canvas id="camera-canvas" style="display:none;"></canvas>

        <p id="camera-error" role="status"></p>

        <button
            type="button"
            id="capture-photo-btn"
            class="capture-btn"
        >
            📷 Capture Photo
        </button>

        <button
            type="button"
            id="close-camera-btn"
            class="close-camera-btn"
        >
            Cancel
        </button>
    </div>
</div>

<script>
    let activeCameraStream = null;
    let activeDeliveryId = null;
    let cameraRequestId = 0;

    function handleStartDelivery(event, form) {
        const address = (form.dataset.deliveryAddress || '').trim();

        if (!address) {
            event.preventDefault();
            alert('The customer delivery address is missing. Please contact the administrator.');
            return false;
        }

        if (!confirm('Start this delivery and open Google Maps directions to the customer?')) {
            event.preventDefault();
            return false;
        }

        const mapsUrl =
            'https://www.google.com/maps/dir/?api=1&destination=' +
            encodeURIComponent(address);

        window.open(mapsUrl, '_blank');

        return true;
    }

    function confirmStatusUpdate() {
        return confirm('Confirm this delivery status update?');
    }

    function showProofPanel(deliveryId) {
        const panel = document.getElementById('delivery-form-' + deliveryId);

        if (!panel) return;

        panel.classList.add('visible');

        panel.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    function hideProofPanel(deliveryId) {
        const panel = document.getElementById('delivery-form-' + deliveryId);

        if (!panel) return;

        panel.reset();
        clearPhotoPreview(deliveryId);
        panel.classList.remove('visible');
    }

    async function openPhotoPicker(deliveryId, source) {
        if (source === 'upload') {
            const uploadInput = document.getElementById('upload-' + deliveryId);

            if (uploadInput) {
                uploadInput.click();
            }

            return;
        }

        // Open the live camera instead of the Files picker.
        stopCamera();

        activeDeliveryId = deliveryId;

        const thisRequest = ++cameraRequestId;
        const modal = document.getElementById('camera-modal');
        const video = document.getElementById('camera-video');
        const error = document.getElementById('camera-error');
        const captureButton = document.getElementById('capture-photo-btn');

        modal.style.display = 'flex';
        error.textContent = 'Requesting camera access...';
        captureButton.disabled = true;

        if (!navigator.mediaDevices ||
            !navigator.mediaDevices.getUserMedia) {
            error.textContent =
                'Live camera is unavailable. Open this page on localhost or through HTTPS, use a supported browser, and allow camera access.';
            return;
        }

        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' }
                },
                audio: false
            });

            if (thisRequest !== cameraRequestId) {
                stream.getTracks().forEach(track => track.stop());
                return;
            }

            activeCameraStream = stream;
            video.srcObject = stream;

            await video.play();

            error.textContent = '';
            captureButton.disabled = false;

        } catch (err) {
            if (thisRequest !== cameraRequestId) return;

            captureButton.disabled = true;

            if (err.name === 'NotAllowedError' ||
                err.name === 'PermissionDeniedError') {
                error.textContent =
                    'Camera permission was denied. Allow camera access in your browser settings, then try again.';
            } else if (err.name === 'NotFoundError' ||
                       err.name === 'DevicesNotFoundError') {
                error.textContent =
                    'No available camera was found on this device.';
            } else {
                error.textContent =
                    'Unable to open the camera. Check camera permissions and make sure no other application is blocking it.';
            }

            console.error('Camera error:', err);
        }
    }

    function stopCamera() {
        // Invalidate any camera request that is still pending.
        cameraRequestId++;

        if (activeCameraStream) {
            activeCameraStream.getTracks().forEach(track => track.stop());
            activeCameraStream = null;
        }

        const video = document.getElementById('camera-video');
        const modal = document.getElementById('camera-modal');
        const captureButton = document.getElementById('capture-photo-btn');

        if (video) {
            video.pause();
            video.srcObject = null;
        }

        if (captureButton) {
            captureButton.disabled = false;
        }

        if (modal) {
            modal.style.display = 'none';
        }
    }

    function clearPhotoPreview(deliveryId) {
        const preview = document.getElementById('preview-' + deliveryId);
        const container = document.getElementById('preview-container-' + deliveryId);
        const filename = document.getElementById('selected-file-' + deliveryId);

        if (preview && preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
            delete preview.dataset.objectUrl;
        }

        if (preview) {
            preview.removeAttribute('src');
        }

        if (container) {
            container.classList.remove('visible');
        }

        if (filename) {
            filename.textContent = '';
        }
    }

    function attachPhotoToForm(deliveryId, file) {
        const proofInput = document.getElementById('proof-photo-' + deliveryId);
        const preview = document.getElementById('preview-' + deliveryId);
        const container = document.getElementById('preview-container-' + deliveryId);
        const filename = document.getElementById('selected-file-' + deliveryId);

        if (!proofInput || !preview || !container || !filename) {
            alert('The photo form could not be found. Please refresh the page and try again.');
            return false;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please choose a JPG, JPEG, PNG, or WEBP image.');
            return false;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('The proof photo must not exceed 5 MB.');
            return false;
        }

        try {
            const transfer = new DataTransfer();
            transfer.items.add(file);
            proofInput.files = transfer.files;
        } catch (err) {
            alert('This browser could not attach the photo. Please try another browser.');
            return false;
        }

        if (preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
        }

        const objectUrl = URL.createObjectURL(file);

        preview.src = objectUrl;
        preview.dataset.objectUrl = objectUrl;

        filename.textContent = 'Selected photo: ' + file.name;
        container.classList.add('visible');

        return true;
    }

    function setupPhotoInputs() {
        document.querySelectorAll('form[id^="delivery-form-"]').forEach(function (form) {
            const deliveryId = form.id.replace('delivery-form-', '');
            const uploadInput = document.getElementById('upload-' + deliveryId);

            if (!uploadInput) return;

            uploadInput.addEventListener('change', function () {
                if (!uploadInput.files || !uploadInput.files.length) {
                    return;
                }

                const file = uploadInput.files[0];

                if (attachPhotoToForm(deliveryId, file)) {
                    // The actual upload uses the proof-photo input.
                    uploadInput.value = '';
                } else {
                    uploadInput.value = '';
                }
            });
        });
    }

    document.getElementById('capture-photo-btn').addEventListener('click', function () {
        const video = document.getElementById('camera-video');
        const canvas = document.getElementById('camera-canvas');
        const error = document.getElementById('camera-error');
        const captureButton = this;

        if (!activeCameraStream ||
            !video.videoWidth ||
            !activeDeliveryId) {
            error.textContent = 'The camera is not ready. Please wait and try again.';
            return;
        }

        captureButton.disabled = true;
        error.textContent = 'Capturing photo...';

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const context = canvas.getContext('2d');

        context.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
        );

        canvas.toBlob(function (blob) {
            if (!blob) {
                error.textContent = 'Could not capture the photo. Please try again.';
                captureButton.disabled = false;
                return;
            }

            const deliveryId = activeDeliveryId;

            const file = new File(
                [blob],
                'delivery-proof-' + Date.now() + '.jpg',
                { type: 'image/jpeg' }
            );

            const attached = attachPhotoToForm(deliveryId, file);

            if (attached) {
                stopCamera();
                activeDeliveryId = null;
            } else {
                captureButton.disabled = false;
                error.textContent = 'Please try capturing the photo again.';
            }
        }, 'image/jpeg', 0.9);
    });

    document.getElementById('close-camera-btn').addEventListener('click', function () {
        activeDeliveryId = null;
        stopCamera();
    });

    document.getElementById('camera-modal').addEventListener('click', function (event) {
        if (event.target === this) {
            activeDeliveryId = null;
            stopCamera();
        }
    });

    function validateProofSubmission(event, form) {
        const deliveryId = form.id.replace('delivery-form-', '');
        const proofInput = document.getElementById('proof-photo-' + deliveryId);

        if (!proofInput ||
            !proofInput.files ||
            proofInput.files.length === 0) {
            event.preventDefault();

            alert('Please take a photo or choose a delivery proof photo before completing this delivery.');

            return false;
        }

        const file = proofInput.files[0];

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            event.preventDefault();
            alert('Invalid file type. Please choose a JPG, JPEG, PNG, or WEBP image.');
            return false;
        }

        if (file.size > 5 * 1024 * 1024) {
            event.preventDefault();
            alert('The proof photo must not exceed 5 MB.');
            return false;
        }

        return confirm('Submit the proof photo and mark this delivery as completed?');
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupPhotoInputs();
    });
</script>

</body>
</html>
