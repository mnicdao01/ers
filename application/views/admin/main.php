<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <META http-equiv="Content-type" content="text/html; charset=iso-8859-1">
    <title>Employee Record System v1.0</title>
    <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>public/css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url();?>public/css/plugins/morris.css" rel="stylesheet">
<!--    <link href="--><?php //echo base_url();?><!--public/css/plugins/prettify.min.css" rel="stylesheet">-->
    <link href="<?php echo base_url();?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/css/datepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/less/datepicker.less" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>public/css/bootstrap-switch.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/alertify.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/themes/semantic.css">

    <style>
        /*#table_employee {*/
            /*font-size: 11px;*/
        /*}*/
        @media (min-width: 992px) {
            .modal-lg {
                width: auto;
            }
        }

        .modal-content {
            margin-left: -175px;
            width: 900px;
        }
        #table-wrapper {
            position:relative;
        }
        #table-scroll {
            height:450px;
            overflow:auto;
            margin-top:20px;
        }
        #table-wrapper table {
            width:1200px;

        }
        #table-wrapper table * {

            color:black;
        }
        #table-wrapper table thead .text {
            position:absolute;
            top:-20px;
            z-index:2;
            height:20px;
            width:35%;
            border:1px solid red;
        }




    </style>
<!--    <script>-->
<!--        $('#brand_name').html('Finance Staff');-->
<!--        $('#btnDashboard').hide();-->
<!--        $('#btnIpaddress').hide();-->
<!--        $('#btnEmployee').hide();-->
<!--        $('#btnUsers').hide();-->
<!--        $('#btnAttendance').hide();-->
<!--        $('#btnScheduling').hide();-->
<!--        $('#btnSchedulingTemplate').hide();-->
<!--        //            $('#financeTools').hide();-->
<!--        $('#bankingTools').hide();-->
<!--        $('#it').hide();-->
<!--    </script>-->

</head>

<body>
<input type="hidden" value="<?php echo base_url()?>" id="base_url"/>
<input type="hidden" value="<?php echo $results[0]->username?>" id="empid"/>
<input type="hidden" value="<?php echo $level?>" id="global_level"/>


<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" id="brand_name">Administrator</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <?php foreach($alerts as $alert){?>
                <li>
                    <a href="#"> <span class="label label-warning"><?php echo $alert->title ?></span><p><?php echo $alert->dsc ?></p><p><span class="label label-default">From: <?php echo $alert->dept ?></span></p></a>
                </li>

                <li class="divider"></li>
<!--                <li>-->
<!--                    <a href="#">View All</a>-->
<!--                </li>-->
                <?php } ?>
            </ul>
        </li>
        <li class="dropdown">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $results[0]->username?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" id="aProfile"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>

                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li>
                    <a href="#" id="aPassword"><i class="fa fa-fw fa-lock"></i> Password</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#" id="btnLogout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="container">
        <div class="row" style="overflow-y: scroll;">
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav side-nav ">
                    <li class="active" id="dashboard">
                        <a href="#" id="btnDashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
<!--                    <li id="ipaddress">-->
<!--                        <a href="#" id="btnIpaddress"><i class="fa fa-fw fa-check"></i> IP Addresses</a>-->
<!--                    </li>-->
                    <li id="employee">
                        <a href="#" id="btnEmployee"><i class="fa fa-fw fa-users"></i> Employee Information</a>
                    </li>
