
@extends('admin.layout')

@section('title', 'Add Banner')

@section('content')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
>

<style>
    .crop-page {
        max-width: 900px;
        margin: 0 auto;
        color: #111827;
    }

    .crop-page .back-link {
        display: inline-block;
        margin-bottom: 16px;
        color: #15803d;
        text-decoration: none;
        font-weight: 700;
    }

    .crop-page h1 {
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .crop-page .muted {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .crop-page .panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .crop-page .group {
        margin-bottom: 20px;
    }

    .crop-page label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 800;
    }

    .crop-page input[type="text"],
    .crop-page input[type="file"],
    .crop-page input[type="range"] {
        width: 100%;
        box-sizing: border-box;
    }

    .crop-page input[type="text"] {
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
    }

    .crop-page .file-box {
        background: #f0fdf4;
        border: 2px dashed #bbf7d0;
        padding: 18px;
        border-radius: 10px;
    }

    .crop-page .help {
        font-size: 12px;
        color: #6b7280;
        margin-top: 7px;
    }

    .crop-page .crop-workspace {
        display: none;
        margin-top: 20px;
    }

    .crop-page .crop-frame {
        width: 100%;
        height: 430px;
        overflow: hidden;
        background: #111827;
        border-radius: 10px;
    }

    .crop-page .crop-frame img {
        display: block;
        max-width: 100%;
    }

    .crop-page .control-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-top: 20px;
    }

    .crop-page .crop-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 16px;
    }

    .crop-page .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        border: 0;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .crop-page .btn:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .crop-page .btn-green {
        color: #fff;
        background: #15803d;
    }

    .crop-page .btn-gray {
        color: #374151;
        background: #f3f4f6;
    }

    .crop-page .preview-frame {
        width: 100%;
        aspect-ratio: 16 / 6;
        overflow: hidden;
        border-radius: 9px;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
    }

    .crop-page .preview-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .crop-page .errors {
        padding: 14px;
        border: 1px solid #fecaca;
        border-radius: 8px;
        background: #fef2f2;
        color: #b91c1c;
        margin-bottom: 18px;
    }

    .crop-page .status-message {
        font-size: 13px;
        margin-top: 12px;
        color: #166534;
    }

    @media (max-width: 600px) {
        .crop-page .panel {
            padding: 16px;
        }

        .crop-page .crop-frame {
            height: 300px;
        }

        .crop-page .control-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="crop-page">
    <a href="{{ route('admin.banners.index') }}" class="back-link">
        &larr; Back to Banners
    </a>

    <h1>Add Banner</h1>
    <p class="muted">
        Upload an image, crop it, zoom, and reposition before saving.
    </p>

    @if ($errors->any())
        <div class="errors">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        id="bannerForm"
        action="{{ route('admin.banners.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="panel">
            <div class="group">
                <label for="title">Banner Title (optional)</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    maxlength="255"
                    placeholder="Enter banner title"
                >
            </div>

            <div class="group">
                <label for="image">Choose Banner Image</label>

                <div class="file-box">
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >
                    <div class="help">
                        JPG, JPEG, PNG, or WEBP. Maximum size: 5 MB.
                    </div>
                </div>
            </div>

            <div class="crop-workspace" id="cropWorkspace">
                <div class="group">
                    <label>Crop Editor — drag the image and adjust the crop box</label>
                    <div class="crop-frame">
                        <img id="cropImage" alt="Image to crop">
                    </div>
                    <div class="help">
                        Drag the image to reposition it. Drag the crop box handles
                        to change the selected area. The final banner uses a wide 16:6 ratio.
                    </div>
                </div>

                <div class="control-grid">
                    <div>
                        <label for="zoomControl">
                            Zoom: <span id="zoomValue">100%</span>
                        </label>
                        <input
                            type="range"
                            id="zoomControl"
                            min="0"
                            max="100"
                            value="0"
                            step="1"
                        >
                    </div>

                    <div>
                        <label for="qualityControl">
                            JPEG quality: <span id="qualityValue">92%</span>
                        </label>
                        <input
                            type="range"
                            id="qualityControl"
                            min="60"
                            max="100"
                            value="92"
                            step="1"
                        >
                    </div>
                </div>

                <div class="crop-buttons">
                    <button type="button" class="btn btn-gray" id="zoomIn">
                        + Zoom In
                    </button>
                    <button type="button" class="btn btn-gray" id="zoomOut">
                        − Zoom Out
                    </button>
                    <button type="button" class="btn btn-gray" id="rotateLeft">
                        Rotate Left
                    </button>
                    <button type="button" class="btn btn-gray" id="rotateRight">
                        Rotate Right
                    </button>
                    <button type="button" class="btn btn-gray" id="resetCrop">
                        Reset Crop
                    </button>
                </div>

                <div class="status-message" id="cropStatus" aria-live="polite"></div>
            </div>
        </div>

        <div class="panel">
            <div class="group">
                <label>Final Banner Preview</label>
                <div class="preview-frame">
                    <img id="finalPreview" alt="Final cropped banner preview" hidden>
                </div>
                <div class="help">
                    This preview shows the actual crop that will be uploaded.
                </div>
            </div>

            <div class="crop-buttons">
                <button type="submit" class="btn btn-green" id="saveBanner">
                    Crop &amp; Upload Banner
                </button>

                <a
                    href="{{ route('admin.banners.index') }}"
                    class="btn btn-gray"
                >
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bannerForm');
    const fileInput = document.getElementById('image');
    const cropImage = document.getElementById('cropImage');
    const workspace = document.getElementById('cropWorkspace');
    const finalPreview = document.getElementById('finalPreview');
    const zoomControl = document.getElementById('zoomControl');
    const zoomValue = document.getElementById('zoomValue');
    const qualityControl = document.getElementById('qualityControl');
    const qualityValue = document.getElementById('qualityValue');
    const saveButton = document.getElementById('saveBanner');
    const cropStatus = document.getElementById('cropStatus');

    let cropper = null;
    let originalObjectUrl = null;
    let previewObjectUrl = null;
    let isPreparingUpload = false;
    let zoomMin = 0;
    let zoomMax = 0;

    function setStatus(message) {
        cropStatus.textContent = message;
    }

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function revokePreviewUrl() {
        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
            previewObjectUrl = null;
        }
    }

    function refreshFinalPreview() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 1600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
            fillColor: '#ffffff'
        });

        if (!canvas) return;

        canvas.toBlob(function (blob) {
            if (!blob) return;

            revokePreviewUrl();
            previewObjectUrl = URL.createObjectURL(blob);
            finalPreview.src = previewObjectUrl;
            finalPreview.hidden = false;
        }, 'image/jpeg', Number(qualityControl.value) / 100);
    }

    function updateZoomRange() {
        if (!cropper) return;

        const data = cropper.getImageData();
        zoomMin = data.width > 0 ? 0 : 0;
        zoomMax = 100;

        zoomControl.value = 0;
        zoomValue.textContent = '100%';
    }

    fileInput.addEventListener('change', function () {
        const file = fileInput.files && fileInput.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Please choose a valid image.');
            fileInput.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('The image must not exceed 5 MB.');
            fileInput.value = '';
            return;
        }

        destroyCropper();

        if (originalObjectUrl) {
            URL.revokeObjectURL(originalObjectUrl);
        }

        originalObjectUrl = URL.createObjectURL(file);
        cropImage.src = originalObjectUrl;
        workspace.style.display = 'block';
        finalPreview.hidden = true;
        setStatus('Loading image...');

        cropImage.onload = function () {
            cropper = new Cropper(cropImage, {
                aspectRatio: 16 / 6,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.85,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                background: false,
                zoomOnWheel: true,
                ready: function () {
                    updateZoomRange();
                    refreshFinalPreview();
                    setStatus('Image ready. Drag to reposition or adjust the crop box.');
                },
                crop: function () {
                    refreshFinalPreview();
                }
            });
        };
    });

    document.getElementById('zoomIn').addEventListener('click', function () {
        if (cropper) cropper.zoom(0.1);
    });

    document.getElementById('zoomOut').addEventListener('click', function () {
        if (cropper) cropper.zoom(-0.1);
    });

    document.getElementById('rotateLeft').addEventListener('click', function () {
        if (cropper) cropper.rotate(-90);
    });

    document.getElementById('rotateRight').addEventListener('click', function () {
        if (cropper) cropper.rotate(90);
    });

    document.getElementById('resetCrop').addEventListener('click', function () {
        if (!cropper) return;

        cropper.reset();
        zoomControl.value = 0;
        zoomValue.textContent = '100%';
        refreshFinalPreview();
        setStatus('Crop reset.');
    });

    zoomControl.addEventListener('input', function () {
        if (!cropper) return;

        const amount = Number(zoomControl.value);
        const ratio = 1 + amount / 100;
        const currentData = cropper.getImageData();
        const targetWidth = currentData.naturalWidth * ratio;

        if (currentData.width > 0 && targetWidth > 0) {
            cropper.zoomTo(ratio);
        }

        zoomValue.textContent = Math.round(ratio * 100) + '%';
    });

    qualityControl.addEventListener('input', function () {
        qualityValue.textContent = qualityControl.value + '%';
        refreshFinalPreview();
    });

    form.addEventListener('submit', function (event) {
        if (isPreparingUpload || !cropper) {
            if (!fileInput.files || !fileInput.files.length) {
                event.preventDefault();
                alert('Please choose an image first.');
            }
            return;
        }

        event.preventDefault();

        saveButton.disabled = true;
        saveButton.textContent = 'Preparing Cropped Image...';
        setStatus('Creating cropped image...');

        const canvas = cropper.getCroppedCanvas({
            width: 1600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
            fillColor: '#ffffff'
        });

        if (!canvas) {
            saveButton.disabled = false;
            saveButton.textContent = 'Crop & Upload Banner';
            alert('Could not crop this image. Please try another image.');
            return;
        }

        canvas.toBlob(function (blob) {
            if (!blob) {
                saveButton.disabled = false;
                saveButton.textContent = 'Crop & Upload Banner';
                alert('Could not create the cropped image. Please try again.');
                return;
            }

            const croppedFile = new File(
                [blob],
                'banner-cropped-' + Date.now() + '.jpg',
                { type: 'image/jpeg' }
            );

            const transfer = new DataTransfer();
            transfer.items.add(croppedFile);
            fileInput.files = transfer.files;

            isPreparingUpload = true;
            setStatus('Uploading cropped image...');
            form.submit();
        }, 'image/jpeg', Number(qualityControl.value) / 100);
    });

    window.addEventListener('beforeunload', function () {
        destroyCropper();

        if (originalObjectUrl) URL.revokeObjectURL(originalObjectUrl);
        if (previewObjectUrl) URL.revokeObjectURL(previewObjectUrl);
    });
});
</script>
@endsection