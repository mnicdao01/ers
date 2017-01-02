
<form role="form" id="frmAddSInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtEmpId">Employee ID</label>
        <input type="text" class="form-control" placeholder="Employee ID" id="txtEmpId" value="<?php echo $empid?>" disabled="disabled"/>
    </div>
    <div class="form-group">
        <label for="txtFName">First Name</label>
        <input type="text" class="form-control" placeholder="First Name" id="txtFName" value="<?php echo $fname?>" disabled="disabled"/>
    </div>
    <div class="form-group">
        <label for="txtLName">Last Name</label>
        <input type="text" class="form-control" placeholder="Last Name" id="txtFName" value="<?php echo $lname?>" disabled="disabled"></textarea>
    </div>
    <div class="form-group">
        <label for="txtSalary">Salary</label>
        <input type="number" class="form-control" placeholder="Salary" id="txtSalary" value="<?php echo $salary?>"></textarea>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAInfo">Save</button>

    </div>

</form>

<script>
    var table = $('#salaryInfo').DataTable();
    $('#frmAddSInfo').submit(function(e) {
        var empid = $('#txtEmpId').val();
        var salary = $('#txtSalary').val();

        e.preventDefault();
        $.post('main/insert_salary',{empid: empid, salary: salary},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");

                table.cell('.selected',3).data(salary);
                
//                $('#btnSalary').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });



</script>
