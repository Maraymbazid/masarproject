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
                                <div class="form-group @error('semester') form-group has-danger @enderror">
                                    <label>Semester</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="Semester 1"> Semester 1</option>
                                        <option value="Semester 2"> Semester 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('exam') form-group has-danger @enderror">
                                    <label>exam</label>

                                    <select class="form-control" name="exam" id="exam">
                                        @foreach ($exams as $exam)
                                            <option value="{{ $exam }}">{{ $exam }}</option>
                                        @endforeach
                                    </select>
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
                                    <label>Class</label>

                                    <select class="form-control" name="class_name" id="class_name">
                                        @foreach ($classes as $class)
                                            <option value="{{ $class }}">{{ $class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" id="submit-button" type="submit">Add</button>
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
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Students will be populated here -->
                            </tbody>
                            <tfoot>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="save-notes" type="submit">Save Chnages</button>
                                    </div>
                                </div>
                            </tfoot>
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
            let notesData = {}; // To store updated notes
            let originalNotes = {}; // To store original notes

            $('#filter-form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                console.log('hello');

                var className = $('#class_name').val();
                var semester = $('#semester').val();
                var exam = $('#exam').val();
                console.log(className);
                // AJAX request to fetch students based on selected class
                $.ajax({
                    type: 'POST',
                    url: '{{ route('students.getByClass') }}', // Correct route for fetching students
                    data: {
                        class_name: className,
                        exam: exam,
                        semester: semester,
                        _token: '{{ csrf_token() }}' // Include the CSRF token
                    },
                    success: function(response) {
                        console.log(response); // Check the response

                        if (response.success) {
                            if (!$.fn.DataTable.isDataTable('#students-table')) {
                                // Initialize DataTable if it hasn't been initialized yet
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
                                                originalNotes[row.id] = row
                                                    .note || 0;
                                                return `<input type="number" class="form-control note-input" value="${row.note || 0}" data-student-id="${row.id}">`;
                                            }
                                        }
                                    ]
                                });
                            } else {
                                table.clear(); // Clear any existing rows
                            }

                            // Add new data to the DataTable
                            table.rows.add(response.data).draw(); // Add new rows

                            // Show the hidden student table
                            $('#student-table-container').show();
                        } else {
                            alert(response.message); // Show error message
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Log the error for debugging
                        alert(
                            'An error occurred. Please try again.'
                        ); // Show a generic error message
                    }
                });
            });

            $(document).on('input', '.note-input', function() {
                let studentId = $(this).data('student-id');
                let noteValue = $(this).val();
                notesData[studentId] = noteValue; // Update or add the note
            });

            // Save notes when the button is clicked
            $('#save-notes').on('click', function() {
                let notesArray = []; // Prepare an array to hold notes
                var semester;
                var exam;

                // Access the DataTable instance
                let table = $('#students-table').DataTable();

                // Loop through all data in DataTable
                table.rows().every(function() {
                    let studentData = this.data(); // Get the data for the current row
                    let studentId = studentData.id; // Ensure you have student ID in the data

                    // If the note exists in notesData, push to notesArray
                    if (notesData[studentId] !== undefined) {
                        notesArray.push({
                            student_id: studentId,
                            note: notesData[studentId] // Get the corresponding note
                        });
                    } else {
                        // If note wasn't updated, push the original note
                        notesArray.push({
                            student_id: studentId,
                            note: originalNotes[studentId] // Use the original note value
                        });
                    }
                });

                // Log the formatted notesArray for debugging
                console.log('Notes to be sent:', notesArray);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('notes.store') }}',
                    data: {
                        class_name: $('#class_name').val(),
                        semester: $('#semester').val(),
                        exam: $('#exam').val(),
                        notes: notesArray,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Notes saved successfully!');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred while saving notes.');
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
