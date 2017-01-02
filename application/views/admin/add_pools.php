
<form role="form" id="frmAddPoolsInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtPoolCode">Pool Code</label>
        <input type="text" class="form-control" placeholder="Pool Code" id="txtPoolCode"/>
    </div>
    <div class="form-group">
        <label for="txtPDsc">Pool Description</label>
        <input type="text" class="form-control" placeholder="Pool Description" id="txtPDsc"/>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddPoolsInfo').submit(function(e) {
        var poolcode = $('#txtPoolCode').val();
        var dsc = $('#txtPDsc').val();


        e.preventDefault();
        $.post('main/insert_pool_info',{poolcode: poolcode, dsc: dsc},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnPools').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });




//    $(document).ready(function(){
//        $('#btnClose').on('click', function(){
//
//            $.post(base_url + 'admin/main/load_ip',function(data){
//                $('#body_content').html(data);
//            });
//        })
//    });
</script>
