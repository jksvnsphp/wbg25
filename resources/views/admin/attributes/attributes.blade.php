@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Attributes
                        <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Attribute</button>
                    </div>

                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 {{ isset($attribute->id) || old('isok') ? 'd-block' : 'd-none' }}"
                            id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Add Attribute
                            </div>
                            <form class="card-body pb-0" method="post" action="{{ route('admin.add.attribute') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                        <label for="name" class="form-label">Attribute Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ isset($attribute->name) ? $attribute->name : old('name') }}" />
                                        <input type="hidden" id="id" name="id"
                                            value="{{ isset($attribute->id) ? $attribute->id : '' }}" />
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="datatype" class="form-label">Data Type</label>
                                        <select class="form-control" id="datatype" name="datatype">
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'text') value="text">Text</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'number') value="number">Number</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'decimal') value="decimal">Decimal</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'textarea') value="textarea">Textarea(Large Text)
                                            </option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'radio') value="radio">Single Choice</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'checkbox') value="checkbox">Multiple Choice</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'select') value="select">Select</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'date') value="date">Date</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'year') value="year">Year</option>
                                            <option @selected((isset($attribute->input_option) ? $attribute->input_option : old('datatype')) == 'datetime') value="datetime">Date & Time</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div id="value-options" class="col-md-6 mt-3" style="display: none;">
                                                <label for="options" class="form-label">Values</label>
                                                <div id="dynamic-values">

                                                </div>
                                                <button type="button" id="add-value"
                                                    class="btn btn-sm btn-success my-2">Add Value</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 px-3 mt-4">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Attribute Name</th>
                                        <th>Data Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($attributes as $key => $pcat)
                                        <tr>
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="">{{ $pcat->name }}</a>
                                            </td>

                                            <td>
                                                <h6 class="text-uppercase"> {{ $pcat->input_option }}</h6>
                                            </td>
                                           
                                            <td class="align-middle">

                                                <a href="{{ route('admin.edit.attribute', $pcat->id) }}" title="Edit"
                                                    class="btn m-1 btn-sm btn-info"> <i class="fas fa-edit    "></i> </a>
                                                <a href="{{ route('admin.delete.attribute', $pcat->id) }}" title="Delete"
                                                    id="delete" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash"
                                                        aria-hidden="true"></i> </a>

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
@endsection
@section('custom-js')
    <script>
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.category.attribute') }}',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success('Status updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status');
                    }
                });
            });
        });
    </script>

    <script>
        // Initialize multiple select on your regular select
        $("#my-select").multipleSelect({
            filter: true
        });
    </script>

    <script>
        const datatype = document.getElementById('datatype');
        const valueOptionsDiv = document.getElementById('value-options');
        const dynamicValuesDiv = document.getElementById('dynamic-values');
        const addValueBtn = document.getElementById('add-value');

        
        const attributeOptions = @json($attribute->attribute_options ?? []); 
        datatype.addEventListener('change', function() {
            if (['checkbox', 'radio', 'select'].includes(this.value)) {
                valueOptionsDiv.style.display = 'block';
            } else {
                valueOptionsDiv.style.display = 'none';
                dynamicValuesDiv.innerHTML = ''; 
            }
        });

       
        function addValueField(value = '') {
            const valueGroup = document.createElement('div');
            valueGroup.classList.add('input-group', 'mb-2');

            const valueInput = document.createElement('input');
            valueInput.type = 'text';
            valueInput.name = 'values[]';
            valueInput.classList.add('form-control');
            valueInput.placeholder = 'Enter option';
            valueInput.value = value; // Pre-fill the input if value is provided

            const deleteBtn = document.createElement('button');
            deleteBtn.type = "button";
            deleteBtn.classList.add('btn-sm', 'btn', 'btn-danger', 'cursor-pointer');
            deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
            deleteBtn.onclick = function() {
                valueGroup.remove();
            };

            valueGroup.appendChild(valueInput);
            valueGroup.appendChild(deleteBtn);

            dynamicValuesDiv.appendChild(valueGroup);
        }

        // Populate existing values if available
        if (attributeOptions.length > 0) {
            valueOptionsDiv.style.display = 'block'; // Make sure the field is visible if editing
            attributeOptions.forEach(function(option) {
                addValueField(option?.attribute_option); // Add each option to the form
            });
        }

        // Add new blank value field when 'Add Value' button is clicked
        addValueBtn.addEventListener('click', function() {
            addValueField(); // Add a new empty field
        });
    </script>
@endsection
