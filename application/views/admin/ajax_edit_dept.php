
<form role="form" id="frmEditADInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtID">ID</label>
        <input type="text" class="form-control" placeholder="ID" id="txtID" disabled value="<?php echo $id ?>"/>
    </div>
    <div class="form-group">
        <label for="txtDName">Name</label>
        <input type="text" class="form-control" placeholder="Title" id="txtDName" value="<?php echo $dsc ?>"/>
    </div>


    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAInfo">Save</button>

    </div>

</form>


<script>

    var d = new Date();
    var empid = $('#empid').val();

    $('#frmEditADInfo').submit(function(e) {
        var id = $('#txtID').val();
        var dname = $('#txtDName').val();

        e.preventDefault();
        $.post('main/update_dept_info',{id:id,dname: dname},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnIT').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });



</script>
