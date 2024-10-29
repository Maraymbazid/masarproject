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
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form id="filter-form" method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('ppr') form-group has-danger @enderror">
                                    <label>Class</label>
                                    <select class="form-control" name="class_name" id="class_name">
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

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('ppr') form-group has-danger @enderror">
                                    <label>Subject</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::guard('teacher')->user()->subject->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('ppr') form-group has-danger @enderror">
                                    <label>Etablisement</label>

                                    <input type="text" class="form-control" value="Ibn-tomert" readonly>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" id="submit-button" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="pb-20">
                    <div id="student-table-container" class="pd-20 card-box mb-30" style="display: none;">
                        <table id="students-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Sexe</th>
                                    <th>class_name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Students will be populated here -->
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var table;
            $('#filter-form').on('submit', function(event) {
                event.preventDefault();
                var className = $('#class_name').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('students.getStudentsbyteachers') }}',
                    data: {
                        class_name: className,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);

                        if (response.success) {
                            if (!$.fn.DataTable.isDataTable('#students-table')) {
                                table = $('#students-table').DataTable({
                                    columns: [{
                                            data: 'first_name'
                                        },
                                        {
                                            data: 'last_name'
                                        },
                                        {
                                            data: 'sexe'
                                        },
                                        {
                                            data: null, // Editable note column
                                            render: function(data, type, row) {
                                                // Store original notes on page load

                                                return `<input type="text" class="form-control" readonly value="${row.class_name}">`;
                                            }
                                        }

                                    ]
                                });
                            } else {
                                table.clear();
                            }

                            table.rows.add(response.data).draw();
                            $('#student-table-container').show();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert(
                            'An error occurred. Please try again.'
                        );
                    }
                });
            });

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
