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
                  <h4>Add Blogs List Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-blogs.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Blogs List</li>
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
                        <h4>Blogs List Form</h4>
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
                                        action="{{ route('manage-blogs.update', $blog->id) }}" 
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
                                                value="{{ old('banner_title', $blog->banner_title) }}" 
                                                placeholder="Enter Banner Title">
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
                                            @if($blog->banner_image)
                                                <div style="margin-top:10px;">
                                                    <img src="{{ asset($blog->banner_image) }}" alt="Current Banner" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                             <!-- This is needed for JS preview -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Blog Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="blog_title">Blog Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="blog_title" 
                                                type="text" 
                                                name="blog_title" 
                                                value="{{ old('blog_title', $blog->blog_title) }}" 
                                                placeholder="Enter Blog Title" 
                                                required>
                                        </div>

                                        <!-- Blog Date -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="blog_date">Date <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="blog_date" 
                                                type="date" 
                                                name="blog_date" 
                                                value="{{ old('blog_date', $blog->blog_date) }}" 
                                                required>
                                        </div>

                                        <!-- Blog Thumbnail Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="blog_image">Blog Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" 
                                                id="blog_image" 
                                                type="file" 
                                                name="blog_image" 
                                                accept=".jpg, .jpeg, .png, .webp" 
                                                onchange="previewBlogImage()">
                                            @if($blog->blog_image)
                                                <div style="margin-top:10px;">
                                                    <img src="{{ asset($blog->blog_image) }}" alt="Current Blog Image" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                              <!-- This is needed for JS preview -->
                                            <div id="blogImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="blog_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                            
                                        </div>
                                        
                                        
                                        
                                                                                
                                        <hr class="mt-4 mb-4">
                                        
                                        <!-- ================= SEO Section ================= -->


                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_title">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                                value="{{ old('meta_title', $blog->meta_title) }}">
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_description">Meta Description </label>
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="4">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        </div>
                                        
                                        
                                        
                                        
                                         <div class="col-xxl-6 col-sm-12">
                                            <label for="cannonical">Cannonical</label>
                                            <textarea name="cannonical" id="cannonical" class="form-control" rows="4">{{ old('cannonical', $blog->cannonical) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="hreflang">HrefLang</label>
                                            <textarea name="hreflang" id="hreflang" class="form-control" rows="4">{{ old('hreflang', $blog->hreflang) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">OG Tag</label>
                                            <textarea name="og_tag" id="og_tag" class="form-control" rows="4">{{ old('og_tag', $blog->og_tag) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">Twitter Card Tag</label>
                                            <textarea name="twitter_card_tag" id="twitter_card_tag" class="form-control" rows="4">{{ old('twitter_card_tag', $blog->twitter_card_tag) }}</textarea>
                                        </div>
                                        

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-blogs.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    function previewBlogImage() {
        const file = document.getElementById('blog_image').files[0];
        const previewContainer = document.getElementById('blogImagePreviewContainer');
        const previewImage = document.getElementById('blog_image_preview');

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