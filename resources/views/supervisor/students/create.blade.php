@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Class</label>
                    <div class="col-sm-12 col-md-10">
                        <select class="form-control" name="class_name" id="class_name">
                            @foreach ($classes as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"> File </label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="file" name="file">
                        @error('file')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"></label>
                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary" type="submit">Upload File </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
