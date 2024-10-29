@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">



            <div class="form-group row col-sm-12">
                <label class="col-sm-12 col-md-12 col-form-label"></label>
                <div class="col-sm-12 col-md-12">
                    <button class="btn btn-primary" id="downloadButton" type="submit">Download file excel for students
                    </button>

                </div>
            </div>


        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>

    <script>
        document.getElementById('downloadButton').addEventListener('click', function() {
            // Trigger file download
            window.location.href = "{{ route('downloadfile') }}";

            // Redirect after a slight delay to the create view
            setTimeout(function() {
                window.location.href = "{{ route('students.create') }}";
            }, 2000); // Adjust the delay as needed
        });
    </script>
@endpush
