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
                  <h4>Edit Job Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-jobs.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Job</li>
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
                        <h4>Job Form</h4>
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
                                          action="{{ route('manage-jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                    
                                        <!-- Job Role -->
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="job_role">Job Role <span class="txt-danger">*</span></label>
                                            <input type="text" id="job_role" name="job_role" class="form-control" 
                                                   placeholder="Enter Job Role" value="{{ old('job_role', $job->job_role) }}" required>
                                            <div class="invalid-feedback">Please enter a Job Role.</div>
                                        </div>
                                    
                                        <!-- Job Location -->
                                        <div class="col-md-6">
                                            <label for="job_location">Job Location <span class="txt-danger">*</span></label>
                                            <input type="text" name="job_location" id="job_location" class="form-control" 
                                                   placeholder="Enter Job Location" value="{{ old('job_location', $job->job_location) }}" required>
                                        </div>
                                    
                                        <!-- Job Description -->
                                        <div class="col-md-12">
                                            <label for="job_description">Job Description <span class="txt-danger">*</span></label>
                                            <textarea name="job_description" id="editor" class="form-control" rows="4" 
                                                      placeholder="Enter Job description..." required>{{ old('job_description', $job->job_description) }}</textarea>
                                        </div>
                                    
                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-jobs.index') }}" class="btn btn-danger px-4">Cancel</a>
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

</body>

</html>