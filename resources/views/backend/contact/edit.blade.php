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
                  <h4>Add Contact Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-contact.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Contact Details</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Contact Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                <form action="{{ route('manage-contact.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Email and Contact Number Row -->
                                    <div class="row">
                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="email">Email <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="email" type="text" name="email" value="{{ old('email', $contact->email) }}" placeholder="Enter Email" required>
                                            <div class="invalid-feedback">Please enter an Email.</div>
                                        </div>

                                        <!-- Contact Number -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact_number">Contact Number <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="contact_number" type="text" name="contact_number"
                                                value="{{ old('contact_number', $contact->contact_number) }}"
                                                placeholder="Enter Contact Number" required
                                                pattern="^\+?[0-9]{1,4}?[-. ]?(\(?\d{1,3}?\)?[-. ]?)?[\d]{1,4}[-. ]?[\d]{1,4}[-. ]?[\d]{1,9}$"
                                                maxlength="12">
                                            <div class="invalid-feedback">Please enter a valid Contact Number.</div>
                                        </div>
                                    </div>

                                    <br>
                                    <!-- About Us -->
                                    <div class="col-md-12">
                                        <label class="form-label" for="about">About Us <span class="txt-danger">*</span></label>
                                        <textarea class="form-control" id="editor" name="about" required>{{ old('about', $contact->about) }}</textarea>
                                        <div class="invalid-feedback">Please enter an About Us.</div>
                                    </div>


                                    <!-- Location Details -->
                                    <div class="col-md-12 mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-label"><strong>Location Details</strong></label>
                                            <button type="button" id="add-location-row" class="btn btn-success">Add More</button>
                                        </div>
                                        <table class="table table-bordered" id="locationTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th>Name <span class="txt-danger">*</span></th>
                                                    <th>Address <span class="txt-danger">*</span></th>
                                                    <th>Gmap URL <span class="txt-danger">*</span></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="location-table-body">
                                                @foreach($contact->locations as $index => $location)
                                                    <tr>
                                                        <td><input type="text" name="locations[{{ $index }}][name]" class="form-control" value="{{ $location['name'] }}" required></td>
                                                        <td><input type="text" name="locations[{{ $index }}][address]" class="form-control" value="{{ $location['address'] }}" required></td>
                                                        <td><input type="url" name="locations[{{ $index }}][gmap_url]" class="form-control" value="{{ $location['gmap_url'] }}" required></td>
                                                        <td><button type="button" class="btn btn-danger remove-location-row">Remove</button></td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    <br><br>

                                    <!-- Social Media Links -->
                                    <div class="col-md-12 mt-5">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-label"><strong>Social Media Links</strong></label>
                                            <button type="button" id="add-social-media-row" class="btn btn-success">Add Link</button>
                                        </div>
                                        <table class="table table-bordered" id="dynamicTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th>Social Media Platform <span class="txt-danger">*</span></th>
                                                    <th>Link <span class="txt-danger">*</span></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="social-media-table-body">
                                                @foreach($contact->social_media as $index => $social)
                                                    <tr>
                                                        <td>
                                                            <select name="social_media[{{ $index }}][platform]" class="form-control" required>
                                                                <option value="">Select Platform</option>
                                                                <option value="1" {{ $social['platform'] == 1 ? 'selected' : '' }}>Facebook</option>
                                                                <option value="2" {{ $social['platform'] == 2 ? 'selected' : '' }}>Twitter</option>
                                                                <option value="3" {{ $social['platform'] == 3 ? 'selected' : '' }}>Instagram</option>
                                                                <option value="4" {{ $social['platform'] == 4 ? 'selected' : '' }}>LinkedIn</option>
                                                                <option value="5" {{ $social['platform'] == 5 ? 'selected' : '' }}>YouTube</option>
                                                                <option value="6" {{ $social['platform'] == 6 ? 'selected' : '' }}>Pintrest</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="url" name="social_media[{{ $index }}][link]" class="form-control" value="{{ $social['link'] }}" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-social-media-row">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                  <!-- Form Actions -->
                                    <div class="col-md-12 text-end" style="margin-top: 30px !important;">
                                        <a href="{{ route('manage-contact.index') }}" class="btn btn-danger px-4">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
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


<!-- JavaScript to dynamically add/remove rows -->
<script>
    document.getElementById('add-social-media-row').addEventListener('click', function () {
        var tableBody = document.getElementById('social-media-table-body');
        var rowCount = tableBody.rows.length;
        var row = tableBody.insertRow();

        // Platform Dropdown
        var cell1 = row.insertCell(0);
        var platformSelect = document.createElement('select');
        platformSelect.name = `social_media[${rowCount}][platform]`;
        platformSelect.classList.add('form-control');
        platformSelect.required = true;

        // Add options to the dropdown with numerical values
        var platforms = [
            { id: 1, name: 'Facebook' },
            { id: 2, name: 'Twitter' },
            { id: 3, name: 'Instagram' },
            { id: 4, name: 'Linkedin' },
            { id: 5, name: 'Youtube' },
            { id: 6, name: 'Pintrest' }
        ];
        platformSelect.innerHTML = '<option value="">Select Platform</option>';
        platforms.forEach(function (platform) {
            var option = document.createElement('option');
            option.value = platform.id; // Numerical value
            option.textContent = platform.name.charAt(0).toUpperCase() + platform.name.slice(1); // Capitalized name
            platformSelect.appendChild(option);
        });

        cell1.appendChild(platformSelect);

        // URL Input
        var cell2 = row.insertCell(1);
        var urlInput = document.createElement('input');
        urlInput.type = 'url';
        urlInput.name = `social_media[${rowCount}][link]`;
        urlInput.classList.add('form-control');
        urlInput.placeholder = 'Enter Social Media URL';
        urlInput.required = true;
        cell2.appendChild(urlInput);

        // Remove Button
        var cell3 = row.insertCell(2);
        var removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('btn', 'btn-danger', 'remove-social-media-row');
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', function () {
            tableBody.deleteRow(row.rowIndex);
        });
        cell3.appendChild(removeBtn);
    });


    // Event delegation to remove rows
    document.getElementById('social-media-table-body').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-social-media-row')) {
            var row = e.target.closest('tr');
            row.remove();
        }
    });
</script>


<!--- for address ----->
<script>
    let locationIndex = 1;


    // Add Location Row
    document.getElementById('add-location-row').addEventListener('click', function () {
        const tableBody = document.getElementById('location-table-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="locations[${locationIndex}][name]" class="form-control" placeholder="Enter Name" required></td>
            <td><input type="text" name="locations[${locationIndex}][address]" class="form-control" placeholder="Enter Address" required></td>
            <td><input type="url" name="locations[${locationIndex}][gmap_url]" class="form-control" placeholder="Enter Gmap URL" required></td>
            <td><button type="button" class="btn btn-danger remove-location-row">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
        locationIndex++;
    });

    // Remove Location Row
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-location-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>


</body>

</html>