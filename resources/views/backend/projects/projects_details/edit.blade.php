<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Edit Projects Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-projects-details.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Projects Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Projects Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate 
                                        action="{{ route('manage-projects-details.update', $projects_list->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row g-3">
                                            <!-- Project Name -->
                                            <div class="col-sm-6">
                                                <label class="form-label" for="project_name">Project Name <span class="txt-danger">*</span></label>
                                                <select class="form-control" id="project_name" name="project_name" required>
                                                    <option value="">-- Select Project --</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" 
                                                            data-category="{{ $project->category_id }}"
                                                            {{ $projects_list->project_id == $project->id ? 'selected' : '' }}>
                                                            {{ $project->project_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select a Project.</div>
                                            </div>

                                            <!-- Project Category (readonly) -->
                                            <div class="col-sm-6">
                                                <label class="form-label" for="project_category">Project Category <span class="txt-danger">*</span></label>
                                                <select class="form-control" id="project_category" disabled>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($projects_category as $category)
                                                        <option value="{{ $category->id }}" 
                                                            {{ $projects_list->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!-- Hidden input to actually submit the category -->
                                                <input type="hidden" name="project_category" id="project_category_hidden" 
                                                    value="{{ $projects_list->category_id }}">
                                            </div>

                                       

                                            <!-- Banner Image -->
                                            <div class="col-sm-6">
                                                <label class="form-label" for="banner_image">Banner Image <span class="txt-danger">*</span></label>
                                                <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewBannerImage()">
                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" 
                                                        src="{{ $projects_list->banner_image ? asset($projects_list->banner_image) : '' }}" 
                                                        alt="Banner" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px; {{ $projects_list->banner_image ? '' : 'display:none;' }}">
                                                </div>

                                            </div>
                                        </div>


                                        <hr>

                                        <!-- Project Image -->
                                        <div class="col-sm-6">
                                            <label class="form-label" for="project_image">Project Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="project_image" type="file" name="project_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewProjectImage()">
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                            <div id="projectImagePreviewContainer" style="margin-top: 10px;">
                                                <img id="project_image_preview" 
                                                    src="{{ $projects_list->project_image ? asset($projects_list->project_image) : '' }}" 
                                                    alt="Project" 
                                                    class="img-fluid" 
                                                    style="max-height: 200px; border: 1px solid #ddd; padding: 5px; {{ $projects_list->project_image ? '' : 'display:none;' }}">
                                            </div>

                                        </div>

                                        <!-- Title -->
                                        <div class="col-sm-6">
                                            <label class="form-label" for="project_title">Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="project_title" type="text" name="project_title" 
                                                value="{{ old('project_title', $projects_list->project_title) }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <label class="form-label" for="project_description">Description <span class="txt-danger">*</span></label>
                                            <textarea class="form-control" id="project_description" name="project_description" rows="4" required>{{ old('project_description', $projects_list->project_description) }}</textarea>
                                        </div>


                                        <hr>

                                        <!-- Section Title -->
                                        <div class="col-sm-6">
                                            <label class="form-label" for="section_title">Section Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_title" type="text" name="section_title" 
                                                value="{{ old('section_title', $projects_list->section_title) }}" required>
                                        </div>

                                        

                                        <!-- Highlights -->
                                        <div class="col-12 mt-5">
                                            <div class="col-12 d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><strong>#Highlights</strong></h5>
                                                <button type="button" class="btn btn-primary" onclick="addHighlightRow()">Add More</button>
                                            </div>
                                            <table class="table table-bordered mt-3" id="highlightsTable">
                                                <tbody>
                                                    @php $highlights = json_decode($projects_list->highlights, true) ?? []; @endphp
                                                    @forelse($highlights as $highlight)
                                                        <tr>
                                                            <td><input type="text" name="highlights[]" class="form-control" value="{{ $highlight }}" required></td>
                                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td><input type="text" name="highlights[]" class="form-control" placeholder="Enter Feature" required></td>
                                                            <td><button type="button" class="btn btn-primary" onclick="addHighlightRow()">Add More</button></td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>

                                        <!-- Gallery -->
                                        <div class="col-12 mt-5">
                                            <div class="col-12 d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><strong>#Gallery Images</strong></h5>
                                                <button type="button" class="btn btn-primary" onclick="addGalleryRow()">Add More</button>
                                            </div>
                                            <table class="table table-bordered mt-3" id="galleryTable">
                                                <tbody>
                                                    @php $gallery = json_decode($projects_list->gallery_images, true) ?? []; @endphp
                                                    @foreach($gallery as $image)
                                                        <tr>
                                                            <td><input type="file" name="gallery_images[]" class="form-control"><small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                                <!-- Hidden input to track existing image -->
                                                                <input type="hidden" name="existing_gallery_images[]" value="{{ $image }}">
                                                            </td>
                                                            <td><img src="{{ asset( $image ) }}" class="gallery-preview img-fluid" style="max-height:100px;"></td>
                                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                 
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-projects-details.index') }}" class="btn btn-danger px-4">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')

<script>
    function previewBannerImage() {
        const file = document.getElementById('banner_image').files[0];
        const previewContainer = document.getElementById('bannerImagePreviewContainer');
        const previewImage = document.getElementById('banner_image_preview');

        // Clear the previous preview
        previewImage.src = '';
        
        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if (validImageTypes.includes(file.type)) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Display the image preview
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';  // Show the preview section
                };

                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid image file (jpg, jpeg, png, webp).');
            }
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const projectSelect = document.getElementById('project_name');
        const categorySelect = document.getElementById('project_category');
        const hiddenCategory = document.getElementById('project_category_hidden');

        // Set initial hidden value
        hiddenCategory.value = categorySelect.value;

        projectSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const categoryId = selectedOption.getAttribute('data-category');

            if (categoryId) {
                categorySelect.value = categoryId;
                hiddenCategory.value = categoryId;
            } else {
                categorySelect.value = '';
                hiddenCategory.value = '';
            }
        });
    });

</script>


<!-- JS for Preview and Add More -->
<script>
    function previewProjectImage() {
        const input = document.getElementById('project_image');
        const preview = document.getElementById('project_image_preview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                document.getElementById('projectImagePreviewContainer').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Add new Highlight row
    function addHighlightRow() {
        const tableBody = document.querySelector('#highlightsTable tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="highlights[]" class="form-control" placeholder="Enter Feature" required></td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
            </td>
        `;

        tableBody.appendChild(newRow);
    }

    // Remove a row
    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }


    // Add new gallery row
    function addGalleryRow() {
        const tableBody = document.querySelector('#galleryTable tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <input type="file" name="gallery_images[]" class="form-control gallery-input" accept=".jpg,.jpeg,.png,.webp" onchange="previewGalleryImage(this)">
                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp files are allowed.</b></small>
            </td>
            <td><img src="" class="gallery-preview img-fluid" style="max-height:100px; display:none;"></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;

        tableBody.appendChild(newRow);
    }

    // Remove any row (both dynamic and pre-filled)
    function removeRow(button) {
        const row = button.closest('tr');
        // remove the row
        row.remove();
    }



    function previewGalleryImage(input) {
        const preview = input.closest('tr').querySelector('.gallery-preview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


</body>

</html>