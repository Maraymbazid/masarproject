@extends('layouts.dashboard')
@section('content')
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form>

                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control" type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->email }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->decrypted_password }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->name }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">PPR</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->ppr }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->subject->name }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Province</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->province }}" readonly>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-12 col-md-2 col-form-label">Etablissement</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control " type="text" name="name" placeholder="Add Name"
                            value="{{ $teatcher->etablissement }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label"></label>
                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary" type="submit">Send this Credentials</button>

                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
@endpush
