/**
 * Created by alexv on 9/17/2016.
 */

var accountModel;
var xcrfc_token;
var site_root;
var from_model_1 ;
var form_model_2;
var placementFrom = "top";
var placementAlign = "right";
var animateEnter = "animated rotateInUpRight";
var animateExit = "animated rotateOutUpRight";
var commonErrorMessage = "Something went wrong Please Contact Administrators";
/** other **/
function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    var allowDismiss = true;

    $.notify({
            message: text
        },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
}

/*** Normal Models **/
function PageSIzeModel(name,value){
    this.value = value;
    this.name = name;
}
function PageFilters(name ,value){
    this.value = value;
    this.name = name;
}
function UserRoles(name,value){
    this.value = value;
    this.name = name;
}
function Pages(name,value){
    this.name = name;
    this.value = value;
}
function Priority(name,value){
    this.name = name;
    this.value = value;
}
/* Knockout Models */
function User(username,fname,lastname,email,roleNo,active,gender,priority){
    var self = this;
    self.username =  ko.observable(username);
    self.email = ko.observable(email);
    self.role = ko.observable(roleNo);
    self.active = ko.observable(active);
    self.fname = ko.observable(fname);
    self.lastname = ko.observable(lastname);
    self.gender = ko.observable(gender);
    self.UserRole = ko.observable();
    self.UserRoleCalc = ko.computed(function(){
        if (typeof accountModel != 'undefined') {
            self.UserRole(
                ko.utils.arrayFirst(accountModel.AllUserRoles(), function(role) {
                    return role.value === self.role();
                })
            );
        }
    });
    self.genderName = ko.computed(function(){
        if(self.gender() == 1){
            return "Male";
        }else{
            return "Female";
        }
    });
    self.priority = ko.observable();
    self.priorityOri = ko.observable(priority);
    self.priorityCalc = ko.computed(function () {
        if (typeof accountModel != 'undefined') {
            self.priority(
                ko.utils.arrayFirst(accountModel.AllUserPriority(), function(role) {
                    return role.value === self.priorityOri();
                })
            );
        }
    });
    self.isPasswordReset = ko.observable(false);
}

/* pagination */
function Pagination(root){
    var self = this;
    self.total = ko.observable(1);
    self.root = ko.observable(root);
    self.rowsPerPage = ko.observable(new PageSIzeModel("10",10));
    self.currentPage = ko.observable(1); // current page index
    self.allPages = ko.observableArray([new Pages(0,0)]); // displaying page objects
    self.displayableMaxSize = ko.observable(5);
    // pass the ko observerable object in here
    self.setTotal = function(total){
        self.total = total;
    };
    // pass the ko observerable object in here
    self.setRowsPerPage = function(rowsPerPage){
        self.rowsPerPage = rowsPerPage;
    };
    self.setAllPages = ko.computed(function () {
        console.log("setAllPages");
        self.allPages.removeAll();
        var tempArr = new Array();
        var pagesNeeded = Math.ceil(self.root().totalUsers()/self.root().PageSizeSelected().value);
        if(pagesNeeded > self.displayableMaxSize() ){

            if(self.currentPage() >= self.displayableMaxSize()){
               if(self.currentPage()<pagesNeeded){
                    for(var x=(self.currentPage()+2) - self.displayableMaxSize();x<=self.currentPage()+1;x++){
                        self.allPages.push(new Pages(x,x));
                    }
               }else{
                   for(var x=(self.currentPage()+1) - self.displayableMaxSize();x<=self.currentPage();x++){
                       self.allPages.push(new Pages(x,x));
                   }
               }

            }else{
                for(var x=1;x<=self.displayableMaxSize();x++){
                    self.allPages.push(new Pages(x,x));
                }
            }
        }else{
            for(var x=1;x<=pagesNeeded;x++){
                self.allPages.push(new Pages(x,x));
            }
        }
        console.log(self.allPages());
    });
    self.setCurrentPage = function(value){
        self.currentPage(value.value);
        self.root().getUsers();
        console.log("setCurrentPage");
        //return true;
    };
    self.setNextPage = function(){
        self.currentPage(self.currentPage()+1);
        self.root().getUsers();
        console.log("setNextPage");
    };
    self.setPrevPage = function () {
        self.currentPage(self.currentPage()-1);
        self.root().getUsers();
        console.log("setPrevPage");
    };
    self.setLastPage = function(){
        self.currentPage(Math.ceil(self.root().totalUsers()/self.root().PageSizeSelected().value));
        self.root().getUsers();
        console.log("setLastPage");
    };
    self.setFirstPage = function(){
        self.currentPage(1);
        self.root().getUsers();
        console.log("setFirstPage");
    };
    self.dummyClick = function () {
        console.log("dummy click");
    };
    /*
    self.resetCurrentPage = ko.computed(function () {
        if(self.root().PageSizeSelected().value){
            self.setCurrentPage(new Pages(1,1));
        }
    });
*/

}

