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
                                    <a href="{{ route('manage-model-details.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Model Details</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-model-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Model Details</a>
                    </div>

                    <div class="table-responsive custom-scrollbar">
                        <div class="d-flex justify-content-end mb-2">
                            <input type="text" id="productSearch" class="form-control w-auto" placeholder="Search Here.....">
                        </div>
                        
                        <table class="table table-bordered table-striped" id="model-details-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Sub Product Name</th>
                                    <th>Specsheet</th>
                                    <th>2D</th>
                                    <th>3D</th>
                                    <th>Installation Manual</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter = 1;
                                @endphp
                                
                                @if($modelDetails->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                @else
                        
                                   @php
                                        $groupedModelDetails = $modelDetails->groupBy(function($details) {
                                            $subProduct = $details->first()->subProduct ?? null;
                                            return $subProduct ? implode(', ', $subProduct->application_names) : 'N/A';
                                        })->map(function($applicationGroup) {
                                            return $applicationGroup->groupBy(function($details) {
                                                $subProduct = $details->first()->subProduct ?? null;
                                                return $subProduct ? implode(', ', $subProduct->category_names) : 'N/A';
                                            })->map(function($categoryGroup) {
                                                return $categoryGroup->groupBy(function($details) {
                                                    $subProduct = $details->first()->subProduct ?? null;
                                                    return $subProduct->product->product ?? 'N/A';
                                                });
                                            });
                                        });
                                    @endphp
                            
                                    @foreach($groupedModelDetails as $applicationType => $categories)
                                        <tr class="table-primary">
                                            <td colspan="7" style="font-weight:bold;">
                                                Main Category: @foreach(explode(',', $applicationType) as $app)
                                                    <span class="badge bg-info me-1">{{ trim($app) }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                            
                                        @foreach($categories as $category => $products)
                                            <tr class="table-secondary">
                                                <td colspan="7" style="font-weight:600; padding-left:20px;">
                                                    Sub Category: @foreach(explode(',', $category) as $cat)
                                                        <span class="badge bg-warning text-dark me-1">{{ trim($cat) }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                            
                                            @foreach($products as $productName => $items)
                                                <tr class="table-light">
                                                    <td colspan="7" style="padding-left:40px; font-weight:600;">
                                                        Product: {{ $productName }}
                                                    </td>
                                                </tr>
                            
                                                @foreach($items as $subProductId => $details)
                                                    @php
                                                        $subProduct = $details->first()->subProduct ?? null;
                                                        $hasSpecsheet = $details->where('spec_upload', 1)->isNotEmpty();
                                                        $has2D = $details->where('2d_upload', 1)->isNotEmpty();
                                                        $has3D = $details->where('3d_upload', 1)->isNotEmpty();
                                                        $hasManual = $details->where('manual_upload', 1)->isNotEmpty();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td style="padding-left:60px;">{{ $subProduct->sub_product ?? 'N/A' }}</td>
                                                        <td class="text-center">{{ $hasSpecsheet ? '✅' : '❌' }}</td>
                                                        <td class="text-center">{{ $has2D ? '✅' : '❌' }}</td>
                                                        <td class="text-center">{{ $has3D ? '✅' : '❌' }}</td>
                                                        <td class="text-center">{{ $hasManual ? '✅' : '❌' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('manage-model-details.edit', $details->first()->id) }}" class="btn btn-sm btn-primary">Edit</a> &nbsp
                                                                <form action="{{ route('manage-model-details.destroy', $details->first()->id) }}" method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif    
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

<!--- for searchfunctionality ---->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('productSearch');
    const table = document.getElementById('model-details-table');

    if (!searchInput || !table) return;

    searchInput.addEventListener('input', function () {
        const filter = this.value.trim().toLowerCase();
        const rows = Array.from(table.tBodies[0].rows);

        // Reset all rows
        rows.forEach(row => {
            row.style.display = '';
            row.dataset.hasMatch = 'false';
        });

        if (!filter) return;

        rows.forEach((row, i) => {
            const rowText = row.textContent.trim().toLowerCase();
            const rowClass = row.className; // table-primary / table-secondary / table-light

            // If this row matches the filter
            if (rowText.includes(filter)) {
                row.dataset.hasMatch = 'true';

                // Mark all parents above
                let j = i - 1;
                while (j >= 0) {
                    const parentRow = rows[j];
                    const parentClass = parentRow.className;
                    if (parentClass === 'table-primary' || parentClass === 'table-secondary' || parentClass === 'table-light') {
                        parentRow.dataset.hasMatch = 'true';
                        if (parentClass === 'table-primary') break; // stop at main category
                    }
                    j--;
                }

                // Mark all children below
                let k = i + 1;
                while (k < rows.length) {
                    const childRow = rows[k];
                    const childClass = childRow.className;

                    // Stop at next same or higher level
                    if (rowClass === 'table-primary' && childClass === 'table-primary') break;
                    if (rowClass === 'table-secondary' && (childClass === 'table-primary' || childClass === 'table-secondary')) break;
                    if (rowClass === 'table-light' && (childClass === 'table-primary' || childClass === 'table-secondary' || childClass === 'table-light')) break;

                    childRow.dataset.hasMatch = 'true';
                    k++;
                }
            }
        });

        // Hide unmatched rows
        rows.forEach(row => {
            if (row.dataset.hasMatch !== 'true') row.style.display = 'none';
        });
    });
});
</script>




</body> 

</html>