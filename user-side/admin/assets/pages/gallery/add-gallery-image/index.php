<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Upload Images</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Upload Images</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Upload Images</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=gallery-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All Images
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="uploadImagesForm" enctype="multipart/form-data">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="galleryImages" class="form-label">Images:</label>
                            <div class="d-flex gap-2">
                                <input type="file" id="galleryImages" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                                <button type="button" class="btn btn-outline-danger" id="clearAllImages" style="white-space: nowrap;">Clear All</button>
                            </div>
                            <small class="text-muted">You can select images multiple times to add more</small>
                        </div>
                    </div>
                </div>
                
                <!-- Image Preview Section -->
                <div class="row" id="imagePreviewContainer">
                    <!-- Image previews will be inserted here -->
                </div>

                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitUploadImages">Save Images</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle image preview with individual title fields
    const galleryImages = document.getElementById('galleryImages');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const clearAllBtn = document.getElementById('clearAllImages');
    
    // Store all selected files across multiple selections
    let allSelectedFiles = [];
    
    if (galleryImages) {
        galleryImages.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);
            
            // Add new files to the collection
            allSelectedFiles = allSelectedFiles.concat(newFiles);
            
            // Get current count for proper indexing
            const startIndex = imagePreviewContainer.children.length;
            
            // Create placeholders for new files only
            const placeholders = newFiles.map((file, localIndex) => {
                if (file.type.startsWith('image/')) {
                    const globalIndex = startIndex + localIndex;
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.setAttribute('data-index', globalIndex);
                    col.innerHTML = `
                        <div class="card position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 px-10 py-10" onclick="removeImage(${globalIndex})" style="z-index: 10; padding: 2px 8px;">
                                <iconify-icon icon="solar:trash-bin-minimalistic-outline"></iconify-icon>
                            </button>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <label for="imageTitle${globalIndex}" class="form-label">Image Title:</label>
                                <input type="text" 
                                       id="imageTitle${globalIndex}" 
                                       name="image_titles[]" 
                                       class="form-control" 
                                       placeholder="Enter title for this image"
                                       required>
                                <small class="text-muted">Image ${globalIndex + 1} of ${allSelectedFiles.length}</small>
                            </div>
                        </div>
                    `;
                    imagePreviewContainer.appendChild(col);
                    return { col, file, index: globalIndex };
                }
                return null;
            }).filter(item => item !== null);
            
            // Load images asynchronously but insert them into pre-created placeholders
            placeholders.forEach(({ col, file, index }) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = col.querySelector('.card-img-top');
                    img.innerHTML = `<img src="${e.target.result}" class="w-100 h-100" alt="Preview" style="object-fit: cover;">`;
                };
                
                reader.readAsDataURL(file);
            });
            
            // Update total count for all images
            updateImageCounts();
            
            // Clear the file input so the same files can be selected again if needed
            e.target.value = '';
        });
    }
    
    // Remove individual image
    window.removeImage = function(index) {
        const col = document.querySelector(`[data-index="${index}"]`);
        if (col) {
            col.remove();
            allSelectedFiles.splice(index, 1);
            
            // Reindex remaining images
            const remainingCols = imagePreviewContainer.querySelectorAll('.col-md-3');
            remainingCols.forEach((col, newIndex) => {
                col.setAttribute('data-index', newIndex);
                const removeBtn = col.querySelector('button[onclick^="removeImage"]');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeImage(${newIndex})`);
                }
                const titleInput = col.querySelector('input[name="image_titles[]"]');
                if (titleInput) {
                    titleInput.id = `imageTitle${newIndex}`;
                }
                const label = col.querySelector('label');
                if (label) {
                    label.setAttribute('for', `imageTitle${newIndex}`);
                }
            });
            
            updateImageCounts();
        }
    };
    
    // Clear all images
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            if (allSelectedFiles.length > 0) {
                if (confirm('Are you sure you want to clear all images?')) {
                    imagePreviewContainer.innerHTML = '';
                    allSelectedFiles = [];
                    galleryImages.value = '';
                }
            }
        });
    }
    
    // Update image counts
    function updateImageCounts() {
        const totalCount = allSelectedFiles.length;
        const allSmallTags = imagePreviewContainer.querySelectorAll('small.text-muted');
        allSmallTags.forEach((small, index) => {
            small.textContent = `Image ${index + 1} of ${totalCount}`;
        });
    }
    
    // Handle Upload Images form submit
    const uploadImagesForm = document.getElementById('uploadImagesForm');
    if (uploadImagesForm) {
        uploadImagesForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitUploadImages');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            // Validate that images are selected
            if (allSelectedFiles.length === 0) {
                Swal.fire('Validation Error', 'Please select at least one image.', 'warning');
                btn.disabled = false;
                btn.textContent = 'Save Images';
                return;
            }

            // Validate that all titles are filled
            const titleInputs = document.querySelectorAll('input[name="image_titles[]"]');
            let allTitlesFilled = true;
            titleInputs.forEach(input => {
                if (!input.value.trim()) {
                    allTitlesFilled = false;
                    input.classList.add('is-invalid');
                }
            });

            if (!allTitlesFilled) {
                Swal.fire('Validation Error', 'Please fill in titles for all images.', 'warning');
                btn.disabled = false;
                btn.textContent = 'Save Images';
                return;
            }

            // Remove invalid class on validation pass
            titleInputs.forEach(input => input.classList.remove('is-invalid'));

            const csrf_token = document.querySelector('input[name="csrf_token"]').value;
            const formData = new FormData();

            // Append all images
            allSelectedFiles.forEach((file, index) => {
                formData.append('gallery_images[]', file);
                const titleInput = document.querySelector(`#imageTitle${index}`);
                formData.append('gallery_titles[]', titleInput.value);
            });

            formData.append('action', 'add_gallery_images');
            formData.append('csrf_token', csrf_token);

            fetch('assets/includes/functions/ajax-handlers/gallery/add_gallery_images.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message || 'Gallery images added successfully.', 'success').then(() => {
                        // Clear the form and previews
                        uploadImagesForm.reset();
                        imagePreviewContainer.innerHTML = '';
                        allSelectedFiles = [];
                        
                        // Redirect to gallery management
                        setTimeout(() => {
                            window.location.href = '<?= get_site_option('dashboard_url') ?>?page=gallery-management';
                        }, 1000);
                    });
                } else {
                    Swal.fire('Error', data.message || 'Failed to add gallery images.', 'error');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                Swal.fire('Error', 'An error occurred while saving images.', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Save Images';
            });
        }
    }
</script>