<h1>Profile <small> Any information here are kept confidential. - HRD</small></h1>
<hr>
<h3>Personal Information</h3>
<input type="hidden" value="<?php echo $results[0]->empid?>" id="empidhidden"/>
<form id="frmUpdateProfile" method="post">
    <div class="row">
        <div class="col-xs-3">
            <div class="form-group">
                <label for="txtEmpId">Employee ID</label>
                <input type="text" id="txtEmpId" class="form-control" placeholder="Employee ID" value="<?php echo $results[0]->empid?>" name="empid" readonly/>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="txtEmail">Email Address</label>
                <input type="text" id="txtEmail" class="form-control" placeholder="Email Address" value="<?php echo $results[0]->email?>" name="email"/>
            </div>
        </div>
        <div class="col-xs-3">

            <div class="form-group" aria-disabled="true">
                <label for="selDept">Department</label>
<!--                <input type="text" id="selDeptSpec" class="form-control" placeholder="Department" value="--><?php //echo $dept_get?><!--" name="selDeptSpec" />-->
                <label for="selDept">Department</label>
                <select id="selDept" name="dept" class="form-control" disabled>
                    <?php foreach($dept as $row){

                        if($row->dsc == $dept_get){
                            echo "<option selected='selected' value='$row->dsc'>$row->dsc</option>";
                        }
                        else{
                            echo "<option value='$row->dsc'>$row->dsc</option>";
                        }

                    } ?>
                </select>
            </div>
        </div>

    </div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtFName">First Name</label>
            <input type="text" id="txtFName" class="form-control" placeholder="First Name" value="<?php echo $results[0]->fname?>" name="fname"/>
        </div>

    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtMName">Middle Name</label>
            <input type="text" id="txtMName" class="form-control" placeholder="Middle Name" value="<?php echo $results[0]->mname?>" name="mname"/>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtLName">Last Name</label>
            <input type="text" id="txtLName" class="form-control" placeholder="Last Name" value="<?php echo $results[0]->lname?>" name="lname"/>
        </div>
    </div>
    <div class="col-xs-3" hidden>
        <img src="" alt="My Profile Picture" width="150"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-9">
        <div class="form-group">
            <label for="txtPAdd">Permanent Address</label>
            <textarea id="txtPAdd" placeholder="Permanent Address" class="form-control" name="paddress"><?php echo $results[0]->paddress?></textarea>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="form-group">
            <label for="txtTAdd">Temporary Address</label>
            <textarea id="txtTAdd" placeholder="Temporary Address" class="form-control" name="taddress"><?php echo $results[0]->taddress?></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtICno">Indonesian/Personal Contact Number</label>
            <input type="text" id="txtICno" class="form-control" placeholder="Indonesian Contact Number" value="<?php echo $results[0]->i_cno?>" name="i_cno"/>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtWCno">Work Contact Number</label>
            <input type="text" id="txtWCno" class="form-control" placeholder="Work Contact Number" value="<?php echo $results[0]->w_cno?>" name="w_cno"/>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <label for="txtBDay">Birthday</label>
            <input type="date" id="txtBDay" class="form-control" placeholder="Birthday" value="<?php echo $results[0]->d_birth?>" name="d_birth"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-9">
        <div class="form-group">
            <label for="txtPBirth">Place of Birth</label>
            <textarea id="txtPBirth" placeholder="Place of Birth" class="form-control" name="p_birth"><?php echo $results[0]->p_birth?></textarea>
        </div>
    </div>
