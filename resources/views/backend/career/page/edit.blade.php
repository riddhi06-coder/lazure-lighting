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
                  <h4>Edit Careers Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-career.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Careers</li>
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
                        <h4>Careers Form</h4>
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
                                          action="{{ route('manage-career.update', $career->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                    
                                        <!-- ================= Banner Section ================= -->
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="banner_heading">Banner Heading <span class="txt-danger">*</span></label>
                                            <input type="text" id="banner_heading" name="banner_heading" 
                                                   class="form-control" placeholder="Enter Banner Heading" 
                                                   value="{{ old('banner_heading', $career->banner_heading) }}" required>
                                            <div class="invalid-feedback">Please enter a banner heading.</div>
                                        </div>
                                    
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="banner_image">Banner Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" 
                                                   accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                    
                                            <!-- 🔍 Preview -->
                                            <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                @if($career->banner_image)
                                                    <img id="banner_image_preview" src="{{ asset('uploads/career/' . $career->banner_image) }}" 
                                                         alt="Preview" class="img-fluid" style="max-height: 200px; border:1px solid #ddd; padding:5px;">
                                                @else
                                                    <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border:1px solid #ddd; padding:5px; display:none;">
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <hr class="mt-4 mb-4">
                                    
                                        <!-- ================= Section Title + Image ================= -->
                                        <div class="col-md-6">
                                            <label for="section_title">Section Heading <span class="txt-danger">*</span></label>
                                            <input type="text" name="section_title" id="section_title" class="form-control" 
                                                   value="{{ old('section_title', $career->section_title) }}" required>
                                        </div>
                                    
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="section_image">Section Image <span class="txt-danger">*</span></label>
                                            <input type="file" name="section_image" id="section_image" class="form-control" 
                                                   accept=".jpg, .jpeg, .png, .webp" onchange="previewSectionImage()">
                                            <div id="sectionImagePreviewContainer" style="margin-top:10px;">
                                                @if($career->section_image)
                                                    <img id="section_image_preview" src="{{ asset('uploads/career/' . $career->section_image) }}" 
                                                         alt="Preview" class="img-fluid" style="max-height:200px; border:1px solid #ddd; padding:5px;">
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <!-- ================= Section Description ================= -->
                                        <div class="col-md-12">
                                            <label for="section_description">Section Description <span class="txt-danger">*</span></label>
                                            <textarea name="section_description" id="section_description" class="form-control" rows="4" required>{{ old('section_description', $career->section_description) }}</textarea>
                                        </div>
                                    
                                        <hr class="mt-4 mb-4">
                                    
                                        <!-- ================= Value Heading ================= -->
                                        <div class="col-md-6">
                                            <label for="value_heading">Heading <span class="txt-danger">*</span></label>
                                            <input type="text" name="value_heading" id="value_heading" class="form-control" 
                                                   value="{{ old('value_heading', $career->value_heading) }}" required>
                                        </div>
                                    
                                        <!-- ================= Our Values Table ================= -->
                                        <div class="table-container mt-5" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>Our Values</strong></h6>
                                            <table class="table table-bordered p-3" id="printsTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Title <span class="txt-danger">*</span></th>
                                                        <th>Icon <span class="txt-danger">*</span></th>
                                                        <th>Description <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $values = json_decode($career->our_values, true); @endphp
                                                    @if($values && count($values) > 0)
                                                        @foreach($values as $i => $value)
                                                            <tr>
                                                                <td><input type="text" name="print_title[]" class="form-control" value="{{ $value['title'] }}" required></td>
                                                                <td>
                                                                    <input type="file" name="print_icon[]" class="form-control" onchange="previewPrintImage(this, {{ $i }})" accept=".png, .jpg, .jpeg, .webp, .svg">
                                                                    <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                    <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                                    <input type="hidden" name="existing_print_icon[]" value="{{ $value['icon'] ?? '' }}">


                                                                    @if(isset($value['icon']))
                                                                        <div id="print-preview-container-{{ $i }}" class="mt-2">
                                                                            <img src="{{ asset('uploads/career/' . $value['icon']) }}" style="max-height:80px; border:1px solid #ddd; padding:3px;">
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td><textarea name="print_description[]" class="form-control" rows="2" required>{{ $value['description'] }}</textarea></td>
                                                                <td>
                                                                    @if($i == 0)
                                                                        <button type="button" class="btn btn-primary" id="addPrintRow">Add More</button>
                                                                    @else
                                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="print_title[]" class="form-control" required></td>
                                                            <td><input type="file" name="print_icon[]" class="form-control" required>
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                            <input type="hidden" name="existing_print_icon[]" value="{{ $value['icon'] ?? '' }}"></td>
                                                            <td><textarea name="print_description[]" class="form-control" rows="2" required></textarea></td>
                                                            <td><button type="button" class="btn btn-primary" id="addPrintRow">Add More</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                        <hr class="mt-4 mb-4">
                                    
                                        <!-- ================= Join Features ================= -->
                                        <div class="col-md-6">
                                            <label for="join_heading">Heading <span class="txt-danger">*</span></label>
                                            <input type="text" name="join_heading" id="join_heading" class="form-control" value="{{ old('join_heading', $career->join_heading) }}" required>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_icon">Section Image <span class="txt-danger">*</span></label>
                                            <input type="file" name="section_icon" id="section_icon" class="form-control" onchange="previewSectionIcon()" accept=".jpg, .jpeg, .png, .webp, .svg">
                                            <div id="sectionIconPreviewContainer" style="margin-top:10px;">
                                                @if($career->section_icon)
                                                    <img id="section_icon_preview" src="{{ asset('uploads/career/' . $career->section_icon) }}" style="max-height:100px; border:1px solid #ddd; padding:5px;">
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="table-container mt-5">
                                            <h6 class="mb-4"><strong>Why Join Features</strong></h6>
                                            <table class="table table-bordered p-3" id="detailsTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Features <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $features = json_decode($career->join_features, true); @endphp
                                                    @if($features && count($features) > 0)
                                                        @foreach($features as $i => $feature)
                                                            <tr>
                                                                <td><input type="text" name="features[]" class="form-control" value="{{ $feature }}" required></td>
                                                                <td>
                                                                    @if($i == 0)
                                                                        <button type="button" class="btn btn-primary" id="addDetailRow">Add More</button>
                                                                    @else
                                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="features[]" class="form-control" required></td>
                                                            <td><button type="button" class="btn btn-primary" id="addDetailRow">Add More</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                        <hr class="mt-4 mb-4">
                                        
                                        
                                       <div class="col-md-6">
                                            <label for="role_heading">Heading <span class="txt-danger">*</span></label>
                                            <input type="text" name="role_heading" id="role_heading" class="form-control" 
                                                   placeholder="Enter Heading" value="{{ old('role_heading', $career->role_heading) }}" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label" for="roles_icon">Section Image <span class="txt-danger">*</span></label>
                                            <input type="file" name="roles_icon" id="roles_icon" class="form-control" 
                                                   accept=".jpg, .jpeg, .png, .webp, .svg" onchange="previewroleIcon()">
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                        
                                            <!-- 🔍 Preview Existing Image -->
                                            @if($career->roles_icon)
                                                <div id="rolesIconPreviewContainer" style="display:block; margin-top:10px;">
                                                    <img id="roles_icon_preview" src="{{ asset('uploads/career/' . $career->roles_icon) }}" 
                                                         alt="Preview" class="img-fluid" style="max-height:100px; border:1px solid #ddd; padding:5px;">
                                                </div>
                                            @else
                                                <div id="rolesIconPreviewContainer" style="display:none; margin-top:10px;">
                                                    <img id="roles_icon_preview" src="" alt="Preview" class="img-fluid" style="max-height:100px; border:1px solid #ddd; padding:5px;">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label for="role_description">Section Description <span class="txt-danger">*</span></label>
                                            <textarea name="role_description" id="editor" class="form-control" rows="4" 
                                                      placeholder="Enter section description..." required>{{ old('role_description', $career->role_description) }}</textarea>
                                        </div>




                                        
                                        <hr class="mt-4 mb-4">
                                        
                                        <!-- ================= SEO Section ================= -->


                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_title">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                                value="{{ old('meta_title', $career->meta_title) }}">
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="meta_description">Meta Description </label>
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="4">{{ old('meta_description', $career->meta_description) }}</textarea>
                                        </div>
                                        
                                        
                                        
                                        
                                         <div class="col-xxl-6 col-sm-12">
                                            <label for="cannonical">Cannonical</label>
                                            <textarea name="cannonical" id="cannonical" class="form-control" rows="4">{{ old('cannonical', $career->cannonical) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="hreflang">HrefLang</label>
                                            <textarea name="hreflang" id="hreflang" class="form-control" rows="4">{{ old('hreflang', $career->hreflang) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">OG Tag</label>
                                            <textarea name="og_tag" id="og_tag" class="form-control" rows="4">{{ old('og_tag', $career->og_tag) }}</textarea>
                                        </div>
                                        
                                        
                                        <div class="col-xxl-6 col-sm-12">
                                            <label for="og_tag">Twitter Card Tag</label>
                                            <textarea name="twitter_card_tag" id="twitter_card_tag" class="form-control" rows="4">{{ old('twitter_card_tag', $career->twitter_card_tag) }}</textarea>
                                        </div>
                                    
                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-career.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    let rowIndex = document.querySelectorAll("#printsTable tbody tr").length;

    // Add row
    document.getElementById("addPrintRow").addEventListener("click", function () {
        const tableBody = document.querySelector("#printsTable tbody");
        const newRow = document.createElement("tr");

        newRow.innerHTML = `
            <td>
                <input type="text" name="print_title[]" class="form-control" placeholder="Enter title" required>
            </td>
            <td>
                <input type="file" onchange="previewPrintImage(this, ${rowIndex})" 
                    accept=".png, .jpg, .jpeg, .webp, .svg" name="print_icon[]" 
                    id="print_icon_${rowIndex}" class="form-control" required>
                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

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
        const previewContainerId = `print-preview-container-${index}`;
        let previewContainer = document.getElementById(previewContainerId);
    
        // If container does not exist (should not happen), create it dynamically
        if (!previewContainer) {
            previewContainer = document.createElement("div");
            previewContainer.id = previewContainerId;
            previewContainer.classList.add("mt-2");
            input.parentNode.appendChild(previewContainer);
        }
    
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


<script>

    function previewSectionImage() {
        let input = document.getElementById("section_image");
        let preview = document.getElementById("section_image_preview");
        let container = document.getElementById("sectionImagePreviewContainer");
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            container.style.display = "block";
        }
    }

    function previewSectionIcon() {
        let input = document.getElementById("section_icon");
        let preview = document.getElementById("section_icon_preview");
        let container = document.getElementById("sectionIconPreviewContainer");
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            container.style.display = "block";
        }
    }
    
    
    function previewroleIcon() {
        let input = document.getElementById("roles_icon");
        let preview = document.getElementById("roles_icon_preview");
        let container = document.getElementById("rolesIconPreviewContainer");
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            container.style.display = "block";
        }
    }

    // ✅ Dynamic row addition for Application Details
    document.getElementById("addDetailRow").addEventListener("click", function() {
        let tableBody = document.querySelector("#detailsTable tbody");
        let newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="features[]" class="form-control" placeholder="Enter Features" required></td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    });

    // Remove row
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("removeRow")) {
            e.target.closest("tr").remove();
        }
    });
</script>



</body>

</html>