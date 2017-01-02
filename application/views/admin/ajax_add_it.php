
<form role="form" id="frmAddAInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtTitle">Title</label>
        <input type="text" class="form-control" placeholder="Title" id="txtTitle"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">Description / Troubleshooting Done</label>
        <textarea class="form-control" placeholder="Announcement" id="txtDsc"></textarea>
    </div>
    <div class="form-group">
        <label for="txtStatus">Status</label>
        <select class="form-control" name="selStatus" id="selStatus">
            <option value="Fixed">Fixed</option>
            <option value="For Continuation">For Continuation</option>
            <option value="For Checking">For Checking</option>
        </select>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAInfo">Save</button>

    </div>

</form>


<script>

    var urlRun = "http://admin-sfx.com/ers/admin/main";

    var d = new Date();
    var empid = $('#empid').val();
    $('#frmAddAInfo').submit(function(e) {
        var title = $('#txtTitle').val();
        var dsc = d + "\n" + $('#txtDsc').val() + " by: " + empid;
        var status = $('#selStatus').val();
        var message = $('#empid').val() + ": " + $('#txtDsc').val();


        e.preventDefault();
        $.post('main/insert_it',{title: title, dsc: dsc, status:status},function(data){
//            console.log(data);
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
