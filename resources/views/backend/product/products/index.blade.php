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
                                    <a href="{{ route('manage-product.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Product List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-product.create') }}" class="btn btn-primary px-5 radius-30">+ Add Products</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">

                        <div class="d-flex justify-content-end mb-2">
                            <input type="text" id="productSearch" class="form-control w-auto" placeholder="Search products...">
                        </div>

                       <table id="productTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $applicationType => $appProducts)
                                    {{-- Application Type Heading --}}
                                    <tr style="background:#8f969d; font-weight:bold;">
                                        <td colspan="5">Application Type: {{ $applicationType ?? 'No Application Type' }}</td>
                                    </tr>

                                    {{-- Group by Category inside this Application Type --}}
                                    @php
                                        $categories = $appProducts->groupBy(function($item) {
                                            return $item->category->category ?? '—';
                                        });
                                    @endphp

                                    @foreach($categories as $categoryName => $categoryProducts)
                                        {{-- Category Sub-heading --}}
                                        <tr style="background:#c0cad4; font-weight:600;">
                                            <td colspan="5">Category: {{ $categoryName }}</td>
                                        </tr>

                                        @foreach($categoryProducts as $key => $product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $categoryName }}</td>
                                                <td>{{ $product->product }}</td>
                                                <td>
                                                    @if($product->thumbnail_image)
                                                        <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->product }}"
                                                            style="width:60px; height:60px; object-fit:cover;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('manage-product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('manage-product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No products found.</td>
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

<!--- for searchfunctionality ---->
<script>
    document.getElementById('productSearch').addEventListener('input', function () {
        const filter = this.value.trim().toLowerCase();
        const table = document.getElementById('productTable');
        if (!table) return;

        const rows = Array.from(table.tBodies[0].rows);
        let i = 0;

        while (i < rows.length) {
            const row = rows[i];
            const firstCell = row.cells[0];
            const isAppTypeHeader = firstCell && firstCell.colSpan > 1 && row.textContent.toLowerCase().includes('application type');

            if (isAppTypeHeader) {
                const appTypeRow = row;
                const appTypeText = appTypeRow.textContent.replace(/^Application Type:\s*/i, '').toLowerCase();
                let appTypeHasMatch = false;

                i++;

                // Loop categories inside this application type
                while (i < rows.length && !(rows[i].cells[0] && rows[i].cells[0].colSpan > 1 && rows[i].textContent.toLowerCase().includes('application type'))) {
                    const catRow = rows[i];
                    const isCategoryRow = catRow.cells[0] && catRow.cells[0].colSpan > 1 && catRow.textContent.toLowerCase().includes('category');
                    let categoryHasMatch = false;

                    if (isCategoryRow) {
                        const categoryText = catRow.textContent.replace(/^Category:\s*/i, '').toLowerCase();
                        const productRows = [];
                        let j = i + 1;

                        // Collect product rows for this category
                        while (j < rows.length && !(rows[j].cells[0] && rows[j].cells[0].colSpan > 1)) {
                            productRows.push(rows[j]);
                            j++;
                        }

                        if (filter === '') {
                            catRow.style.display = '';
                            productRows.forEach(r => r.style.display = '');
                            appTypeHasMatch = true;
                            categoryHasMatch = true;
                        } else if (appTypeText.includes(filter)) {
                            // Match on application type → show everything
                            catRow.style.display = '';
                            productRows.forEach(r => r.style.display = '');
                            appTypeHasMatch = true;
                            categoryHasMatch = true;
                        } else if (categoryText.includes(filter)) {
                            // Match on category → show category and all its products
                            catRow.style.display = '';
                            productRows.forEach(r => r.style.display = '');
                            categoryHasMatch = true;
                            appTypeHasMatch = true;
                        } else {
                            // Check products individually
                            let productMatch = false;
                            productRows.forEach(r => {
                                const cat = (r.cells[1]?.textContent || '').toLowerCase();
                                const prod = (r.cells[2]?.textContent || '').toLowerCase();
                                if ((cat + ' ' + prod).includes(filter)) {
                                    r.style.display = '';
                                    productMatch = true;
                                } else {
                                    r.style.display = 'none';
                                }
                            });
                            if (productMatch) {
                                catRow.style.display = '';
                                categoryHasMatch = true;
                                appTypeHasMatch = true;
                            } else {
                                catRow.style.display = 'none';
                            }
                        }

                        i = j; // Move to next category/application type
                    } else {
                        i++; // Skip unexpected row
                    }
                }

                // Show/hide application type row
                appTypeRow.style.display = appTypeHasMatch ? '' : 'none';
            } else {
                i++;
            }
        }
    });
</script>



</body> 

</html>