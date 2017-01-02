

<div class="container-fluid">
    <div class="row">
        <h1>Bank Information</h1>
        <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
            <button type="button" class="btn btn-primary" id="btnAddBankInfo">Add</button>
            <button type="button" class="btn btn-info" id="btnEditBankInfo">Edit</button>
            <button type="button" class="btn btn-danger" id="btnDeleteBankInfo">Delete</button>

        </div>
        <table class="table table-striped" id="bankInfo">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bank Code</th>
                    <th>Bank Name</th>
                    <th>Contact Number</th>
                    <th>Date Updated</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($results as $row){?>
                <tr>
                    <td ><?php echo $row->id?></td>
                    <td><?php echo $row->bank_name?></td>
                    <td><?php echo $row->dsc?></td>
                    <td><?php echo $row->contact_no?></td>
                    <td><?php echo $row->date_updated?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>
    $(document).ready(function(){


        var table = $('#bankInfo').DataTable({

        });

        $('#bankInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnDeleteBankInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_bank_info', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );


        $('#btnAddBankInfo').on('click', function(data){
            $('#myModal').modal('show');
            $.post('main/add_bank_info', function(data){
                $('#modal_body').html(data);


            });

        });

        $('#btnEditBankInfo').on('click', function(data){
            var id = table.cell('.selected',0).data();
            var code = table.cell('.selected',1).data();
            var dsc= table.cell('.selected',2).data();
            var cno = table.cell('.selected',3).data();

            $('#myModal').modal('show');
            $.post('main/load_edit_bank_info',{id:id,code:code,dsc:dsc,cno:cno}, function(data){
                $('#modal_body').html(data);


            });

        });
    });
</script>
