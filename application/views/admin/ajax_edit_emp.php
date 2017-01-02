<form role="form" id="frmEditEmployee" enctype="multipart/form-data" method="post" xmlns="http://www.w3.org/1999/html">
    <input type="hidden" name="id" value="<?php foreach($result as $row){echo $row->id;}?>"/>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" placeholder="Email" name="email" value="<?php foreach($result as $row){echo $row->email;}?>"/>

    </div>
    <div class="form-group">
        <label for="empid">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="empid" value="<?php foreach($result as $row){echo $row->empid;}?>"/>

    </div>
    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" placeholder="First Name" name="fname" value="<?php foreach($result as $row){echo $row->fname;}?>"/>

    </div>
    <div class="form-group">
        <label for="mname">Middle Name</label>
        <input type="text" class="form-control" placeholder="Middle Name" name="mname" value="<?php foreach($result as $row){echo $row->mname;}?>"/>
    </div>
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?php foreach($result as $row){echo $row->lname;}?>"/>
    </div>
    <div class="form-group">
        <label for="dept">Department</label>
        <select class="form-control" name="dept">
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
    <div class="form-group">
        <label for="paddress">Permanent Address</label>
        <textarea class="form-control" placeholder="Permanent Address" name="paddress"><?php foreach($result as $row){echo $row->paddress;}?></textarea>
    </div>
    <div class="form-group">
        <label for="taddress">Temporary Address</label>
        <textarea class="form-control" placeholder="Temporary Address" name="taddress"><?php foreach($result as $row){echo $row->taddress;}?></textarea>
    </div>
    <div class="form-group">
        <label for="i_cno">Indonesia Phone No.</label>
        <input type="text" class="form-control" placeholder="Indonesia Contact No." name="i_cno" value="<?php foreach($result as $row){echo $row->i_cno;}?>"/>
    </div>
    <div class="form-group">
        <label for="w_cno">Work Phone No.</label>
        <input type="text" class="form-control" placeholder="Work Contact No." name="w_cno" value="<?php foreach($result as $row){echo $row->w_cno;}?>"/>
    </div>
    <div class="form-group">
        <label for="p_birth">Place of Birth</label>
        <input type="text" class="form-control" placeholder="Place of Birth" name="p_birth" value="<?php foreach($result as $row){echo $row->p_birth;}?>"/>
    </div>
    <div class="form-group">
        <label for="d_birth">Birthday</label>
        <input type="date" class="form-control" placeholder="Birthday" name="d_birth" value="<?php foreach($result as $row){echo $row->d_birth;}?>"/>
    </div>
    <div class="form-group">
        <label for="visano">Visa Number</label>
        <input type="text" class="form-control" placeholder="Visa Number" name="visano" value="<?php foreach($result as $row){echo $row->visano;}?>"/>
    </div>
    <div class="form-group">
        <label for="c_visa">Visa Created Date</label>
        <input type="date" class="form-control" placeholder="Visa Created Date" name="c_visa" value="<?php foreach($result as $row){echo $row->c_visa;}?>"/>
    </div>
    <div class="form-group">
        <label for="e_visa">Visa Expiration Date</label>
        <input type="date" class="form-control" placeholder="Visa Created Date" name="e_visa" value="<?php foreach($result as $row){echo $row->e_visa;}?>"/>
    </div>
    <div class="form-group">
        <label for="join_date">Join Date</label>
        <input type="date" class="form-control" placeholder="Join Date" name="join_date" value="<?php foreach($result as $row){echo $row->join_date;}?>"/>
    </div>


    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveEmp">Save</button>

    </div>

</form>


<script>



    $(function() {
        var ip = $('#txtIP').val();
        var location = $('#txtLocation').val();


        $('#frmEditEmployee').submit(function(e) {
            var params = $('#frmEditEmployee').serialize();
            e.preventDefault();
            $.post('main/update_emp?'+params,function (data){

                if(data == true){
                    alertify.success("Updated successfully.")
                    $('#myModal').modal('hide');
                    $('#btnEmployee').trigger('click');
                }else{
                    alertify.success("Error in updating.");
                }
            });
            return false;
        });


    });


</script>
