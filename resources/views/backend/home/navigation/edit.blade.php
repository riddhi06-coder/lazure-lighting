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
                  <h4>Edit Navigation Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-navigations.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Navigation Details</li>
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
                        <h4>Navigation Details Form</h4>
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
                                          action="{{ route('manage-navigations.update', $navigation->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                    
                                        <!-- Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="heading">
                                                Heading <span class="txt-danger">*</span>
                                            </label>
                                            <input class="form-control"
                                                   id="heading"
                                                   type="text"
                                                   name="heading"
                                                   value="{{ old('heading', $navigation->heading) }}"
                                                   required>
                                            <div class="invalid-feedback">Please enter a heading.</div>
                                        </div>
                                    
                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="image">
                                                Upload Image
                                            </label>
                                            <input class="form-control"
                                                   id="image"
                                                   type="file"
                                                   name="image"
                                                   accept="image/*">
                                    
                                            <!-- Existing Image -->
                                            @if($navigation->image)
                                                <div class="mt-3">
                                                    <p class="mb-1 text-muted">Current Image:</p>
                                                    <img src="{{ asset($navigation->image) }}"
                                                         class="img-fluid rounded"
                                                         style="max-height:200px;">
                                                </div>
                                            @endif
                                    
                                            <!-- New Image Preview -->
                                            <div class="mt-3" id="imagePreviewContainer" style="display:none;">
                                                <img id="imagePreview" class="img-fluid rounded" style="max-height:200px;">
                                            </div>
                                        </div>
                                    
                                        <!-- Description -->
                                        <div class="col-md-12">
                                            <label class="form-label" for="description">
                                                Description <span class="txt-danger">*</span>
                                            </label>
                                            <textarea class="form-control"
                                                      id="description"
                                                      name="description"
                                                      rows="4"
                                                      required>{{ old('description', $navigation->description) }}</textarea>
                                            <div class="invalid-feedback">Please enter a description.</div>
                                        </div>
                                    
                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-navigations.index') }}" class="btn btn-danger px-4">
                                                Cancel
                                            </a>
                                            <button class="btn btn-primary px-4" type="submit">
                                                Update
                                            </button>
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
        document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    </script>



</body>

</html>