<!--                    <li id="monitor">-->
<!--                        <a href="#" id="btnMonitor"><i class="fa fa-fw fa-users"></i> Monitor</a>-->
<!--                    </li>-->
<!--                    <li id="users">-->
<!--                        <a href="#"  id="btnUsers"><i class="fa fa-fw fa-user"></i> User Accounts</a>-->
<!--                    </li>-->
                    <li id="department">
                        <a href="#"  id="btnDepartment"><i class="fa fa-fw fa-building "></i> Departments</a>
                    </li>

                    <li id="announcements">
                        <a href="#"  id="btnAnnouncements"><i class="fa fa-fw fa-comment "></i> Announcements</a>
                    </li>
                    <li id="profile">
                        <a href="#"  id="btnProfile"><i class="fa fa-fw fa-edit "></i> Profile</a>
                    </li>

                    <li id="it_tools">
                        <a href="javascript:;" data-toggle="collapse" data-target="#itTools"><i class="fa fa-fw fa-bank "></i> IT Tools <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="itTools" class="collapse">
                            <li id="it">
                                <a href="#"  id="btnIT"><i class="fa fa-fw fa-wrench "></i> IT Logging</a>
                            </li>
                            <li id="it_cloudflare">
                                <a href="#"  id="btnITCloudflare"><i class="fa fa-fw fa-wrench "></i> IT Cloudflare Tools</a>
                            </li>
                            <li id="it_godaddy_domains">
                                <a href="#"  id="btnITGDDomains"><i class="fa fa-fw fa-wrench "></i> IT Godaddy Domains</a>
                            </li>
                            <li id="it_server_info">
                                <a href="#"  id="btnITServerInfo"><i class="fa fa-fw fa-wrench "></i> Server Info</a>
                            </li>
                        </ul>
                    </li>

                    <li id="attenanceTools">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bank "></i> Attendance Tools <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo1" class="collapse">
                            <li id="attendance">
                                <a href="#"  id="btnAttendance"><i class="fa fa-fw fa-calendar-o"></i> Attendance Monitoring</a>
                            </li>
                            <li id="member_attendance">
                                <a href="#"  id="btnMemAttendance"><i class="fa fa-fw fa-calendar-o"></i> My Attendance</a>
                            </li>
                            <li id="member_schedule">
                                <a href="#"  id="btnMemSchedule"><i class="fa fa-fw fa-calendar-o"></i> My Schedule</a>
                            </li>
                            <li id="schedule">
                                <a href="#"  id="btnScheduling"><i class="fa fa-fw fa-building "></i> Scheduling</a>
                            </li>
                            <li id="template">
                                <a href="#"  id="btnSchedulingTemplate"><i class="fa fa-fw fa-archive "></i> Scheduling Template</a>
                            </li>
                            <!--<li id="Mandiri">
                                <a href="#" id="btnMandiri"><i class="fa fa-fw fa-briefcase "></i> Mandiri</a>
                            </li>
                            <li id="BNI">
                                <a href="#" id="btnBNI"><i class="fa fa-fw fa-briefcase "></i> BNI</a>
                            </li>
                            <li id="BRI">
                                <a href="#" id="btnBRI"><i class="fa fa-fw fa-briefcase "></i> BRI</a>
                            </li>
                            <li id="Permata">
                                <a href="#" id="btnPermata"><i class="fa fa-fw fa-briefcase "></i> Permata</a>
                            </li>-->
                        </ul>
                    </li>

                    <li id="financeTools">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-bank "></i> Finance Tools <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li id="BCA">
                                <a href="#" id="btnBCA"><i class="fa fa-fw fa-briefcase "></i> Deposit Compare</a>
                            </li>
                            <li id="salary">
                                <a href="#" id="btnSalary"><i class="fa fa-fw fa-briefcase "></i> Salary and Bank Info</a>
                            </li>
                            <li id="salaryReport">
                                <a href="#" id="btnSalaryReport"><i class="fa fa-fw fa-briefcase "></i> Salary Report</a>
                            </li>
<!--                            <li id="BRI">-->
<!--                                <a href="#" id="btnBRI"><i class="fa fa-fw fa-briefcase "></i> BRI</a>-->
<!--                            </li>-->
<!--                            <li id="Permata">-->
<!--                                <a href="#" id="btnPermata"><i class="fa fa-fw fa-briefcase "></i> Permata</a>-->
<!--                            </li>-->
                        </ul>
                    </li>

                    <li id="bankingTools">
                        <a href="javascript:;" data-toggle="collapse" data-target="#report"><i class="fa fa-fw fa-file "></i> Banking Tools <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="report" class="collapse">
                            <li id="addBank">
                                <a href="#" id="btnAddBank"><i class="fa fa-fw fa-briefcase "></i> Bank Information</a>
                            </li>
                            <li id="addAccounts">
                                <a href="#" id="btnAccounts"><i class="fa fa-fw fa-briefcase "></i> Accounts Information</a>
                            </li>
                            <li id="addWithdraw">
                                <a href="#" id="addWithdraw"><i class="fa fa-fw fa-briefcase "></i> WD Information</a>
                            </li>
                            <li id="pools">
                                <a href="#" id="btnPools"><i class="fa fa-fw fa-briefcase "></i> Pools Information</a>
                            </li>
                            <li id="globalmarket">
                                <a href="#" id="btnGlobalMarket"><i class="fa fa-fw fa-briefcase "></i> Global Market</a>
                            </li>
                            <li id="depowid">
                                <a href="#" id="btnDepoWid"><i class="fa fa-fw fa-briefcase "></i> WD-DP Report</a>
                            </li>
