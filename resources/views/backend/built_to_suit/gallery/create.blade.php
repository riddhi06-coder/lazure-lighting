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
                  <h4>Add Built To Suit Gallery Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-gallery-built.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Built To Suit Gallery</li>
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
                        <h4>Built To Suit Gallery Form</h4>
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
                                        action="{{ route('manage-gallery-built.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        
                                        @if(!$hasRecord)
                                            <!-- ================= Banner Section ================= -->
                                            <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_heading">Banner Heading </label>
                                                <input type="text" id="banner_heading" name="banner_heading" class="form-control" placeholder="Enter Banner Heading">
                                                <div class="invalid-feedback">Please enter a banner heading.</div>
                                            </div>
    
                                            <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_image">Banner Image</label>
                                                <input class="form-control" id="banner_image" type="file" name="banner_image" 
                                                    accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage1()">
                                                <div class="invalid-feedback">Please upload a Banner Image.</div>
                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
    
    
                                                <!-- 🔍 Preview -->
                                                <div id="bannerImagePreviewContainer1" style="display: none; margin-top: 10px;">
                                                    <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            </div>

                                            <hr class="mt-4 mb-4">
                                        
                                        @endif

                                        <!-- ================= Banner Section ================= -->
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="project_name">Project Name <span class="txt-danger">*</span></label>
                                            <input type="text" id="project_name" name="project_name" class="form-control" placeholder="Enter Project Name" required>
                                            <div class="invalid-feedback">Please enter a Project Name.</div>
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="thumbnail_image">Project Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" 
                                                accept=".jpg, .jpeg, .png, .webp" required onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Project Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>


                                            <!-- 🔍 Preview -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" 
                                                    style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>
                                        
                                        <hr class="mt-4 mb-4">
                                        
                                        <!-- Gallery Upload -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>Images <span class="txt-danger">*</span> </strong></h6>
                                            <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Upload Image</th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <!-- Upload Image -->
                                                        <td>
                                                            <input type="file" accept=".png, .jpg, .jpeg, .webp, .svg"
                                                                   name="gallery_images[]" 
                                                                   onchange="previewGalleryImage(this, 0)" 
                                                                   id="gallery_image_0" 
                                                                   class="form-control" required>
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                        </td>
                                        
                                                        <!-- Preview -->
                                                        <td>
                                                            <div id="gallery-preview-container-0" class="mt-2"></div>
                                                        </td>
                                        
                                                        <!-- Action -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addGalleryRow">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>



                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-gallery-built.index') }}" class="btn btn-danger px-4">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Submit</button>
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
        const file = document.getElementById('thumbnail_image').files[0];
        const previewContainer = document.getElementById('bannerImagePreviewContainer');
        const previewImage = document.getElementById('thumbnail_image_preview');

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
    
    function previewBannerImage1() {
        const file = document.getElementById('banner_image').files[0];
        const previewContainer = document.getElementById('bannerImagePreviewContainer1');
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
    let galleryIndex = document.querySelectorAll("#galleryTable tbody tr").length - 1;

    function previewGalleryImage(input, index) {
        let container = document.getElementById(`gallery-preview-container-${index}`);
        if (!container) return; // Prevent JS error

        container.innerHTML = "";

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                container.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("click", function(e) {
        if (e.target.id === "addGalleryRow") {
            galleryIndex++;

            let newRow = `
                <tr>
                    <td>
                        <input type="file" name="gallery_images[]"
                               class="form-control"
                               accept=".png, .jpg, .jpeg, .webp"
                               onchange="previewGalleryImage(this, ${galleryIndex})" required>
                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                    </td>
                    <td>
                        <div id="gallery-preview-container-${galleryIndex}" class="mt-2"></div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                    </td>
                </tr>
            `;
            document.querySelector("#galleryTable tbody").insertAdjacentHTML("beforeend", newRow);
        }

        if (e.target.classList.contains("removeGalleryRow")) {
            e.target.closest("tr").remove();
        }
    });
</script>





</body>

</html>