
<form role="form" id="frmIpAddress" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="txtIP">IP Address</label>
        <input type="text" class="form-control" placeholder="IP Address" id="txtIP"/>
    </div>
    <div class="form-group">
        <label for="txtLocation">Location / Office Name</label>
        <input type="text" class="form-control" placeholder="Location" id="txtLocation"/>
    </div>
    <div class="form-group">
        <label for="fileUpload">Logo</label>
        <input type="file" name="fileToUpload" id="fileToUpload" size="20" lass="form-control"/>
        <span>
<!--        <button type="submit" class="btn btn-info">Upload</button>-->
</span>
    </div>
    <div id="files"></div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSave">Save</button>

    </div>

</form>


<script>



    $(function() {
        var ip = $('#txtIP').val();
        var location = $('#txtLocation').val();
        $('#frmIpAddress').submit(function(e) {
            e.preventDefault();
            $.ajaxFileUpload({
                url             :base_url + 'admin/main/upload_file',
                secureuri       :false,
                fileElementId   :'fileToUpload',
                dataType: 'JSON',
                data: {ip: $('#txtIP').val(), location: $('#txtLocation').val()},
                success : function (data)
                {

                    $('#files').html(data);

                }
            });
            return false;
        });

    });



    $(document).ready(function(){
        $('#btnClose').on('click', function(){
            alert();
            $.post(base_url + 'admin/main/load_dashboard',function(data){
                $('#body_content').html(data);
            });
        })
    });
</script>
