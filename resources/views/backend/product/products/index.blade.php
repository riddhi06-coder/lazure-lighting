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
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Other Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($products as $applicationType => $appProducts)
                                    {{-- Application Type Heading --}}
                                    <tr style="background:#eadfdf; font-weight:bold;">
                                        <td colspan="5">Main Category: {{ $applicationType }}</td>
                                    </tr>

                                    {{-- Group by Categories --}}
                                    @php
                                        $categories = $appProducts->groupBy(function($item) {
                                            return implode(', ', $item->categories) ?: '—';
                                        });
                                    @endphp

                                    @foreach($categories as $categoryName => $categoryProducts)
                                        <tr style="background:#c0cad4; font-weight:600;">
                                            <td colspan="5">Sub Category: {{ $categoryName }}</td>
                                        </tr>

                                        @foreach($categoryProducts as $key => $product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $product->product }}</td>
                                                <td>
                                                    @if($product->thumbnail_image)
                                                        <img src="{{ asset($product->thumbnail_image) }}" 
                                                            alt="{{ $product->product }}" 
                                                            style="width:100px; height:100px; object-fit:cover;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @if($product->thumbnail_image1)
                                                        <img src="{{ asset($product->thumbnail_image1) }}" 
                                                            alt="{{ $product->product }}" 
                                                            style="width:100px; height:100px; object-fit:cover;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    <a href="{{ route('manage-product.edit', $product->id) }}" 
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('manage-product.destroy', $product->id) }}" 
                                                        method="POST" 
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Are you sure?')">
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
        const rows = Array.from(document.querySelector("#productTable tbody").rows);
    
        let i = 0;
    
        while (i < rows.length) {
            const row = rows[i];
    
            // Detect Main Category Row
            const isMainCategory = row.cells[0]?.colSpan == 5 &&
                                   row.textContent.toLowerCase().includes('main category');
    
            if (isMainCategory) {
    
                const mainCategoryText = row.textContent.toLowerCase();
                let hasMainMatch = false;
                row.style.display = 'none';
    
                i++;
    
                // Loop until next Main Category
                while (i < rows.length &&
                       !(rows[i].cells[0]?.colSpan == 5 &&
                         rows[i].textContent.toLowerCase().includes('main category'))) {
    
                    const catRow = rows[i];
    
                    // Detect Sub Category Row
                    const isSubCategory = catRow.cells[0]?.colSpan == 5 &&
                                          catRow.textContent.toLowerCase().includes('sub category');
    
                    if (isSubCategory) {
    
                        const subText = catRow.textContent.toLowerCase();
                        let hasSubMatch = false;
    
                        const productRows = [];
                        let j = i + 1;
    
                        // Collect product rows under this category
                        while (j < rows.length && !(rows[j].cells[0]?.colSpan == 5)) {
                            productRows.push(rows[j]);
                            j++;
                        }
    
                        // Cases
                        if (filter === '' ||
                            mainCategoryText.includes(filter) ||
                            subText.includes(filter)) {
    
                            catRow.style.display = '';
                            productRows.forEach(r => r.style.display = '');
                            hasSubMatch = true;
                            hasMainMatch = true;
    
                        } else {
    
                            // individual product match
                            let productMatched = false;
    
                            productRows.forEach(r => {
                                const name = (r.cells[1]?.textContent || '').toLowerCase();
    
                                if (name.includes(filter)) {
                                    r.style.display = '';
                                    productMatched = true;
                                } else {
                                    r.style.display = 'none';
                                }
                            });
    
                            catRow.style.display = productMatched ? '' : 'none';
    
                            if (productMatched) {
                                hasSubMatch = true;
                                hasMainMatch = true;
                            }
                        }
    
                        i = j;
                    } else {
                        i++;
                    }
                }
    
                row.style.display = hasMainMatch ? '' : 'none';
    
            } else {
                i++;
            }
        }
    });
    </script>




</body> 

</html>