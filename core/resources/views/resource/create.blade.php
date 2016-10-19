@extends('_shared.main-layout')
@section('dynamic-content')

<link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet">

<div class="container-fluid">
        <!-- Input -->
    <form id="form_validation" method="POST" novalidate="novalidate">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CREATE NEW RESOURCE
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="room-no" maxlength="4" minlength="4" required="" aria-required="true">
                                <label class="form-label">Room No</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="number" class="form-control" name="student-cap" required="" aria-required="true">
                                <label class="form-label">Student Capacity</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="gender" id="hall" class="with-gap">
                            <label for="hall">Lecture Hall</label>

                            <input type="radio" name="gender" id="lab" class="with-gap">
                            <label for="lab" class="m-l-20">Lab</label>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="switch">
                                        <label>Active
                                            <input type="checkbox" checked="" name="active">
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary waves-effect" type="submit">CREATE</button>
                        <button class="btn bg-red btn-primary waves-effect" type="submit">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <!-- #END# Input -->
    </div>
@stop

@section('JS-Plugins')

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('assets/js/admin.js') }}"></script>

    <script src="{{ asset('assets/plugins/knockoutjs/knockout-3.4.0.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.js') }}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>


    <script src="{{ asset('assets/js/pages/forms/form-validation.js') }}"></script>

@stop