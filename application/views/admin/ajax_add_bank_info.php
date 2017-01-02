
<form role="form" id="frmAddBankInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtBankName">Bank Name</label>
        <input type="text" class="form-control" placeholder="Bank Name" id="txtBankName"/>
    </div>
    <div class="form-group">
        <label for="txtDsc">Bank Description</label>
        <input type="text" class="form-control" placeholder="Bank Description" id="txtDsc"/>
    </div>
    <div class="form-group">
        <label for="txtCno">Contact Number</label>
        <input type="text" class="form-control" placeholder="Contact Number" id="txtCno"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>


<script>




        $('#frmAddBankInfo').submit(function(e) {
            var name = $('#txtBankName').val();
            var dsc = $('#txtDsc').val();
            var cno = $('#txtCno').val();

            e.preventDefault();
            $.post('main/insert_bank_info',{bankname: name, dsc: dsc, cno: cno},function(data){
                    if(data==true){
                    $('#myModal').modal('hide');
                    alertify.success("Save successfully");
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
