
<form role="form" id="frmAddExpenses" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtDate">Date</label>
        <input type="date" class="form-control" placeholder="Date" id="txtDate"/>
    </div>
    <div class="form-group">
        <label for="txtAmount">Amount</label>
        <input type="text" class="form-control" placeholder="Amount" id="txtAmount"/>
    </div>
    <div class="form-group">
        <label for="selDept">Department</label>
        <select name="selDept" id="selDept" class="form-control">
            <option value="">- Select Department -</option>
            <?php foreach($dept as $row){?>

                <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
            <?php }?>
        </select>
    </div>
    <div class="form-group">
        <label for="txtFrom">From</label>
        <input type="text" class="form-control" placeholder="Account From" id="txtFrom"/>
    </div>
    <div class="form-group">
        <label for="txtTo">To</label>
        <input type="text" class="form-control" placeholder="Account To" id="txtTo"/>
    </div>

    <div class="form-group">
        <label for="txtRemarks">Remarks</label>
        <input type="text" class="form-control" placeholder="Remarks" id="txtRemarks"/>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveBankInfo">Save</button>

    </div>

</form>


<script>




    $('#frmAddExpenses').submit(function(e) {
        var date = $('#txtDate').val();
        var amount = $('#txtAmount').val();
        var from = $('#txtFrom').val();
        var to = $('#txtTo').val();
        var department = $('#selDept').val();
        var remarks = $('#txtRemarks').val();

        e.preventDefault();
        $.post('main/insert_expenses',{date: date, amount: amount, from: from, to:to, department:department, remarks:remarks},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");

            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });

</script>
