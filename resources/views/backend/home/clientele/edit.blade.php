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
                  <h4>Edit Our Clientele Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-clientele.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Our Clientele</li>
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
                        <h4>Our Clientele Form</h4>
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
                                        action="{{ route('manage-clientele.update', $projects_list->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                      
                                        <!-- Gallery -->
                                        <div class="col-12 mt-5">
                                            <div class="col-12 d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><strong>#Gallery Images</strong></h5>
                                                <button type="button" class="btn btn-primary" onclick="addGalleryRow()">Add More</button>
                                            </div>
                                            <table class="table table-bordered mt-3" id="galleryTable">
                                                <tbody>
                                                    @php $gallery = json_decode($projects_list->gallery_images, true) ?? []; @endphp
                                                    @foreach($gallery as $image)
                                                        <tr>
                                                            <td><input type="file" name="gallery_images[]" class="form-control"><small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                                <!-- Hidden input to track existing image -->
                                                                <input type="hidden" name="existing_gallery_images[]" value="{{ $image }}">
                                                            </td>
                                                            <td><img src="{{ asset( $image ) }}" class="gallery-preview img-fluid" style="max-height:100px;"></td>
                                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                 
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-clientele.index') }}" class="btn btn-danger px-4">Cancel</a>
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

    // Add new Highlight row
    function addHighlightRow() {
        const tableBody = document.querySelector('#highlightsTable tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="highlights[]" class="form-control" placeholder="Enter Feature" required></td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
            </td>
        `;

        tableBody.appendChild(newRow);
    }

    // Remove a row
    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }


    // Add new gallery row
    function addGalleryRow() {
        const tableBody = document.querySelector('#galleryTable tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <input type="file" name="gallery_images[]" class="form-control gallery-input" accept=".jpg,.jpeg,.png,.webp" onchange="previewGalleryImage(this)">
                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp files are allowed.</b></small>
            </td>
            <td><img src="" class="gallery-preview img-fluid" style="max-height:100px; display:none;"></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;

        tableBody.appendChild(newRow);
    }

    // Remove any row (both dynamic and pre-filled)
    function removeRow(button) {
        const row = button.closest('tr');
        // remove the row
        row.remove();
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