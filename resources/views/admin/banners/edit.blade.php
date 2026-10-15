
@extends('admin.layout')

@section('title', 'Edit Banner')

@section('content')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
>

<style>
    .edit-banner { max-width: 900px; margin: 0 auto; color: #111827; }
    .edit-banner h1 { font-size: 25px; font-weight: 800; margin-bottom: 6px; }
    .edit-banner .muted { color: #6b7280; font-size: 13px; }
    .edit-banner .panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin: 20px 0; }
    .edit-banner .group { margin-bottom: 20px; }
    .edit-banner label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 800; }
    .edit-banner input[type="text"],
    .edit-banner input[type="number"],
    .edit-banner input[type="file"],
    .edit-banner input[type="range"],
    .edit-banner textarea,
    .edit-banner select { width: 100%; box-sizing: border-box; }
    .edit-banner input[type="text"],
    .edit-banner input[type="number"],
    .edit-banner textarea,
    .edit-banner select { padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; }
    .edit-banner .current-image { width: 100%; aspect-ratio: 16 / 6; overflow: hidden; background: #f3f4f6; border-radius: 9px; margin-bottom: 15px; }
    .edit-banner .current-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .edit-banner .crop-workspace { display: none; margin-top: 20px; }
    .edit-banner .crop-frame { height: 420px; overflow: hidden; background: #111827; border-radius: 10px; }
    .edit-banner .crop-frame img { display: block; max-width: 100%; }
    .edit-banner .control-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-top: 18px; }
    .edit-banner .preview-frame { width: 100%; aspect-ratio: 16 / 6; overflow: hidden; border: 1px solid #d1d5db; border-radius: 9px; background: #f3f4f6; }
    .edit-banner .preview-frame img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .edit-banner .buttons { display: flex; flex-wrap: wrap; gap: 9px; margin-top: 20px; }
    .edit-banner .btn { display: inline-flex; justify-content: center; align-items: center; border: 0; border-radius: 7px; padding: 11px 16px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; }
    .edit-banner .btn-green { background: #15803d; color: #fff; }
    .edit-banner .btn-gray { background: #f3f4f6; color: #374151; }
    .edit-banner .help { font-size: 12px; color: #6b7280; margin-top: 7px; }
    .edit-banner .errors { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 14px; border-radius: 8px; }
    @media(max-width:600px) {
        .edit-banner .panel { padding: 16px; }
        .edit-banner .crop-frame { height: 300px; }
        .edit-banner .control-grid { grid-template-columns: 1fr; }
        .edit-banner .buttons { flex-direction: column; }
    }
</style>

<div class="edit-banner">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
        <div>
            <h1>Edit Banner</h1>
            <p class="muted">Update details or replace and crop the banner image.</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-gray">Back to Banners</a>
    </div>

    @if ($errors->any())
        <div class="errors">
            <strong>Please fix these errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        id="editBannerForm"
        action="{{ route('admin.banners.update', $banner) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="panel">
            <div class="group">
                <label for="title">Banner Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $banner->title) }}" maxlength="255">
            </div>

            <div class="group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
            </div>

            <div class="group">
                <label>Current Image</label>
                <div class="current-image">
                    <img
                        src="{{ asset('image/banners/' . $banner->image) }}"
                        alt="Current banner"
                    >
                </div>

                <label for="image">Replace Image (optional)</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
                <div class="help">Leave this empty to keep the existing image.</div>
            </div>

            <div class="crop-workspace" id="cropWorkspace">
                <div class="group">
                    <label>Crop Editor</label>
                    <div class="crop-frame">
                        <img id="cropImage" alt="Image to crop">
                    </div>
                    <div class="help">
                        Drag the image to reposition it. Adjust the crop handles to select the visible area.
                    </div>
                </div>

                <div class="control-grid">
                    <div>
                        <label for="zoomControl">Zoom: <span id="zoomValue">100%</span></label>
                        <input type="range" id="zoomControl" min="0" max="100" value="0">
                    </div>
                    <div>
                        <label for="qualityControl">JPEG quality: <span id="qualityValue">92%</span></label>
                        <input type="range" id="qualityControl" min="60" max="100" value="92">
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-gray" id="zoomIn">+ Zoom In</button>
                    <button type="button" class="btn btn-gray" id="zoomOut">− Zoom Out</button>
                    <button type="button" class="btn btn-gray" id="rotateLeft">Rotate Left</button>
                    <button type="button" class="btn btn-gray" id="rotateRight">Rotate Right</button>
                    <button type="button" class="btn btn-gray" id="resetCrop">Reset Crop</button>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="group">
                <label for="button_text">Button Text</label>
                <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $banner->button_text) }}">
            </div>

            <div class="group">
                <label for="button_link">Button Link</label>
                <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $banner->button_link) }}">
            </div>

            <div class="group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $banner->sort_order) }}">
            </div>

            <div class="group">
                <label for="status">Banner Status</label>
                <select id="status" name="status">
                    <option value="1" {{ (string) old('status', (int) $banner->status) === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ (string) old('status', (int) $banner->status) === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="group">
                <label>Preview of image being saved</label>
                <div class="preview-frame">
                    <img
                        id="finalPreview"
                        src="{{ asset('image/banners/' . $banner->image) }}"
                        alt="Banner preview"
                    >
                </div>
                <div class="help">When you select a replacement image, this preview will show its crop.</div>
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-green" id="saveBanner">Save Changes</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-gray">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editBannerForm');
    const fileInput = document.getElementById('image');
    const cropImage = document.getElementById('cropImage');
    const workspace = document.getElementById('cropWorkspace');
    const finalPreview = document.getElementById('finalPreview');
    const zoomControl = document.getElementById('zoomControl');
    const zoomValue = document.getElementById('zoomValue');
    const qualityControl = document.getElementById('qualityControl');
    const qualityValue = document.getElementById('qualityValue');
    const saveButton = document.getElementById('saveBanner');

    let cropper = null;
    let sourceUrl = null;
    let preparing = false;

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function makePreview() {
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

            const previewUrl = URL.createObjectURL(blob);
            const previousUrl = finalPreview.dataset.objectUrl;

            finalPreview.onload = function () {
                if (previousUrl) URL.revokeObjectURL(previousUrl);
                finalPreview.onload = null;
            };

            finalPreview.src = previewUrl;
            finalPreview.dataset.objectUrl = previewUrl;
        }, 'image/jpeg', Number(qualityControl.value) / 100);
    }

    fileInput.addEventListener('change', function () {
        const file = fileInput.files && fileInput.files[0];
        if (!file) {
            destroyCropper();
            workspace.style.display = 'none';
            return;
        }

        if (!file.type.startsWith('image/') || file.size > 5 * 1024 * 1024) {
            alert('Choose a valid image that is no larger than 5 MB.');
            fileInput.value = '';
            return;
        }

        destroyCropper();

        if (sourceUrl) URL.revokeObjectURL(sourceUrl);
        sourceUrl = URL.createObjectURL(file);

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
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                ready: function () {
                    zoomControl.value = 0;
                    zoomValue.textContent = '100%';
                    makePreview();
                },
                crop: makePreview
            });
        };

        cropImage.src = sourceUrl;
        workspace.style.display = 'block';
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
        if (cropper) {
            cropper.reset();
            zoomControl.value = 0;
            zoomValue.textContent = '100%';
            makePreview();
        }
    });

    zoomControl.addEventListener('input', function () {
        if (!cropper) return;

        const ratio = 1 + Number(zoomControl.value) / 100;
        cropper.zoomTo(ratio);
        zoomValue.textContent = Math.round(ratio * 100) + '%';
    });

    qualityControl.addEventListener('input', function () {
        qualityValue.textContent = qualityControl.value + '%';
        makePreview();
    });

    form.addEventListener('submit', function (event) {
        if (!fileInput.files || !fileInput.files.length) {
            return;
        }

        if (preparing || !cropper) {
            if (!preparing) {
                event.preventDefault();
                alert('The crop editor is not ready yet. Please wait and try again.');
            }
            return;
        }

        event.preventDefault();
        saveButton.disabled = true;
        saveButton.textContent = 'Preparing Cropped Image...';

        const canvas = cropper.getCroppedCanvas({
            width: 1600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
            fillColor: '#ffffff'
        });

        if (!canvas) {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
            alert('Unable to crop this image. Please try again.');
            return;
        }

        canvas.toBlob(function (blob) {
            if (!blob) {
                saveButton.disabled = false;
                saveButton.textContent = 'Save Changes';
                alert('Unable to create the cropped image.');
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

            preparing = true;
            form.submit();
        }, 'image/jpeg', Number(qualityControl.value) / 100);
    });

    window.addEventListener('beforeunload', function () {
        destroyCropper();
        if (sourceUrl) URL.revokeObjectURL(sourceUrl);
    });
});
</script>
@endsection
