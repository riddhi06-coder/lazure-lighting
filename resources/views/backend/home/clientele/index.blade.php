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
											<a href="{{ route('manage-clientele.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">Our Clientele Details</li>
									</ol>
								</nav>

								<a href="{{ route('manage-clientele.create') }}" class="btn btn-primary px-5 radius-30">+ Add Our Clientele</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projectsDetails as $index => $client)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">
                                            @php
                                                $images = json_decode($client->gallery_images, true);
                                            @endphp
                                
                                            @if(!empty($images))
                                                <div>
                                                    @foreach($images as $img)
                                                        <img src="{{ asset($img) }}" alt="Client Image" 
                                                             style="display:block; height:80px; width:auto; border-radius:4px; margin:0 auto 8px;">
                                                    @endforeach
                                                </div>
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('manage-clientele.edit', $client->id) }}" class="btn btn-primary btn-sm mb-1">Edit</a>
                                
                                            <form action="{{ route('manage-clientele.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Clientele found.</td>
                                    </tr>
                                @endforelse

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