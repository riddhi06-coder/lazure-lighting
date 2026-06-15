<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
                  <h4>Edit Light Applications Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-light-application.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Light Applications</li>
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
                        <h4>Light Applications Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" 
                                        novalidate 
                                        action="{{ route('manage-light-application.update', $banner_details->id) }}" 
                                        method="POST" 
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
        
                                        <!-- Application Type-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="light_application_type">Light Application Type <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="light_application_type" type="text" name="light_application_type" value="{{ old('light_application_type', $banner_details->light_application_type) }}" placeholder="Enter Application Type" required>
                                            <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                        </div>
                                        
                                        
                                        <!-- sub_category -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="sub_category">Sub Category <span class="txt-danger">*</span></label>
                                            <select class="form-control select2" id="sub_category" name="sub_category[]" multiple required>
                                                <option value="">Select Sub Category</option>
                                                @foreach($categories as $id => $name)
                                                    <option value="{{ $id }}" 
                                                        {{ in_array($id, $selectedCategories) ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Sub Category.</div>
                                        </div>




                                        
                                        <!-- Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewThumbnailImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                
                                            
                                            <div id="thumbnailImagePreviewContainer" style="margin-top: 10px; display: {{ $banner_details->thumbnail_image ? 'block' : 'none' }};">
                                                <img id="thumbnail_image_preview" 
                                                    src="{{ $banner_details->thumbnail_image ? asset($banner_details->thumbnail_image) : '' }}" 
                                                    alt="Preview" 
                                                    class="img-fluid" 
                                                    style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
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
                                            <a href="{{ route('manage-light-application.index') }}" class="btn btn-danger px-4">Cancel</a>
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


<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function() {
    $('#sub_category').select2({
        placeholder: "Select Sub Category",
        allowClear: true
    });
});
</script>

<script>
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