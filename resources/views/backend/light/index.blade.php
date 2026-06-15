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
                                    <a href="{{ route('manage-light-application.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Light Applications</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-light-application.create') }}" class="btn btn-primary px-5 radius-30">+ Add Light Applications</a>
                    </div>

                    <div class="table-responsive custom-scrollbar">
                        
                       <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Light Applications</th>
                                    <th>Categories</th>
                                    <!--<th>Thumbnail Image</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $key => $app)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $app->light_application_type ?? 'N/A' }}</td>
                                        <td>
                                            @if(!empty($app->sub_category_names))
                                                @foreach($app->sub_category_names as $name)
                                                    <span class="badge bg-primary me-1 mb-1">{{ $name }}</span>
                                                @endforeach
                                            @else
                                               -
                                            @endif
                                        </td>
                                        <!--<td>-->
                                        <!--    @if($app->thumbnail_image)-->
                                        <!--        <img src="{{ asset($app->thumbnail_image) }}" alt="{{ $app->light_application_type }}" style="max-height: 120px; border:1px solid #ddd; padding:2px;">-->
                                        <!--    @else-->
                                        <!--        N/A-->
                                        <!--    @endif-->
                                        <!--</td>-->
                                        <td>
                                            <a href="{{ route('manage-light-application.edit', $app->id) }}" class="btn btn-sm btn-primary">Edit</a><br><br>
                                            <form action="{{ route('manage-light-application.destroy', $app->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
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