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
                  <h4>Edit Projects Category Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-project-category.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Projects Category</li>
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
                        <h4>Projects Category Form</h4>
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
                                        action="{{ route('manage-project-category.update', $appIntro->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') {{-- Required for update --}}

                                        <!-- Project Category -->
                                        <div class="col-xxl-4 col-sm-6">
                                            <label class="form-label" for="project_category">Projects Category <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="project_category" 
                                                type="text" 
                                                name="project_category" 
                                                value="{{ old('project_category', $appIntro->category_name) }}" 
                                                placeholder="Enter Projects Category" required>
                                            <div class="invalid-feedback">Please enter a Projects Category.</div>
                                        </div>

                                        <!-- Thumbnail Image -->
                                        <div class="col-xxl-4 col-sm-6">
                                            <label class="form-label" for="banner_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="banner_image" 
                                                type="file" 
                                                name="banner_image" 
                                                accept=".jpg, .jpeg, .png, .webp" 
                                                onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>

                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- Current Image Preview -->
                                            @if($appIntro->banner_image && file_exists(public_path($appIntro->banner_image)))
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" 
                                                        src="{{ asset($appIntro->banner_image) }}" 
                                                        alt="Preview" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @else
                                                <div id="bannerImagePreviewContainer" style="display:none; margin-top: 10px;">
                                                    <img id="banner_image_preview" 
                                                        src="" 
                                                        alt="Preview" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-project-category.index') }}" class="btn btn-danger px-4">Cancel</a>
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
</body>

</html>