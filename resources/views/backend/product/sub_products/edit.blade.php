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
                  <h4>Edit Sub Product Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-sub-product.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Sub Product Details</li>
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
                        <h4>Sub Product Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-sub-product.update', $banner_details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Banner Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title </label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title"
                                                value="{{ old('banner_title', $banner_details->banner_title) }}">
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image </label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- Show existing banner image preview if exists -->
                                            @if($banner_details->banner_image)
                                                <div style="margin-top: 10px;">
                                                    <img src="{{ asset($banner_details->banner_image) }}" alt="Banner Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                            <!-- Preview container for new image -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Product -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="product_id">Product <span class="txt-danger">*</span></label>
                                            <select name="product_id" class="form-control" id="product_id" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $p)
                                                    <option value="{{ $p->id }}" {{ (old('product_id', $banner_details->product_id) == $p->id) ? 'selected' : '' }}>{{ $p->product }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Product.</div>
                                        </div>

                                        <!-- Application Type -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="application_type">Main Category <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="application_type" disabled multiple>
                                                @foreach($applications as $application)
                                                    <option value="{{ $application->id }}"
                                                        {{ in_array($application->id, $selectedApplications) ? 'selected' : '' }}>
                                                        {{ $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="application_type" id="application_type_hidden" value="{{ implode(',', $selectedApplications) }}">


                                            <div class="invalid-feedback">Please select an Main Category.</div>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="parent_category">Sub Category <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="parent_category" disabled multiple>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="parent_category" id="parent_category_hidden" value="{{ implode(',', $selectedCategories) }}">

                                            <div class="invalid-feedback">Please select a Sub Category.</div>
                                        </div>


                                        <!-- Light Application Type -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="light_application_type">Light Application Type <span class="txt-danger">*</span></label>
                                            <select class="form-control select2" id="light_application_type" name="light_application_type[]" multiple required>
                                                @foreach($light_applications as $lightApp)
                                                    <option value="{{ $lightApp->id }}"
                                                        {{ in_array($lightApp->id, $selectedLightApplications) ? 'selected' : '' }}>
                                                        {{ $lightApp->light_application_type }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="invalid-feedback">Please select at least one Application Type.</div>
                                        </div>


                                        <!-- Sub Product -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="sub_product">Sub Product <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="sub_product" type="text" name="sub_product" placeholder="Enter Sub Product" required value="{{ old('sub_product', $banner_details->sub_product) }}">
                                            <div class="invalid-feedback">Please enter a Sub Product.</div>
                                        </div>

                                        <!-- Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewThumbnailImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- Show existing thumbnail image -->
                                            @if($banner_details->thumbnail_image)
                                                <div style="margin-top: 10px;">
                                                    <img src="{{ asset($banner_details->thumbnail_image) }}" alt="Thumbnail Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                            <!-- Preview container for new image -->
                                            <div id="thumbnailImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
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
                                            <a href="{{ route('manage-sub-product.index') }}" class="btn btn-danger px-4">Cancel</a>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- jQuery (required for Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!---- Select 2 js--->
        <script>
            $(document).ready(function() {
                $('#application_type').select2({
                    placeholder: "-- Select Main Category --",
                    allowClear: true,
                    width: '100%'
                });

                $('#light_application_type').select2({
                    placeholder: "-- Select Light Application Type --",
                    allowClear: true,
                    width: '100%'
                });

                $('#parent_category').select2({
                    placeholder: "-- Select Sub Category --",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>


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


        <script>
        $(document).ready(function () {
                $('#product_id').on('change', function () {
                    let productId = $(this).val();

                    if (productId) {
                        $.ajax({
                            url: '/get-product-details/' + productId,
                            type: 'GET',
                            success: function (data) {
                                if (data.application_id) {
                                    $('#application_type').val(data.application_id);
                                    $('#application_type_hidden').val(data.application_id);
                                } else {
                                    $('#application_type').val('');
                                    $('#application_type_hidden').val('');
                                }

                                if (data.category_id) {
                                    $('#parent_category').html(`<option value="${data.category_id}">${data.category}</option>`);
                                    $('#parent_category_hidden').val(data.category_id);
                                } else {
                                    $('#parent_category').html('<option value="">Select Sub Category</option>');
                                    $('#parent_category_hidden').val('');
                                }
                            },
                            error: function (xhr) {
                                console.log("Error fetching product details:", xhr.responseText);
                                // Reset selects and hidden inputs on error
                                $('#application_type').val('');
                                $('#application_type_hidden').val('');
                                $('#parent_category').html('<option value="">Select Sub Category</option>');
                                $('#parent_category_hidden').val('');
                            }
                        });
                    } else {
                        // Reset on no product selected
                        $('#application_type').val('');
                        $('#application_type_hidden').val('');
                        $('#parent_category').html('<option value="">Select Sub Category</option>');
                        $('#parent_category_hidden').val('');
                    }
                });
            });

        </script>





</body>

</html>