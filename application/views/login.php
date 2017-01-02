<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Record System v1.0</title>
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/alertify.css">
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

</head>
<body id="the_body">

<div class="jumbotron">Administrator ERS v5.2<span class="pull-right" style="margin-right: 20px; font-size: 15px;">

        <a class="btn btn-info col-xs-12" href="<?php echo base_url();?>">Go back to attendance</a>
</div>
<div class="row">
    <div class="col-md-offset-4 col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Login Security
            </div>
            <div class="panel-body">
                <?php $msg =  $this->session->userdata('msg'); if($msg){echo "<div class='alert alert-danger' role='alert'>$msg</div>";}?>
                <?php $attributes = array('id' => 'frmLogin');?>
                <?php echo form_open('client/login',$attributes);?>
                <input type="hidden" value="<?php echo base_url()?>" id="base_url"/>
                <div class="well">
                <label for="txtUName">Username:</label>
                <input type="text" id="uname" name="uname" placeholder="Username" class="form-control" autocomplete="false" required/>
                <label for="txtPass">Password:</label>
                <input type="password" id="pass" name="pass" placeholder="Password" class="form-control" required/>

                </div>
            </div>

            <div class="panel-footer">
                <input type="button" class="btn btn-primary" value="Login" id="btnLogin2"/>
                <?php echo form_close();?>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jqBootstrapValidation.js"></script>
<script src="<?php echo base_url();?>public/js/alertify.js"></script>
<script>
    $.getJSON( "http://api.ipify.org/?format=json", function(response) {


//        $("#c_ip").val(response.ip);
//
//
//        if(response.ip != '119.82.255.34'){
//            $('#the_body').html('')
//        } else {
//
//        }

    });

    $(document).ready(function(){
        alertify.defaults.transition = "zoom";
        alertify.defaults.title = "App Message";
        alertify.defaults.theme.ok = "ui positive button";
        alertify.defaults.theme.cancel = "ui black button";
        alertify.set('notifier','position', 'bottom-right');
    });

    $(document).ready(function(){
        $('#btnLogin2').on('click', function(){
            var uname = $('#uname').val();
            var pass = $('#pass').val();

            if(uname){
                if(pass){
                    $('#frmLogin').submit();
                }
                else{
                    alertify.error("Please fill password!");
                }
            }
            else
            {
                alertify.error("Please fill username!");
            }
        });

    });
</script>

</body>
</html>