
<form role="form" id="frmAddDWInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Date" id="txtDate" required="true"/>
    </div>
    <div class="form-group">
        <label for="txtDepo">Deposit</label>
        <input type="number" class="form-control" placeholder="Deposit" id="txtDepo" required="true"/>
    </div>
    <div class="form-group">
        <label for="txtWid">Withdraw</label>
        <input type="number" class="form-control" placeholder="Withdraw" id="txtWid" required="true"/>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveDWInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddDWInfo').submit(function(e) {
        var date= $('#txtDate').val();
        var wid = $('#txtWid').val();
        var depo = $('#txtDepo').val();
        var dept = $('#sel_dept').val();


        e.preventDefault();
        $.post('main/insert_depowid',{date: date, wid: wid, depo: depo, dept:dept},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnFilterDW').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });


</script>
