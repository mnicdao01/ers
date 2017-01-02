<form role="form" id="frmChangePassword">
    <input type="hidden" value="<?php echo $empid ?>" id="empid"/>
    <div class="alert alert-info" aria-hidden="true" id="myAlert"><strong>Please read. </strong>Change to your desired password.</div>
    <div class="control-group">

        <label class="control-label">New Password:</label>
        <div class="controls">
            <input type="password" id="txtNewPass" class="form-control" name="txtNewPass"/>
            <p class="help-block"></p>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Re-type New Password</label>
        <div class="controls">
            <input type="password" id="txtValidPass" name="txtValidPass" class="form-control" data-validation-match-match="txtNewPass"/>
            <p class="help-block"></p>
        </div>
    </div>


</form>

<script>
    $(document).ready(function(){
        $('#btnChangePass').removeAttr('disabled');
        $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );


        $('#btnChangePass').on('click', function() {
            var empid = $('#empid').val();

            var passkey = $('#txtValidPass').val();

            $.post($('#base_url').val() + 'client/update_pass', {empid: empid, passkey: passkey }, function (data){

                $('#myAlert').html("<strong>Change password was successful. </strong>Close this dialog box and login again.");
                $('#btnChangePass').attr('disabled', 'disabled');

            } );
       });
    });

</script>