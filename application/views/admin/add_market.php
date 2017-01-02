
<form role="form" id="frmAddBankInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Gross" id="txtDate"/>
    </div>
    <div class="form-group">
        <label for="txtGross">Gross</label>
        <input type="number" class="form-control" placeholder="Gross" id="txtGross" pattern="1,000,000,000"/>
    </div>
    <div class="form-group">
        <label for="txtDC">Discount</label>
        <input type="number" class="form-control" placeholder="Discount" id="txtDC"/>
    </div>
    <div class="form-group">
        <label for="txtKei">Kei</label>
        <input type="number" class="form-control" placeholder="Kei" id="txtKei"/>
    </div>
    <div class="form-group">
        <label for="txtGift">Gift</label>
        <input type="number" class="form-control" placeholder="Gift" id="txtGift"/>
    </div>
    <div class="form-group">
        <label for="txtReferral">Referral</label>
        <input type="number" class="form-control" placeholder="Referral" id="txtReferral"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddBankInfo').submit(function(e) {
        var dept = $('#selDept').val();
        var pool = $('#selPool').val();
        var date = $('#txtDate').val();
        var gross = $('#txtGross').val();
        var dc = $('#txtDC').val();
        var kei = $('#txtKei').val();
        var gift = $('#txtGift').val();
        var referral = $('#txtReferral').val();

        e.preventDefault();
        $.post('main/insert_market',{dept: dept,pool: pool, date: date, gross: gross, dc: dc, kei: kei, gift: gift, referral: referral},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnFilter').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });


</script>
