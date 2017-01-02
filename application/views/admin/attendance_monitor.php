<h1>Attendance Monitor<small> Monitor Employee Attendance</small></h1>
    <div class="row">
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
                <div class="col-xs-3">
                    <label for="myDate">Select Month:</label>

                    <div class='input-group date' id='datetimepicker1' >
                        <input type='text' class="form-control" id="myDate"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>


                </div>
                <div class="col-xs-5">
                    <label for="btnGetData">Actions:</label><br/>

                    <button class="btn btn-primary btn-sm" id="btnFilterAttendance">Filter</button>

                    <button type="button" id="btnEditTimein" class="btn btn-warning">Fix Time In and Out</button>
                    <button type="button" id="btnDeleteTimein" class="btn btn-danger">Delete</button>

                </div>

            </div>

        </div>
        <div class="row">
            <hr/>
            <div class="col-xs-12">
                <div id="attendance_table">


                </div>
            </div>
        </div>



<script>

    $(document).ready( function () {
        $('#btnEditTimein').hide();
        $('#btnDeleteTimein').hide();
        $.post('main/load_attendance_table',function(data){
            $('#attendance_table').html(data);
        });


        $('#myDate').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });

        $('#btnFilterAttendance').on('click', function(){
            var dept = $('#dept').val();
            var date = $('#myDate').val();


            if(date && dept){
                $.post('main/get_attendance_dept_month',{dept:dept,date:date},function(data){

                    $('#attendance_table').html(data);


                });
            }
            else {
                alert('Please select month.')
            }
        });



    } );
</script>