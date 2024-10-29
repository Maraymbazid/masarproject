@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            @include('layouts.session')
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form id="filter-form" method="POST" action="{{ route('exams.update', $exam->id) }}">
                        @method('PUT')
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
                                    <input type="text" class="form-control" value="{{ $exam->subject->name }}" readonly>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('semester') form-group has-danger @enderror">
                                    <label>Semester</label>
                                    <input type="text" class="form-control" value="{{ $exam->semester }}" readonly>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group @error('number_of_exams') form-group has-danger @enderror">
                                    <label>Number of exams</label>
                                    <input type="number" class="form-control" value="{{ $exam->number_of_exams }}"
                                        name="number_of_exams">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" id="submit-button" type="submit"> Update</button>
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
