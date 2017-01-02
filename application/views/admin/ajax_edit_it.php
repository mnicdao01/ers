
<form role="form" id="frmEditAInfo" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtID">ID</label>
        <input type="text" class="form-control" placeholder="ID" id="txtID" disabled value="<?php echo $id ?>"/>
    </div>
    <div class="form-group">
        <label for="txtTitle">Title</label>
        <input type="text" class="form-control" placeholder="Title" id="txtTitle" value="<?php echo $title ?>"/>
    </div>

    <div class="form-group">
        <label for="txtDsc">Action/Troubleshooting/Remarks</label>
        <textarea class="form-control" placeholder="" id="txtDscFixed" disabled rows="20"><?php echo $dsc ?></textarea>
        <textarea class="form-control" placeholder="Action/Troubleshooting/Remarks" id="txtDsc" required="true"></textarea>
    </div>


    <select class="form-control" name="selStatus" id="selStatus">
        <?php


        if($status = 'Fixed') {
            echo "<option value='Fixed' selected>Fixed</option>";
            echo "<option value='For Continuation' >For Continuation</option>";
            echo "<option value='For Checking'>For Checking</option>";

        }
        elseif($status = 'For Continuation'){
            echo " <option value='Fixed' >Fixed</option>";
            echo " <option value='For Continuation' selected>For Continuation</option>";
            echo " <option value='For Checking'>For Checking</option>";

        }
        elseif($status = 'For Checking'){
            echo "<option value='Fixed' >Fixed</option>";
            echo "<option value='For Continuation' >For Continuation</option>";
            echo "<option value='For Checking' selected>For Checking</option>";
        }
        else { ?>
            <option value='Fixed' >Fixed</option>
            <option value='For Continuation' >For Continuation</option>
            <option value='For Checking'>For Checking</option>
        <?php
        }

        ?>




    </select>


    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAInfo">Save</button>

    </div>

</form>
<?php //echo $status?>

<script>
    var urlRun = "http://admin-sfx.com/ers/admin/main";
    var d = new Date();
    var empid = $('#empid').val();

        $('#frmEditAInfo').submit(function(e) {
        var id = $('#txtID').val();
        var title = $('#txtTitle').val();
        var dsc = d + "\n" + $('#txtDsc').val() + " by: " + empid + "\n\n" + $('#txtDscFixed').val();
        var status = $('#selStatus').val();
        var message = $('#empid').val() + ": " +  $('#txtDsc').val();

        e.preventDefault();
        $.post('main/update_it_info',{id:id,title: title, dsc: dsc, status: status},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Save successfully");
                $('#btnIT').trigger('click');
                
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });



</script>