<!--                            <li id="expenses">-->
<!--                                <a href="#" id="btnExpenses"><i class="fa fa-fw fa-briefcase "></i> Expenses</a>-->
<!--                            </li>-->
                        </ul>
                    </li>


            </div>
        </div>
    </div>
</nav>

<div id="page-wrapper">
    <div id="body_content">

    </div>

</div>
<!-- /#page-wrapper -->

</div>

<div class="modal fade modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div id="modal_body"></div>


        </div>
    </div>
</div>



<!-- /#wrapper -->
    <script src="<?php echo base_url();?>public/js/raphael-min.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.js"></script>

    <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>public/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>public/js/ajaxfileupload.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.jeditable.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.dataTables.columnFilter.js"></script>
    <script src="<?php echo base_url();?>public/js/alertify.js"></script>

    <script src="<?php echo base_url();?>public/js/morris.js"></script>
<!--    <script src="--><?php //echo base_url();?><!--public/js/prettify.min.js"></script>-->
    <script src="<?php echo base_url();?>public/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap-switch.js"></script>
<!--    <script src="--><?php //echo base_url();?><!--public/js/service-worker.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>public/js/vendor/underscore.js"></script>


<script>

    var global_level = "<?php echo $level?>";
    var office = "<?php echo $results[0]->office?>";
    var base_url = $('#base_url').val();

    function clearSelected(){
        $('#ipaddress').removeAttr('class');
        $('#employee').removeAttr('class');
        $('#users').removeAttr('class');
        $('#attendance').removeAttr('class');
        $('#schedule').removeAttr('class');
        $('#template').removeAttr('class');
        $('#dashboard').removeAttr('class');
        $('#member_attendance').removeAttr('class');
        $('#member_schedule').removeAttr('class');
        $('#announcements').removeAttr('class');
        $('#profile').removeAttr('class');
        $('#salary').removeAttr('class');
        $('#it').removeAttr('class');
        $('#it_tool').removeAttr('class');
        $('#it_cloudflare').removeAttr('class');
        $('#salaryReport').removeAttr('class');
    }

    $(document).ready(function(){

        var level = "<?php echo $level?>";
        var office = "<?php echo $results[0]->office?>";

        if(office == 1) {

            if (level == 2) {
                $('#brand_name').html('Head Supervisor')
                //            $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                //            $('#btnEmployee').hide();
                $('#btnUsers').hide();
                //            $('#btnAttendance').hide();
                //            $('#btnScheduling').hide();
                //            $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                //            $('#bankingTools').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                $('#department').hide();

            }
            else if (level == 3) {

                $('#brand_name').html('Finance Head');
                //            $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                //            $('#btnEmployee').hide();
                $('#btnUsers').hide();
                //            $('#btnAttendance').hide();
                //            $('#btnScheduling').hide();
                //            $('#btnSchedulingTemplate').hide();
                //            $('#financeTools').hide();
                //            $('#bankingTools').hide();
                $('#it_tools').hide();
                //            $('#salary').hide()
                //            $('#salaryReport').hide();
                $('#department').hide();

            }
            else if (level == 4) {

                $('#brand_name').html('Finance Staff');
                $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                $('#btnEmployee').hide();
                $('#btnUsers').hide();
                $('#btnAttendance').hide();
                $('#btnScheduling').hide();
                $('#btnSchedulingTemplate').hide();
                //            $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                $('#department').hide();
            }
            else if (level == 5) {

                $('#brand_name').html('Human Resource Department')
                //            $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                //            $('#btnEmployee').hide();
                //            $('#btnUsers').hide();
                //            $('#btnAttendance').hide();
                //            $('#btnScheduling').hide();
                //            $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
            }
            else if (level == 6) {

                $('#brand_name').html('IT Department')
                //            $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                $('#btnEmployee').hide();
                $('#btnUsers').hide();
                $('#btnAttendance').hide();
                $('#btnScheduling').hide();
                $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#announcements').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                //            $('#it').hide();


            }
            else if (level == 0) {

                $('#brand_name').html('Member Portal')
                //            $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                $('#btnEmployee').hide();
                $('#btnUsers').hide();
                $('#btnAttendance').hide();
                $('#btnScheduling').hide();
                $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#announcements').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                $('#department').hide();

            }

        }else{
            if (level == 2) {

                $('#brand_name').html('Head Supervisor')
                $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                $('#btnEmployee').hide();
                $('#btnUsers').hide();
                $('#announcements').hide();
                //            $('#btnAttendance').hide();
                //            $('#btnScheduling').hide();
                //            $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                $('#department').hide();

            }
            else if (level == 0) {

                $('#brand_name').html('Member Portal')
                $('#btnDashboard').hide();
                $('#btnIpaddress').hide();
                $('#btnEmployee').hide();
                $('#btnUsers').hide();
                $('#btnAttendance').hide();
                $('#btnScheduling').hide();
                $('#btnSchedulingTemplate').hide();
                $('#financeTools').hide();
                $('#bankingTools').hide();
                $('#announcements').hide();
                $('#it_tools').hide();
                $('#salary').hide();
                $('#salaryReport').hide();
                $('#department').hide();

            }
        }

//        Default view to dashboard


        $('#btnDashboard').on('click',function(){
            $.post(base_url + 'admin/main/load_dashboard',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#dashboard').attr('class','active')
        });
        $('#btnIpaddress').on('click',function(){
            $.post(base_url + 'admin/main/load_ipaddress',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#ipaddress').attr('class','active')
        });
        $('#btnEmployee').on('click',function(){
            $.post(base_url + 'admin/main/load_employee',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#employee').attr('class','active')
        });
        $('#btnUsers').on('click',function(){
            $.post(base_url + 'admin/main/load_users',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#users').attr('class','active')
        });
        $('#btnAttendance').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_attendance',{username: username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#attendance').attr('class','active')
        });

//      Employee JS
        $('#btnEmployee').on('click',function(){
            $.post(base_url + 'admin/main/load_employee',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#employee').attr('class','active')
        });

        $('#btnScheduling').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_scheduling',{username: username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#shechedule').attr('class','active')
        });

        $('#btnDepartment').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_department',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#shechedule').attr('class','active')
        });



        $('#btnSchedulingTemplate').on('click',function(){
            $.post(base_url + 'admin/main/load_scheduling_template',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#template').attr('class','active')
        });
        $('#btnBCA').on('click',function(){
            var username = "<?php echo $results[0]->username?>";

            $.post(base_url + 'admin/main/load_bca',{username: username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#BCA').attr('class','active')
        });

// Bank Tools

        $('#btnAddBank').on('click',function(){
            $.post(base_url + 'admin/main/load_bank_info',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#addBank').attr('class','active')
        });
        $('#btnAccounts').on('click',function(){
            $.post(base_url + 'admin/main/load_accounts_info',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#addAccounts').attr('class','active')
        });
        $('#addWithdraw').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_withdraw_info',{username: username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#addWithdraw').attr('class','active')
        });
        $('#btnExpenses').on('click',function(){
            $.post(base_url + 'admin/main/load_expenses',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#btnExpenses').attr('class','active')
        });

//        Members Portal

        $('#btnMemAttendance').on('click',function(){
            $.post(base_url + 'admin/main/load_member_portal',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#member_attendance').attr('class','active')
        });

        $('#btnMemSchedule').on('click',function(){
            $.post(base_url + 'admin/main/load_my_schedule',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#member_schedule').attr('class','active')
        });

        $('#btnPools').on('click',function(){
            $.post(base_url + 'admin/main/load_pools',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#pools').attr('class','active')
        });

        $('#btnGlobalMarket').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_global_market',{username: username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#globalmarket').attr('class','active')
        });

        $('#btnDepoWid').on('click',function(){
            var username = "<?php echo $results[0]->username?>";
            $.post(base_url + 'admin/main/load_depowid',{username:username},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#depowid').attr('class','active')
        });

        $('#btnAnnouncements').on('click',function(){
            $.post(base_url + 'admin/main/load_announcements',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#announcements').attr('class','active')
        });
        $('#btnProfile').on('click',function(){
            $.post(base_url + 'admin/main/load_profile',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#profile').attr('class','active')
        });

//        IT CALLS

        $('#btnIT').on('click',function(){
            $.post(base_url + 'admin/main/load_it',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#it_cloudflare').attr('class','active')
        });

        $('#btnITCloudflare').on('click',function(){
            $.post(base_url + 'admin/main/load_it_cloudflare',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#it').attr('class','active')
        });

        $('#btnITGDDomains').on('click',function(){
            $.post(base_url + 'admin/main/load_it_godaddy_domains',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#it').attr('class','active')
        });

        $('#btnITServerInfo').on('click',function(){
            $.post(base_url + 'admin/main/getServerInfo',function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#it').attr('class','active')
        });



        $('#aProfile').on('click', function(){
            $('#btnProfile').trigger('click');
        })

        $('#aPassword').on('click', function(){
            $.post(base_url + 'admin/main/change_pass',function(data){

                $('#myModal').modal('show');

                $('#modal_body').html(data);

            });

        });

//        Salary
        $('#btnSalary').on('click',function(){
            $.post(base_url + 'admin/main/load_salary',{level:level},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#salary').attr('class','active')
        });

        $('#btnSalaryReport').on('click',function(){
            $.post(base_url + 'admin/main/load_salary_report',{level:level},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#salary').attr('class','active')
        });

        $('#btnMonitor').on('click',function(){
            $.post(base_url + 'admin/main/it_monitor',{level:level},function(data){
                $('#body_content').html(data);
            });
            clearSelected();
            $('#salary').attr('class','active')
        });

// Logout
        $('#btnLogout').on('click',function(){
            $.post(base_url + 'admin/main/logOut',function(){
                    location.reload();
            });
        });

    });

//IP Address

    $(document).ready(function(){
        alertify.defaults.transition = "zoom";
        alertify.defaults.title = "App Message";
        alertify.defaults.theme.ok = "ui positive button";
        alertify.defaults.theme.cancel = "ui black button";
        alertify.set('notifier','position', 'bottom-right');
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
//    var checker = setInterval(function(){
//        var isLoggedIn = "<?php //echo $this->session->userdata('isLoggedIn')?>//"
//        alert(isLoggedIn);
//        if(isLoggedIn == 0){
//
//            alertify.alert('Please log in again');
//            window.location.assign(base_url+'admin');
//            location.reload();
//        }
//    },1000);
    $(document).ready(function(){



        var level = "<?php echo $level?>";
        if(level == 10){

            $('#btnBCA').trigger('click');
            $.post(base_url + 'admin/main/load_profile',function(data){
                $('#body_content').html(data);
                clearSelected();
                $('#profile').attr('class','active')

            });
        }else{
            $.post(base_url + 'admin/main/load_profile',function(data){
                $('#body_content').html(data);
                clearSelected();
                $('#profile').attr('class','active')
            });
        }
    })


    var url = '<?php echo base_url()?>public/img/sfx-logo.png';

    function notifyMe(title, message, url, urlRun) {
        var message = message.substring(0,100);
        if (!Notification) {
            alert('Desktop notifications not available in your browser. Try Chromium.');
            return;
        }

        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            var notification = new Notification(title, {
                icon: url,
                body: message,
            });

            notification.onclick = function () {
                window.open(urlRun);
            };

        }

    }

    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
    }
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }


</script>
</body>

</html>
