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
                                     <th>Priority</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach($groupedSubProducts as $applicationType => $categories)
                                    <tr>
                                        <td colspan="5" style="background:#e9ecef; font-weight: bold;">
                                            Main Category: {{ $applicationType }}
                                        </td>
                                    </tr>

                                    @foreach($categories as $category => $products)
                                        <tr>
                                            <td colspan="5" style="background:#f8f9fa; font-weight: 600;">
                                                Sub Category: {{ $category }}
                                            </td>
                                        </tr>

                                        @foreach($products as $productName => $items)
                                            <tr>
                                                <td colspan="5" style="background:#f1f3f5; padding-left: 40px; font-weight: 600;">
                                                    Product: {{ $productName }}
                                                </td>
                                            </tr>

                                            @foreach($items as $subProduct)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $subProduct->sub_product }}</td>
                                                    <td>
                                                        @if($subProduct->thumbnail_image)
                                                            <img src="{{ asset($subProduct->thumbnail_image) }}" alt="Thumbnail Image" style="max-height: 100px;">
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    {{-- Priority Column --}}
                                                    <td style="width: 140px;">
                                                        <form action="{{ route('manage-sub-product.update-priority', $subProduct->id) }}" method="POST">
                                                            @csrf
                                                            <input type="number" 
                                                                   name="priority"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $subProduct->priority ?? '' }}"
                                                                   min="0"
                                                                   onchange="this.form.submit()">
                                                        </form>
                                                    </td>
                            
                                                    <td>
                                                        <a href="{{ route('manage-sub-product.edit', $subProduct->id) }}" class="btn btn-sm btn-primary">Edit</a><br><br>
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

        // Reset all rows
        rows.forEach(row => {
            row.style.display = '';
            row.dataset.hasMatch = 'false';
        });

        if (!filter) return;

        let currentApplication = null;
        let currentCategory = null;
        let currentProduct = null;
        let productStartIndex = null;

        rows.forEach((row, i) => {
            const text = row.textContent.toLowerCase();
            const colSpan = row.cells[0]?.colSpan;

            // Identify headers
            if (colSpan == 4 && text.startsWith("main category:")) {
                currentApplication = row;
            } else if (colSpan == 4 && text.startsWith("sub category:")) {
                currentCategory = row;
            } else if (colSpan == 4 && text.startsWith("product:")) {
                currentProduct = row;
                productStartIndex = i;
            }

            // Check if row matches filter
            if (text.includes(filter)) {
                // Always mark headers above
                if (currentApplication) currentApplication.dataset.hasMatch = 'true';
                if (currentCategory) currentCategory.dataset.hasMatch = 'true';
                if (currentProduct) currentProduct.dataset.hasMatch = 'true';

                // If a product row matches, mark all sub-product rows under it
                if (colSpan == 4 && text.startsWith("product:")) {
                    let j = productStartIndex + 1;
                    while (j < rows.length) {
                        const nextRow = rows[j];
                        const nextColSpan = nextRow.cells[0]?.colSpan;
                        if (nextColSpan == 4) break; // next header
                        nextRow.dataset.hasMatch = 'true';
                        j++;
                    }
                }

                // If a sub-product row matches, mark its product + headers
                if (colSpan == 1) {
                    if (currentProduct) currentProduct.dataset.hasMatch = 'true';
                    if (currentCategory) currentCategory.dataset.hasMatch = 'true';
                    if (currentApplication) currentApplication.dataset.hasMatch = 'true';
                }

                // Mark this row itself
                row.dataset.hasMatch = 'true';
            }
        });

        // Finally hide rows not matched
        rows.forEach(row => {
            row.style.display = (row.dataset.hasMatch === 'true') ? '' : 'none';
        });
    });
});
</script>









</body> 

</html>