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
                                            <td colspan="4" style="background:#f8f9fa; padding-left: 20px; font-weight: 600;">
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
        if (!searchInput) {
            console.error('Input with id "productSearch" not found!');
            return;
        }

        searchInput.addEventListener('input', function () {
            const filter = this.value.trim().toLowerCase();
            const table = document.getElementById('productTable');
            if (!table) return;

            const rows = Array.from(table.tBodies[0].rows);
            let i = 0;

            while (i < rows.length) {
                const row = rows[i];
                const firstCell = row.cells[0];

                const isAppTypeHeader = firstCell && firstCell.colSpan == 4 && firstCell.textContent.toLowerCase().startsWith('application type:');


                if (isAppTypeHeader) {
                    const appTypeRow = row;
                    const appTypeText = firstCell.textContent.replace(/^application type:\s*/i, '').toLowerCase();
                    let appTypeHasMatch = false;

                    i++;

                    while (i < rows.length && !(rows[i].cells[0] && rows[i].cells[0].colSpan > 1 && rows[i].cells[0].textContent.toLowerCase().startsWith('application type:'))) {
                        const catRow = rows[i];
                        const catCell = catRow.cells[0];
                    const isCategoryRow = catCell && catCell.colSpan == 4 && catCell.textContent.toLowerCase().startsWith('category:');

                        let categoryHasMatch = false;

                        if (isCategoryRow) {
                            const categoryText = catCell.textContent.replace(/^category:\s*/i, '').toLowerCase();

                            i++;

                            const subProductRows = [];
                            while (i < rows.length
                                && !(rows[i].cells[0] && rows[i].cells[0].colSpan > 1
                                    && (rows[i].cells[0].textContent.toLowerCase().startsWith('category:')
                                        || rows[i].cells[0].textContent.toLowerCase().startsWith('application type:')))
                            ) {
                                subProductRows.push(rows[i]);
                                i++;
                            }

                            if (filter === '') {
                                catRow.style.display = '';
                                subProductRows.forEach(r => r.style.display = '');
                                appTypeHasMatch = true;
                                categoryHasMatch = true;

                            } else if (appTypeText.includes(filter)) {
                                catRow.style.display = '';
                                subProductRows.forEach(r => r.style.display = '');
                                appTypeHasMatch = true;
                                categoryHasMatch = true;

                            } else if (categoryText.includes(filter)) {
                                catRow.style.display = '';
                                subProductRows.forEach(r => r.style.display = '');
                                categoryHasMatch = true;
                                appTypeHasMatch = true;

                            } else {
                                let subProductMatch = false;
                                subProductRows.forEach(r => {
                                    let subProductName = '';
                                    for(let c=0; c < r.cells.length; c++){
                                        subProductName += r.cells[c].textContent.toLowerCase() + ' ';
                                    }
                                    subProductName = subProductName.trim();

                                    if (subProductName.includes(filter)) {
                                        r.style.display = '';
                                        subProductMatch = true;
                                    } else {
                                        r.style.display = 'none';
                                    }
                                });

                                if (subProductMatch) {
                                    catRow.style.display = '';
                                    categoryHasMatch = true;
                                    appTypeHasMatch = true;
                                } else {
                                    catRow.style.display = 'none';
                                }
                            }
                        } else {
                            i++;
                        }
                    }

                    appTypeRow.style.display = appTypeHasMatch ? '' : 'none';

                } else {
                    i++;
                }
            }
        });
    });
</script>



</body> 

</html>