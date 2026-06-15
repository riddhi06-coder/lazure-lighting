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
                  <h4>Edit Sub Category Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-category.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Sub Category Details</li>
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
                        <h4>Sub Category Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-category.update', $banner_details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Banner Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title</label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title" value="{{ old('banner_title', $banner_details->banner_title) }}">
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image</label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            @if($banner_details->banner_image)
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" src="{{ asset($banner_details->banner_image) }}" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>

                                        <hr>

                                        <!-- Main Category -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="application_type">Main Category <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="application_type" name="application_type" required>
                                                <option value="">-- Select Main Category --</option>
                                                @foreach($applications as $application)
                                                    <option value="{{ $application->id }}" {{ $banner_details->application_id == $application->id ? 'selected' : '' }}>
                                                        {{ $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select an Main Category.</div>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="category">Sub Category <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="category" type="text" name="category" placeholder="Enter Category" value="{{ old('category', $banner_details->category) }}" required>
                                            <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                        </div>

                                        <!-- Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewThumbnailImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            @if($banner_details->thumbnail_image)
                                                <div id="thumbnailImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="thumbnail_image_preview" src="{{ asset($banner_details->thumbnail_image) }}" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        
                                        
                                        <hr class="mt-4 mb-4">
                                        
                                        <!-- ================= SEO Section ================= -->


                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_title">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                                value="{{ old('meta_title', $banner_details->meta_title) }}">
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_description">Meta Description </label>
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="4">{{ old('meta_description', $banner_details->meta_description) }}</textarea>
                                        </div>
                                        
                                         <div class="col-xxl-6 col-sm-12">
                                            <label for="cannonical">Cannonical</label>
                                            <textarea name="cannonical" id="cannonical" class="form-control" rows="4">{{ old('cannonical', $banner_details->cannonical) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="hreflang">HrefLang</label>
                                            <textarea name="hreflang" id="hreflang" class="form-control" rows="4">{{ old('hreflang', $banner_details->hreflang) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">OG Tag</label>
                                            <textarea name="og_tag" id="og_tag" class="form-control" rows="4">{{ old('og_tag', $banner_details->og_tag) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">Twitter Card Tag</label>
                                            <textarea name="twitter_card_tag" id="twitter_card_tag" class="form-control" rows="4">{{ old('twitter_card_tag', $banner_details->twitter_card_tag) }}</textarea>
                                        </div>

                                        

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-category.index') }}" class="btn btn-danger px-4">Cancel</a>
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

     function previewThumbnailImage() {
        const file = document.getElementById('thumbnail_image').files[0];
        const previewContainer = document.getElementById('thumbnailImagePreviewContainer');
        const previewImage = document.getElementById('thumbnail_image_preview');

        // Clear the previous preview
        previewImage.src = '';
        
        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if (validImageTypes.includes(file.type)) {
                const reader = new FileReader();

                reader.onload = function (e) {
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