function NewUserRegistration(){
    var self= this;
    self.email = ko.observable();
    self.fname = ko.observable();
    self.lastname = ko.observable();
    self.password = ko.observable("");
    self.gender = ko.observable(1);
    self.priority = ko.observable();
    self.role = ko.observable();
    self.active = ko.observable(false);
    self.sendUser = function () {

        if(!(form_model_2.element("#newUser_email_address") && form_model_2.element("#newUser_first_name") && form_model_2.element("#newUser_last_name"))){
            return false;
        }else{
            $('#newUserModel').modal('hide');
        }


        accountModel.waitForData(true);

        var data = {_token:xcrfc_token,user:ko.toJSON(self)};
        var json = JSON.stringify(data);
        console.log("user registration");
        var url = site_root + "/api/accounts/insertUser";
        $.ajax({
            type: "POST",
            url: url,
            data: json,
            beforeSend: function (request)
            {
                //request.setRequestHeader("cookie","auth="+$.cookie("auth") );
                //request.setRequestHeader("cookie","auth2="+$.cookie("auth2") );
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);

                var colorName = "bg-green";
                if(data.code == 500){
                    colorName = "bg-red";
                }else if(data.code == 403){
                    colorName = "bg-orange";
                }else{

                }

                showNotification(colorName, data.description, placementFrom, placementAlign, animateEnter, animateExit);
                accountModel.getUsers();
            },
            error: function() {
                var colorName = "bg-red";
                showNotification(colorName,commonErrorMessage , placementFrom, placementAlign, animateEnter, animateExit);
                accountModel.waitForData(false);
                //alert('Error Accords');
            }
        });


        return true;
    };
    self.showModel = function () {
        $("#radio_6").click(function() {
        });
        $("#radio_6").trigger("click");
        $('#newUserModel').modal('show');
        return true;
    };

}

