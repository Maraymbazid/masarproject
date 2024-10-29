@extends('layouts.dashboard')
@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <style>
        .student_checkbox {
            width: 15px;
            height: 15px;
            margin: 0;
            vertical-align: middle;
        }

        .btn-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            line-height: 1.5;
        }

        .button-container {
            display: flex;
            gap: 0.5rem;
            /* Small gap between buttons */
            margin-top: -20px;
            margin-left: 13px;
            /* Space above the buttons */
        }

        .custom-btn {
            font-size: 0.875rem;
            /* Adjust font size */
            padding: 0.375rem 0.75rem;
            /* Adjust padding */
            border: 1px solid transparent;
            border-radius: 0.25rem;
            /* Rounded corners */
            color: #fff;
            cursor: pointer;
            text-align: center;
        }

        .custom-btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .custom-btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
@endpush
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            @include('layouts.session')
            <!-- Simple Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form id="filter-form" method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('ppr') form-group has-danger @enderror">
                                    <label>Class</label>
                                    <select class="form-control" name="class_name" id="classSelector">
                                        @foreach ($classes as $class)
                                            <option value="{{ $class }}">{{ $class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('ppr') form-group has-danger @enderror">
                                    <label>Province</label>
                                    <input type="text" class="form-control" value="Tarfaya" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="pd-20">
                    <button id="add-new-elment" class="custom-btn custom-btn-primary" style="display:none;">Add student
                    </button>
                </div>
                <div class="pb-20" id="studentSection" style="display:none;">
                    <table class="table table-bordered" id="students-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th> <!-- Select All Checkbox -->
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Birth Date</th>
                                <th>Region</th>
                                <th>Sexe</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="button-container mt-1">

                        <button id="edit-selected-items" class="custom-btn custom-btn-primary">Edit Selected</button>

                        <button id="delete-selected-items" class="custom-btn custom-btn-danger" type="submit">Delete
                            Selected</button>

                    </div>
                </div>
            </div>
            <!-- Simple Datatable End -->

        </div>

    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var selectedIds = [];
            var table;

            // Hide the table and buttons initially
            $('#studentSection').hide();

            $('#classSelector').change(function() {
                var className = $(this).val();

                if (className) {
                    // Destroy the existing DataTable if it exists
                    if ($.fn.DataTable.isDataTable('#students-table')) {
                        $('#students-table').DataTable().destroy();
                    }

                    // Show the table and buttons
                    $('#studentSection').show();
                    $('#add-new-elment').show();

                    table = $('#students-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('students.index') }}", // Adjust route accordingly
                            data: {
                                class_name: className
                            }
                        },
                        columns: [{
                                data: 'checkbox',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'first_name',
                                name: 'first_name'
                            },
                            {
                                data: 'last_name',
                                name: 'last_name'
                            },
                            {
                                data: 'birth_date',
                                name: 'birth_date'
                            },
                            {
                                data: 'region',
                                name: 'region'
                            },
                            {
                                data: 'sexe',
                                name: 'sexe'
                            },
                            {
                                data: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                                text: 'Export CSV',
                                action: function() {
                                    window.location =
                                        "{{ route('students.export', 'csv') }}";
                                }
                            },
                            {
                                text: 'Export Excel',
                                action: function() {
                                    window.location =
                                        "{{ route('students.export', 'excel') }}";
                                }
                            },
                            {
                                text: 'Export PDF',
                                action: function() {
                                    window.location =
                                        "{{ route('students.export', 'pdf') }}";
                                }
                            },
                            'colvis'
                        ],
                        pagingType: "simple_numbers",
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ]
                    });
                }
            });

            // Handle select-all checkbox
            $('#select-all').on('click', function() {
                var checkboxes = $('input[type="checkbox"].student_checkbox', table.rows({
                    'search': 'applied'
                }).nodes());
                if (this.checked) {
                    checkboxes.prop('checked', true).each(function() {
                        var rowId = $(this).val();
                        if ($.inArray(rowId, selectedIds) === -1) {
                            selectedIds.push(rowId);
                        }
                    });
                } else {
                    checkboxes.prop('checked', false).each(function() {
                        var rowId = $(this).val();
                        selectedIds.splice(selectedIds.indexOf(rowId), 1);
                    });
                }
            });

            // Handle individual checkbox change
            $('#students-table tbody').on('change', 'input[type="checkbox"].student_checkbox', function() {
                var rowId = $(this).val();
                if (this.checked) {
                    selectedIds.push(rowId);
                } else {
                    selectedIds.splice(selectedIds.indexOf(rowId), 1);
                }
            });

            // Delete selected items
            $('#delete-selected-items').click(function() {
                if (selectedIds.length === 0) {
                    Swal.fire('No items selected', 'Please select at least one item to delete.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('students.deleteall') }}', // Update to your route
                            data: {
                                ids: selectedIds,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });

            // Delete individual student
            $('#students-table').on('click', '.delete', function() {
                var studentId = $(this).data('id');
                var url = "{{ route('students.delete', ':id') }}".replace(':id', studentId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this student!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Deleted!', response.message, 'success').then(
                                    () => {
                                        table.ajax.reload();
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Unable to delete this student.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Edit selected items
            $('#edit-selected-items').click(function() {
                if (selectedIds.length > 0) {
                    window.location.href = "{{ route('editstudents') }}" + '?ids=' + selectedIds.join(',');
                } else {
                    Swal.fire('No items selected!', 'Please select at least one item to edit.', 'warning');
                }
            });

            // Add new element
            $('#add-new-elment').click(function() {
                window.location.href = "{{ route('add-one-student') }}";
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#students-table').DataTable();

            $('#students-table').on('click', '.delete', function() {
                var studentId = $(this).data('id');
                var url = "{{ route('students.delete', ':id') }}".replace(':id', studentId);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this student !!!!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // Redirect to the delete route
                    }
                });
            });
        });
    </script>
@endpush
