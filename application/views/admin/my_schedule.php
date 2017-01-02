
<h1>My Schedule<small> My Schedule for this Month</small></h1>
<hr/>

<div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
    <button type="button" class="btn btn-info" id="btnPrevious">Previous Month</button>
    <button type="button" class="btn btn-danger" id="btnThisMonth">This Month</button>
    <button type="button" class="btn btn-primary" id="btnNext">Next Month</button>



</div>
<input type="hidden" id="txtMyDate" value="<?php echo date('Y-m-d')?>" disabled class="form-control" style="text-align: center;font-size: 20px;">
<div id="my_schedule_table">

</div>

<script>
    $(document).ready(function(){

        var date = $('#txtMyDate').val();

        $.post(base_url + 'admin/main/load_member_schedules', {date:date},function(data){
            $('#my_schedule_table').html(data);
        });

        $('#btnNext').on('click', function(){
            var date = $('#txtMyDate').val();
            $.post(base_url + 'admin/main/load_member_schedules_next',{date:date},function(data){
                $('#my_schedule_table').html(data);
            });
        });
        $('#btnPrevious').on('click', function(){
            var date = $('#txtMyDate').val();
            $.post(base_url + 'admin/main/load_member_schedules_prev',{date:date},function(data){
                $('#my_schedule_table').html(data);
            });
        });
        $('#btnThisMonth').on('click', function(){
            $('#btnMemSchedule').trigger('click');
        });
    });
</script>