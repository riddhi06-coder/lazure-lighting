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

                                    <form class="row g-3 needs-validation custom-input" novalidate 
                                        action="{{ route('manage-app-intro.update', $appIntro->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Application Type -->
                                        <div class="col-xxl-4 col-sm-6">
                                            <label for="application_type">Application Type <span class="txt-danger">*</span></label>
                                            <select name="application_type" id="application_type" class="form-control" required>
                                                <option value="">-- Select Application Type --</option>
                                                @foreach ($applications as $application)
                                                    <option value="{{ $application->id }}" 
                                                        {{ $appIntro->application_type_id == $application->id ? 'selected' : '' }}>
                                                        {{ $application->name ?? $application->application_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="col-xxl-4 col-sm-6">
                                            <label class="form-label" for="banner_image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" 
                                                accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">

                                            <div id="bannerImagePreviewContainer" style="margin-top: 10px; {{ $appIntro->banner_image ? '' : 'display:none;' }}">
                                                <img id="banner_image_preview" 
                                                    src="{{ $appIntro->banner_image && file_exists(public_path($appIntro->banner_image)) 
                                                            ? asset($appIntro->banner_image) 
                                                            : '' }}" 
                                                    alt="Preview" 
                                                    class="img-fluid" 
                                                    style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>


                                        <!-- Application Information -->
                                        <div class="col-xxl-4 col-sm-12">
                                            <label for="application_info">Application Information <span class="txt-danger">*</span></label>
                                            <textarea name="application_info" id="editor" class="form-control" rows="8" 
                                                    required>{{ $appIntro->application_info }}</textarea>
                                        </div>

                                        <!-- Application Details -->
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
                                                    @php
                                                        $details = json_decode($appIntro->application_details, true) ?? [];
                                                    @endphp

                                                    @forelse ($details as $index => $detail)
                                                        <tr>
                                                            <!-- Title -->
                                                            <td>
                                                                <input type="text" name="print_title[]" value="{{ $detail['title'] }}" 
                                                                    class="form-control" required>
                                                            </td>

                                                            <!-- Icon -->
                                                            <td>
                                                                <input type="file" 
                                                                    onchange="previewPrintImage(this, {{ $index }})" 
                                                                    accept=".png, .jpg, .jpeg, .webp, .svg" 
                                                                    name="print_icon[]" 
                                                                    id="print_icon_{{ $index }}" 
                                                                    class="form-control">

                                                                <div id="print-preview-container-{{ $index }}" class="mt-2" style="{{ isset($detail['icon']) ? '' : 'display:none;' }}">
                                                                    <img id="print_image_preview_{{ $index }}"
                                                                        src="{{ isset($detail['icon']) ? asset($detail['icon']) : '' }}"
                                                                        style="max-height: 60px; border: 1px solid #ddd; padding: 3px;">
                                                                </div>
                                                            </td>


                                                            <!-- Description -->
                                                            <td>
                                                                <textarea name="print_description[]" class="form-control" rows="2" required>{{ $detail['description'] }}</textarea>
                                                            </td>

                                                            <!-- Action -->
                                                            <td>
                                                                @if($index == 0)
                                                                    <button type="button" class="btn btn-primary" id="addPrintRow">Add More</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger removePrintRow">Remove</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <!-- If no details exist, show one empty row -->
                                                        <tr>
                                                            <td><input type="text" name="print_title[]" class="form-control" required></td>
                                                            <td>
                                                                <input type="file" name="print_icon[]" class="form-control" required>
                                                            </td>
                                                            <td><textarea name="print_description[]" class="form-control" rows="2" required></textarea></td>
                                                            <td><button type="button" class="btn btn-primary" id="addPrintRow">Add More</button></td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-app-intro.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    function previewBannerImage() {
        const file = document.getElementById('banner_image').files[0];
        const previewContainer = document.getElementById('bannerImagePreviewContainer');
        const previewImage = document.getElementById('banner_image_preview');

        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if (validImageTypes.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
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
        // Set rowIndex based on last existing index from Blade
        let rowIndex = {{ count($details) }}; 

        // Add row
        document.getElementById("addPrintRow").addEventListener("click", function () {
            const tableBody = document.querySelector("#printsTable tbody");
            const newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td>
                    <input type="text" name="print_title[]" class="form-control" placeholder="Enter title" required>
                </td>
                <td>
                    <input type="file" 
                        onchange="previewPrintImage(this, ${rowIndex})" 
                        accept=".png, .jpg, .jpeg, .webp, .svg" 
                        name="print_icon[]" 
                        id="print_icon_${rowIndex}" 
                        class="form-control" 
                        required>
                    <small class="text-secondary"><b>Note: Max 2MB, formats: jpg, jpeg, png, webp.</b></small>
                    <div id="print-preview-container-${rowIndex}" class="mt-2" style="display:none;">
                        <img id="print_image_preview_${rowIndex}" 
                            style="max-height: 60px; border: 1px solid #ddd; padding: 3px;">
                    </div>
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

        // Preview image function stays same
        function previewPrintImage(input, index) {
            const file = input.files[0];
            const previewContainer = document.getElementById('print-preview-container-' + index);
            const previewImage = document.getElementById('print_image_preview_' + index);

            if (file) {
                const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/svg+xml'];
                if (validImageTypes.includes(file.type)) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload a valid image file (jpg, jpeg, png, webp, svg).');
                }
            }
        }


</script>


</body>

</html>