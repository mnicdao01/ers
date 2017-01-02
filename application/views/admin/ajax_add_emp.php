
<form role="form" id="frmAddEmployee" enctype="multipart/form-data" method="post">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" placeholder="Email" name="email"/>

    </div>
    <div class="form-group">
        <label for="empid">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="empid"/>

    </div>
    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" placeholder="First Name" name="fname"/>

    </div>
    <div class="form-group">
        <label for="mname">Middle Name</label>
        <input type="text" class="form-control" placeholder="Middle Name" name="mname"/>
    </div>
    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" placeholder="Last Name" name="lname"/>
    </div>
    <div class="form-group">
        <label for="dept">Department</label>
        <select class="form-control" name="dept">
           <?php foreach($dept as $row){?>
            <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
            <?php }?>
        </select>
    </div>
    <div class="form-group">
        <label for="dept">Office</label>
        <select class="form-control" name="office">
            <?php foreach($office as $row){?>
                <option value="<?php echo $row->id?>"><?php echo $row->dsc?></option>
            <?php }?>
        </select>
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

        $('#frmAddEmployee').submit(function(e) {
            var params = $('#frmAddEmployee').serialize();
            e.preventDefault();
            $.post('main/upload_file_emp?'+params,function (data){
                  if(data == true){
                  $('#myModal').modal('hide');

                  alertify.success("Added Successfully");
                    $('#btnEmployee').trigger('click');
                  }
                else{
                      alertify.error("Error adding new employee information");
                  }

            });
            return false;
        });


    });



    $(document).ready(function(){
        $('#btnClose').on('click', function(){

            $.post(base_url + 'admin/main/load_employee',function(data){
                $('#body_content').html(data);
            });
        })
    });
</script>
