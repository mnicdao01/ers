

<div class="container-fluid">
    <div class="row">
        <h1>My Attendance </h1>
        <div class="form-group">
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

                <button class="btn btn-primary btn-sm" id="btnFilterMyAttendance">Filter</button>

            </div>
        </div>

    </div>

    <div class="row" id="lstMyAttendance">

    </div>
</div><!-- End of Container-Fluid -->


<script>
    $(document).ready(function(){


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

        $('#btnFilterMyAttendance').on('click', function(){
            var empid = $('#empid').val();

            var year = $('#year').val();
            var month = $('#month').val();

            if(year && month){
                $.post('main/show_my_attendance',{empid:empid,year:year,month:month},function(data){
                    $('#lstMyAttendance').html(data);
                })
            }
            else{
                alertify.error("Please select year and month");
            }
        });



    });





</script>
