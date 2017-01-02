
<form role="form" id="frmAddADInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtDName">Department Name</label>
        <input type="text" class="form-control" placeholder="Title" id="txtDName"/>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveADInfo">Save</button>

    </div>

</form>


<script>


    var d = new Date();
    var empid = $('#empid').val();
    $('#frmAddADInfo').submit(function(e) {
        var dname = $('#txtDName').val();

        e.preventDefault();
        $.post('main/insert_department',{dname: dname},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnDepartment').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });



</script>
