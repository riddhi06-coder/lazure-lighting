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
                  <h4>Add Job Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-jobs.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Job</li>
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
                                        action="{{ route('manage-jobs.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- ================= Banner Section ================= -->
                                        <div class="col-xxl-6 col-sm-12">
                                            <label class="form-label" for="job_role">Job Role <span class="txt-danger">*</span></label>
                                            <input type="text" id="job_role" name="job_role" class="form-control" placeholder="Enter Job Role" required>
                                            <div class="invalid-feedback">Please enter a Job Role.</div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="job">Job Location <span class="txt-danger">*</span></label>
                                            <input type="text" name="job_location" id="job_location" class="form-control" placeholder="Enter Job Location" required>
                                        </div>
                                        
                                        
                                        <div class="col-md-12">
                                            <label for="job_description">Job Description <span class="txt-danger">*</span></label>
                                            <textarea name="job_description" id="editor" class="form-control" rows="4" placeholder="Enter Job description..." required></textarea>
                                        </div>




                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-jobs.index') }}" class="btn btn-danger px-4">Cancel</a>
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

</body>

</html>