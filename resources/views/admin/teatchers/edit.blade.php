@extends('layouts.dashboard')
@section('content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    @endpush
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form method="POST" action="{{ route('teatchers.update', $teatcher->id) }}">
                @method('PUT')
                @csrf
                <div class="form-group row @error('name') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('name') form-control-danger @enderror" type="text"
                            name="name" placeholder="Add Name" value="{{ old('name', $teatcher->name) }}">
                        @error('name')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('ppr') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label">PPR</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control @error('ppr') form-control-danger @enderror" type="text"
                            name="ppr" placeholder="Add ppr" value="{{ old('ppr', $teatcher->ppr) }}">
                        @error('ppr')
                            <div class="form-control-feedback">{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('subject_id') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label"> Subject</label>
                    <div class="col-sm-12 col-md-10">
                        <select class="form-control" name="subject_id">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected($subject->id == $teatcher->subject_id)>{{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="form-control-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row @error('etablissement') form-group has-danger @enderror">
                    <label class="col-sm-12 col-md-2 col-form-label"> classe</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control tagify--outside @error('class') form-control-danger @enderror"
                            type="text" name="classe-names" placeholder="Add a class"
                            value='{{ $teatcher->getClasses() }}'>
                        @error('class')
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
                        <button class="btn btn-primary" type="submit">Edit</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var whiteliste = @json(ClassService::getClasse());
        var input = document.querySelector('input[name=classe-names]')

        var tagify = new Tagify(input, {
            whitelist: whiteliste,
            focusable: false,
            dropdown: {
                position: 'input',
                maxItems: Infinity,
                enabled: 0 // always opens dropdown when input gets focus
            }
        })
    </script>
@endpush
