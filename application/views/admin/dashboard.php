<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Dashboard <small>Statistics Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Control Panel
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">All Logged-in Employees</div>
                <div class="panel-body">
                    <div class="filter">
                        <label for="selDept">Select Department</label>
                       <select class="form-control" id="selDept">
                           <option value="all">All</option>
                           <?php foreach($filter_department as $row){?>
                           <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                            <?php }?>
                       </select>
                    </div>
                    <div id="ajax_login"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="panel panel-primary">
                <div class="panel-heading">Summary</div>
                <div class="panel-body">
<!--                    Repeat-->
                    <?php foreach($summary as $row){?>
                    <div class="col-xs-4">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <?php echo strtoupper($row->dept)?>
                                </div>
                                <div class="panel-body">
                                    <center>
                                    <?php echo $row->count_dept?>
                                    </center>
                                </div>
                            </div>

                    </div>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>




</div>

<script>
    $(document).ready(function (){

        var base_url = $('#base_url').val();

//        var auto_start = setInterval(function (){
            $.post('main/load_ajax_login', function(data){
                $('#ajax_login').html(data);
            });
//        }, 0);


        $('#selDept').change(function(){
           var selected = $(this).val();

            if(selected == 'all'){


                    $.post('main/load_ajax_login', function(data){
                        $('#ajax_login').html(data);
                    });

            }
            else {


                    $.post('main/load_ajax_login_dept', {dept: selected}, function (data) {
                        $('#ajax_login').html(data);
                    });

            }

        });




    });
</script>