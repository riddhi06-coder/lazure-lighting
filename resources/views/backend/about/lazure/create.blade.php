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
                  <h4>Add Lazure Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-about-us.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Lazure Details</li>
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
                        <h4>Lazure Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-about-us.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
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
                                            
                                            
                                               
                                            <!-- Youtube URL -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="youtube_url">Youtube URL </label>
                                                <input class="form-control" id="youtube_url" type="text" name="youtube_url" placeholder="Enter Youtube URL">
                                                <div class="invalid-feedback">Please enter a Youtube URL.</div>
                                            </div>


                                            <!-- Video Upload -->
                                            <div class="col-md-6 mt-5">
                                                <label class="form-label" for="banner_video">About Video </label>
                                                <input class="form-control" id="banner_video" type="file" name="banner_video" 
                                                    accept="video/mp4,video/webm,video/ogg" onchange="previewBannerVideo(this)">
                                                <div class="invalid-feedback">Please upload a Banner Video.</div>
                                                <small class="text-secondary"><b>Note: The file size should be less than 4MB.</b></small><br>
                                                <small class="text-secondary"><b>Note: Only .mp4, .webm, .ogg formats allowed.</b></small>

                                                <!-- 🔍 Video Preview -->
                                                <div id="bannerVideoPreviewContainer" style="display: none; margin-top: 10px;">
                                                    <video id="banner_video_preview" controls autoplay muted playsinline 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                        <source src="">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>

                                            </div>

                                            <!-- Thumbnail Image Upload -->
                                            <div class="col-md-6 mt-5">
                                                <label class="form-label" for="thumbnail_image">Video Thumbnail Image </label>
                                                <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" 
                                                    accept=".jpg, .jpeg, .png, .webp" onchange="previewThumbnailImage()">
                                                <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                                <!-- 🔍 Thumbnail Preview -->
                                                <div id="thumbnailPreviewContainer" style="display: none; margin-top: 10px;">
                                                    <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            </div>
                                        </div>
                                        
                                     

                                        <hr>
                                        
                                        <!-- Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="heading">Heading <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="heading" type="text" name="heading" placeholder="Enter Heading" required>
                                            <div class="invalid-feedback">Please enter a Heading.</div>
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
                                                    style="max-height: 100px; border: 1px solid #ddd; padding: 5px;">
                                            </div>

                                        </div>


                                        <!-- Banner Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="image_title">Image Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="image_title" type="text" name="image_title" placeholder="Enter Image Title" required>
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label" for="extra_image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="extra_image" type="file" name="extra_image"
                                                accept=".jpg, .jpeg, .png, .webp" required onchange="previewExtraImage()">
                                            <div class="invalid-feedback">Please upload an Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only .jpg, .jpeg, .png, .webp allowed.</b></small>

                                            <!-- 🔍 Preview -->
                                              <!-- 🔍 Correct Preview Container -->
                                            <div id="extraImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="extra_image_preview" src="" alt="Preview" class="img-fluid"
                                                    style="max-height: 100px; border: 1px solid #ddd; padding: 5px;">
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
                                            <a href="{{ route('manage-about-us.index') }}" class="btn btn-danger px-4">Cancel</a>
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

     // Thumbnail Image Preview
    function previewThumbnailImage() {
        const input = document.getElementById('thumbnail_image');
        const previewContainer = document.getElementById('thumbnailPreviewContainer');
        const preview = document.getElementById('thumbnail_image_preview');

        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            previewContainer.style.display = 'block';
        }
    }

    // Video Preview + Size Validation
    function previewBannerVideo(input) {
        const file = input.files[0];
        const previewContainer = document.getElementById('bannerVideoPreviewContainer');
        const preview = document.getElementById('banner_video_preview');

        if (file) {
            if (file.size > 4 * 1024 * 1024) { // 3 MB
                alert("Video size must be less than 4MB.");
                input.value = ""; // clear input
                previewContainer.style.display = 'none';
                return;
            }
            preview.querySelector("source").src = URL.createObjectURL(file);
            preview.load();
            previewContainer.style.display = 'block';
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

            // 🔥 Apply black background behind the icon only
            preview.style.backgroundColor = '#000';
            preview.style.padding = '10px'; // optional: spacing around icon
            preview.style.borderRadius = '6px'; // optional: rounded look
        }
    }

    function previewExtraImage() {
        const input = document.getElementById('extra_image');
        const previewContainer = document.getElementById('extraImagePreviewContainer');
        const preview = document.getElementById('extra_image_preview');

        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            previewContainer.style.display = 'block';
        }
    }

</script>
</body>

</html>