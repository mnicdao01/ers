
    <table class="table table-striped" id="myBCASave">
        <thead>
        <tr>
            <th>File Name</th>
            <th>Date Uploaded</th>
            <th>Updated By</th>
            <th></th>



        </tr>
        </thead>
        <tbody>
        <?php foreach($results as $row){?>
            <tr>
                <td><?php echo $row->filename?></td>
                <td><?php echo $row->date_uploaded?></td>
                <td><?php echo $row->updated_by?></td>
                <td><?php


                    if($row->save == 1){
                        echo "<button class='btn btn-success'>Save</button>";
                    }
                    else {
                        echo "<button class='btn btn-danger'>Unsaved</button>";
                    }


                    ?>

                </td>


            </tr>
        <?php }?>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>


        </tr>
        </tfoot>
    </table>

    <button class="btn btn-primary" id="btnLoadBCA">Load</button>
    <button class="btn btn-danger" id="btnDelete">Delete</button>



<script>
    $(document).ready(function(){

        var table = $('#myBCASave').DataTable({
            "bSort": false

        });

        $('#myBCASave tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );


        $('#myBCASave tbody').on( 'click', 'tr', function () {

            var filename = table.cell('.selected',0).data();

            $('#txtFName').val(filename);



        });

        $('#btnLoadBCA').on('click',function () {

           $('#myModal').modal('hide');

            $('#btnProcess').attr('disabled',true)
            $('#btnSubmit').attr('disabled',true)
            $('#selBank').attr('disabled',true);
            $('#txtDate').attr('disabled',true);
            $('#txtFName').attr('disabled',true);
            $('#userfile').attr('disabled',true);
            $('#fileAdmin').attr('disabled',true);

        });

        $('#myModal').on('hidden.bs.modal', function(){
            $('#btnBCARefresh').trigger('click');
        })

        $('#btnDelete').on('click', function(){
            var docno = table.cell('.selected',0).data();

            alertify.confirm('Are you sure you want to delete document no '+docno+'?').set('onok', function(){

                $.post('main/delete_all_save_bca', {docno: docno},function(data){
                    alertify.success('Deleted Succesfully');
                })
            });
        });



    });





</script>