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
                                    <a href="{{ route('manage-sub-product.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Sub Product List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-sub-product.create') }}" class="btn btn-primary px-5 radius-30">+ Add Sub Products</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">

                        <div class="d-flex justify-content-end mb-2">
                            <input type="text" id="productSearch" class="form-control w-auto" placeholder="Search products...">
                        </div>

                        <table id="productTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sub Product Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach($groupedSubProducts as $applicationType => $categories)
                                    <tr>
                                        <td colspan="4" style="background:#e9ecef; font-weight: bold;">
                                            Application Type: {{ $applicationType }}
                                        </td>
                                    </tr>

                                    @foreach($categories as $category => $products)
                                        <tr>
                                            <td colspan="4" style="background:#f8f9fa; font-weight: 600;">
                                                Category: {{ $category }}
                                            </td>
                                        </tr>

                                        @foreach($products as $productName => $items)
                                            <tr>
                                                <td colspan="4" style="background:#f1f3f5; padding-left: 40px; font-weight: 600;">
                                                    Product: {{ $productName }}
                                                </td>
                                            </tr>

                                            @foreach($items as $subProduct)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $subProduct->sub_product }}</td>
                                                    <td>
                                                        @if($subProduct->thumbnail_image)
                                                            <img src="{{ asset($subProduct->thumbnail_image) }}" alt="Thumbnail Image" style="max-height: 60px;">
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('manage-sub-product.edit', $subProduct->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <form action="{{ route('manage-sub-product.destroy', $subProduct->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
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


<!--- for searchfunctionality ---->


<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('productSearch');
    const table = document.getElementById('productTable');

    if (!searchInput || !table) return;

    searchInput.addEventListener('input', function () {
        const filter = this.value.trim().toLowerCase();
        const rows = Array.from(table.tBodies[0].rows);

        // Reset visibility
        rows.forEach(row => {
            row.style.display = '';
            row.dataset.hasMatch = 'false';
        });

        if (!filter) return; // nothing to filter

        // Pass 1: find matches and mark hierarchy
        rows.forEach((row, i) => {
            const rowText = row.textContent.trim().toLowerCase();
            const isAppType   = row.cells[0]?.colSpan == 4 && rowText.startsWith('application type:');
            const isCategory  = row.cells[0]?.colSpan == 4 && rowText.startsWith('category:');
            const isProduct   = row.cells[0]?.colSpan == 4 && rowText.startsWith('product:');

            // Match only if filter is actually present
            if (rowText.includes(filter)) {
                row.dataset.hasMatch = 'true';

                // --- Mark all parents above ---
                let j = i - 1;
                while (j >= 0) {
                    const parentText = rows[j].textContent.trim().toLowerCase();
                    const parentIsAppType  = rows[j].cells[0]?.colSpan == 4 && parentText.startsWith('application type:');
                    const parentIsCategory = rows[j].cells[0]?.colSpan == 4 && parentText.startsWith('category:');
                    const parentIsProduct  = rows[j].cells[0]?.colSpan == 4 && parentText.startsWith('product:');

                    if (parentIsAppType || parentIsCategory || parentIsProduct) {
                        rows[j].dataset.hasMatch = 'true';
                        if (parentIsAppType) break; // stop at top level
                    }
                    j--;
                }

                // --- Mark children below if header matched ---
                if (isAppType || isCategory || isProduct) {
                    let k = i + 1;
                    while (k < rows.length) {
                        const childText = rows[k].textContent.trim().toLowerCase();
                        const childIsAppType  = rows[k].cells[0]?.colSpan == 4 && childText.startsWith('application type:');
                        const childIsCategory = rows[k].cells[0]?.colSpan == 4 && childText.startsWith('category:');
                        const childIsProduct  = rows[k].cells[0]?.colSpan == 4 && childText.startsWith('product:');

                        if (isAppType && childIsAppType) break;
                        if (isCategory && (childIsCategory || childIsAppType)) break;
                        if (isProduct && (childIsProduct || childIsCategory || childIsAppType)) break;

                        rows[k].dataset.hasMatch = 'true';
                        k++;
                    }
                }
            }
        });

        // Pass 2: hide everything not marked
        rows.forEach(row => {
            if (row.dataset.hasMatch !== 'true') {
                row.style.display = 'none';
            }
        });
    });
});
</script>








</body> 

</html>