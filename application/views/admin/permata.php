

<h1>PERMATA<small> Compare PERMATA Bank and Admin</small></h1>


<form enctype="multipart/form-data" id="frmUploadBankPERMATA" action="admin/main/do_upload" method="post">
    <div class="col-xs-12">
        <label for="fileName">Filename:</label>

        <input type='text' name='txtFName' size='20' class="form-control" id="txtFName" placeholder="Filename"/>
    </div>
    <div class="col-xs-6">
        <label for="userfile">Bank CSV</label>
        <input type='file' name='userfile' size='20' class="form-control" id="userfile" placeholder="Upload Bank CSV"/>

        <br/>
        <!--<input type="submit" name='btnBankPERMATA' class="btn btn-primary" id="btnBankPERMATA" value="Upload Bank CSV"/>-->
</form>
</div>
<div class="col-xs-6">
    <form enctype="multipart/form-data" id="frmUploadAdminPERMATA" action="admin/main/do_upload2" method="post">
        <input type="hidden" value="" name="txtFName" id="hid_txtFName"/>
        <label for="fileAdmin">Admin CSV</label>
        <input type='file' name='userfile' size='200' class="form-control" id="fileAdmin" placeholder="PERMATA Bank CSV"/>

        <br/>
        <!--    <input type="submit" name='btnAdminPERMATA' class="btn btn-primary" id="btnAdminPERMATA" value="Upload Admin"/>-->
    </form></div>
<button id="btnSubmit" class="btn btn-primary">Upload</button>
<button id="btnProcessPERMATA" class="btn btn-info">Process</button>
<button id="btnRefreshPERMATA" class="btn btn-success">Refresh</button>
<div id="content_PERMATA"></div>

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
        var filename;

        $("#frmUploadBankPERMATA").submit(function(e)
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

//    $("#frmUploadBankPERMATA").submit(); //Submit  the FORM

        $("#frmUploadAdminPERMATA").submit(function(e)
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
            $('#hid_txtFName').attr('value',$('#txtFName').val());
            if(fname && fileBank && fileAdmin){
                $("#frmUploadBankPERMATA").submit();
                $("#frmUploadAdminPERMATA").submit();

            }
            else
            {
                alertify.alert("Please fill all required data fields");
            }
        })

        $('#txtFName').val("PERMATA"+(new Date()).getTime().toString());

//    $("#frmUploadAdminPERMATA").submit(); //Submit  the FORM

    });

    $(document).ready(function(){
        $('#btnProcessPERMATA').on('click', function (){
            var fname = $('#txtFName').val();

//           $.post('admin/main/process_PERMATA',{fname: fname}, function(data){
//                alertify.message("Please wait...");
//               $('#content_PERMATA').html(data);
//           });
//            alert(fname);
            $.ajax({
                url: 'admin/main/process_permata',
                type: 'POST',
                data: {fname: fname},
                cache: false,
                beforeSend: function() {
                    $('#myWaitModal').modal('show');
                },
                complete: function() {
                    $('#myWaitModal').modal('hide');
                },
                success: function (result) {
//                    alert(result);
                    $('#content_PERMATA').html(result);
                }
            });
        })
        $('#btnRefreshPERMATA').on('click', function(){
            var fname = $('#txtFName').val();
            $.post('admin/main/refresh_permata',{fname:fname},function(data){

                $('#content_PERMATA').html(data);
            })
        });

    });
</script>




