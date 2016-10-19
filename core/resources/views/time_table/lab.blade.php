@extends('_shared.main-layout')
@section('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@stop
@section('dynamic-content')

    <div class="container-fluid">

        <ol class="breadcrumb breadcrumb-bg-purple">
            <li><a href="{{ URL('/') }}"><i class="material-icons">home</i> Home</a></li>
            <li><a href="javascript:void(0);"><i class="material-icons">view_carousel</i> Time Tables</a></li>
            <li class="active">{{ $category }} TIME TABLE</li>
        </ol>
        {{--<div class="block-header">--}}
            {{--<h2>{{ $category }} TIME TABLE</h2>--}}
        {{--</div>--}}

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Filter {{ ucfirst(strtolower($category)) }}
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <select class="selectpicker show-tick" id="hall">
                                    @for($i=1;$i<=\App\Algorithm\Constants::$LAB_COUNT;$i++)
                                    <option value="{{$i}}">{{$i}} Lab</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary waves-effect" onclick="filterLab()">Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="body">

                        <div id="lab_time_table_progress" class="progress" style="display: none;margin: 10px 20px;">
                        </div>
                        <div id="time_table_view">
                            <h3 style="text-align: center; font-weight: lighter; font-style: italic; font-family: monospace;">
                                Select Filter Criteria
                            </h3>
                            <!-- Load Time Table -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales orci ante, sed ornare eros
                    vestibulum ut. Ut accumsan
                    vitae eros sit amet tristique. Nullam scelerisque nunc enim, non dignissim nibh faucibus
                    ullamcorper.
                    Fusce pulvinar libero vel ligula iaculis ullamcorper. Integer dapibus, mi ac tempor varius, purus
                    nibh mattis erat, vitae porta nunc nisi non tellus. Vivamus mollis ante non massa egestas fringilla.
                    Vestibulum egestas consectetur nunc at ultricies. Morbi quis consectetur nunc.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('JS-Plugins')
        <!-- Select Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    {{--<script src="{{ asset('assets/js/pages/forms/basic-form-elements.js') }}"></script>--}}

    <!-- Time Table Js -->
    <script src="{{ asset('assets/custom/js/time_table.js') }}"></script>
@stop