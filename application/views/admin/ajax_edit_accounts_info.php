<form role="form" id="frmEditAccInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtID">ID</label>
        <input type="text" class="form-control" placeholder="ID" id="txtID" value="<?php echo $id?>"/>
    </div>
    <div class="form-group">
        <label for="txtAccName">Account Name</label>
        <input type="text" class="form-control" placeholder="Account Name" id="txtAccName" value="<?php echo $name?>"/>
    </div>
    <div class="form-group">
        <label for="txtAccNo">Account Number</label>
        <input type="text" class="form-control" placeholder="Account Number" id="txtAccNo" value="<?php echo $accno?>"/>
    </div>
    <div class="form-group">
        <label for="txtCno">Contact No.</label>
        <input type="text" class="form-control" placeholder="Contact No." id="txtCno" value="<?php echo $cno?>"/>
    </div>

    <div class="form-group">

        <label for="selBank">Bank</label>
        <select id="selBank" name="selBank" class="form-control">
            <?php foreach($bank as $row){

                if($row->bank_name == $bank_get){
                    echo "<option selected='selected' value='$row->bank_name'>$row->bank_name</option>";
                }
                else{
                    echo "<option value='$row->bank_name'>$row->bank_name</option>";
                }

            } ?>
        </select>
    </div>
    <div class="form-group">

        <label for="selDept">Department</label>
        <select id="selDept" name="selDept" class="form-control">
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


    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>

<script>

    $('#frmEditAccInfo').submit(function(e) {
        var id = $('#txtID').val();
        var name = $('#txtBankName').val();
        var dsc = $('#txtDsc').val();
        var cno = $('#txtCno').val();


        e.preventDefault();
        $.post('main/update_bank_info',{id:id, bankname: name, dsc: dsc, cno: cno},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Updated successfully");
                $('#btnAddBank').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });




    $(document).ready(function(){
        $('#btnClose').on('click', function(){

            $.post(base_url + 'admin/main/load_ip',function(data){
                $('#body_content').html(data);
            });
        })
    });
</script>
