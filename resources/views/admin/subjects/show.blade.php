@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
                @method('PUT')
                @csrf
                <div class="form-group row @error('name') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('name') form-control-danger @enderror" type="text" name="name"
                            placeholder="Add Name" value="{{ $subject->name }}">
                        @error('name')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"></label>
                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary" type="submit">Update</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
