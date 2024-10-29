@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            @include('layouts.session')
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form id="filter-form" method="POST" action="{{ route('exams.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label>Etablissement</label>
                                    <input type="text" class="form-control" value="ibn-tomert" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('subject_id') form-group has-danger @enderror">
                                    <label>Subject</label>
                                    <select class="form-control" name="subject_id" id="subject_id">
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
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
                                <div class="form-group @error('number_of_exams') form-group has-danger @enderror">
                                    <label>Number of exams</label>
                                    <input type="number" class="form-control" value="" name="number_of_exams">
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
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
