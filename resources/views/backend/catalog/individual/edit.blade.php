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
                  <h4>Edit Individual Series Catalog Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-individual-series-catalog.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Individual Series Catalog</li>
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
                        <h4>Individual Series Catalog Form</h4>
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
                                          action="{{ route('manage-individual-series-catalog.update', $catalog->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                    
                                        @csrf
                                        @method('PUT')
                                    
                                        
                                        {{-- ================= Banner Section: Only for First Record ================= --}}
                                        @if($isFirstRecord)
                                            <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_heading">Banner Heading</label>
                                                <input type="text"
                                                       id="banner_heading"
                                                       name="banner_heading"
                                                       class="form-control"
                                                       value="{{ old('banner_heading', $catalog->banner_heading) }}"
                                                       placeholder="Enter Banner Heading">
                                    
                                            </div>
                                    
                                            <div class="col-xxl-6 col-sm-12">
                                                <label class="form-label" for="banner_image">Banner Image</label>
                                    
                                                <input class="form-control"
                                                       id="banner_image"
                                                       type="file"
                                                       name="banner_image"
                                                       accept=".jpg, .jpeg, .png, .webp"
                                                       onchange="previewBannerImage()">
                                    
                                                <small class="text-secondary"><b>Max 2MB, formats: JPG, PNG, WEBP</b></small>
                                    
                                                {{-- Existing Preview --}}
                                                <div id="bannerImagePreviewContainer"
                                                     style="margin-top:10px; {{ $catalog->banner_image ? '' : 'display:none;' }}">
                                                    <img id="banner_image_preview"
                                                         src="{{ $catalog->banner_image ? asset($catalog->banner_image) : '' }}"
                                                         class="img-fluid"
                                                         style="max-height:200px; border:1px solid #ddd; padding:5px;">
                                                </div>
                                            </div>
                                    
                                            <hr class="mt-4 mb-4">
                                        @endif
                                    
                                    
                                        {{-- ================= Section Title ================= --}}
                                        <div class="col-md-6">
                                            <label for="section_title">Heading </label>
                                            <input type="text"
                                                   name="section_title"
                                                   id="section_title"
                                                   class="form-control"
                                                   value="{{ old('section_title', $catalog->section_title) }}"
                                                   placeholder="Enter Heading title">
                                        </div>
                                    
                                    
                                        {{-- ================= Thumbnail Image ================= --}}
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image</label>
                                    
                                            <input type="file"
                                                   name="thumbnail_image"
                                                   id="thumbnail_image"
                                                   class="form-control"
                                                   accept=".jpg, .jpeg, .png, .webp"
                                                   onchange="previewSectionImage()">
                                    
                                            <small class="text-secondary"><b>Max 2MB, formats: JPG, PNG, WEBP</b></small>
                                    
                                            {{-- Existing Thumbnail Preview --}}
                                            <div id="sectionImagePreviewContainer"
                                                 style="margin-top:10px;">
                                                <img id="thumbnail_image_preview"
                                                     src="{{ asset($catalog->thumbnail_image) }}"
                                                     class="img-fluid"
                                                     style="max-height:200px; border:1px solid #ddd; padding:5px;">
                                            </div>
                                        </div>
                                    
                                    
                                        {{-- ================= Document File ================= --}}
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="document_file">Upload Document</label>
                                    
                                            <input type="file"
                                                   name="document_file"
                                                   id="document_file"
                                                   class="form-control"
                                                   accept=".pdf, .doc, .docx, .zip"
                                                   onchange="previewDocument()">
                                    
                                            <small class="text-secondary"><b>Allowed: PDF, DOC, DOCX, ZIP (max 3MB)</b></small>
                                    
                                            <div id="documentPreviewContainer" style="margin-top:10px;">
                                    
                                                {{-- PDF Preview --}}
                                                @if(Str::endsWith($catalog->document_file, '.pdf'))
                                                    <iframe src="{{ asset($catalog->document_file) }}"
                                                            style="width:100%; height:300px; border:1px solid #ddd;"></iframe>
                                                @else
                                                    {{-- DOC/DOCX/ZIP name --}}
                                                    <p style="font-weight:600; border:1px solid #ddd; padding:10px;">
                                                        Current File: {{ basename($catalog->document_file) }}
                                                    </p>
                                                @endif
                                    
                                            </div>
                                        </div>
                                    
                                    
                                        {{-- ================= Actions ================= --}}
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-individual-series-catalog.index') }}" class="btn btn-danger px-4">Cancel</a>
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



<script>
    function previewSectionImage() {
        let input = document.getElementById("thumbnail_image");
        let preview = document.getElementById("thumbnail_image_preview");
        let container = document.getElementById("sectionImagePreviewContainer");
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            container.style.display = "block";
        }
    }
</script>


<script>
    function previewDocument() {
    const fileInput = document.getElementById('document_file');
    const file = fileInput.files[0];

    const pdfPreview = document.getElementById('document_pdf_preview');
    const namePreview = document.getElementById('document_name_preview');
    const container = document.getElementById('documentPreviewContainer');

    pdfPreview.style.display = 'none';
    namePreview.style.display = 'none';
    container.style.display = 'none';

    if (!file) return;

    const fileType = file.type;
    const validDocs = ['application/pdf', 
                       'application/msword', 
                       'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    if (!validDocs.includes(fileType)) {
        alert("Please upload only PDF, DOC, or DOCX files.");
        fileInput.value = "";
        return;
    }

    container.style.display = 'block';

    if (fileType === 'application/pdf') {
        // Show PDF in iframe
        const reader = new FileReader();
        reader.onload = (e) => {
            pdfPreview.src = e.target.result;
            pdfPreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        // Show DOC/DOCX name only
        namePreview.innerText = "Selected Document: " + file.name;
        namePreview.style.display = 'block';
    }
}
</script>




</body>

</html>