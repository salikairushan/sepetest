@extends('_shared.main-layout')
@section('css')

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />

@stop
@section('dynamic-content')

    <div class="container-fluid">

        <ol class="breadcrumb breadcrumb-bg-blue">
            <li><a href="{{ URL('/') }}"><i class="material-icons">home</i> Home</a></li>
            <li><a href="javascript:void(0);"><i class="material-icons">view_carousel</i> Time Tables</a></li>
            <li class="active">{{ $category }} TIME TABLE</li>
        </ol>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Time Table Configurations
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Time Table Requests Closing Date</b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="datepicker form-control" placeholder="choose a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect" onclick="saveTimeTableClosingDate()">Save
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Week Day
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Lectures Start Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="start time">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Lectures End Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="end time">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Interval Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="interval time">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect" onclick="saveWeekDayConfig()">Save
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Week End
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Lectures Start Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="start time">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Lectures End Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="end time">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Interval Time&nbsp;&nbsp;<sup> 24 hours</sup></b>
                                    <br/><br/>
                                    <div class="form-line">
                                        <input type="text" class="timepicker form-control" placeholder="interval time">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect" onclick="saveWeekEndConfig()">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('JS-Plugins')

    <!-- Moment Plugin Js -->
    <script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <script src="{{ asset('assets/js/pages/forms/basic-form-elements.js') }}"></script>

    <!-- Time Table Js -->
    <script src="{{ asset('assets/custom/js/time_table.js') }}"></script>

@stop