

<div class="container-fluid">
    <div class="row">
        <h1>Deposit and Withdrawal Management</h1>

        <div class="form-group">
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
                <label for="btnGetData">Actions:</label><br/>

                <button class="btn btn-primary btn-sm" id="btnFilterDW">Filter</button>

            </div>
        </div>

    </div>

    <div class="row" id="tableDepoWid">

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


        $('#btnFilterDW').on('click', function(){

            var dept = $('#sel_dept').val();
            var year = $('#year').val();
            var month = $('#month').val();

            $.post('main/load_depowid_table',{dept:dept,year:year,month:month},function(data){
                $('#tableDepoWid').html(data);
            })
        });




    });





</script>