</div>
<hr>
<h3>Work and Visa Information</h3>
<div class="row">
    <div class="col-xs-3">
        <div class="form2-group">
            <label for="txtVisaNo">Visa Number</label>
            <input type="text" id="txtVisaNo" placeholder="Visa Number" class="form-control" value="<?php echo $results[0]->visano?>" name="visano">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group">
            <label for="txtVisaCreated">Visa Creation Date</label>
            <input type="date" id="txtVisaCreated" placeholder="Visa Creation Date" class="form-control" value="<?php echo $results[0]->c_visa?>" name="c_visa" >
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group">
            <label for="txtVisaExpired">Visa Expiration Date</label>
            <input type="date" id="txtVisaExpired" placeholder="Visa Expiration Date" class="form-control" value="<?php echo $results[0]->e_visa?>" name="e_visa" >
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group">
            <label for="txtJoinDate">Date of Employment</label>
            <input type="date" id="txtJoinDate" placeholder="Date of Employment" class="form-control" value="<?php echo $results[0]->join_date?>" name="join_date" >
        </div>
    </div>
</div>

    <hr>
    <h3>Bank Account Information (Salary Transfer)<small> Please make sure all information here are correct or your salary will be delayed.</small></h3>
    <div class="row">
        <div class="col-xs-2">
            <div class="form2-group">
                <label for="txtBank">Beneficiary Bank</label>
                <input type="text" id="txtBank" placeholder="Beneficiary Bank" class="form-control" value="<?php echo $results[0]->bank?>" name="bank">
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form2-group">
                <label for="txtBankName">Bank Account Name</label>
                <input type="text" id="txtBankName" placeholder="Bank Account Name" class="form-control" value="<?php echo $results[0]->bank_name?>" name="bank_name">
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label for="txtBankAccNo">Bank Account Number</label>
                <input type="text" id="txtBankAccNo" placeholder="Bank Account Number" class="form-control" value="<?php echo $results[0]->bank_accno?>" name="bank_accno">
            </div>
        </div>
        <div class="col-xs-2">
            <div class="form-group">
                <label for="txtBankAdd">Bank Account Address</label>
                <input type="text" id="txtBankAdd" placeholder="Bank Account Address" class="form-control" value="<?php echo $results[0]->bank_accadd?>" name="bank_accadd">
            </div>
        </div>

    </div>
    <input type="submit" id="btnUpdateProfile" value="Update" class="btn btn-info">
    <input type="button" id="btnLockBankInfo" value="Update bank is disabled until <?php echo $lock_details[0]->until?>" class="btn btn-danger">

</form>


<script>
    var lock_value = "<?php echo $lock_details[0]->lock_value?>";
    if(lock_value == 1){
        $('#btnLockBankInfo').prop('disabled',true);
        $('#txtBank').prop('disabled',true);
        $('#txtBankName').prop('disabled',true);
        $('#txtBankAccNo').prop('disabled',true);
        $('#txtBankAdd').prop('disabled',true);

    }else {
        $('#btnLockBankInfo').val("Lock Bank Details");
    }
    $('#frmUpdateProfile').submit(function(e) {
        var params = $('#frmUpdateProfile').serialize();

        e.preventDefault();
        $.post('main/update_profile?'+params,function(data){
            if(data==true){

                alertify.success("Updated successfully");
                $('#btnLockBankInfo').prop('disabled',true);
                $('#txtBank').prop('disabled',true);
                $('#txtBankName').prop('disabled',true);
                $('#txtBankAccNo').prop('disabled',true);
                $('#txtBankAdd').prop('disabled',true);
                $('#btnLockBankInfo').val("Update bank is disabled until <?php echo $lock_details[0]->until?>");

            } else
            {
                alertify.error("Error saving");
            }
        });
        if(lock_value == 0) {
            $('#btnLockBankInfo').trigger('click');
        }
        return false;
    });



    if(global_level == '1' || global_level == '5'){
        $('#selDept').removeAttr('disabled');
    }

    $('#btnLockBankInfo').on('click', function(){
        var empid = $('#txtEmpId').val();
        $.post('main/lock_bank',{empid:empid}, function(data){
            if(data==true){

                alertify.success("Locked bank info successfully");

            } else
            {
                alertify.error("Error locking");
            }
        });


    })


</script>

