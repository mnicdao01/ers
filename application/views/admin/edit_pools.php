
<form role="form" id="frmUpdatePoolInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtId">ID</label>
        <input type="text" class="form-control" id="txtID" value="<?php echo $id ?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtPoolCode">Pool Code</label>
        <input type="text" class="form-control" placeholder="Pool Code" id="txtPoolCode" value="<?php echo $code ?>"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">Pool Description</label>
        <input type="text" class="form-control" placeholder="Pool Description" id="txtDsc" value="<?php echo $dsc ?>"/>
    </div>

    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnUpdateBankInfo">Update</button>

    </div>

</form>
<script>




    $('#frmUpdatePoolInfo').submit(function(e) {
        var id = $('#txtID').val();
        var code = $('#txtPoolCode').val();
        var dsc = $('#txtDsc').val();




        e.preventDefault();
        $.post('main/update_pool_info',{id:id, code: code, dsc: dsc},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Updated successfully");
                $('#btnPools').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });


</script>
