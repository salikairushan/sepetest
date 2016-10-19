<?php
/**
 * Created by PhpStorm.
 * User: alexv
 * Date: 9/16/2016
 * Time: 6:30 PM
 */
?>
@extends('_shared.main-layout')
@section('css')
        <!-- JQuery DataTable Css -->
<link href="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet" />
<!-- Bootstrap Select Css -->
<!--link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" /-->
<style>
     .filter {
        width: 100px !important;
    }
    .padding-pagingation-button{
        padding-right:0px !important;
        padding-left:0px !important;
    }
    .preLoader-center{
        position: absolute !important;
        /* height: 100px; */
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
        left: 50% !important;
        z-index: 10 !important;
    }
    .preloader-backgrounds{
        min-width: calc(100% - 30px) !important;
        min-height: 100% !important;
        background-color: rgba(217, 222, 219, 0.4) !important;
        z-index: 11 !important;
        position: absolute !important;


    }
</style>
@stop
@section('dynamic-content')
    @if ( UAuth::isLogged() )
        <input type="hidden" id="hidden_user_email" value="{{ UAuth::getUserEmail() }}" />
    @else
        <input type="hidden" id="hidden_user_email" value="1" />
    @endif

    <div id="accountContainer" class="container-fluid">
        <ol class="breadcrumb breadcrumb-bg-teal">
            <li><a href="{{ URL('/') }}"><i class="material-icons">home</i> Home</a></li>
            <li class="active"><i class="material-icons">account_box</i> User Accounts</li>
        </ol>
        <div class="block-header">
            <h2>
                USER ACCOUNTS
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            USER DATA
                        </h2>
                        <ul class="header-dropdown m-r-0">
                            <li>
                                <a data-bind="click: newUserRegistrationModel().showModel" href="javascript:void(0);">
                                    <i class="material-icons">add_circle_outline</i>

                                </a>
                            </li>
                            <li>
                                <a data-bind="click: refresh" href="javascript:void(0);">
                                    <i class="material-icons">cached</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="dataTables_length" id="DataTables_Table_0_length">
                                        <label>Show
                                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control input-sm" data-bind="options: PageSizeSelect,
                                                            optionsText: 'name',
                                                            value: PageSizeSelected
                                                             "></select>
                                            entries
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="dataTables_length" id="DataTables_Table_0_length">
                                        <label>Filter
                                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control input-sm filter" data-bind="options: PageFilter,
                                                            optionsText: 'name',
                                                            value: PageFilterSelected
                                                             "></select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                        <label>
                                            Search:<input data-bind="value: searchText" type="search" class="form-control input-sm" placeholder="" aria-controls="DataTables_Table_0">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-12 align-center">
                                    <div class="preloader-backgrounds" data-bind="visible : waitForData() && !firstLoad()">
                                        <div class="md-preloader pl-size-md preLoader-center" >
                                            <svg viewBox="0 0 75 75">
                                                <circle cx="37.5" cy="37.5" r="33.5" class="pl-green" stroke-width="5"></circle>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="md-preloader pl-size-md " data-bind="visible : waitForData() && firstLoad()">
                                        <svg viewBox="0 0 75 75">
                                            <circle cx="37.5" cy="37.5" r="33.5" class="pl-green" stroke-width="5"></circle>
                                        </svg>
                                    </div>
                                    <div class="row align-center" data-bind="visible: totalUsers() == 0 && !waitForData()">
                                        <h4>No Users Found !</h4>
                                    </div>
                                    <table data-bind="visible: (totalUsers() > 0)" class="table table-bordered table-striped table-hover js-basic-example dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th rowspan="1" colspan="1">Name</th>
                                            <th rowspan="1" colspan="1">Role</th>

                                            <th rowspan="1" colspan="1">Email</th>
                                            <th rowspan="1" colspan="1">Gender</th>
                                            <th rowspan="1" colspan="1">Edit</th>
                                            <th rowspan="1" colspan="1">Active</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Name</th>
                                            <th rowspan="1" colspan="1">Role</th>

                                            <th rowspan="1" colspan="1">Email</th>
                                            <th rowspan="1" colspan="1">Gender</th>
                                            <th rowspan="1" colspan="1">Edit</th>
                                            <th rowspan="1" colspan="1">Active</th>
                                        </tr>
                                        </tfoot>
                                        <tbody data-bind="foreach: { data: userList, as : 'user'}">


                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><span data-bind="text: user.fname()+ ' ' + user.lastname()"></span></td>
                                            <td><span data-bind="text: UserRole().name"></span></td>


                                            <td><span data-bind="text: email()"></span></td>
                                            <td><span data-bind="text:genderName()"></span></td>
                                            <td><button type="button"  data-bind="click: $parent.setPopUpModel" data-color="" class="btn bg-teal btn-block btn-xs waves-effect">Edit</button></td>
                                            <td>
                                                <!-- ko if: email() != $parent.CurrentLoggedInUserEmail() -->
                                                <div class="switch">
                                                    <label><input data-bind="checked: active,click: $parent.userClick" type="checkbox" ><span class="lever switch-col-teal"></span></label>
                                                </div>
                                                <!-- /ko -->


                                                

                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" data-bind="visible: (totalUsers() > 0) && !waitForData()">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" role="status" aria-live="polite">
                                        Showing <span data-bind="text: ((pagination().currentPage()-1)*PageSizeSelected().value)+1"></span> to <span data-bind="text: pagination().currentPage()*PageSizeSelected().value"></span> of <span data-bind="text: totalUsers()"></span> entries
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate" >
                                        <ul class="pagination">
                                            <!-- ko if: pagination().currentPage() > 1 -->
                                            <li class="paginate_button previous">
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0"  tabindex="0" data-bind="click: pagination().setFirstPage">
                                                    <i class="material-icons">first_page</i>
                                                </a>
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0"  tabindex="0" data-bind="click: pagination().setPrevPage">
                                                    <i class="material-icons">chevron_left</i>
                                                </a>
                                            </li>
                                            <!-- /ko -->
                                            <!-- ko if: pagination().currentPage() == 1 -->
                                            <li class="paginate_button previous disabled">
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().dummyClick"  tabindex="0">
                                                    <i class="material-icons">first_page</i>
                                                </a>
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().dummyClick"  tabindex="0">
                                                    <i class="material-icons">chevron_left</i>
                                                </a>
                                            </li>
                                            <!-- /ko -->
                                            <!-- ko foreach: pagination().allPages -->
                                            <!-- ko if: $parent.pagination().currentPage() == value -->
                                            <li class="paginate_button active">
                                                <a href="#" aria-controls="DataTables_Table_0" data-bind="click: $parent.pagination().setCurrentPage"  tabindex="0"><span data-bind="text: value"></span></a>
                                            </li>
                                            <!-- /ko -->
                                            <!-- ko if: $parent.pagination().currentPage() != value -->
                                            <li class="paginate_button">
                                                <a href="#" aria-controls="DataTables_Table_0" data-bind="click: $parent.pagination().setCurrentPage"  tabindex="0"><span data-bind="text: value"></span></a>
                                            </li>
                                            <!-- /ko -->
                                            <!-- /ko -->
                                            <!-- ko if: pagination().allPages().length >0 && pagination().currentPage() < pagination().allPages()[pagination().allPages().length-1].value -->
                                            <li class="paginate_button next">
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().setNextPage" tabindex="0">
                                                    <i class="material-icons">chevron_right</i>

                                                </a>
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().setLastPage" tabindex="0">
                                                    <i class="material-icons">last_page</i>

                                                </a>
                                            </li>
                                            <!-- /ko -->
                                            <!-- ko if: pagination().allPages().length >0 && pagination().currentPage() == pagination().allPages()[pagination().allPages().length-1].value -->
                                            <li class="paginate_button next disabled">
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().dummyClick" tabindex="0">
                                                    <i class="material-icons">chevron_right</i>
                                                </a>
                                                <a class="padding-pagingation-button" href="#" aria-controls="DataTables_Table_0" data-bind="click: pagination().dummyClick" tabindex="0">
                                                    <i class="material-icons">last_page</i>
                                                </a>
                                            </li>

                                            <!-- /ko -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- model for update the user -->
        <div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel" data-bind="text:popUpModel().fname() + ' ' +popUpModel().lastname()"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_validation_1">
                            <label for="email_address">Email Address</label>
                            <div class="form-group">
                                <div class="form-line disabled">
                                    <input type="text" data-bind="value: popUpModel().email()" id="email_address" class="form-control" disabled>
                                </div>
                            </div>
                            <label for="Model_first_name">First Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" data-bind="value: popUpModel().fname" id="Model_first_name" class="form-control" placeholder="Enter user's first name" required>
                                </div>
                            </div>
                            <label for="Model_last_name">Last Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" data-bind="value: popUpModel().lastname" id="Model_last_name" class="form-control" placeholder="Enter user's last name" required>
                                </div>
                            </div>

                            <label for="Model_user_role">User Role</label>
                            <div class="form-group form-float">
                                <select id="Model_user_role" class="form-control input-sm filter" data-bind="options: AllUserRoles,
                                                            optionsText: 'name',
                                                            value: popUpModel().UserRole
                                                             "></select>
                            </div>

                            <label for="Model_user_role">Priority</label>
                            <div class="form-group">
                                <select id="Model_user_priority" class="form-control input-sm filter" data-bind="options: AllUserPriority,
                                                            optionsText: 'name',
                                                            value: popUpModel().priority
                                                             "></select>
                            </div>
                            <div class="form-group">

                                <input name="group1" value="1" type="radio" id="radio_3" class="with-gap" data-bind="checked: popUpModel().gender" />
                                <label for="radio_3">Male</label>
                                <input name="group1" value="2" type="radio" id="radio_4" class="with-gap" data-bind="checked: popUpModel().gender" />
                                <label for="radio_4">Female</label>
                            </div>
                            <div class="form-group">
                                <!-- ko if: popUpModel().email() != CurrentLoggedInUserEmail() -->
                                <div class="switch">
                                    <span>Active : </span><label><input data-bind="checked: popUpModel().active" type="checkbox" ><span class="lever switch-col-teal"></span></label>
                                </div>
                                <!-- /ko -->




                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="md_checkbox_9" class="chk-col-teal" data-bind="checked: popUpModel().isPasswordReset" />
                                <label for="md_checkbox_9">Reset Password</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-bind="click: popUpModelUpdate">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" data-bind="click: popUpModelCancel">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of the model -->
        <!-- start of the new user model -->
        <div class="modal fade" id="newUserModel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">User Registration</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_validation_2">
                            <label for="newUser_email_address">Email Address</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" data-bind="value: newUserRegistrationModel().email" id="newUser_email_address" class="form-control" required>
                                </div>
                            </div>
                            <label for="newUser_first_name">First Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" data-bind="value: newUserRegistrationModel().fname" id="newUser_first_name" class="form-control" placeholder="Enter user's first name" required>
                                </div>
                            </div>
                            <label for="newUser_last_name">Last Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" data-bind="value: newUserRegistrationModel().lastname" id="newUser_last_name" class="form-control" placeholder="Enter user's last name" required>
                                </div>
                            </div>

                            <label for="Model_password">Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" data-bind="value: newUserRegistrationModel().password" id="newUser_password" class="form-control" placeholder="Leave Password Blank for auto generate it" >
                                </div>
                            </div>
                            <label for="Model_user_role">User Role</label>
                            <div class="form-group">
                                <select id="Model_new_user_role" class="form-control input-sm filter" data-bind="options: AllUserRoles,
                                                            optionsText: 'name',
                                                            value: newUserRegistrationModel().role
                                                             "></select>
                            </div>
                            <label for="Model_user_role">Priority</label>
                            <div class="form-group">
                                <select id="Model_new_user_priority" class="form-control input-sm filter" data-bind="options: AllUserPriority,
                                                            optionsText: 'name',
                                                            value: newUserRegistrationModel().priority
                                                             "></select>
                            </div>
                            <div class="form-group">

                                <input name="group6" value="1" type="radio" id="radio_6" class="with-gap" data-bind="checked: newUserRegistrationModel().gender" />
                                <label for="radio_6">Male</label>
                                <input name="group6" value="2" type="radio" id="radio_7" class="with-gap" data-bind="checked: newUserRegistrationModel().gender" />
                                <label for="radio_7">Female</label>
                            </div>
                            <div class="form-group">
                                <div class="switch">
                                    <span>Active : </span><label><input data-bind="checked: newUserRegistrationModel().active" type="checkbox" ><span class="lever switch-col-teal"></span></label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-bind="click: newUserRegistrationModel().sendUser">Register User</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of the new user model -->
    </div>
@stop

@section('JS-Plugins')
        <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- jquery cookie -->
    <script src="{{ asset('assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
    <!-- Jquery Validation -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
    <!-- knockout js -->
    <script src="{{ asset('assets/plugins/knockoutjs/knockout-3.4.0.js') }}"></script>
    <!--custom js-->
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/knockoutModels/accountsModel.js') }}"></script>
    <!--script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script -->
@stop

