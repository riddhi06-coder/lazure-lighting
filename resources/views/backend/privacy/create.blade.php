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
                  <h4>Add Privacy Policy Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-privacy-policy.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Privacy Policy</li>
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
                        <h4>Privacy Policy Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                     <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-privacy-policy.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        @php
                                            $firstRecord = \App\Models\PrivacyPolicy::first();
                                        @endphp
                                        
                                        @if(!$firstRecord)

                                            <!-- Section Title -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="banner_heading">Banner Heading </label>
                                                <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Banner Heading">
                                                <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                            </div>
    
    
                                            
                                            <!-- Thumbnail Image -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="image"> Banner Image </label>
                                                <input class="form-control" id="image" type="file" name="image" onchange="previewThumbnail(event)">
                                                <div class="invalid-feedback">Please upload a Banner image.</div>
                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                                <br>
                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp, .svg format can be uploaded.</b></small>
                                                
                                                <!-- Image Preview -->
                                                <div class="mt-2">
                                                    <img id="thumbnailPreview" src="#" alt="Preview" class="img-fluid rounded border d-none" style="max-height: 150px; background:black;">
                                                </div>
                                            </div>
    
    
                                            <!-- Title -->
                                            <div class="col-md-6">
                                                <label class="form-label" for="effective_date">Effective Date</label>
                                                <input class="form-control" id="effective_date" type="date" name="effective_date" placeholder="Enter Effective Date">
                                                <div class="invalid-feedback">Please enter a Effective Date.</div>
                                            </div>
    
    
                                            <hr class="mt-5">
                                        @endif
                                        
                                        <!-- Title -->
                                        <div class="col-md-6 mt-5">
                                            <label class="form-label" for="title"> Title<span class="txt-danger">*</span></label>
                                            <input class="form-control" id="title" type="text" name="title" placeholder="Enter Title" required>
                                            <div class="invalid-feedback">Please enter a Title.</div>
                                        </div>
                                    

                                        <!-- Description Textarea -->
                                        <div class="col-md-12">
                                            <label for="description" class="form-label">Description <span class="txt-danger">*</span></label>
                                            <textarea name="description" id="editor" class="form-control" rows="4" placeholder="Enter description" required>{{ old('description') }}</textarea>
                                            <div class="invalid-feedback">Please enter a description.</div>
                                        </div>



                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-privacy-policy.index') }}" class="btn btn-danger px-4">Cancel</a>
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


<!-- JavaScript to dynamically add/remove rows -->
<script>
     function previewThumbnail(event) {
                const input = event.target;
                const preview = document.getElementById('thumbnailPreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none'); // show preview
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = "#";
                    preview.classList.add('d-none'); // hide if no file
                }
            }
</script>



</body>

</html>