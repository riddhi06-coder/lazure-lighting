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
                  <h4>Edit Built To Suit Gallery Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-gallery-built.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Built To Suit Gallery</li>
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
                        <h4>Built To Suit Gallery Form</h4>
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
                                        action="{{ route('manage-gallery-built.update', $built_to_suit->id) }}" 
                                        method="POST" enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT') <!-- ✅ Required for update -->


                                        @if($isFirstRecord)
                                            <!-- ================= Banner Section ================= -->
                                            <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_heading">Banner Heading <span class="txt-danger">*</span></label>
                                                <input type="text" id="banner_heading" name="banner_heading" 
                                                    class="form-control" placeholder="Enter Banner Heading" 
                                                    value="{{ old('banner_heading', $built_to_suit->banner_heading) }}" required>
                                                <div class="invalid-feedback">Please enter a banner heading.</div>
                                            </div>
    
                                           <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_image">Banner Image <span class="txt-danger">*</span></label>
                                                <input class="form-control" id="banner_image" type="file" name="banner_image" 
                                                    accept=".jpg, .jpeg, .png, .webp" onchange="previewImage(this, 'banner_image_preview', 'bannerImagePreviewContainer')">
                                        
                                                <small class="text-secondary"><b>Note: File size < 2MB. Only .jpg, .jpeg, .png, .webp allowed.</b></small>
                                        
                                                <!-- Preview container -->
                                                <div id="bannerImagePreviewContainer" style="margin-top:10px; {{ $built_to_suit->banner_image ? '' : 'display:none;' }}">
                                                    <img id="banner_image_preview" 
                                                         src="{{ $built_to_suit->banner_image ? asset($built_to_suit->banner_image) : '' }}" 
                                                         alt="Preview" class="img-fluid" style="max-height:200px; border:1px solid #ddd; padding:5px;">
                                                </div>
                                            </div>
                                            
                                            
                                            <hr class="mt-4 mb-4">
                                        @endif
                                        
                                        <!-- ================= Project Section ================= -->
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="project_name">Project Name <span class="txt-danger">*</span></label>
                                            <input type="text" id="project_name" name="project_name" class="form-control" placeholder="Enter Project Name" value="{{ old('project_name', $built_to_suit->project_name) }}" required>
                                            <div class="invalid-feedback">Please enter a Project Name.</div>
                                        </div>

                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="thumbnail_image">Project Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" 
                                                accept=".jpg, .jpeg, .png, .webp" required onchange="previewImage(this, 'thumbnail_image_preview', 'thumbnailImagePreviewContainer')">
                                        
                                            <small class="text-secondary"><b>Note: File size < 2MB. Only .jpg, .jpeg, .png, .webp allowed.</b></small>
                                        
                                            <!-- Preview container -->
                                            <div id="thumbnailImagePreviewContainer" style="margin-top:10px; {{ $built_to_suit->thumbnail_image ? '' : 'display:none;' }}">
                                                <img id="thumbnail_image_preview" 
                                                     src="{{ $built_to_suit->thumbnail_image ? asset($built_to_suit->thumbnail_image) : '' }}" 
                                                     alt="Preview" class="img-fluid" style="max-height:200px; border:1px solid #ddd; padding:5px;">
                                            </div>
                                        </div>
                                        
                                        <hr class="mt-4 mb-4">
                                        
                                        <!-- ================= Gallery Images ================= -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h6 class="mb-4"><strong>Images</strong></h6>
                                        
                                            <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Upload Image</th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $gallery = json_decode($built_to_suit->gallery_images, true) ?? [];
                                                    @endphp
                                                    
                                                    <!--@forelse($gallery as $i => $image)-->
                                                    <!--<tr>-->
                                                        <!-- FILE INPUT -->
                                                    <!--    <td>-->
                                                    <!--        <input type="file" name="gallery_images[]" class="form-control gallery-upload"-->
                                                    <!--               accept=".png, .jpg, .jpeg, .webp, .svg" multiple>-->
                                                    <!--        <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>-->
                                                    <!--        <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>-->
                                                    
                                                    <!--        {{-- Hidden old image data --}}-->
                                                    <!--        <input type="hidden" name="existing_gallery[]" value="{{ $image }}">-->
                                                    <!--    </td>-->
                                                    
                                                        <!-- PREVIEW -->
                                                    <!--    <td>-->
                                                    <!--       <img src="{{ url($image) }}" class="img-preview" style="max-width:200px;">-->

                                                    <!--    </td>-->
                                                    
                                                        <!-- ACTION -->
                                                    <!--    <td>-->
                                                    <!--        @if($loop->first)-->
                                                    <!--            <button type="button" class="btn btn-primary addGalleryRow">Add More</button>-->
                                                    <!--        @else-->
                                                    <!--            <button type="button" class="btn btn-danger removeGalleryRow"-->
                                                    <!--                data-old-image="{{ $image }}">Remove</button>-->
                                                    <!--        @endif-->
                                                    <!--    </td>-->
                                                    <!--</tr>-->
                                                    <!--@empty-->
                                                    <!--<tr>-->
                                                    <!--    <td>-->
                                                    <!--        <input type="file" name="gallery_images[]" class="form-control gallery-upload"-->
                                                    <!--               accept=".png, .jpg, .jpeg, .webp, .svg">-->
                                                    <!--            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>-->
                                                    <!--            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>-->
                                                    <!--    </td>-->
                                                    <!--    <td><img class="img-preview" style="max-width: 200px; display:none;"></td>-->
                                                    <!--    <td><button type="button" class="btn btn-primary addGalleryRow">Add More</button></td>-->
                                                    <!--</tr>-->
                                                    <!--@endforelse-->
                                                    
                                                    
                                                    @foreach($gallery as $i => $image)
                                                        <tr>
                                                            <td>
                                                                <input type="file"
                                                                       name="gallery_images[{{ $i }}]"
                                                                       class="form-control gallery-upload"
                                                                       accept=".png,.jpg,.jpeg,.webp,.svg">
                                                                        <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                        <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                        
                                                                <input type="hidden"
                                                                       name="existing_gallery[{{ $i }}]"
                                                                       value="{{ $image }}">
                                                            </td>
                                                        
                                                            <td>
                                                                <img src="{{ url($image) }}" class="img-preview" style="max-width:200px;">
                                                            </td>
                                                        
                                                            <td>
                                                                @if($loop->first)
                                                                    <button type="button" class="btn btn-primary addGalleryRow">Add More</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>


                                            </table>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-gallery-built.index') }}" class="btn btn-danger px-4">Cancel</a>
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
function previewImage(input, previewImgId, previewContainerId) {
    const file = input.files[0];
    const previewImage = document.getElementById(previewImgId);
    const previewContainer = document.getElementById(previewContainerId);

    // Clear previous preview
    previewImage.src = '';

    if(file){
        const validTypes = ['image/jpeg','image/jpg','image/png','image/webp'];
        if(validTypes.includes(file.type)){
            const reader = new FileReader();
            reader.onload = function(e){
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block'; // Show container
            }
            reader.readAsDataURL(file);
        } else {
            alert('Please upload a valid image (jpg, jpeg, png, webp).');
            input.value = ''; // Clear invalid input
        }
    } else {
        previewContainer.style.display = 'none'; // Hide if no file
    }
}
</script>



