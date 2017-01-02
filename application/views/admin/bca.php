

<h1>Bank Comparison Tool<small> All Banks</small></h1>

<form enctype="multipart/form-data" id="frmUploadBankBCA" action="main/do_upload" method="post">
    <hr>
    <div class="col-xs-2">
        <label for="selType">Department:</label>
        <select id="selDept" name="selDept" class="form-control">

                <?php foreach($dept as $row){?>
                    <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                <?php } ?>

        </select>
    </div>
    <div class="col-xs-2">
        <label for="selType">Type:</label>
        <select id="selType" name="selType" class="form-control">
            <option value="Deposit">Deposit</option>
            <option value="Withdrawal">Withdrawal</option>
        </select>
    </div>
    <div class="col-xs-2">
        <label for="selBank">Bank:</label>
        <select id="selBank" name="selBank" class="form-control">
            <?php foreach($bank as $row){?>
                <option value="<?php echo $row->bank_name?>"><?php echo $row->bank_name?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-xs-2">
        <label for="fileName">Date:</label>
        <input type='date' name='txtDate' class="form-control" id="txtDate" placeholder="Date"/>
    </div>
    <div class="form-group">
        <label for="fileName">Actions:</label>
        <br>
        <button class="btn btn-primary" id="btnNew">New</button>
        <button class="btn btn-primary" id="generateID">Generate ID</button>
        <button class="btn btn-primary" id="btnSearch">Load</button>
    </div>
    <hr>
    <div class="col-xs-12">



        <label for="fileName">Filename:</label>
        <input type='text' name='txtFName' size='20' class="form-control" id="txtFName" placeholder="Filename"/>



    </div>
    <div class="col-xs-6">
    <label for="userfile">Bank CSV</label>
<input type='file' name='userfile' size='20' class="form-control" id="userfile" placeholder="Upload Bank CSV"/>

    <br/>
<!--<input type="submit" name='btnBankBCA' class="btn btn-primary" id="btnBankBCA" value="Upload Bank CSV"/>-->
</form>
</div>
<div class="col-xs-6">
<form enctype="multipart/form-data" id="frmUploadAdminBCA" action="main/do_upload2" method="post">
    <input type="hidden" value="" name="txtFName" id="hid_txtFName"/>
    <label for="fileAdmin">Admin CSV</label>
    <input type='file' name='userfile' size='200' class="form-control" id="fileAdmin" placeholder="BCA Bank CSV"/>

    <br/>
<!--    <input type="submit" name='btnAdminBCA' class="btn btn-primary" id="btnAdminBCA" value="Upload Admin"/>-->
</form>
</div>

    <button id="btnSubmit" class="btn btn-primary" disabled>Upload</button>
    <button id="btnProcess" class="btn btn-info" disabled>Process</button>
    <button id="btnBCARefresh" class="btn btn-success">Refresh</button>
    <button class="btn btn-primary" id="btnReport" data-toggle="collapse" data-target="#myCPanel">Report</button>
    <button id="btnOpenPastBCA" class="btn btn-danger" data-toggle="collapse" data-target="#myCPanel">Open Past Unmatched</button>
    <button class="btn btn-info" id="btnAuto">Auto Bank Search: <span><input type="checkbox" checked id="autoSearch" data-size="small"></span></button>




<div class="row">
    <div class="col-xs-12">

        <div id="myCPanel" class="collapse">
            <div class="well-large">
                <div id="past_unmatched">
                    No past unmatched.
                </div>
            </div>
        </div>
        <hr>
        <div id="content_bca"></div>
    </div>

</div>
<div class="modal fade"  id="myWaitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" style="width: 100%">
                        <span class="sr-only">Please Wait...</span>
                    </div>
                </div>
                Please wait...
            </div>

        </div>
    </div>

</div>

<script>
$(document).ready(function(){
    $('#btnProcess').attr('disabled',true)
    $('#btnSubmit').attr('disabled',true)
    $('#btnBCARefresh').attr('disabled',true)
    $('#btnOpenPastBCA').attr('disabled',true)
//    $('#autoSearch').attr('disabled',true)
//    $('#btnAuto').attr('disabled',true)

    $('#selBank').attr('disabled',true);
    $('#txtDate').attr('disabled',true);
    $('#txtFName').attr('disabled',true);
    $('#userfile').attr('disabled',true);
    $('#fileAdmin').attr('disabled',true);

    $("#autoSearch").bootstrapSwitch();
    var filename;
    $('#btnNew').on('click', function(){
        $('#userfile').val('');
        $('#fileAdmin').val('');
        $('#txtFName').val('');
        $('#txtDate').val('');

        $('#btnProcess').attr('disabled',false)
        $('#btnSubmit').attr('disabled',false)

        $('#selBank').attr('disabled',false);
        $('#txtDate').attr('disabled',false);
        $('#txtFName').attr('disabled',false);
        $('#userfile').attr('disabled',false);
        $('#fileAdmin').attr('disabled',false);
    });

    $("#frmUploadBankBCA").submit(function(e)
    {
        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);
        if($('#userfile').val()){
            $.ajax({
                url: formURL,
                type: 'POST',
                data:  formData,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR)
                {

                   alertify.alert(data);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alertify.alert(errorThrown);
                }
            });
        }
        e.preventDefault(); //Prevent Default action.
//        e.unbind();



    });

//    $("#frmUploadBankBCA").submit(); //Submit  the FORM

    $("#frmUploadAdminBCA").submit(function(e)
    {

        $('#hid_txtFName').attr('value',$('#txtFName').val());

        var formObj1 = $(this);
        var formURL1 = formObj1.attr("action");

        var formData1 = new FormData(this);
        if($('#fileAdmin').val()){
            $.ajax({
                url: formURL1,
                type: 'POST',
                data:  formData1,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR)
                {

//                    alertify.alert(data);

                    alertify.alert(data);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alertify.alert(errorThrown);
                }
            });
        }
        e.preventDefault(); //Prevent Default action.
//        e.unbind();
    });

    $('#btnSubmit').on('click', function(){
        var fname = $('#txtFName').val();
        var fileBank = $('#userfile').val();
        var fileAdmin = $('#fileAdmin').val();

        var date = $('#txtDate').val();
        $('#hid_txtFName').attr('value',$('#txtFName').val());

        if(fname && fileBank && fileAdmin){
            $("#frmUploadBankBCA").submit();
            $("#frmUploadAdminBCA").submit();

        }
        else{
            alertify.alert("Please fill all required data fields");
        }
    })




        $('#generateID').on('click', function(){
            $('#userfile').val('');
            $('#fileAdmin').val('');
            var type = $('#selType').val();
            var bank = $('#selBank').val();

            if(type == 'Deposit'){
                type = 'DP';

            }else{
                type = 'WD';
            }
            $('#btnProcess').attr('disabled',false)
            $('#btnSubmit').attr('disabled',false)
            if($('#txtDate').val()){
                $('#txtFName').val(bank+(new Date()).getTime()+type);
                $('#btnSubmit').removeProp('disabled');
                $('#btnBCARefresh').removeProp('disabled');
            }
            else {
                alertify.error('Please select date.');
            }
            $('#btnBCARefresh').trigger('click');
        });

        $('#selBank').on('click', function(){
            $('#txtFName').val('');
        })

        $('#btnSearch').on('click', function(){
            var type = $('#selType').val();
            var bank = $('#selBank').val();
            var date = $('#txtDate').val();
            var dept = $('#selDept').val();
            $('#userfile').val('');
            $('#fileAdmin').val('');
            $('#myModal').modal('show');
            $.post('main/load_search_save_bca', {bank: bank, date:date, type:type, dept:dept}, function (data){

                $('#modal_body').html(data);
                $('#btnOpenPastBCA').attr('disabled',false);
                $('#autoSearch').attr('disabled',false);
                $('#btnAuto').attr('disabled',false);
                $('#btnProcess').attr('disabled',false);
                $('#btnBCARefresh').attr('disabled',false);
            });


        });


    $('#btnProcess').removeProp('disabled');



       $('#btnProcess').on('click', function (){
           var type = $('#selType').val();
           var bank = $('#selBank').val();
           var fname = $('#txtFName').val();
           var dept = $('#selDept').val();



//           $.post('admin/main/process_bca',{fname: fname}, function(data){
//                alertify.message("Please wait...");
//               $('#content_bca').html(data);
//           });

           $.ajax({
               url: 'main/process_bca',
               type: 'POST',
               data: {fname: fname, bank: bank,type:type, dept: dept},
               cache: false,
               beforeSend: function() {
                   $('#myWaitModal').modal('show');
               },
               complete: function() {
                   $('#myWaitModal').modal('hide');
               },
               success: function (result) {
                   $('#content_bca').html(result);
                   $('#btnOpenPastBCA').attr('disabled',false)
                   $('#autoSearch').attr('disabled',false)
                   $('#btnAuto').attr('disabled',false)
               }
           });
       });

        $('#btnBCARefresh').on('click', function(){
            var fname = $('#txtFName').val();
            $.post('main/refresh_bca',{fname:fname},function(data){
                $('#content_bca').html(data);
            })
        })

        $('#btnOpenPastBCA').on('click', function(){
            var fname = $('#txtFName').val();
            var type = $('#selType').val();
            var dept = $('#selDept').val();
            $.post('main/get_bca_past',{fname:fname,type:type,dept:dept}, function(data){

                $('#past_unmatched').html(data);

            })

        })

    $('#btnReport').on('click', function(){
        var fname = $('#txtFName').val();
        var type = $('#selType').val();

        $.post('main/report_bca',{fname:fname,type:type},function(data){
            $('#past_unmatched').html(data);
        })

    });

    });
</script>




