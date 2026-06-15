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
                  <h4>Add Our Clientele Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-clientele.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Our Clientele Details</li>
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
                        <h4>Our Clientele Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-clientele.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Clientele Section -->
                                        <div class="col-12">
                                            <h5><strong>#Clientele Images</strong></h5>
                                            <table class="table table-bordered mt-3" id="galleryTable">
                                                <thead>
                                                    <tr>
                                                        <th>Image <span class="txt-danger">*</span></th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="file" name="gallery_images[]" class="form-control gallery-input" accept=".jpg,.jpeg,.png,.webp" required onchange="previewGalleryImage(this)">
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                                        </td>
                                                        <td><img src="" class="gallery-preview img-fluid" style="max-height:100px; display:none;"></td>
                                                        <td><button type="button" class="btn btn-primary" onclick="addGalleryRow()">Add More</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-clientele.index') }}" class="btn btn-danger px-4">Cancel</a>
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



<!-- JS for Preview and Add More -->
<script>
    function previewProjectImage() {
        const input = document.getElementById('project_image');
        const preview = document.getElementById('project_image_preview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                document.getElementById('projectImagePreviewContainer').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addHighlightRow() {
        const table = document.getElementById('highlightsTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow();
        row.innerHTML = `<td><input type="text" name="highlights[]" class="form-control" placeholder="Enter Feature"></td>
                         <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Remove</button></td>`;
    }

    function addGalleryRow() {
        const table = document.getElementById('galleryTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow();
        row.innerHTML = `<td><input type="file" name="gallery_images[]" class="form-control gallery-input" accept=".jpg,.jpeg,.png,.webp" onchange="previewGalleryImage(this)"> <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                        </td>
                         <td><img src="" class="gallery-preview img-fluid" style="max-height:100px; display:none;"></td>
                         <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Remove</button></td>`;
    }

    function previewGalleryImage(input) {
        const preview = input.closest('tr').querySelector('.gallery-preview');
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


</body>

</html>