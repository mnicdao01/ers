

<div class="container-fluid">
    <div class="row">
        <h1>Withdrawals Information and Management</h1>

        <div class="form-group">
            <div class="col-xs-2">
                <label for="myDate">Select Bank:</label>

                <div class='input-group' id='bank' >
                    <select class="form-control" id="sel_bank">
                        <?php foreach($bank as $row){?>
                            <option value="<?php echo $row->bank_name?>"><?php echo $row->bank_name?></option>
                        <?php } ?>
                    </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </span>

                </div>
            </div>
            <div class="col-xs-2">
                <label for="dept">Select Department:</label>

                <div class='input-group' id='dept' >
                    <select class="form-control" id="sel_dept">
                        <?php foreach($dept as $row){?>
                            <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                        <?php } ?>
                    </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </span>

                </div>
            </div>
            <div class="col-xs-2">
                <label for="myYear">Year:</label>

                <div class='input-group date' id='datetimepicker1' >
                    <input type='text' class="form-control" id="year"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                </div>


            </div>
            <div class="col-xs-2">
                <label for="myMonth">Month:</label>

                <div class='input-group date' id='datetimepicker1' >
                    <input type='text' class="form-control" id="month"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                </div>


            </div>
            <div class="col-xs-2">
                <label for="myDay">Day:</label>

                <div class='input-group date' id='datetimepicker1' >
                    <input type='text' class="form-control" id="day"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                </div>


            </div>
            <div class="col-xs-2">
                <label for="btnGetData">Actions:</label><br/>

                <button class="btn btn-primary btn-sm" id="btnRefresh">Refresh</button>

            </div>
        </div>

    </div>

    <div class="row" id="lstAccounts">

    </div>
</div><!-- End of Container-Fluid -->


<script>
    $(document).ready(function(){

        $('#wdInfo').DataTable();

        $('#year').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
        $('#month').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: " mm",
            viewMode: "months",
            minViewMode: "months"
        });
        $('#day').datepicker({
            autoclose: true,
            format: " dd",
            viewMode: "days",
            minViewMode: "days"
        });



//        $('#month').on('click',function(){
//            var d = new Date();
//            var year = $('#year').val();
//            var month = $(this).val();
//            var day = d.getDay();
//
//
//            var start = new Date(year,month,day);
//            alert(start);
//            $('#day').datepicker('setDate',start);
//
//        });

        $('#sel_dept').on('change', function(){
            var bank = $('#sel_bank').val();
            var dept = $('#sel_dept').val();

            $.post('main/get_wd_dept',{bank:bank, dept:dept}, function(data){
                $('#lstAccounts').html(data);
            })


        });

        $('#sel_bank').on('change', function(){
            var bank = $('#sel_bank').val();
            var dept = $('#sel_dept').val();

            $.post('main/get_wd_dept',{bank:bank, dept:dept}, function(data){
                $('#lstAccounts').html(data);
            })


        });

        $('#btnFilterData').on('click', function(){
            var bank = $('#bank').val();
            var dept = $('#dept').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();

            $.post('main/show_legend',function(data){
                $('#legendBody').html(data);
            })
        });

        $('#btnRefresh').on('click', function(){
            $('#sel_dept').trigger('change');
        })




    });





</script>
