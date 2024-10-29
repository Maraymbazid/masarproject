@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            @include('layouts.session')
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form id="filter-form" method="POST" action="{{ route('notes.export') }}">
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
                                    <button class="btn btn-primary" id="submit-button" type="submit">Export</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="pd-20">


                    {{-- <form action="{{ route('notes.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required />
                        <button type="submit">Import Notes</button>
                    </form> --}}

                    <form method="POST" action="{{ route('notes.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Import de données</label>

                                    <!-- Hidden file input -->
                                    <input type="file" name="file" id="fileInput" required style="display: none;" />

                                    <!-- Custom styled file input -->
                                    <div id="customFileInput"
                                        style="width: 100%; height: 200px; padding: 10px; font-size: 16px; border: 2px solid #ccc; border-radius: 5px; text-align: center; display: flex; justify-content: center; align-items: center; background-color: #f9f9f9;">
                                        Click to select file
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <button id="triggerFileInput" class="btn btn-primary" type="button">Add</button>
                                    <button class="btn btn-primary" id="submit-button" type="submit">Import Notes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>

    <script>
        document.getElementById('triggerFileInput').addEventListener('click', function() {
            // Trigger the hidden file input
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            // Update the custom file input area with the selected file name
            var fileName = this.files[0] ? this.files[0].name : 'Click to select file';
            document.getElementById('customFileInput').innerText = fileName;
        });

        document.getElementById('customFileInput').addEventListener('click', function() {
            // Trigger the hidden file input when clicking the custom div
            document.getElementById('fileInput').click();
        });
    </script>
@endpush
