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
                  <h4>Edit Featured Products Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-featured-products.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Featured Products Details</li>
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
                        <h4>Featured Products Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-featured-products.update', $banner_details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Banner Heading-->
                                        <div class="col-xxl-4 col-sm-12">
                                            <label class="form-label" for="section_heading">Section Heading </label>
                                            <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" value="{{ old('section_heading', $banner_details->section_heading) }}">
                                            <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <!-- Banner Heading -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="banner_heading"> Heading <span class="txt-danger">*</span></label>
                                                <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Heading" value="{{ old('banner_heading', $banner_details->banner_heading) }}" required>
                                                <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                            </div>

                                            <!-- Banner Title -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="banner_title"> Title <span class="txt-danger">*</span></label>
                                                <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Title" value="{{ old('banner_title', $banner_details->banner_title) }}" required>
                                                <div class="invalid-feedback">Please enter a Banner Title.</div>
                                            </div>
                                        </div>

                                        <!-- Image Upload Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label" for="banner_image">Image <span class="txt-danger">*</span></label>
                                                <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                                <div class="invalid-feedback">Please upload a Banner Image.</div>
                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                                <!-- Existing Image Preview -->
                                                @if($banner_details->banner_images)
                                                    <div id="existingBannerImageContainer" class="mt-3">
                                                        <label class="form-label">Current Image:</label><br>
                                                        <img src="{{ asset('uploads/home/featured/' . $banner_details->banner_images) }}" alt="Current Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                    </div>
                                                @endif

                                                <!-- New Image Preview -->
                                                <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                    <label class="form-label">New Preview:</label><br>
                                                    <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-featured-products.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        const input = document.getElementById('banner_image');
        const previewContainer = document.getElementById('bannerImagePreviewContainer');
        const preview = document.getElementById('banner_image_preview');
        const existingContainer = document.getElementById('existingBannerImageContainer');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                if (existingContainer) {
                    existingContainer.style.display = 'none'; // Hide existing image
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>

</html>