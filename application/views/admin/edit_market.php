
<form role="form" id="frmEditMarketInfo" enctype="multipart/form-data" method="post">

    <input type="hidden" class="form-control" id="txtID" value="<?php echo $id ?>"/>
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Gross" id="txtDate" value="<?php echo $date ?>"/>
    </div>
    <div class="form-group">
        <label for="txtGross">Gross</label>
        <input type="text" class="form-control" placeholder="Gross" id="txtGross" value="<?php echo $gross ?>"/>
    </div>
    <div class="form-group">
        <label for="txtDC">Discount</label>
        <input type="text" class="form-control" placeholder="Discount" id="txtDC" value="<?php echo $dc ?>"/>
    </div>
    <div class="form-group">
        <label for="txtKei">Kei</label>
        <input type="text" class="form-control" placeholder="Kei" id="txtKei" value="<?php echo $kei ?>"/>
    </div>
    <div class="form-group">
        <label for="txtGift">Gift</label>
        <input type="text" class="form-control" placeholder="Gift" id="txtGift" value="<?php echo $gift ?>"/>
    </div>
    <div class="form-group">
        <label for="txtReferral">Referral</label>
        <input type="text" class="form-control" placeholder="Referral" id="txtReferral" value="<?php echo $referral ?>"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveMarketInfo">Save</button>

    </div>

</form>


<script>




    $('#frmEditMarketInfo').submit(function(e) {

        var id = $('#txtID').val();
        var dept = $('#selDept').val();
        var pool = $('#selPool').val();
        var date = $('#txtDate').val();
        var gross = $('#txtGross').val();
        var dc = $('#txtDC').val();
        var kei = $('#txtKei').val();
        var gift = $('#txtGift').val();
        var referral = $('#txtReferral').val();

        e.preventDefault();
        $.post('main/update_market',{id:id, dept: dept,pool: pool, date: date, gross: gross, dc: dc, kei: kei, gift: gift, referral: referral},function(data){
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
