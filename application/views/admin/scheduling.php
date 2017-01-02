

<div class="container-fluid">
    <div class="row">
        <h1>Monthly Scheduling</h1>

        <div class="form-group">
            <div class="col-xs-3">
                <label for="myDate">Select Department:</label>

                <div class='input-group' id='datetimepicker1' >
                    <select class="form-control" id="dept">
                        <?php foreach($dept as $row){?>
                        <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                        <?php } ?>
                    </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </span>

                </div>
            </div>
            <div class="col-xs-offset-1 col-xs-3">
                <label for="myDate">Select Month:</label>

                <div class='input-group date' id='datetimepicker1' >
                    <input type='text' class="form-control" id="myDate"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                </div>


            </div>
            <div class="col-xs-3">
                <label for="btnGetData">Actions:</label><br/>

                <button class="btn btn-primary btn-sm" id="btnGetData">Get Data</button>
                <button class="btn btn-info btn-sm" id="btnLegend"> Show Legend</button>
                <button class="btn btn-danger btn-sm" id="btnReset"> Reset Data</button>

            </div>
        </div>

    </div>
    <div class="row">
        <p><hr></p>
        <div class="col-xs-12">
            <div id="ajax_schedule_main">

            </div>


        </div>
    </div>
    <div class="row">
        <p><hr></p>
        <div class="col-xs-12">
            Schedule Summary
            <div id="ajax_schedule_summary">

            </div>


        </div>
    </div>
</div><!-- End of Container-Fluid -->

<div class="modal fade" id="myLegend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Legend</h4>
            </div>
            <div class="modal-body">
                <div id="legendBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){


        $('#myDate').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        $('#btnGetData').on('click', function(){
            var dept = $('#dept').val();
            var month = $('#myDate').val();


            if(month){
            $.post('main/get_attendance_data',{dept:dept,month:month},function(data){

                $('#ajax_schedule_main').html(data);


                });
            }
            else {
                alert('Please select month.')
            }
        });

        $('#btnLegend').on('click', function(){
            var dept = $('#dept').val();
            $('#myLegend').modal('show');
            $.post('main/show_legend',{dept:dept},function(data){
                $('#legendBody').html(data);
            })
        });

        $('#btnReset').on('click', function(){
            var dept = $('#dept').val();
            var month = $('#myDate').val();
            alertify.confirm('Are you sure you want to reset all data from the selected department and selected date?').set('onok', function(closeEvent){
                $.post('main/reset_schedule',{dept:dept, month: month},function(data){
                    alertify.success('Data was reset');
                    $('#btnGetData').trigger('click')
                })
            } );


        })


    });





</script>
