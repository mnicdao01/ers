

<h1>MANDIRI<small> Compare MANDIRI Bank and Admin</small></h1>


<form enctype="multipart/form-data" id="frmUploadBankMANDIRI" action="main/do_upload" method="post">
    <hr>
    <div class="col-xs-2">
        <label for="fileName">Date:</label>
        <input type='date' name='txtDate' class="form-control" id="txtDate" placeholder="Date"/>
    </div>
    <div class="form-group">
        <label for="fileName">Actions:</label>
        <br>
        <button class="btn btn-primary" id="generateID">Generate ID</button>
        <button class="btn btn-primary" id="btnSearchMandiri">Search</button>
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
        <!--<input type="submit" name='btnBankMANDIRI' class="btn btn-primary" id="btnBankMANDIRI" value="Upload Bank CSV"/>-->
</form>
</div>
<div class="col-xs-6">
    <form enctype="multipart/form-data" id="frmUploadAdminMANDIRI" action="main/do_upload2" method="post">
        <input type="hidden" value="" name="txtFName" id="hid_txtFName"/>
        <label for="fileAdmin">Admin CSV</label>
        <input type='file' name='userfile' size='200' class="form-control" id="fileAdmin" placeholder="MANDIRI Bank CSV"/>

        <br/>
        <!--    <input type="submit" name='btnAdminMANDIRI' class="btn btn-primary" id="btnAdminMANDIRI" value="Upload Admin"/>-->
    </form></div>
<button id="btnSubmit" class="btn btn-primary">Upload</button>
<button id="btnProcess" class="btn btn-info">Process</button>
<button id="btnRefreshMandiri" class="btn btn-success">Refresh</button>


<div class="row">
    <div class="col-xs-12">
        <h3>List</h3>
        <hr>
        <div id="content_mandiri"></div>
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
        var filename;

        $("#frmUploadBankMANDIRI").submit(function(e)
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

//    $("#frmUploadBankMANDIRI").submit(); //Submit  the FORM

        $("#frmUploadAdminMANDIRI").submit(function(e)
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
                $("#frmUploadBankMANDIRI").submit();
                $("#frmUploadAdminMANDIRI").submit();

            }
            else
            {
                alertify.alert("Please fill all required data fields");
            }
        })

//        $('#txtFName').val("MANDIRI"+(new Date()).getTime().toString());

//    $("#frmUploadAdminMANDIRI").submit(); //Submit  the FORM

    });

    $(document).ready(function(){
        $('#btnProcess').on('click', function (){
            var fname = $('#txtFName').val();

//           $.post('admin/main/process_bca',{fname: fname}, function(data){
//                alertify.message("Please wait...");
//               $('#content_bca').html(data);
//           });

            $.ajax({
                url: 'main/process_mandiri',
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
                    $('#content_mandiri').html(result);;
                }
            });
        })

        $('#btnRefreshMandiri').on('click', function(){
            var fname = $('#txtFName').val();
            $.post('main/refresh_mandiri',{fname:fname},function(data){
                $('#content_mandiri').html(data);
            })
        });

        $('#btnSearchMandiri').on('click', function(){

            var date = $('#txtDate').val();
            $('#myModal').modal('show');
            $.post('main/load_search_save_mandiri', {bank: 'MANDIRI', date:date}, function (data){

                $('#modal_body').html(data);
                $('#btnProcess').attr('disabled',true)
                $('#btnSubmit').attr('disabled',true)
            })
        });

        $(document).ready(function () {
            $('#generateID').on('click', function(){
                $('#btnProcess').attr('disabled',false)
                $('#btnSubmit').attr('disabled',false)
                if($('#txtDate').val()){
                    $('#txtFName').val("MANDIRI"+(new Date()).getTime());
                    $('#btnSubmit').removeProp('disabled');
                    $('#btnRefresh').removeProp('disabled');
                }
                else {
                    alertify.error('Please select date.');
                }
                $('#btnRefresh').trigger('click');
            });

            $('#btnSearch').on('click', function(){

                var date = $('#txtDate').val();
                $('#myModal').modal('show');
                $.post('main/load_search_save_bca', {bank: 'BCA', date:date}, function (data){

                    $('#modal_body').html(data);
                    $('#btnProcess').attr('disabled',true)
                    $('#btnSubmit').attr('disabled',true)
                })
            });

        });

        $('#btnSearch').on('click', function(){

            var date = $('#txtDate').val();
            $('#myModal').modal('show');
            $.post('main/load_search_save_bca', {bank: 'BCA', date:date}, function (data){

                $('#modal_body').html(data);
                $('#btnProcess').attr('disabled',true)
                $('#btnSubmit').attr('disabled',true)
            })
        });


    });
</script>




