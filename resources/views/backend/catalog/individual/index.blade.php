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
                                    <a href="{{ route('manage-individual-series-catalog.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Individual Series Catalog List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-individual-series-catalog.create') }}" class="btn btn-primary px-5 radius-30">+ Add Individual Series Catalog</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Heading</th>
                                    <th>Thumbnail Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($catalogs as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                            
                                        <td>{{ $item->section_title ?? '—' }}</td>
                            
                                        <td>
                                            @if($item->thumbnail_image)
                                                <img src="{{ asset($item->thumbnail_image) }}" 
                                                     alt="Thumbnail" 
                                                     style="height:130px; width:auto; border:1px solid #ddd; border-radius:4px;">
                                            @else
                                                —
                                            @endif
                                        </td>
                            
                                        <td>
                                            <a href="{{ route('manage-individual-series-catalog.edit', $item->id) }}" 
                                               class="btn btn-sm btn-primary">Edit</a>
                            
                                            <form action="{{ route('manage-individual-series-catalog.destroy', $item->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
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