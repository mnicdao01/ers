
<form role="form" id="frmAddTemplate" enctype="multipart/form-data" method="post">

    <div class="form-group">
        <label for="txtIP">Code</label>
        <input type="text" class="form-control" placeholder="CODE" id="txtCode"/>
    </div>
    <div class="form-group">
        <label for="txtLocation">Description</label>
        <input type="text" class="form-control" placeholder="DESCRIPTION" id="txtDsc"/>
    </div>

    <div class="form-group">
        <label for="txtLocation">Time In</label>
        <input type="time" class="form-control" placeholder="TIME IN" id="txtTimein"/>
    </div>

    <div class="form-group">
        <label for="txtLocation">Time Out</label>
        <input type="time" class="form-control" placeholder="TIME OUT" id="txtTimeout"/>
    </div>
    <div class="form-group">
        <label for="selDept">Department</label>
        <select name="selDept" id="selDept" class="form-control">
            <?php foreach($dept as $row){?>
            <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
            <?php }?>
        </select>
    </div>
    <div class="form-group">
        <label for="propColor">Text Color</label>
        <input type="color" class="form-control" id="propColor"/>
    </div>


    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSave">Save</button>

    </div>

</form>


<script>


    $(function() {

        $('#frmAddTemplate').submit(function(e) {
            e.preventDefault();
            var code = $('#txtCode').val();
            var dsc = $('#txtDsc').val();
            var timein = $('#txtTimein').val();
            var timeout = $('#txtTimeout').val();
            var dept = $('#selDept').val();
            var color = $('#propColor').val();

            $.post('main/add_template',{code: code, dsc: dsc, timein: timein, timeout: timeout, dept:dept, color:color},function (data){

                    if(data == true){
                        alertify.success("Save Successfully");
                    }else {
                        alertify.error("Error is saving the template");
                    }


            });
            return false;
        });

    });



    $(document).ready(function(){
        $('#btnClose').on('click', function(){

            $.post(base_url + 'admin/main/load_scheduling_template',function(data){
                $('#body_content').html(data);
            });
        })
    });
</script>
