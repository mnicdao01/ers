
<form role="form" id="frmUpdateWDInfo" enctype="multipart/form-data" method="post">
    <div class="form-group" hidden>
        <label for="txtId">ID</label>
        <input type="text" class="form-control" id="txtID" value="<?php echo $id ?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Date" id="txtDate" value="<?php echo $date ?>" required="true"/>
    </div>
    <div class="form-group">
        <label for="txtDepo">Deposit</label>
        <input type="text" class="form-control" placeholder="Deposit" id="txtDepo" value="<?php echo $depo ?>" required="true"/>
    </div>
    <div class="form-group">
        <label for="txtWid">Withdraw</label>
        <input type="text" class="form-control" placeholder="Withdraw" id="txtWid" value="<?php echo $wid ?>" required="true"/>
    </div>


    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnUpdateWDInfo">Update</button>

    </div>

</form>


<script>




    $('#frmUpdateWDInfo').submit(function(e) {

        var id= $('#txtID').val();
        var date= $('#txtDate').val();
        var wid = $('#txtWid').val();
        var depo = $('#txtDepo').val();

        e.preventDefault();
        $.post('main/update_depowid',{id:id, date: date, wid: wid, depo: depo},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Updated successfully");
                $('#btnFilterDW').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });


</script>
