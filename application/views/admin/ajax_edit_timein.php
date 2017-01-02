
<form role="form" id="frmUpdateTimeIn" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtId">ID</label>
        <input type="text" class="form-control" id="txtID" value="<?php echo $id ?>" disabled/>
    </div>
    <div class="form-group">
        <label for="txtTimein">Time In</label>
        <?php if($timein){?>


            <input type="datetime-local(yyyy-mm-ddTHH:MM)" id="txtTimein" class="form-control" value="<?php echo $timein ?>"/>


        <?php }else{ ?>


            <input type="datetime-local" id="txtTimein1" class="form-control" value="<?php echo $timein ?>"/>


        <?php } ?>
    </div>
    <div class="form-group">
        <label for="txtTimeout">Time Out</label>
        <?php if($timeout){?>


            <input type="datetime-local(yyyy-mm-ddTHH:MM)" id="txtTimeout" value="<?php echo $timeout ?>" class="form-control">


        <?php }else{ ?>

            <input type="datetime-local" id="txtTimeout1" class="form-control"/>
        <?php } ?>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnUpdateBankInfo">Update</button>

    </div>

</form>



<style>
    .datetimepicker{z-index:1151 !important;}
</style>

<script>




    $('#frmUpdateTimeIn').submit(function(e) {
        var id = $('#txtID').val();
        var timein = $('#txtTimein').val();
        var timeout = $('#txtTimeout').val();

        e.preventDefault();
        $.post('main/update_timein_info',{id:id, timein: timein, timeout: timeout},function(data){
            if(data==true){
                $('#myModal').modal('hide');
                alertify.success("Updated successfully");
                $('#btnFilterAttendance').trigger('click');
            } else
            {
                alertify.error("Error saving");
            }
        });
        return false;
    });




</script>