function ViewModel(){
    var self = this;
    /* page size */
    self.PageSizeSelect = ko.observableArray([
        new PageSIzeModel("5",5),
        new PageSIzeModel("10",10),
        new PageSIzeModel("25",25),
        new PageSIzeModel("50",50),
        new PageSIzeModel("100",100)
    ]);
    self.PageSizeSelected = ko.observable(self.PageSizeSelect()[0]);
    /* ---------------------------------------------- */

    /* Page Filter */
    self.CurrentLoggedInUserEmail = ko.observable('');
    self.PageFilter = ko.observableArray([
        new PageFilters("All",1),
        new PageFilters("Active",2),
        new PageFilters("Inactive",3)
    ]);

    self.AllUserRoles = ko.observableArray([
        new UserRoles("User",1),
        new UserRoles("Lvl2 User",2),
        new UserRoles("Operator",3),
        new UserRoles("Admin",4),
        new UserRoles("Super Admin",5)
    ]);
    self.AllUserPriority = ko.observableArray([
        new Priority("None",1),
        new Priority("Lecturer",2),
        new Priority("OP",3)
    ]);
    self.PageFilterSelected = ko.observable(self.PageFilter()[0]);
    /* ---------------------------------------- */

    self.userList = ko.observableArray();
    self.userClick = function (user) {
        //send to the server
        self.waitForData(true);
        var data = {_token:xcrfc_token,user:ko.toJSON(user)};
        console.log(data);
        var json = JSON.stringify(data);
        var url = site_root + "/api/accounts/updateUser";
        $.ajax({
            type: "POST",
            url: url,
            data: json,
            beforeSend: function (request)
            {
                //request.setRequestHeader("cookie","auth="+$.cookie("auth") );
                //request.setRequestHeader("cookie","auth2="+$.cookie("auth2") );
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                var colorName = "bg-green";
                if(data.code == 500){
                    colorName = "bg-red";
                }else if(data.code == 403){
                    colorName = "bg-orange";
                }

                showNotification(colorName, data.description, placementFrom, placementAlign, animateEnter, animateExit);
                accountModel.getUsers();
                self.getUsers();
            },
            error: function() {
                var colorName = "bg-red";
                showNotification(colorName,commonErrorMessage , placementFrom, placementAlign, animateEnter, animateExit);
                self.waitForData(false);
                //alert('Error Accords');
            }
        });
        return true;
    };
    self.firstLoad = ko.observable(true);
    self.waitForData = ko.observable(false);
    self.searchText = ko.observable("");
    self.getUsers = function () {
        self.waitForData(true);
        var data = {_token:xcrfc_token,rowsPerPage:self.PageSizeSelected().value,filter:self.PageFilterSelected().value,page:self.pagination().currentPage(),searchText:self.searchText()};
        console.log(data);
        var json = JSON.stringify(data);
        var url = site_root + "/api/accounts/getUsers";
        $.ajax({
            type: "POST",
            url: url,
            queue : true,
            beforeSend: function (request)
            {
                //request.setRequestHeader("cookie","auth="+$.cookie("auth") );
                //request.setRequestHeader("cookie","auth2="+$.cookie("auth2") );
            },
            data: json,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                self.userList.removeAll();
                if(data.code == 200){
                    var users = data.data.user;
                    self.totalUsers(data.data.totalRecords);
                    $.each(users,function (key,value) {
                        self.userList.push(new User(value.email,value.fname,value.lname,value.email,value.role,value.active,value.gender,value.priority));
                    });
                }
                self.waitForData(false);
                self.firstLoad(false);
            },
            error: function() {
                self.waitForData(false);
                var colorName = "bg-red";
                showNotification(colorName,commonErrorMessage , placementFrom, placementAlign, animateEnter, animateExit);
                //alert('Error Accords');
            }
        });
    };
    self.popUpModel = ko.observable(new User('','','','',1,1,1,1));
    self.setPopUpModel = function(data,event){
        self.popUpModel(data);
        //we use this if condition because materialize radio button wont decorate it
        if(data.gender() == 1){
            $("#radio_3").click(function() {
            });
            $("#radio_3").trigger("click");
        }else{
            $("#radio_4").click(function() {
            });
            $("#radio_4").trigger("click");
        }
        // end of the hack

        console.log(self.popUpModel);
        var color = $(event.target).data('color');
        $('#mdModal .modal-content').removeAttr('class').addClass('modal-content modal-col-' + color);
        $('#mdModal').modal('show');
        return true;
    };
    self.popUpModelCancel = function(){
      self.getUsers();
    };
    self.popUpModelUpdate = function(){

        if(!(from_model_1.element("#Model_first_name") && from_model_1.element("#Model_last_name"))){
            return false;
        }else{
            $('#mdModal').modal('hide');
        }
        self.waitForData(true);
        //send the user model to the server
        var data = {_token:xcrfc_token,user:ko.toJSON(self.popUpModel)};
        console.log(data);
        var json = JSON.stringify(data);
        var url = site_root + "/api/accounts/updateUser";
        $.ajax({
            type: "POST",
            url: url,
            data: json,
            beforeSend: function (request)
            {
                //request.setRequestHeader("cookie","auth="+$.cookie("auth") );
                //request.setRequestHeader("cookie","auth2="+$.cookie("auth2") );
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                var colorName = "bg-green";
                if(data.code == 500){
                    colorName = "bg-red";
                }else if(data.code == 403){
                    colorName = "bg-orange";
                }

                showNotification(colorName, data.description, placementFrom, placementAlign, animateEnter, animateExit);
                accountModel.getUsers();
                self.getUsers();
            },
            error: function() {
                var colorName = "bg-red";
                showNotification(colorName,commonErrorMessage , placementFrom, placementAlign, animateEnter, animateExit);
                self.waitForData(false);
                //alert('Error Accords');
            }
        });
        return true;
    };

    // pagination in ViewModel
    self.totalUsers = ko.observable(0);
    self.pagination = ko.observable(new Pagination(self));
    self.PageSizeSelected.subscribe(function (newValue) {
        self.pagination().setCurrentPage(new Pages(1,1));
    });
    self.PageFilterSelected.subscribe(function (newValue) {
        self.pagination().setCurrentPage(new Pages(1,1));
    });
    self.refresh = function () {
        self.pagination().setCurrentPage(new Pages(1,1));
    };
    self.searchText.subscribe(function () {
        self.refresh();
    });

    // new User registration

    self.newUserRegistrationModel = ko.observable(new NewUserRegistration());

}
/*
accountModel = {
  User : new User()
};
*/
accountModel = new ViewModel();
$(document ).ready(function() {
    ko.applyBindings(accountModel,document.getElementById("accountContainer"));
    xcrfc_token = document.getElementById("crfc_token").value;
    site_root = document.getElementById("site_root").value;
    accountModel.getUsers();
    console.log(accountModel.popUpModel());

    accountModel.CurrentLoggedInUserEmail( $("#hidden_user_email").val() );

    form_model_2 = $('#form_validation_2').validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

    from_model_1 = $('#form_validation_1').validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

});
