<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Record System v1.0</title>

    <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .jumbotron {
            background-color: #265a88;
            height: 50px;
            padding: 0px;
            color: #ffffff;
            font-family: Helvetica;
            font-size: 20px;
            text-align: center;
            padding-top: 10px;
        }
    </style>
    <script>
        $('#btnLogin').attr('disabled', 'disabled');
        $('#btnLogout').attr('disabled', 'disabled');

    </script>

</head>
<body id="the_body">
    <input type="hidden" value="<?php echo base_url();?>" id="base_url"/>

    <div class="jumbotron">Attendance Monitoring System v5.20 <span class="pull-right" style="margin-right: 20px; font-size: 15px;"><a class="btn btn-info" href="<?php echo base_url()?>admin">Login to Portal</a></span>

    </div>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-xs-3">
            <?php foreach($results as $row){?>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <b style="font-size: 20px;"><?php echo $row->title?></b><br/>
                        <i style="font-size: 12px;">Date:</i><span style="font-size: 12px;"> <?php echo $row->date?></span><br/>
                    </div>
                    <div class="panel-body">
                        <?php echo $row->dsc?>
                    </div>
                    <div class="panel-footer panel-warning">
                        by: <?php echo $row->dept ?>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-calendar"></i>Log your attendance here.
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-warning alert-dismissible" role="alert" id="alert2">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div id="msg"><strong>Warning!</strong> Be sure to press the right button. </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="c_date">Server date and time:</label>
                                <input type="text" id="c_date" class="form-control" disabled/>
                            </div>
                            <div class="form-group">
                                <label for="c_ip">IP Address:</label>
                                <input type="text" id="c_ip" class="form-control" disabled />
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <form role="form" id="login">
                                <div class="controls">
                                    <label for="txtEmpId">Username:</label>
                                    <input type="text" class="form-control" placeholder="Username" id="txtEmpId" autocomplete="off" required disabled/>
                                    <p class="help-block"></p>
                                </div>
                                <div class="controls">
                                    <label for="txtEmpPass">Password:</label>
                                    <input type="password" class="form-control" placeholder="Password" id="txtEmpPass" required disabled/>
                                    <p class="help-block"></p>
                                </div>

                        </div>

                    </div>
                    <div class="panel-footer">

                        <button class="btn btn-primary" type="button" id="btnLogin" disabled="true">Time In</button>
                        <button class="btn btn-danger pull-right" type="button" id="btnLogout" disabled="true">Time Out</button>
                    </div>
                    </form>
                </div>



            </div>
            <div class="col-xs-3">
                <div id="last_login"></div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modalChangePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
<!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                    <h4 class="modal-title" id="myModalLabel">Change Default Password</h4>
                </div>
                <div class="modal-body">
                    <div id="change_pass"></div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="btnChangePass">Change Password</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="col-lg-offset-3 col-xs-6 col-lg-offset-3">
                    <div class="col-xs-12">
                    <center>
                        <p>Attendance Monitoring System v5.2 - Copyright 2015</p>
                    </center>
                    </div>

            </div>
        </div>
    </footer>




    <script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/js/jqBootstrapValidation.js"></script>

    <script>


            var myalert;


            $.getJSON( "http://api.ipify.org/?format=json", function(response) {


                $('#btnLogin').attr('disabled', 'disabled');
                $('#btnLogout').attr('disabled', 'disabled');
                var base_url = $("#base_url").val() + "client/check_ip";



                $("#c_ip").val(response.ip);




                $.post(base_url, {ipaddress: response.ip}, function($message){

                    if($message == 0){

                        $('#txtEmpId').attr('disabled', 'disabled')
                        $('#txtEmpPass').attr('disabled', 'disabled')
                        $('.btn').attr('disabled', 'disabled')
                        document.getElementById("alert2").className = "alert alert-danger";
                        $('#msg').html("<strong>Warning!</strong> IP Address not recognised. All functions are disabled.");
                    }
                    $.post( $("#base_url").val() + "client/get_logo", {ipaddress: response.ip}, function($message) {

//                      $('#companylogo').attr("src",$("#base_url").val()+"public/thumb/"+$message);

                    });
                })
            });


        $( document ).ready(function() {


            function close_alert(){
                myalert = setInterval(function(){
                    document.getElementById("alert2").className = "alert alert-warning alert-dismissible";
                    $('#msg').html("<strong>Warning!</strong> Be sure to press the right button.");
                }, 5000);

                $('#txtEmpId').val('');
                $('#txtEmpPass').val('');
            }

            $("#btnLogin").on('click', function(){
                clearInterval(myalert);
                $("#alert2").show();
               var empid = $("#txtEmpId").val();
               var emppass =  $("#txtEmpPass").val();
                var ippool_id = $("#c_ip").val();

                var base_url = $("#base_url").val() + "client/insert_time_in";



                $.post($('#base_url').val() + 'client/change_pass', {empid: empid}, function(data){
                    if(data == 0) {

                        $.post(base_url, {username: empid, password: emppass, ippool: ippool_id}, function ($message) {

                            if ($message == "Cannot find Employee ID" || $message == "Access Denied") {
                                document.getElementById("alert2").className = "alert alert-danger alert-dismissible";

                                $('#msg').html($message);
                            } else {


                                document.getElementById("alert2").className = "alert alert-success alert-dismissible";

                                $('#msg').html($message);
                                $('#btnLogin').attr('disabled', 'disabled');

                                setInterval(function(){
                                    $('#btnLogin').removeAttr('disabled');
                                },5000)
                            }
                        });
                    }
                    else
                    {

                        $('#modalChangePass').modal('show');

                            $.post($('#base_url').val() + 'client/pass_forms', {empid: empid}, function(data) {
                                $('#change_pass').html(data);


                            })

                    }


                close_alert();
                refresh_last_login();
                })
            });

            $("#btnLogout").on('click', function(){
                clearInterval(myalert);
                $("#alert").show();
                var empid = $("#txtEmpId").val();
                var emppass =  $("#txtEmpPass").val();
                var ippool_id = $("#c_ip").val();

                var base_url = $("#base_url").val() + "client/insert_time_out";


                $.post( base_url, { username: empid, password: emppass, ippool: ippool_id }, function($message){
                    if($message == "Cannot find Employee ID" || $message == "Access Denied"){
                        document.getElementById("alert2").className = "alert alert-danger alert-dismissible";

                        $('#msg').html($message);
                    } else {
                        document.getElementById("alert2").className = "alert alert-info alert-dismissible";

                        $('#msg').html($message);
                    }

                });

                close_alert();
                $('#btnLogin').removeAttr('disabled');

            });


//            Get Date and Time of Server
            $.post($("#base_url").val() + "client/get_datetime", function ($data){

                $("#c_date").val($data);

            });
            setInterval(function(){
                $.post($("#base_url").val() + "client/get_datetime", function ($data){
                    $("#c_date").val($data);
                });

            }, 1000);




        });

        $(document).ready(function(){
            clearInterval(myalert);
            $('#txtEmpId').keyup(function(){
                $.post($("#base_url").val() + "client/get_login_user", {username: $(this).val()}, function ($data){
console.log($data);
                    if($data > 0){
                        $('#btnLogin').attr('disabled', 'disabled');
//                        $('#btnLogin').removeAttr('disabled');
                        $('#btnLogout').removeAttr('disabled');
                        document.getElementById("alert2").className = "alert alert-danger alert-dismissible";
                        $('#msg').html("<strong>User already login.</strong> Login button has been disabled.");

                    }else {
                        document.getElementById("alert2").className = "alert alert-warning alert-dismissible";
                        $('#msg').html("<strong>Warning!</strong> Be sure to press the right button.");
                        $('#btnLogin').removeAttr('disabled');
                        $('#btnLogout').attr('disabled', 'disabled');
                    }
                });
            });

        });



        $(document).ready(function() {
            $('#txtEmpId').removeAttr('disabled');
            $('#txtEmpPass').removeAttr('disabled');
//            $('#btnLogin').removeAttr('disabled');
//            $('#btnLogout').removeAttr('disabled');
            $('form:first *:input[type!=hidden]:first').focus();
        });

            $(document).ready(function(){

            });

    </script>
</body>
</html>