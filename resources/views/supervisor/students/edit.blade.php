@extends('layouts.dashboard')
@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    @endpush
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('students.update', $student->id) }}">
                @method('PUT')
                @csrf
                <div class="form-group row @error('first_name') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">First_name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('first_name') form-control-danger @enderror" type="text"
                            name="first_name" placeholder="Add first_name"
                            value="{{ old('first_name', $student->first_name) }}">
                        @error('first_name')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('last_name') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Last_name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('last_name') form-control-danger @enderror" type="text"
                            name="last_name" placeholder="Add last_name"
                            value="{{ old('last_name', $student->last_name) }}">
                        @error('last_name')
                            <div class="form-control-feedback">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('birth_date') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Birth_date</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('birth_date') form-control-danger @enderror" type="date"
                            name="birth_date" placeholder="Add birth_date"
                            value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : null) }}">

                        @error('birth_date')
                            <div class="form-control-feedback">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('region') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">region</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('region') form-control-danger @enderror" type="text"
                            name="region" placeholder="Add region" value="{{ old('region', $student->region) }}">
                        @error('region')
                            <div class="form-control-feedback">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('sexe') has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Sexe</label>
                    <div class="col-sm-12 col-md-10">
                        <select class="form-control" name="sexe">
                            <option value="f" @selected(old('sexe', $student->sexe) == 'f')>Female</option>
                            <option value="m" @selected(old('sexe', $student->sexe) == 'm')>Male</option>
                        </select>
                        @error('sexe')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"></label>
                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary" type="submit">Edit</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
