
<form role="form" id="frmAddWdInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtAccName">Account Name</label>
        <input type="text" class="form-control" placeholder="Account Name" id="txtAccName" value="<?php echo $name?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtAccNo">Account Number</label>
        <input type="text" class="form-control" placeholder="Account Number" id="txtAccNo" value="<?php echo $accno?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtAmount">Amount (x 1,000,000)</label>
        <input type="text" class="form-control" placeholder="Amount (x 1,000,000)" id="txtAmount"/>
    </div>
    <div class="form-group">
        <label for="txtDate">Date of Withdrawal</label>
        <input type="date" class="form-control" placeholder="Date of Withdrawal" id="txtDate"/>
<!--        <button class="btn btn-primary" id="now">Now</button>-->
    </div>


    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveWdInfo">Save</button>

    </div>

</form>


<script>


    $('#frmAddWdInfo').submit(function(e) {
        var accname = $('#txtAccName').val();
        var accno = $('#txtAccNo').val();
        var amount = $('#txtAmount').val();
        var date = $('#txtDate').val();

        e.preventDefault();
        $.post('main/insert_wd_info',{accname: accname, accno: accno, amount:amount, date:date},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");

                $('#btnRefresh').trigger('click');
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
