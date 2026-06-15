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
                  <h4>Add Product Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-detailed-page.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Product Details</li>
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

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-detailed-page.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                       <!-- Banner Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image </label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        
                                        <!-- Sub Product -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="sub_product_id">Select Sub Product <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="sub_product_id" name="sub_product_id" required>
                                                <option value="">-- Select Sub Product --</option>
                                                @foreach($sub_product as $sp)
                                                    <option value="{{ $sp->id }}">{{ $sp->sub_product }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Sub Product.</div>
                                        </div>


                                        <hr>

                                        <div class="col-md-12">
                                            <label class="form-label" for="sub_product_description">Sub Product Description <span class="txt-danger">*</span></label>
                                            <textarea class="form-control" id="editor" name="sub_product_description" rows="6" placeholder="Enter details about the sub product..." required></textarea>
                                        </div>

                                        <!-- Gallery Image Upload -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong>Gallery Images</strong></h5>
                                            <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Product Image: <span class="text-danger">*</span></th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="file" onchange="previewGalleryImage(this, 0)" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_0" class="form-control" placeholder="Upload Gallery Image" multiple required>
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                                            <br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                        </td>
                                                        <td>
                                                            <div id="gallery-preview-container-0"></div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addGalleryRow">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                        <h5><strong># Details</strong></h5>


                                        <!-- Section Title  -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="sec_title">Section Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="sec_title" type="text" name="sec_title" placeholder="Enter Section Title " required>
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>

                                        <!-- Product Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Product Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg, .jpeg, .png, .webp, .svg" onchange="previewThumbnailImage()" required>
                                            <div class="invalid-feedback">Please upload a Product Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            <div id="thumbnailImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        <!-- Specifications -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong>Specifications</strong></h5>
                                            <table class="table table-bordered p-3" id="tabletTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Specifications <span class="txt-danger">*</span></th>
                                                        <th>Value <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="specifications[]" id="specifications_0" class="form-control" placeholder="Enter Specifications" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="value[]" id="value_0" class="form-control" placeholder="Enter Value" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addTabletRow">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                        <h5><strong># Features Section</strong></h5>
                                        
                                        <!-- Features Table -->
                                        <div class="table-container mt-5" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong>Features</strong></h5>
                                            <table class="table table-bordered p-3" id="tabletTable1" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Heading <span class="txt-danger">*</span></th>
                                                        <th>Description <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="table_heading[]" id="table_heading_0" class="form-control" placeholder="Enter Heading" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="desc[]" id="desc_0" class="form-control" placeholder="Enter Description" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addTabletRow1">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                        

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-detailed-page.index') }}" class="btn btn-danger px-4">Cancel</a>
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
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/svg+xml'];

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


         <!--Gallery Image Preview & Add More Option-->
        <script>
            $(document).ready(function () {
                let rowId = 0;

                // Add a new gallery image row
                $('#addGalleryRow').click(function () {
                    rowId++;
                    const newRow = `
                        <tr>
                            <td>
                                <input type="file" onchange="previewGalleryImage(this, ${rowId})" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_${rowId}" class="form-control" placeholder="Upload Gallery Image">
                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                <br>
                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                            </td>
                            <td>
                                <div id="gallery-preview-container-${rowId}"></div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                            </td>
                        </tr>`;
                    $('#galleryTable tbody').append(newRow);
                });

                // Remove a gallery image row
                $(document).on('click', '.removeGalleryRow', function () {
                    $(this).closest('tr').remove();
                });
            });

            // Preview function for gallery images
            function previewGalleryImage(input, rowId) {
                const file = input.files[0];
                const previewContainer = document.getElementById(`gallery-preview-container-${rowId}`);

                // Clear previous preview
                previewContainer.innerHTML = '';

                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            // Create an image element for preview
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '120px';
                            img.style.maxHeight = '100px';
                            img.style.objectFit = 'cover';

                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.innerHTML = '<p>Unsupported file type</p>';
                    }
                }
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let rowIndex = 1; // start index for new rows

                // Add new row
                document.getElementById("addTabletRow").addEventListener("click", function () {
                    const tableBody = document.querySelector("#tabletTable tbody");
                    const newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>
                            <input type="text" name="specifications[]" id="specifications_${rowIndex}" class="form-control" placeholder="Enter Specifications" required>
                        </td>
                        <td>
                            <input type="text" name="value[]" id="value_${rowIndex}" class="form-control" placeholder="Enter Value" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeTabletRow">Remove</button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                    rowIndex++;
                });

                // Remove row
                document.querySelector("#tabletTable").addEventListener("click", function (e) {
                    if (e.target.classList.contains("removeTabletRow")) {
                        const row = e.target.closest("tr");
                        row.remove();
                    }
                });
            });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let rowIndex = 1; // start index for new rows

                // Add new row
                document.getElementById("addTabletRow1").addEventListener("click", function () {
                    const tableBody = document.querySelector("#tabletTable1 tbody");
                    const newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>
                            <input type="text" name="table_heading[]" id="table_heading_${rowIndex}" class="form-control" placeholder="Enter Heading" required>
                        </td>
                        <td>
                            <input type="text" name="desc[]" id="desc_${rowIndex}" class="form-control" placeholder="Enter Description" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeTabletRow1">Remove</button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                    rowIndex++;
                });

                // Remove row
                document.querySelector("#tabletTable1").addEventListener("click", function (e) {
                    if (e.target.classList.contains("removeTabletRow1")) {
                        const row = e.target.closest("tr");
                        row.remove();
                    }
                });
            });
        </script>




</body>

</html>