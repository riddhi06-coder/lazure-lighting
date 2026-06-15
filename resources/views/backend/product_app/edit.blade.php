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
                  <h4>Edit Design Intent Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-apps.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Design Intent</li>
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
                        <h4>Design Intent Form</h4>
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
                                        action="{{ route('manage-apps.update', $appIntro->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- Important for PUT method -->


                                        <!-- Banner Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title</label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title" value="{{ old('banner_title', $appIntro->banner_title) }}" >
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>


                                       <!-- Banner Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image</label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            @if($appIntro->banner_image)
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" src="{{ asset($appIntro->banner_image) }}" alt="Preview" class="img-fluid" style="max-height:200px;border:1px solid #ddd;padding:5px;">
                                                </div>
                                            @endif
                                        </div>

                                        <hr>


                                        <!-- Product Dropdown -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="product_id">Select Product <span class="txt-danger">*</span></label>
                                            <select class="form-select" id="product_id" name="product_id" required>
                                                <option value="" disabled>-- Select Product --</option>
                                                @foreach($product as $item)
                                                    <option value="{{ $item->id }}" 
                                                            {{ $appIntro->product_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->product }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Product.</div>
                                        </div>


                                        <!-- Section Heading-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading">Section Heading <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" value="{{ old('section_heading', $appIntro->section_heading) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Heading.</div>
                                        </div>


                                        <!-- Section Description-->
                                        <div class="col-md-12">
                                            <label class="form-label" for="section_desc">Section Description <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_desc" type="text" name="section_desc" placeholder="Enter Section Description"   value="{{ old('section_desc', $appIntro->section_desc) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Description.</div>
                                        </div>

                                        <br><br>


                                        <!-- On/Off Images -->
                                        <div class="table-container mt-5" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>On/Off Images</strong></h6>
                                            <table class="table table-bordered p-3" id="onOffTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($onOffImages as $index => $onOff)
                                                    <tr>
                                                        <td>
                                                            <select name="on_off_status[]" class="form-select" required>
                                                                <option value="" disabled selected>-- Select Status --</option>
                                                                <option value="on" {{ $onOff['status']=='on' ? 'selected' : '' }}>On</option>
                                                                <option value="off" {{ $onOff['status']=='off' ? 'selected' : '' }}>Off</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="file" onchange="previewOnOffImage(this, {{ $index }})" 
                                                                accept=".png,.jpg,.jpeg,.webp" name="on_off_image[]" id="on_off_image_{{ $index }}" class="form-control">
                                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                            @if(!empty($onOff['image']))
                                                                <div id="on-off-preview-container-{{ $index }}" class="mt-2">
                                                                    <img src="{{ asset($onOff['image']) }}" style="max-height:100px;border:1px solid #ddd;padding:2px;">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($index == 0)
                                                                <button type="button" class="btn btn-primary" id="addOnOffRow">Add More</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger removeOnOffRow">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>


                                         <!-- Light Application Images -->
                                        <div class="table-container mt-5" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>Light Application Images</strong></h6>
                                            <table class="table table-bordered p-3" id="printsTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($lightImages as $index => $light)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="type[]" class="form-control" value="{{ $light['type'] ?? '' }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="file" onchange="previewPrintImage(this, {{ $index }})" 
                                                                accept=".png,.jpg,.jpeg,.webp,.svg" name="type_image[]" id="type_image_{{ $index }}" class="form-control">
                                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                            @if(!empty($light['image']))
                                                                <div id="print-preview-container-{{ $index }}" class="mt-2">
                                                                    <img src="{{ asset($light['image']) }}" style="max-height:100px;border:1px solid #ddd;padding:2px;">
                                                                </div>
                                                            @endif
                                                        </td>
                                                       <!-- Action Button -->
                                                        <td>
                                                            @if($index == 0)
                                                                <button type="button" class="btn btn-primary" id="addPrintRow">Add More</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger removePrintRow">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>

                                            
                                        <!-- ================= SEO Section ================= -->


                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_title">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                                value="{{ old('meta_title', $appIntro->meta_title) }}">
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_description">Meta Description </label>
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="4">{{ old('meta_description', $appIntro->meta_description) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="cannonical">Cannonical</label>
                                            <textarea name="cannonical" id="cannonical" class="form-control" rows="4" required>{{ old('cannonical', $appIntro->cannonical) }}</textarea>
                                        </div>
                                    
                                    
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="hreflang">HrefLang</label>
                                            <textarea name="hreflang" id="hreflang" class="form-control" rows="4" required>{{ old('hreflang', $appIntro->hreflang) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">OG Tag</label>
                                            <textarea name="og_tag" id="og_tag" class="form-control" rows="4" required>{{ old('og_tag', $appIntro->og_tag) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">Twitter Card Tag</label>
                                            <textarea name="twitter_card_tag" id="twitter_card_tag" class="form-control" rows="4" required>{{ old('twitter_card_tag', $appIntro->twitter_card_tag) }}</textarea>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-apps.index') }}" class="btn btn-danger px-4">Cancel</a>
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


<!--Add More Option for images-->
<script>
   document.addEventListener("DOMContentLoaded", function () {
    // Get current number of rows in the table to start unique indices
    let rowIndex = document.querySelectorAll("#printsTable tbody tr").length;

    // Add row
    document.getElementById("addPrintRow").addEventListener("click", function () {
        const tableBody = document.querySelector("#printsTable tbody");
        const newRow = document.createElement("tr");

        newRow.innerHTML = `
            <td>
                <input type="text" name="type[]" class="form-control" placeholder="Enter title" required>
            </td>
            <td>
                <input type="file" onchange="previewPrintImage(this, ${rowIndex})" accept=".png, .jpg, .jpeg, .webp, .svg" name="type_image[]" id="type_image_${rowIndex}" class="form-control" required>
                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                <div id="print-preview-container-${rowIndex}" class="mt-2"></div>
            </td>

            <td>
                <button type="button" class="btn btn-danger removePrintRow">Remove</button>
            </td>
        `;

        tableBody.appendChild(newRow);
        rowIndex++; // increment for next new row
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
        let previewContainer = document.getElementById(`print-preview-container-${index}`);

        // Create container if it doesn't exist (dynamic rows)
        if (!previewContainer) {
            previewContainer = document.createElement("div");
            previewContainer.id = `print-preview-container-${index}`;
            previewContainer.className = "mt-2";
            input.parentNode.appendChild(previewContainer);
        }

        previewContainer.innerHTML = ""; // clear previous preview
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


<!--On off image Add More Option for images -->
<script>

    // Preview uploaded image
    function previewOnOffImage(input, index) {
        // Create the container if it does not exist
        let container = document.getElementById(`on-off-preview-container-${index}`);
        if (!container) {
            container = document.createElement('div');
            container.id = `on-off-preview-container-${index}`;
            container.className = 'mt-2';
            input.parentNode.appendChild(container); // append below input
        }

        container.innerHTML = ""; // clear previous preview
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                container.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 120px; border: 1px solid #ddd; padding: 5px;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


    // Add new On/Off row
   // Get the current number of rows in the table
    let onOffRowIndex = document.querySelectorAll("#onOffTable tbody tr").length;

    document.getElementById("addOnOffRow").addEventListener("click", function () {
        const tableBody = document.querySelector("#onOffTable tbody");
        const newRow = document.createElement("tr");

        newRow.innerHTML = `
            <td>
                <select name="on_off_status[]" class="form-select" required>
                    <option value="" disabled selected>-- Select Status --</option>
                    <option value="on">On</option>
                    <option value="off">Off</option>
                </select>
            </td>
            <td>
                <input type="file" onchange="previewOnOffImage(this, ${onOffRowIndex})" accept=".png, .jpg, .jpeg, .webp" name="on_off_image[]" id="on_off_image_${onOffRowIndex}" class="form-control" required>
                 <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                <div id="on-off-preview-container-${onOffRowIndex}" class="mt-2"></div>
            </td>
            <td>
                <button type="button" class="btn btn-danger removeOnOffRow">Remove</button>
            </td>
        `;

        tableBody.appendChild(newRow);
        onOffRowIndex++; // increment for next new row
    });


    // Remove row
    document.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("removeOnOffRow")) {
            e.target.closest("tr").remove();
        }
    });

</script>


</body>

</html>