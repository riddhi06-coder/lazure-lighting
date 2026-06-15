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
                                    <a href="{{ route('manage-gallery-built.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Built To Suit Gallery List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-gallery-built.create') }}" class="btn btn-primary px-5 radius-30">+ Add Details</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Thumbnail Image</th>
                                    
                                    <th>Priority</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galleries as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                            
                                        <td>{{ $item->project_name }}</td>
                            
                                        <td>
                                            @if(!empty($item->thumbnail_image))
                                                <img src="{{ asset($item->thumbnail_image) }}" 
                                                     alt="Thumbnail" 
                                                     style="width: 120px; height: 100px; border-radius: 6px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        
                                        {{-- Priority Column --}}
                                        <td style="width: 150px;">
                                            <form action="{{ route('manage-gallery-built.update-priority', $item->id) }}" method="POST">
                                                @csrf
                                        
                                                <input type="number"
                                                    name="priority"
                                                    class="form-control form-control-sm"
                                                    value="{{ $item->priority }}"
                                                    min="0"
                                                    style="width: 90px;"
                                                    onchange="this.form.submit()">
                                            </form>
                                        </td>

                            
                                        <td>
                                            <a href="{{ route('manage-gallery-built.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                            
                                            <form action="{{ route('manage-gallery-built.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this record?')" 
                                                        class="btn btn-sm btn-danger">
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