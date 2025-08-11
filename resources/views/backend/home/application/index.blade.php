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
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('manage-app-intro.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Application Intro List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-app-intro.create') }}" class="btn btn-primary px-5 radius-30">+ Add Application Intro</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Application Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $index => $app)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                            <td>{{ $app->applicationType->application_type ?? 'N/A' }}</td>
                                        <td>
                                            @if($app->banner_image)
                                                <img src="{{ asset($app->banner_image) }}"
                                                    alt="{{ $app->applicationType->application_type ?? '' }}"
                                                    width="200"
                                                    height="100"
                                                    style="object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('manage-app-intro.edit', $app->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('manage-app-intro.destroy', $app->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>

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