<script>
    document.addEventListener("click", function(e) {
    
        let index = document.querySelectorAll("#galleryTable tbody tr").length;
        // ADD ROW
        if (e.target.classList.contains("addGalleryRow")) {
            // let newRow = `
            // <tr>
            //     <td>
            //         <input type="file" name="gallery_images[]" class="form-control gallery-upload"
            //               accept=".png, .jpg, .jpeg, .webp, .svg">
            //               <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
            //                 <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
            //     </td>
            //     <td><img class="img-preview" style="max-width: 200px; display:none;"></td>
            //     <td><button type="button" class="btn btn-danger removeGalleryRow">Remove</button></td>
            // </tr>`;
            
            let newRow = `
                <tr>
                    <td>
                        <input type="file" name="gallery_images[${index}]"
                               class="form-control gallery-upload"
                               accept=".png,.jpg,.jpeg,.webp,.svg">
                               <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                               <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                    </td>
                    <td><img class="img-preview" style="max-width:200px; display:none;"></td>
                    <td><button type="button" class="btn btn-danger removeGalleryRow">Remove</button></td>
                </tr>`;
            
            document.querySelector("#galleryTable tbody")
                    .insertAdjacentHTML("beforeend", newRow);
        }
    
        // REMOVE ROW
        if (e.target.classList.contains("removeGalleryRow")) {
    
            let row = e.target.closest("tr");
            let oldImage = e.target.getAttribute("data-old-image");
    
            // If image already stored in DB → append to form before delete
            if (oldImage) {
                let hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = "remove_gallery[]";
                hidden.value = oldImage;
    
                document.querySelector("form").appendChild(hidden);
            }
    
            row.remove();
        }
    });
    
    // Preview uploaded image
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("gallery-upload")) {
            let file = e.target.files[0];
            let preview = e.target.closest("tr").querySelector(".img-preview");
    
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        }
    });
</script>





</body>

</html>