@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('classes.store') }}">

                @csrf
                <div class="form-group row @error('subject_id') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label"> Class Name</label>
                    <div class="col-sm-12 col-md-10">
                        <select class="form-control @error('name') form-control-danger @enderror" name="name">

                            <option value="1-APIC"> 1-APIC</option>
                            <option value="2-APIC"> 2-APIC</option>
                            <option value="3-APIC"> 3-APIC</option>
                        </select>
                        @error('name')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="form-group row @error('number') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">number</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('number') form-control-danger @enderror" type="number"
                            name="number" placeholder="Add number">
                        @error('number')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('supervisor_id') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label"> Supervisor</label>
                    <div class="col-sm-12 col-md-10">
                        <select class="form-control" name="supervisor_id">
                            @foreach ($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                            @endforeach
                        </select>
                        @error('supervisor')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"></label>
                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary" type="submit">Add</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
