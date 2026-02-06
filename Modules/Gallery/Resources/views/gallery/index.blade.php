@extends('setting::layouts.master')

@section('title', 'Galleries')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Galleries</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Gallery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Galleries</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Galleries</h4>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galleries as $key => $gallery)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $gallery->title }}</td>
                                                <td>{{ $gallery->category->title ?? 'N/A' }}</td>

                                                <td><a href="{{ asset($gallery->image) }}" target="_blank" title="Click to view"><img src="{{ asset($gallery->image) }}" alt="Gallery image" width="100"></a></td>

                                                <td class="text-center">
                                                    @if ($gallery->status == 'on')
                                                        <a href="{{ route('galleries.status', $gallery->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('galleries.status', $gallery->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('delete_galleries')
                                                        
                                                  
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
                                        event.preventDefault();
                                        if (confirm('Are you sure? It will delete the data permanently!')) {
                                            document.getElementById('destroy{{ $gallery->id }}').submit()
                                        }
                                        ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $gallery->id }}" class="d-none"
                                                            action="{{ route('galleries.destroy', $gallery->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                      @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal for Viewing Galleries -->
                                {{-- <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="galleryModalLabel">Galleries in Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" id="galleryContent">
                                                    <!-- Galleries will be loaded here via JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Create Gallery</h4>
                            </div>
                            <form action="{{ route('galleries.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Gallery Title">
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category" class="form-control">
                                            <option value="" disabled selected>Select Gallery Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" id="file-ip-1" accept="image/*" class="form-control-file" name="images[]" multiple onchange="validateAndPreview(event);">
                                        <small class="form-text text-muted">
                                            Required formats: JPG, PNG, WEBP |
                                            Allowed sizes: 349×160px or 301×675px |
                                            Max size: 2MB per image
                                        </small>
                                        @error('images')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="preview mt-2 d-flex flex-wrap" id="file-preview-zone"></div>
                                        <div id="size-error" class="text-danger mt-2" style="display: none;"></div>
                                    </div>

                                    <!-- Cropper Modal -->
                                    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Crop Image to Required Size</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="img-container">
                                                                <img id="imageToCrop" src="" alt="Crop Image">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="size-options">
                                                                <h6>Select Target Size:</h6>
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-outline-primary active">
                                                                        <input type="radio" name="sizeOption" value="349x160" checked> 349×160
                                                                    </label>
                                                                    <label class="btn btn-outline-primary">
                                                                        <input type="radio" name="sizeOption" value="301x675"> 301×675
                                                                    </label>
                                                                </div>
                                                                <div class="preview-size mt-3">
                                                                    <div class="size-preview" id="sizePreview" style="width: 100px; height: 46px; border: 2px dashed #ccc;"></div>
                                                                    <small class="text-muted">Aspect ratio preview</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="cropImageBtn">Crop & Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                        /* Preview styling */
                                        .preview-image-container {
                                            position: relative;
                                            margin: 5px;
                                            width: 120px;
                                            height: 120px;
                                            border: 1px solid #ddd;
                                            border-radius: 4px;
                                            overflow: hidden;
                                        }

                                        .preview-image {
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                        }

                                        .remove-image-btn {
                                            position: absolute;
                                            top: 0;
                                            right: 0;
                                            background: rgba(255,0,0,0.7);
                                            color: white;
                                            border: none;
                                            border-radius: 0 0 0 4px;
                                            cursor: pointer;
                                            padding: 2px 5px;
                                            font-size: 12px;
                                        }

                                        .image-size-badge {
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            background: rgba(0,0,0,0.7);
                                            color: white;
                                            padding: 2px 5px;
                                            font-size: 10px;
                                            border-radius: 0 4px 0 0;
                                        }

                                        /* Cropper modal styling */
                                        .img-container {
                                            height: 500px;
                                            background-color: #f5f5f5;
                                        }

                                        /* Size preview */
                                        .size-preview {
                                            margin: 0 auto;
                                            background-color: #f8f9fa;
                                        }
                                    </style>

                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

                                    <script>
                                        let cropper;
                                        let currentFile;
                                        let croppedImages = [];
                                        let currentAspectRatio = 349/160;

                                        function validateAndPreview(event) {
                                            const files = event.target.files;
                                            const previewZone = document.getElementById('file-preview-zone');
                                            const errorDiv = document.getElementById('size-error');
                                            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                                            const maxSize = 2 * 1024 * 1024; // 2MB
                                            const allowedDimensions = [
                                                {width: 349, height: 160},
                                                {width: 301, height: 675}
                                            ];

                                            // Clear previous errors
                                            errorDiv.style.display = 'none';
                                            errorDiv.innerHTML = '';

                                            // Process each file
                                            for (let i = 0; i < files.length; i++) {
                                                const file = files[i];

                                                // Validate file type
                                                if (!allowedTypes.includes(file.type)) {
                                                    showError(`File ${file.name}: Invalid format. Only JPG, PNG, WEBP allowed.`);
                                                    continue;
                                                }

                                                // Validate file size
                                                if (file.size > maxSize) {
                                                    showError(`File ${file.name}: Too large (max 2MB allowed)`);
                                                    continue;
                                                }

                                                // Check dimensions after load
                                                const reader = new FileReader();
                                                reader.onload = function(e) {
                                                    const img = new Image();
                                                    img.onload = function() {
                                                        const isValidSize = allowedDimensions.some(dim =>
                                                            (this.width === dim.width && this.height === dim.height)
                                                        );

                                                        if (!isValidSize) {
                                                            // Show modal for cropping if size doesn't match
                                                            currentFile = file;
                                                            showCropModal(e.target.result);
                                                        } else {
                                                            // Add directly if size matches
                                                            addImageToPreview(e.target.result, this.width, this.height);
                                                        }
                                                    };
                                                    img.src = e.target.result;
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        }

                                        function showCropModal(imageSrc) {
                                            const modal = $('#cropModal');
                                            const image = document.getElementById('imageToCrop');
                                            const sizePreview = document.getElementById('sizePreview');

                                            image.src = imageSrc;
                                            updateSizePreview();

                                            modal.modal('show');

                                            modal.on('shown.bs.modal', function () {
                                                if (cropper) {
                                                    cropper.destroy();
                                                }

                                                cropper = new Cropper(image, {
                                                    aspectRatio: currentAspectRatio,
                                                    viewMode: 1,
                                                    autoCropArea: 1,
                                                    responsive: true,
                                                    guides: true
                                                });
                                            });

                                            // Handle size option changes
                                            $('input[name="sizeOption"]').change(function() {
                                                const dimensions = this.value.split('x');
                                                currentAspectRatio = dimensions[0] / dimensions[1];
                                                cropper.setAspectRatio(currentAspectRatio);
                                                updateSizePreview();
                                            });

                                            // Crop button handler
                                            document.getElementById('cropImageBtn').onclick = function() {
                                                const canvas = cropper.getCroppedCanvas({
                                                    width: parseInt(currentAspectRatio * 160),
                                                    height: 160
                                                });

                                                if (canvas) {
                                                    const croppedImage = canvas.toDataURL('image/jpeg', 0.9);
                                                    addImageToPreview(croppedImage, canvas.width, canvas.height);
                                                    modal.modal('hide');
                                                }
                                            };
                                        }

                                        function updateSizePreview() {
                                            const sizePreview = document.getElementById('sizePreview');
                                            if (currentAspectRatio > 1) {
                                                // Wider than tall
                                                sizePreview.style.width = '100px';
                                                sizePreview.style.height = (100 / currentAspectRatio) + 'px';
                                            } else {
                                                // Taller than wide
                                                sizePreview.style.height = '100px';
                                                sizePreview.style.width = (100 * currentAspectRatio) + 'px';
                                            }
                                        }

                                        function addImageToPreview(imageSrc, width, height) {
                                            const previewZone = document.getElementById('file-preview-zone');
                                            const container = document.createElement('div');
                                            container.className = 'preview-image-container';

                                            container.innerHTML = `
                                                <img src="${imageSrc}" class="preview-image" alt="Preview">
                                                <button class="remove-image-btn" onclick="removeImage(this)">×</button>
                                                <span class="image-size-badge">${width}×${height}</span>
                                                <input type="hidden" name="cropped_images[]" value="${imageSrc}">
                                            `;

                                            previewZone.appendChild(container);
                                            croppedImages.push(imageSrc);
                                        }

                                        function removeImage(button) {
                                            const container = button.closest('.preview-image-container');
                                            const imageSrc = container.querySelector('img').src;
                                            croppedImages = croppedImages.filter(img => img !== imageSrc);
                                            container.remove();
                                        }

                                        function showError(message) {
                                            const errorDiv = document.getElementById('size-error');
                                            errorDiv.style.display = 'block';
                                            errorDiv.innerHTML += `<p>${message}</p>`;
                                        }
                                    </script>

                                    <div class="form-group">
                                        <label>Publish</label>
                                        <input type="checkbox" name="status" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-success" type="submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script>
    let selectedFiles = []; // Store selected files

    function showPreviews(event) {
        let previewZone = document.getElementById('file-preview-zone');
        previewZone.innerHTML = ''; // Clear previous previews
        selectedFiles = Array.from(event.target.files); // Update selectedFiles with new files

        selectedFiles.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function (e) {
                let previewContainer = document.createElement('div');
                previewContainer.classList.add('preview-container');
                previewContainer.style.position = 'relative';
                previewContainer.style.display = 'inline-block';
                previewContainer.style.margin = '10px';

                // Image preview
                let img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.classList.add('m-2');

                // Delete icon
                let deleteIcon = document.createElement('span');
                deleteIcon.innerHTML = '&times;';
                deleteIcon.style.position = 'absolute';
                deleteIcon.style.top = '5px';
                deleteIcon.style.right = '5px';
                deleteIcon.style.cursor = 'pointer';
                deleteIcon.style.color = 'red';
                deleteIcon.style.fontSize = '20px';
                deleteIcon.addEventListener('click', function() {
                    removeImage(index); // Call removeImage function with index
                });

                previewContainer.appendChild(img);
                previewContainer.appendChild(deleteIcon);
                previewZone.appendChild(previewContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        selectedFiles.splice(index, 1); // Remove the file from selectedFiles array

        // Update the file input with new files
        let dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        document.getElementById('file-ip-1').files = dataTransfer.files;

        // Refresh previews
        showPreviews({ target: { files: selectedFiles } });
    }
</script>
<style>
    .preview-container {
        position: relative;
        display: inline-block;
        margin: 5px;
    }
</style>
