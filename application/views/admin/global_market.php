

<div class="container-fluid">
    <div class="row">
        <h1>Global Market</h1>

        <div class="col-xs-3">
            <label for="selDept">Select Department</label>
            <select id="selDept" name="selDept" class="form-control">
                <option value="" selected>- Select the Department -</option>
                <?php foreach($dept as $row){?>
                    <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="selPool">Select Pool</label>
            <select id="selPool" name="selPool" class="form-control">
                <option value="" selected>- Select the Department -</option>
                <?php foreach($pools as $row){?>
                    <option value="<?php echo $row->code?>"><?php echo $row->code."-".$row->dsc?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="dateAll">Select Year and Month</label>
            <div class='input-group date' id='datetimepicker1' >
                <input type='text' class="form-control" id="myDateAll"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
            </div>
        </div>
        <div class="col-xs-3">

            <button type="button" id="btnFilter" class="btn btn-primary">Filter</button>

        </div>
        <hr/>

        <div id="table_market"></div>

    </div>

</div>

<script>
    $(document).ready(function(){

        $('#myDateAll').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });




//        Filtering

        $('#btnFilter').on('click', function(){
            var dept = $('#selDept').val();
            var pool = $('#selPool').val();
            var date = $('#myDateAll').val();

            $.post('main/load_market_dept_pool_date',{dept:dept,pool:pool,date:date}, function(data){
                $('#table_market').html(data);


            });
        });

//        $('#selDept').on('change', function(){
//            var dept = $('#selDept').val();
//
//                $.post('main/load_market_dept',{dept:dept}, function(data){
//                    $('#table_market').html(data);
//
//
//                });
//
//        });

//        $('#selPool').on('change', function(){
//            var dept = $('#selDept').val();
//            var pool = $('#selPool').val();
//
//            $.post('main/load_market_dept_pool',{dept:dept,pool:pool}, function(data){
//                $('#table_market').html(data);
//
//
//            });
//
//        });







    });
</script>
