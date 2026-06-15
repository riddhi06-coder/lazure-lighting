<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('manage-model-details.index') }}">Home</a>
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

                                    <form class="row g-3 needs-validation custom-input" 
                                        novalidate 
                                        action="{{ route('manage-model-details.update', $appIntro->id) }}" 
                                        method="POST" 
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Product Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="product_image">Product Image</label>
                                            <input class="form-control" id="product_image" type="file" name="product_image" accept=".jpg,.jpeg,.png,.webp" onchange="previewBannerImage()">
                                            @if($appIntro->product_image)
                                                <img src="{{ asset($appIntro->product_image) }}" alt="preview" class="mt-2" width="100">
                                            @endif

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
                                                @foreach($SubProduct as $sp)
                                                    <option value="{{ $sp->id }}" {{ $appIntro->sub_product_id == $sp->id ? 'selected' : '' }}>
                                                        {{ $sp->sub_product }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Sub Product.</div>
                                        </div>

                                        <!-- Model Details CSV/Excel Upload -->
                                        <div class="col-md-6 mt-5">
                                            <label class="form-label" for="model_details_file">Upload Model Details (CSV/Excel)</label>
                                            <input class="form-control" id="model_details_file" type="file" name="model_details_file" accept=".csv,.xls,.xlsx">
                                        </div>

                                        <div class="col-12 text-end mt-3">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>


                                    <hr>


                                    <!-- <form class="row g-3 mt-4" action="{{ route('upload.spec_sheet') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" value="{{ $appIntro->id }}">
                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="spec_sheet">Upload Spec Sheets (PDF)</label>
                                            <div class="d-flex">
                                                <input class="form-control" id="spec_sheet" type="file" name="spec_sheet[]" accept=".pdf" multiple required>
                                                <button type="submit" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                        </div>
                                    </form> -->


                                    <!-- Installation Manual Upload -->
                                    <!-- <form class="row g-3 mt-4" action="{{ route('upload.installation_manual') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" value="{{ $appIntro->id }}">
                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="installation_manual">Upload Installation Manuals (PDF)</label>
                                            <div class="d-flex">
                                                <input class="form-control" id="installation_manual" type="file" name="installation_manual[]" accept=".pdf" multiple required>
                                                <button type="submit" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                        </div>
                                    </form> -->


                                    <!-- 2D Drawings Upload -->
                                    <!-- <form class="row g-3 mt-4" action="{{ route('upload.drawings_2d') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" value="{{ $appIntro->id }}">
                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="drawings_2d">Upload 2D Drawings (PDF)</label>
                                            <div class="d-flex">
                                                <input class="form-control" id="drawings_2d" type="file" name="drawings_2d[]" accept=".pdf" multiple required>
                                                <button type="submit" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                        </div>
                                    </form> -->


                                    <!-- 3D Drawings Upload -->
                                    <!-- <form class="row g-3 mt-4" action="{{ route('upload.drawings_3d') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" value="{{ $appIntro->id }}">
                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="drawings_3d">Upload 3D Drawings (ZIP)</label>
                                            <div class="d-flex">
                                                <input class="form-control" id="drawings_3d" type="file" name="drawings_3d[]" accept=".zip" multiple required>
                                                <button type="submit" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                        </div>
                                    </form> -->


                                    <form class="row g-3 mt-4" id="uploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" id="hidden_sub_product_id">

                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="spec_sheet">Upload Spec Sheets (PDF)</label>

                                            <!-- Progress -->
                                            <div class="progress mt-3" style="height: 25px;">
                                                <div id="uploadProgress" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                            </div>

                                            <!-- Uploaded files list (optional) -->
                                            <ul id="uploadStatus" class="mt-2 text-success small"></ul>

                                            <div class="d-flex mt-2">
                                                <input class="form-control" id="spec_sheet" type="file" name="spec_sheet[]" accept=".pdf" multiple required>
                                                <button type="submit" id="uploadBtn" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                            <small class="text-secondary"><b>Note: Multiple PDFs allowed. Max size per file 2MB.</b></small>
                                        </div>
                                    </form>


                                    <form class="row g-3 mt-4" id="manualUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" id="hidden_sub_product_id_manual">

                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="installation_manual">Upload Installation Manuals (PDF)</label>

                                            <!-- Progress -->
                                            <div class="progress mt-3" style="height: 25px; display: none;">
                                                <div id="manualUploadProgress" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                            </div>

                                            <!-- Uploaded files list (optional) -->
                                            <ul id="manualUploadStatus" class="mt-2 text-success small"></ul>

                                            <div class="d-flex mt-2">
                                                <input class="form-control" id="installation_manual" type="file" name="installation_manual[]" accept=".pdf" multiple required>
                                                <button type="submit" id="manualUploadBtn" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                            <small class="text-secondary"><b>Note: Multiple PDFs allowed. Max size per file 2MB.</b></small>
                                        </div>
                                    </form>


                                    <!-- 2D Drawings Upload -->
                                    <form class="row g-3 mt-4" id="drawings2DUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" id="hidden_sub_product_id_2d">

                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="drawings_2d">Upload 2D Drawings (PDF)</label>

                                            <!-- Progress -->
                                            <div class="progress mt-3" style="height: 25px; display: none;">
                                                <div id="drawings2DProgress" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                            </div>

                                            <ul id="drawings2DStatus" class="mt-2 text-success small"></ul>

                                            <div class="d-flex mt-2">
                                                <input class="form-control" id="drawings_2d" type="file" name="drawings_2d[]" accept=".pdf" multiple required>
                                                <button type="submit" id="drawings2DUploadBtn" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                            <small class="text-secondary"><b>Note: Multiple PDFs allowed. Max size per file 2MB.</b></small>
                                        </div>
                                    </form>



                                    <form class="row g-3 mt-4" id="drawings3DUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="sub_product_id" id="hidden_sub_product_id_3d">

                                        <div class="col-md-12">
                                            <label class="form-label mb-2" for="drawings_3d">Upload 3D Drawings (ZIP)</label>

                                            <!-- Progress -->
                                            <div class="progress mt-3" style="height: 25px; display: none;">
                                                <div id="drawings3DProgress" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                            </div>

                                            <ul id="drawings3DStatus" class="mt-2 text-success small"></ul>

                                            <div class="d-flex mt-2">
                                                <input class="form-control" id="drawings_3d" type="file" name="drawings_3d[]" accept=".zip, .jpg, .jpeg, .png, .webp, .pdf"  multiple required>
                                                <button type="submit" id="drawings3DUploadBtn" class="btn btn-primary ms-2">Upload</button>
                                            </div>
                                            <small class="text-secondary"><b>Note: Multiple ZIP, Image (JPG, JPEG, PNG, WEBP), and PDF files allowed. Max size per file 5MB.</b></small>
                                        </div>
                                    </form>


                                    <!-- Form Actions -->
                                    <div class="col-12 text-end mt-5">
                                        <a href="{{ route('manage-model-details.index') }}" class="btn btn-danger px-4">Cancel</a>
                                        <!-- <button class="btn btn-primary" type="submit">Submit</button> -->
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

        </div>

        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>

        @include('components.backend.main-js')

          <!---- js for showing the usb product id in the Documnet upload----->
        <script>
            document.getElementById('sub_product_id').addEventListener('change', function () {
                document.getElementById('hidden_sub_product_id').value = this.value;
            });

            // Prevent submit if no sub product selected
            document.getElementById('uploadBtn').addEventListener('click', function (e) {
                const subProductId = document.getElementById('sub_product_id').value;
                if (!subProductId) {
                    e.preventDefault();
                    alert("Please select a Sub Product before uploading.");
                }
            });
        </script>

        <script>
            function previewBannerImage() {
                const file = document.getElementById('product_image').files[0];
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
                            previewContainer.style.display = 'block';  
                        };

                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload a valid image file (jpg, jpeg, png, webp).');
                    }
                }
            }
        </script>

   

        <!------ js for uplaoding the specsheet----->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const uploadBtn = document.getElementById('uploadBtn');
                const fileInput = document.getElementById('spec_sheet');
                const progressContainer = document.getElementById('uploadProgress').parentElement; // progress div
                const progressBar = document.getElementById('uploadProgress');

                if (!uploadBtn) return;

                // Update hidden input in edit mode as well
                const subProductSelect = document.getElementById('sub_product_id');
                const hiddenInput = document.getElementById('hidden_sub_product_id');

                // Set hidden input initially if editing
                hiddenInput.value = subProductSelect.value;

                subProductSelect.addEventListener('change', function() {
                    hiddenInput.value = this.value;
                });

                // Hide progress initially
                progressContainer.style.display = 'none';

                uploadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const subProductId = hiddenInput.value;
                    if (!subProductId) return alert('Please select a Sub Product before uploading.');

                    const files = fileInput.files;
                    if (!files.length) return alert('Please select files');

                    uploadBtn.disabled = true;
                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';
                    progressContainer.style.display = 'block'; // show progress

                    const batchSize = 10; // files per batch
                    let currentBatch = 0;
                    const totalBatches = Math.ceil(files.length / batchSize);
                    let currentFileGlobal = 0;

                    function uploadBatch() {
                        const start = currentBatch * batchSize;
                        const end = Math.min(start + batchSize, files.length);
                        const batchFiles = Array.from(files).slice(start, end);
                        let currentFile = 0;

                        function uploadNextInBatch() {
                            if (currentFile >= batchFiles.length) {
                                currentBatch++;
                                if (currentBatch < totalBatches) {
                                    uploadBatch(); // next batch
                                } else {
                                    alert('✅ All files uploaded successfully!');
                                    uploadBtn.disabled = false;
                                    progressContainer.style.display = 'none';
                                    location.reload();
                                }
                                return;
                            }

                            const file = batchFiles[currentFile];
                            const formData = new FormData();
                            formData.append('spec_sheet[]', file);
                            formData.append('sub_product_id', subProductId);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            fetch("{{ route('upload.spec_sheet') }}", {
                                method: 'POST',
                                body: formData,
                                headers: { "Accept": "application/json" }
                            })
                            .then(async res => {
                                const text = await res.text();
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    throw new Error("❌ Server did not return valid JSON.");
                                }
                            })
                            .then(data => {
                                if (data.success) {
                                    currentFile++;
                                    currentFileGlobal++;

                                    // Update file-wise progress in the progress bar only
                                    const percent = Math.round((currentFileGlobal / files.length) * 100);
                                    progressBar.style.width = percent + '%';
                                    progressBar.textContent = `File ${currentFileGlobal} of ${files.length} – ${percent}%`;

                                    uploadNextInBatch(); // next file
                                } else {
                                    console.error('❌ Upload failed:', data.message);
                                    progressBar.textContent = `❌ Failed at file ${currentFileGlobal + 1}`;
                                    alert('❌ Upload failed, check console.');
                                    uploadBtn.disabled = false;
                                    progressContainer.style.display = 'none';
                                }
                            })
                            .catch(err => {
                                console.error('❌ Upload error:', err);
                                progressBar.textContent = `❌ Error at file ${currentFileGlobal + 1}`;
                                alert('❌ Upload failed, check console.');
                                uploadBtn.disabled = false;
                                progressContainer.style.display = 'none';
                            });
                        }

                        uploadNextInBatch();
                    }

                    uploadBatch();
                });
            });
        </script>



        <!------ js for uplaoding the Installation Manuals----->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mainSelect = document.getElementById('sub_product_id'); // main dropdown
                const hiddenManualInput = document.getElementById('hidden_sub_product_id_manual'); // hidden input in manual form
                const manualUploadBtn = document.getElementById('manualUploadBtn');
                const fileInput = document.getElementById('installation_manual');
                const progressContainer = document.getElementById('manualUploadProgress').parentElement;
                const progressBar = document.getElementById('manualUploadProgress');

                if (!manualUploadBtn) return;

                // Initialize hidden input in edit mode
                hiddenManualInput.value = mainSelect.value;

                // Update hidden input whenever the main sub_product_id changes
                mainSelect.addEventListener('change', function() {
                    hiddenManualInput.value = this.value;
                });

                manualUploadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const subProductId = hiddenManualInput.value;
                    if (!subProductId) return alert('Please select a Sub Product before uploading.');

                    const files = fileInput.files;
                    if (!files.length) return alert('Please select files');

                    manualUploadBtn.disabled = true;
                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';
                    progressContainer.style.display = 'block'; // show progress

                    const batchSize = 10; // files per batch
                    let currentBatch = 0;
                    const totalBatches = Math.ceil(files.length / batchSize);
                    let currentFileGlobal = 0;

                    function uploadBatch() {
                        const start = currentBatch * batchSize;
                        const end = Math.min(start + batchSize, files.length);
                        const batchFiles = Array.from(files).slice(start, end);
                        let currentFile = 0;

                        function uploadNextInBatch() {
                            if (currentFile >= batchFiles.length) {
                                currentBatch++;
                                if (currentBatch < totalBatches) {
                                    uploadBatch(); // next batch
                                } else {
                                    alert('✅ All manuals uploaded successfully!');
                                    manualUploadBtn.disabled = false;
                                    progressContainer.style.display = 'none';
                                    location.reload();
                                }
                                return;
                            }

                            const file = batchFiles[currentFile];
                            const formData = new FormData();
                            formData.append('installation_manual[]', file);
                            formData.append('sub_product_id', subProductId);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            fetch("{{ route('upload.installation_manual') }}", {
                                method: 'POST',
                                body: formData,
                                headers: { "Accept": "application/json" }
                            })
                            .then(async res => {
                                const text = await res.text();
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    throw new Error("❌ Server did not return valid JSON.");
                                }
                            })
                            .then(data => {
                                if (data.success) {
                                    currentFile++;
                                    currentFileGlobal++;
                                    const percent = Math.round((currentFileGlobal / files.length) * 100);
                                    progressBar.style.width = percent + '%';
                                    progressBar.textContent = `File ${currentFileGlobal} of ${files.length} – ${percent}%`;

                                    uploadNextInBatch(); // next file
                                } else {
                                    console.error('❌ Upload failed:', data.message);
                                    progressBar.textContent = `❌ Failed at file ${currentFileGlobal + 1}`;
                                    alert('❌ Upload failed, check console.');
                                    manualUploadBtn.disabled = false;
                                    progressContainer.style.display = 'none';
                                }
                            })
                            .catch(err => {
                                console.error('❌ Upload error:', err);
                                progressBar.textContent = `❌ Error at file ${currentFileGlobal + 1}`;
                                alert('❌ Upload failed, check console.');
                                manualUploadBtn.disabled = false;
                                progressContainer.style.display = 'none';
                            });
                        }

                        uploadNextInBatch();
                    }

                    uploadBatch();
                });
            });
        </script>



        <!------ js for uplaoding the 2d drawings----->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mainSelect = document.getElementById('sub_product_id'); 
                const hidden2DInput = document.getElementById('hidden_sub_product_id_2d');
                const drawingsBtn = document.getElementById('drawings2DUploadBtn');
                const drawingsInput = document.getElementById('drawings_2d');
                const progressContainer = document.querySelector('#drawings2DProgress').parentElement;
                const progressBar = document.getElementById('drawings2DProgress');

                // 1️⃣ Pre-fill hidden input for edit forms
                hidden2DInput.value = mainSelect.value;

                // 2️⃣ Update hidden input whenever dropdown changes
                mainSelect.addEventListener('change', function() {
                    hidden2DInput.value = this.value;
                });

                drawingsBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const subProductId = hidden2DInput.value;
                    if (!subProductId) return alert('Please select a Sub Product before uploading.');

                    const files = drawingsInput.files;
                    if (!files.length) return alert('Please select files');

                    drawingsBtn.disabled = true;
                    progressContainer.style.display = 'block';
                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';

                    const batchSize = 10; // files per batch
                    let currentBatch = 0;
                    const totalBatches = Math.ceil(files.length / batchSize);
                    let currentFileGlobal = 0; // track overall file progress

                    function uploadBatch() {
                        const start = currentBatch * batchSize;
                        const end = Math.min(start + batchSize, files.length);
                        const batchFiles = Array.from(files).slice(start, end);
                        let currentFile = 0;

                        function uploadNextInBatch() {
                            if (currentFile >= batchFiles.length) {
                                currentBatch++;
                                if (currentBatch < totalBatches) {
                                    uploadBatch(); // next batch
                                } else {
                                    alert('✅ All 2D drawings uploaded successfully!');
                                    drawingsBtn.disabled = false;
                                    progressContainer.style.display = 'none';
                                    location.reload();
                                }
                                return;
                            }

                            const file = batchFiles[currentFile];
                            const formData = new FormData();
                            formData.append('drawings_2d[]', file);
                            formData.append('sub_product_id', subProductId);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            fetch("{{ route('upload.drawings_2d') }}", {
                                method: 'POST',
                                body: formData,
                                headers: { "Accept": "application/json" }
                            })
                            .then(async res => {
                                const text = await res.text();
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    throw new Error("❌ Server did not return valid JSON.");
                                }
                            })
                            .then(data => {
                                if (data.success) {
                                    currentFile++;
                                    currentFileGlobal++;
                                    const percent = Math.round((currentFileGlobal / files.length) * 100);
                                    progressBar.style.width = percent + '%';
                                    progressBar.textContent = `File ${currentFileGlobal} of ${files.length} – ${percent}%`;

                                    uploadNextInBatch(); // next file
                                } else {
                                    console.error('❌ Upload failed:', data.message);
                                    progressBar.textContent = `❌ Failed at file ${currentFileGlobal + 1}`;
                                    alert('❌ Upload failed, check console.');
                                    drawingsBtn.disabled = false;
                                }
                            })
                            .catch(err => {
                                console.error('❌ Upload error:', err);
                                progressBar.textContent = `❌ Error at file ${currentFileGlobal + 1}`;
                                alert('❌ Upload failed, check console.');
                                drawingsBtn.disabled = false;
                            });
                        }

                        uploadNextInBatch();
                    }

                    uploadBatch();
                });
            });
        </script>



         <!------ js for uplaoding the 3d drawings----->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mainSelect = document.getElementById('sub_product_id'); 
                const hidden3DInput = document.getElementById('hidden_sub_product_id_3d');
                const drawingsBtn = document.getElementById('drawings3DUploadBtn');
                const drawingsInput = document.getElementById('drawings_3d');
                const progressContainer = document.querySelector('#drawings3DProgress').parentElement;
                const progressBar = document.getElementById('drawings3DProgress');

                // 1️⃣ Pre-fill hidden input for edit forms
                hidden3DInput.value = mainSelect.value;

                // 2️⃣ Update hidden input whenever main sub_product_id changes
                mainSelect.addEventListener('change', function() {
                    hidden3DInput.value = this.value;
                });

                drawingsBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const subProductId = hidden3DInput.value;
                    if (!subProductId) return alert('Please select a Sub Product before uploading.');

                    const files = drawingsInput.files;
                    if (!files.length) return alert('Please select files');

                    drawingsBtn.disabled = true;
                    progressContainer.style.display = 'block';
                    progressBar.style.width = '0%';
                    progressBar.textContent = '0%';

                    const totalFiles = files.length;

                    // Upload a single file
                    function uploadFile(fileIndex) {
                        if (fileIndex >= totalFiles) {
                            alert('✅ All 3D drawings uploaded successfully!');
                            drawingsBtn.disabled = false;
                            progressContainer.style.display = 'none';
                            location.reload();
                            return;
                        }

                        const formData = new FormData();
                        formData.append('drawings_3d[]', files[fileIndex]);
                        formData.append('sub_product_id', subProductId);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                        fetch("{{ route('upload.drawings_3d') }}", {
                            method: 'POST',
                            body: formData,
                            headers: { "Accept": "application/json" }
                        })
                        .then(async res => {
                            const text = await res.text();
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                throw new Error("❌ Server did not return valid JSON.");
                            }
                        })
                        .then(data => {
                            if (data.success) {
                                const percent = Math.round(((fileIndex + 1) / totalFiles) * 100);
                                progressBar.style.width = percent + '%';
                                progressBar.textContent = `File ${fileIndex + 1} of ${totalFiles} – ${percent}%`;

                                // Move to next file
                                uploadFile(fileIndex + 1);
                            } else {
                                console.error('❌ Upload failed:', data.message);
                                progressBar.textContent = `❌ Failed at file ${fileIndex + 1}`;
                                alert('❌ Upload failed, check console.');
                                drawingsBtn.disabled = false;
                            }
                        })
                        .catch(err => {
                            console.error('❌ Upload error:', err);
                            progressBar.textContent = `❌ Error at file ${fileIndex + 1}`;
                            alert('❌ Upload failed, check console.');
                            drawingsBtn.disabled = false;
                        });
                    }

                    // Start uploading from the first file
                    uploadFile(0);
                });
            });
        </script>



</body>

</html>