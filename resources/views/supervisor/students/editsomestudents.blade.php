@extends('layouts.dashboard')
@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    @endpush
    <div class="pd-ltr-20">

        <form method="POST" action="{{ route('updateSelectedStudents') }}">
            @csrf

            @foreach ($students as $student)
                <div class="pd-20 card-box mb-30">
                    <div
                        class="form-group row @error('students.{{ $student->id }}.first_name') form-group has-danger @enderror">
                        <label class="col-sm-12 col-md-2 col-form-label">First Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control @error('students.{{ $student->id }}.first_name') form-control-danger @enderror"
                                type="text" name="students[{{ $student->id }}][first_name]" placeholder="Add first name"
                                value="{{ old('students.' . $student->id . '.first_name', $student->first_name) }}">
                            @error('students.{{ $student->id }}.first_name')
                                <div class="form-control-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div
                        class="form-group row @error('students.{{ $student->id }}.last_name') form-group has-danger @enderror">
                        <label class="col-sm-12 col-md-2 col-form-label">Last Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control @error('students.{{ $student->id }}.last_name') form-control-danger @enderror"
                                type="text" name="students[{{ $student->id }}][last_name]" placeholder="Add last name"
                                value="{{ old('students.' . $student->id . '.last_name', $student->last_name) }}">
                            @error('students.{{ $student->id }}.last_name')
                                <div class="form-control-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">

                    <div
                        class="form-group row @error('students.{{ $student->id }}.birth_date') form-group has-danger @enderror">
                        <label class="col-sm-12 col-md-2 col-form-label">Birth Date</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control @error('students.{{ $student->id }}.birth_date') form-control-danger @enderror"
                                type="date" name="students[{{ $student->id }}][birth_date]"
                                placeholder="Add birth date"
                                value="{{ old('students.' . $student->id . '.birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : null) }}">
                            @error('students.{{ $student->id }}.birth_date')
                                <div class="form-control-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div
                        class="form-group row @error('students.{{ $student->id }}.region') form-group has-danger @enderror">
                        <label class="col-sm-12 col-md-2 col-form-label">Region</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control @error('students.{{ $student->id }}.region') form-control-danger @enderror"
                                type="text" name="students[{{ $student->id }}][region]" placeholder="Add region"
                                value="{{ old('students.' . $student->id . '.region', $student->region) }}">
                            @error('students.{{ $student->id }}.region')
                                <div class="form-control-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div
                        class="form-group row @error('students.{{ $student->id }}.sexe') form-group has-danger @enderror">
                        <label class="col-sm-12 col-md-2 col-form-label">Sexe</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="form-control" name="students[{{ $student->id }}][sexe]">
                                <option value="f" @selected('f' == $student->sexe)>Female</option>
                                <option value="m" @selected('m' == $student->sexe)>Male</option>
                            </select>
                            @error('students.{{ $student->id }}.sexe')
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
                </div>
            @endforeach
        </form>

    </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
