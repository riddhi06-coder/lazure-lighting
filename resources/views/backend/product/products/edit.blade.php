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
                  <h4>Edit Product Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-product.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Product Details</li>
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
                        <h4>Product Details Form</h4>
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
                                        action="{{ route('manage-product.update', $banner_details->id) }}" 
                                        method="POST" 
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <!-- Banner Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title</label>
                                            <input class="form-control" 
                                                id="banner_title" 
                                                type="text" 
                                                name="banner_title" 
                                                placeholder="Enter Banner Title"
                                                value="{{ old('banner_title', $banner_details->banner_title) }}">
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image</label>
                                            <input class="form-control" 
                                                id="banner_image" 
                                                type="file" 
                                                name="banner_image" 
                                                accept=".jpg, .jpeg, .png, .webp" 
                                                onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            @if($banner_details->banner_image)
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" 
                                                        src="{{ asset($banner_details->banner_image) }}" 
                                                        alt="Preview" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @else
                                                <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                    <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>

                                        <hr>

                                        <!-- Application Type -->
                                        <!-- <div class="col-md-6">
                                            <label class="form-label" for="application_type">Application Type <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="application_type" name="application_type" required>
                                                <option value="">-- Select Application Type --</option>
                                                @foreach($applications as $application)
                                                    <option value="{{ $application->id }}" {{ $application->id == $banner_details->application_id ? 'selected' : '' }}>
                                                        {{ $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select an Application Type.</div>
                                        </div> -->


                                       <!-- Application Type -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="application_type">Main Category <span class="txt-danger">*</span></label>
                                            <select class="form-control select2" id="application_type" name="application_type[]" multiple required>
                                                @foreach($applications as $application)
                                                    <option value="{{ $application->id }}"
                                                        @if(in_array($application->id, old('application_type', $selectedApplications ?? []))) selected @endif>
                                                        {{ $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select at least one Main Category.</div>
                                        </div>



                                        <!-- Category -->
                                        <!-- <div class="col-md-6">
                                            <label class="form-label" for="parent_category">Category <span class="txt-danger">*</span></label>
                                            <select name="parent_category" class="form-control" id="parent_category">
                                                <option value="">Select Category</option>
                                                @if(isset($categories))
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $category->id == $banner_details->category_id ? 'selected' : '' }}>
                                                            {{ $category->category }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Please select a Category.</div>
                                        </div> -->


                                        <div class="col-md-6">
                                            <label class="form-label" for="parent_category">Sub Category <span class="txt-danger">*</span></label>
                                            <select name="parent_category[]" class="form-control select2" id="parent_category" multiple required>
                                                {{-- Filled by JS --}}
                                            </select>
                                            <div class="invalid-feedback">Please select at least one Sub Category.</div>
                                        </div>



                                         <!-- Light Application Type -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="light_application_type">Light Application Type <span class="txt-danger">*</span></label>
                                            <select class="form-control select2" id="light_application_type" name="light_application_type[]" multiple required>
                                                @foreach($light_applications as $applications)
                                                    <option value="{{ $applications->id }}"
                                                        @if(in_array($applications->id, old('light_application_type', $selectedLightApplications ?? []))) selected @endif>
                                                        {{ $applications->light_application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select at least one Application Type.</div>
                                        </div>



                                        <!-- Product -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="product">Product <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="product" 
                                                type="text" 
                                                name="product" 
                                                placeholder="Enter Product" 
                                                value="{{ old('product', $banner_details->product) }}" 
                                                required>
                                            <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                        </div>

                                        <!-- Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="thumbnail_image" 
                                                type="file" 
                                                name="thumbnail_image" 
                                                accept=".jpg, .jpeg, .png, .webp" 
                                                onchange="previewThumbnailImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            @if($banner_details->thumbnail_image)
                                                <div id="thumbnailImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="thumbnail_image_preview" 
                                                        src="{{ asset($banner_details->thumbnail_image) }}" 
                                                        alt="Preview" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @else
                                                <div id="thumbnailImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                    <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        
                                        
                                        
                                        <!-- Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="other_thumbnail_image">Other Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="other_thumbnail_image" 
                                                type="file" 
                                                name="other_thumbnail_image" 
                                                accept=".jpg, .jpeg, .png, .webp" 
                                                onchange="otherpreviewThumbnailImage()">
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            @if($banner_details->thumbnail_image1)
                                                <div id="otherthumbnailImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="otherthumbnail_image_preview" 
                                                        src="{{ asset($banner_details->thumbnail_image1) }}" 
                                                        alt="Preview" 
                                                        class="img-fluid" 
                                                        style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @else
                                                <div id="otherthumbnailImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                    <img id="otherthumbnail_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-product.index') }}" class="btn btn-danger px-4">Cancel</a>
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
            
            function otherpreviewThumbnailImage() {
                const file = document.getElementById('other_thumbnail_image').files[0];
                const previewContainer = document.getElementById('otherthumbnailImagePreviewContainer');
                const previewImage = document.getElementById('otherthumbnail_image_preview');

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

        <!---- fetching categories on basis of application type js--->
        <script>
            $(document).ready(function () {
                // initialize all select2
                $('#application_type, #light_application_type, #parent_category').select2({
                    placeholder: "-- Select --",
                    allowClear: true,
                    width: '100%'
                });

                // saved category ids from backend (Laravel will JSON encode)
                let selectedCategories = @json($selectedCategories);

                // when application type changes
                $('#application_type').on('change', function () {
                    fetchCategories($(this).val(), selectedCategories);
                });

                // 🔹 trigger fetch once on page load (for edit)
                if ($('#application_type').val().length > 0) {
                    fetchCategories($('#application_type').val(), selectedCategories);
                }

                function fetchCategories(appIds, preselected = []) {
                    if (appIds && appIds.length > 0) {
                        $.ajax({
                            url: '/get-categories',
                            type: 'POST',
                            data: { ids: appIds, _token: '{{ csrf_token() }}' },
                            success: function (data) {
                                let options = '';
                                $.each(data, function (key, category) {
                                    let selected = preselected.includes(category.id.toString()) ? 'selected' : '';
                                    options += `<option value="${category.id}" ${selected}>${category.category}</option>`;
                                });

                                $('#parent_category').html(options).trigger('change');
                            }
                        });
                    } else {
                        $('#parent_category').html('').trigger('change');
                    }
                }
            });

        </script>






</body>

</html>