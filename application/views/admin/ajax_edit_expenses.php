
<form role="form" id="frmEditExpenses" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtID">ID</label>
        <input type="text" class="form-control" placeholder="ID" id="txtID" value="<?php echo $id ?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Date" id="txtDate" value="<?php echo $date ?>"/>
    </div>
    <div class="form-group">
        <label for="txtAmount">Amount</label>
        <input type="text" class="form-control" placeholder="Amount" id="txtAmount" value="<?php echo $amount ?>"/>
    </div>
    <div class="form-group">
        <label for="txtFrom">From</label>
        <input type="text" class="form-control" placeholder="Account From" id="txtFrom" value="<?php echo $from ?>"/>
    </div>
    <div class="form-group">
        <label for="txtTo">To</label>
        <input type="text" class="form-control" placeholder="Account To" id="txtTo" value="<?php echo $to ?>"/>
    </div>

    <div class="form-group">
        <label for="txtRemarks">Remarks</label>
        <input type="text" class="form-control" placeholder="Remarks" id="txtRemarks" value="<?php echo $remarks ?>"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveExpenses">Save</button>

    </div>

</form>


<script>




    $('#frmEditExpenses').submit(function(e) {
        var id = $('#txtID').val();
        var date = $('#txtDate').val();
        var amount = $('#txtAmount').val();
        var from = $('#txtFrom').val();
        var to = $('#txtTo').val();
        var remarks = $('#txtRemarks').val();


        e.preventDefault();
        $.post('main/update_expenses',{id: id,date: date, amount: amount, from: from, to:to, remarks:remarks},function(data){
            if(data==true){

                alertify.success("Updated successfully");
                $('#myModal').modal('hide');

            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });


</script>
