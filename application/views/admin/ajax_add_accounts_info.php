
<form role="form" id="frmAddBankInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtAccName">Account Name</label>
        <input type="text" class="form-control" placeholder="Account Name" id="txtAccName"/>
    </div>
    <div class="form-group">
        <label for="txtAccNo">Account Number</label>
        <input type="text" class="form-control" placeholder="Account Number" id="txtAccNo"/>
    </div>
    <div class="form-group">
        <label for="txtCno">Contact No.</label>
        <input type="text" class="form-control" placeholder="Contact No." id="txtCno"/>
    </div>
    <div class="form-group">

        <label for="selBank">Bank</label>
        <select id="selBank" name="selBank" class="form-control">
            <?php foreach($bank as $row){?>
            <option value="<?php echo $row->bank_name?>"><?php echo $row->bank_name?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">

        <label for="selDept">Department</label>
        <select id="selDept" name="selDept" class="form-control">
            <?php foreach($dept as $row){?>
                <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
            <?php } ?>
        </select>
    </div>


    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddBankInfo').submit(function(e) {
        var accname = $('#txtAccName').val();
        var accno = $('#txtAccNo').val();
        var cno = $('#txtCno').val();
        var bank = $('#selBank').val();
        var dept = $('#selDept').val();

        e.preventDefault();
        $.post('main/insert_accounts_info',{accname: accname, accno: accno, cno: cno, bank:bank, dept:dept},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnAccounts').trigger('click');
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
