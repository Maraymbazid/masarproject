@extends('layouts.dashboard')
@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/switchery/switchery.min.css') }}">
    @endpush
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('supervisors.store') }}">

                @csrf
                <div class="form-group row @error('name') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('name') form-control-danger @enderror" type="text"
                            name="name" placeholder="Add Name">
                        @error('name')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('ppr') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">PPR</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('ppr') form-control-danger @enderror" type="text"
                            name="ppr" placeholder="Add ppr">
                        @error('ppr')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('province') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">province</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('province') form-control-danger @enderror" type="text"
                            name="province" placeholder="Add Province" value="Tarfaya" readonly>
                        @error('province')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('etablissement') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label"> etablissement</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('etablissement') form-control-danger @enderror" type="text"
                            name="etablissement" placeholder="Add Province" value="ibn-tomert" readonly>
                        @error('etablissement')
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
