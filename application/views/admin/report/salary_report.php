

<div class="container-fluid">
    <div class="row">
        <h1>Salary Report</small></h1>
<!--        <div class="col-xs-3">-->
<!--            <label for="dept">-->
<!--                Department-->
<!--            </label>-->
<!--            <select class="form-control" id="dept">-->
<!--                <option value="all">-- ALL --</option>-->
<!--                --><?php //foreach($dept as $row){?>
<!--                    <option value="--><?php //echo $row->dsc?><!--">--><?php //echo $row->dsc?><!--</option>-->
<!--                --><?php //} ?>
<!--            </select>-->
<!--        </div>-->
        <div class="col-xs-2">
            <label for="myDate">Select Month:</label>

            <div class='input-group date' id='datetimepicker1' >
                <input type='text' class="form-control" id="myDate"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
            </div>
        </div>
        <div class="col-xs-2">
            <label for="">
                Actions
            </label>
            <div class="form-group">
                <button type="button" class="btn btn-primary" id="btnLoadSReport">Load</button>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="salary_report"></div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){

        $('#myDate').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });


        $('#btnLoadSReport').on('click', function(data){
            var month = $('#myDate').val();
            $.post('main/load_ajax_salary_report',{month:month}, function(data){
                $('#salary_report').html(data);


            });

        });
    });
</script>
