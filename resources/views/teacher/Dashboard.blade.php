@extends('layouts.dashboard')
@section('content')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Dashboard</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            January 2018
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Export List</a>
                            <a class="dropdown-item" href="#">Policies</a>
                            <a class="dropdown-item" href="#">View Assets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix progress-box">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial1" value="80" data-width="120" data-height="120"
                            data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff"
                            data-angleOffset="180" readonly>
                        <h5 class="text-blue padding-top-10 h5">Students</h5>
                        <span class="d-block">{{ ClassService::gettotalstudentsforoneteacher(9) }} Students<i
                                class="fa fa-line-chart text-blue"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial1" value="80" data-width="120" data-height="120"
                            data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff"
                            data-angleOffset="180" readonly>
                        <h5 class="text-blue padding-top-10 h5">Classes</h5>
                        <span class="d-block">{{ ClassService::gettotalclassesforoneteacher(9) }} Classes <i
                                class="fa fa-line-chart text-blue"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial1" value="80" data-width="120" data-height="120"
                            data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff"
                            data-angleOffset="180" readonly>
                        <h5 class="text-blue padding-top-10 h5">Level</h5>
                        <span class="d-block">{{ ClassService::getDistinctLevelsByTeacher(11) }} Levels <i
                                class="fa fa-line-chart text-blue"></i></span>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 pt-10 height-100-p">
                    <h2 class="mb-30 h4">World Map</h2>
                    <div id="browservisit" style="width:100%!important; height:380px"></div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('vendors/scripts/core.js') }}"></script>
        <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
        <script src="{{ asset('vendors/scripts/process.js') }}"></script>
        <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
        <script src="{{ asset('src/plugins/jQuery-Knob-master/jquery.knob.min.js') }}"></script>
        <script src="{{ asset('src/plugins/highcharts-6.0.7/code/highcharts.js') }}"></script>
        <script src="{{ asset('src/plugins/highcharts-6.0.7/code/highcharts-more.js') }}"></script>
        <script src="{{ asset('src/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
        <script src="{{ asset('src/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('vendors/scripts/dashboard2.js') }}"></script>
    @endpush
@endsection
