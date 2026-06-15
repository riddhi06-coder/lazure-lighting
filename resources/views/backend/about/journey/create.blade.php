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
                  <h4>Add Journey Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-our-journey.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Journey Details</li>
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
                        <h4>Journey Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-our-journey.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Banner Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image </label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" 
                                                accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" 
                                                    style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>
                                            
                                        <hr>
                                        

                                        <!-- Year -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="year">Year <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="year" type="text" name="year" placeholder="Enter Year" required>
                                            <div class="invalid-feedback">Please enter a Year.</div>
                                        </div>


                                        
                                        <!-- Achievement-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="achievement">Achievement <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="achievement" type="text" name="achievement" placeholder="Enter Achievement" required>
                                            <div class="invalid-feedback">Please enter a Achievement.</div>
                                        </div>

                                        
                                        <!-- Heading Icon Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="heading_icon"> Icon <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="heading_icon" type="file" name="heading_icon"
                                                accept=".jpg, .jpeg, .png, .webp, .svg" required onchange="previewHeadingIcon()">
                                            <div class="invalid-feedback">Please upload a Icon.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only .jpg, .jpeg, .png, .webp allowed.</b></small>

                                            <!-- 🔍 Preview -->
                                            <div id="headingIconPreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="heading_icon_preview" src="" alt="Preview" class="img-fluid"
                                                    style="max-height: 100px; border: 1px solid padding: 5px;">
                                            </div>

                                        </div>


                                        <div class="row mt-3">
                                            <!-- Description -->
                                            <div class="col-md-12">
                                                <label class="form-label" for="description">Description <span class="txt-danger">*</span></label>
                                                <textarea class="form-control" id="editor" name="description" rows="4" 
                                                        placeholder="Enter Description" required></textarea>
                                                <div class="invalid-feedback">Please enter a Description.</div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-our-journey.index') }}" class="btn btn-danger px-4">Cancel</a>
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

    // Heading Icon Preview
    function previewHeadingIcon() {
        const input = document.getElementById('heading_icon');
        const previewContainer = document.getElementById('headingIconPreviewContainer');
        const preview = document.getElementById('heading_icon_preview');

        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            previewContainer.style.display = 'block';
        }
    }

</script>
</body>

</html>