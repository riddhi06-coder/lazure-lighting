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
											<a href="{{ route('manage-projects.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">Projects Details</li>
									</ol>
								</nav>

                    <div class="mb-3 text-end">
                      <!-- Add Projects Button -->
                      <a href="{{ route('manage-projects.create') }}" class="btn btn-primary px-5 radius-30">+ Add Projects</a>

                      <!-- Search Input Below Button -->
                      <div class="mt-5" style="max-width: 900px !important; margin-left: auto; margin-right: 0;">
                          <input type="text" id="projectSearch" class="form-control" placeholder="Search.....">
                      </div>
                  </div>


							</div>


                    <div class="table-responsive custom-scrollbar">
                      

                        <table id="projectsTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Project Location</th>
                                    <th>Image</th>
                                    <th>Built-to-Suit Project</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp

                                @foreach($categories as $category)
                                    @if($category->projects->count())
                                        <tr class="category-row" style="background-color:#f2f2f2;">
                                            <td colspan="6"><strong>{{ $category->category_name }}</strong></td>
                                        </tr>

                                        @foreach($category->projects as $project)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td class="project-name">{{ $project->project_name }}</td>
                                                <td class="project-location">{{ $project->project_location }}</td>
                                                <td>
                                                    @if($project->thumbnail_image)
                                                        <img src="{{ asset($project->thumbnail_image) }}" alt="Project Image" style="height: 100px;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input 
                                                            style="margin-left: 6px !important;"
                                                            class="form-check-input status-toggle" 
                                                            type="checkbox" 
                                                            data-id="{{ $project->id }}" 
                                                            {{ $project->status ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                        
                                                <td>
                                                    <a href="{{ route('manage-projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('manage-projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".status-toggle").forEach(toggle => {
                    toggle.addEventListener("change", function () {
                        let blogId = this.dataset.id;
                        let status = this.checked ? 1 : 0;

                        fetch(`/lazure-lighting/manage-projects/status/${blogId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({ status: status })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert("Something went wrong!");
                                this.checked = !this.checked; // revert toggle if failed
                            }
                        })
                        .catch(() => {
                            alert("Error connecting to server.");
                            this.checked = !this.checked;
                        });
                    });
                });
            });
        </script>


      <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('projectSearch');
            const table = document.getElementById('projectsTable');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                let currentCategoryRow = null;
                let currentCategoryHasVisibleProject = false;

                rows.forEach(row => {
                    if (row.classList.contains('category-row')) {
                        // New category row found
                        currentCategoryRow = row;
                        currentCategoryHasVisibleProject = false;
                        // Hide category row initially
                        row.style.display = 'none';
                    } else {
                        const name = row.querySelector('.project-name').textContent.toLowerCase();
                        const location = row.querySelector('.project-location').textContent.toLowerCase();

                        if (name.includes(searchTerm) || location.includes(searchTerm) || (currentCategoryRow && currentCategoryRow.textContent.toLowerCase().includes(searchTerm))) {
                            row.style.display = '';
                            currentCategoryHasVisibleProject = true;
                        } else {
                            row.style.display = 'none';
                        }
                    }

                    // Show the category row if any of its projects are visible
                    if (currentCategoryRow && currentCategoryHasVisibleProject) {
                        currentCategoryRow.style.display = '';
                    }
                });
            });
        });
      </script>

</body>

</html>