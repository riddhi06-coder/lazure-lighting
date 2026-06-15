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
                  <h4>Edit Advertise Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-advertise.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Advertise Details</li>
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
                        <h4>Advertise Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-advertise.update', $banner_details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" value="{{ old('banner_title', $banner_details->banner_title) }}" placeholder="Enter Title" required>
                                            <div class="invalid-feedback">Please enter a Title.</div>
                                        </div>

                                        <!-- Video Upload -->
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label" for="video_upload">Upload Video <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="video_upload" type="file" name="video_upload" accept="video/*">
                                            <div class="invalid-feedback">Please upload a video.</div>
                                            <small class="text-secondary"><b>Note: Maximum file size should be 5MB. Accepted formats: .mp4, .webm, .ogg</b></small>

                                            {{-- Video Preview Container --}}
                                            @if ($banner_details->video)
                                            <div id="videoPreviewContainer" class="mt-3">
                                                <video id="videoPreview" width="100%" height="240" controls autoplay muted>
                                                    <source src="{{ asset('uploads/home/advertise/' . $banner_details->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-advertise.index') }}" class="btn btn-danger px-4">Cancel</a>
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
    document.getElementById('video_upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('videoPreviewContainer');
        const previewVideo = document.getElementById('videoPreview');

        if (file && file.type.startsWith('video/')) {
            const url = URL.createObjectURL(file);
            previewVideo.src = url;
            previewVideo.type = file.type;
            previewContainer.style.display = 'block';
        } else {
            previewVideo.src = '';
            previewContainer.style.display = 'none';
        }
    });
</script>

</body>

</html>