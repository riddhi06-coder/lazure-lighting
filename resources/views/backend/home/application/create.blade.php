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
                  <h4>Add Application Intro Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-app-intro.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Application Intro</li>
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
                        <h4>Application Intro Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-app-intro.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-xxl-4 col-sm-6">
                                            <label for="application_type">Application Type <span class="txt-danger">*</span></label>
                                            <select name="application_type" id="application_type" class="form-control" required>
                                                <option value="">-- Select Application Type --</option>
                                                @foreach ($applications as $application)
                                                    <option value="{{ $application->id }}">
                                                        {{ $application->name ?? $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                       <!-- Banner Image-->
                                        <div class="col-xxl-4 col-sm-6">
                                            <label class="form-label" for="banner_image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" required onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        <br><br>

                                        <div class="col-xxl-4 col-sm-12">
                                            <label for="application_info">Application Information <span class="txt-danger">*</span></label>
                                            <textarea name="application_info" id="editor" id="application_info" class="form-control" rows="8" placeholder="Enter application details..." required></textarea>
                                        </div>
                                        
                                        <hr>
                                        <br><br>
                                         <!-- Product Prints Image Upload -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>Application Details</strong></h6>
                                            <table class="table table-bordered p-3" id="printsTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Icon</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <!-- Title -->
                                                        <td>
                                                            <input type="text" name="print_title[]" class="form-control" placeholder="Enter title" required>
                                                        </td>

                                                        <!-- Icon -->
                                                        <td>
                                                            <input type="file" onchange="previewPrintImage(this, 0)" accept=".png, .jpg, .jpeg, .webp, .svg" name="print_icon[]" id="print_icon_0" class="form-control" required>
                                                            <small class="text-secondary"><b>Note: Max 2MB, formats: jpg, jpeg, png, webp.</b></small>
                                                            <div id="print-preview-container-0" class="mt-2"></div>
                                                        </td>

                                                        <!-- Description -->
                                                        <td>
                                                            <textarea name="print_description[]" class="form-control" rows="2" placeholder="Enter description" required></textarea>
                                                        </td>

                                                        <!-- Action -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addPrintRow">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-app-intro.index') }}" class="btn btn-danger px-4">Cancel</a>
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
</script>


<!--Add More Option for icons and title-->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let rowIndex = 1;

        // Add row
        document.getElementById("addPrintRow").addEventListener("click", function () {
            const tableBody = document.querySelector("#printsTable tbody");
            const newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td>
                    <input type="text" name="print_title[]" class="form-control" placeholder="Enter title" required>
                </td>
                <td>
                    <input type="file" onchange="previewPrintImage(this, ${rowIndex})" accept=".png, .jpg, .jpeg, .webp, .svg" name="print_icon[]" id="print_icon_${rowIndex}" class="form-control" required>
                    <small class="text-secondary"><b>Note: Max 2MB, formats: jpg, jpeg, png, webp.</b></small>
                    <div id="print-preview-container-${rowIndex}" class="mt-2"></div>
                </td>
                <td>
                    <textarea name="print_description[]" class="form-control" rows="2" placeholder="Enter description" required></textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger removePrintRow">Remove</button>
                </td>
            `;

            tableBody.appendChild(newRow);
            rowIndex++;
        });

        // Remove row
        document.querySelector("#printsTable").addEventListener("click", function (e) {
            if (e.target.classList.contains("removePrintRow")) {
                e.target.closest("tr").remove();
            }
        });
    });

    // Preview image
    function previewPrintImage(input, index) {
        const previewContainer = document.getElementById(`print-preview-container-${index}`);
        previewContainer.innerHTML = "";
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "60px";
                img.style.height = "60px";
                img.style.objectFit = "cover";
                img.classList.add("border", "p-1");
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


</body>

</html>