
<form role="form" id="frmEditTemplate" enctype="multipart/form-data" method="post">
    <input type="hidden" value="<?php foreach($result as $row){echo $row->id;}?>" id="ID"/>
    <div class="form-group">
        <label for="txtCode">CODE</label>
        <input type="text" class="form-control" placeholder="CODE" id="txtCode" value="<?php foreach($result as $row){echo $row->code;}?>"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">DESCRIPTION</label>
        <input type="text" class="form-control" placeholder="DESCRIPTION" id="txtDsc" value="<?php foreach($result as $row){echo $row->dsc;}?>"/>
    </div>
    <div class="form-group">
        <label for="txtTimein">TIME IN</label>
        <input type="time" class="form-control" placeholder="TIME IN" id="txtTimein" value="<?php foreach($result as $row){echo $row->start_time;}?>"/>
    </div>
    <div class="form-group">
        <label for="txtTimeout">TIME OUT</label>
        <input type="time" class="form-control" placeholder="TIME OUT" id="txtTimeout" value="<?php foreach($result as $row){echo $row->end_time;}?>"/>
    </div>
    <div class="form-group">
        <label for="selDept">Department</label>
        <select name="selDept" id="selDept" class="form-control">
            <?php foreach($dept as $row){

                if($row->dsc == $dept_get){
                    echo "<option selected='selected' value='$row->dsc'>$row->dsc</option>";
                }
                else{
                    echo "<option value='$row->dsc'>$row->dsc</option>";
                }

            } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="propColor">Text Color</label>
        <input type="color" class="form-control" id="propColor" value="<?php foreach($result as $row){echo $row->color;}?>"/>
    </div>

    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnUpdate">Update</button>

    </div>

</form>


<script>



    $(function() {


        $('#frmEditTemplate').submit(function(e) {
            e.preventDefault();
            var id = $('#ID').val();
            var code = $('#txtCode').val();
            var dsc = $('#txtDsc').val();
            var timein = $('#txtTimein').val();
            var timeout = $('#txtTimeout').val();
            var dept = $('#selDept').val();
            var color = $('#propColor').val();
            $.post('main/update_template',{id: id, code:code, dsc: dsc, timein: timein, timeout: timeout, dept:dept, color:color},function (data){

                    if(data == true){
                        alertify.success("Successfully modified");
                        $("#btnSchedulingTemplate").trigger('click');
                    }
                else {
                        alertify.error("Error on updating the template");
                    }

            });
            return false;
        });

    });



//    $(document).ready(function(){
//        $('#btnClose').on('click', function(){
//
//            $.post(base_url + 'admin/main/load_scheduling_template',function(data){
//                $('#body_content').html(data);
//            });
//        })
//    });
</script>
