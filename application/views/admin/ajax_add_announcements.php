
<form role="form" id="frmAddAInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtTitle">Title</label>
        <input type="text" class="form-control" placeholder="Title" id="txtTitle"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">Announcement</label>
        <textarea class="form-control" placeholder="Announcement" id="txtDsc"></textarea>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddAInfo').submit(function(e) {
        var title = $('#txtTitle').val();
        var dsc = $('#txtDsc').val();


        e.preventDefault();
        $.post('main/insert_announcements_info',{title: title, dsc: dsc},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnAnnouncements').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });



</script>
