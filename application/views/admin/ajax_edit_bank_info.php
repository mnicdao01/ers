
<form role="form" id="frmUpdateBankInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtId">ID</label>
        <input type="text" class="form-control" id="txtID" value="<?php echo $id ?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtBankName">Bank Name</label>
        <input type="text" class="form-control" placeholder="Bank Name" id="txtBankName" value="<?php echo $code ?>"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">Bank Description</label>
        <input type="text" class="form-control" placeholder="Bank Description" id="txtDsc" value="<?php echo $dsc ?>"/>
    </div>
    <div class="form-group">
        <label for="txtCno">Contact Number</label>
        <input type="text" class="form-control" placeholder="Contact Number" id="txtCno" value="<?php echo $cno ?>"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnUpdateBankInfo">Update</button>

    </div>

</form>


<script>




    $('#frmUpdateBankInfo').submit(function(e) {
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
