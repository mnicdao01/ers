

<div class="container-fluid">
    <div class="row">
        <h1>Bank Account Information</h1>
        <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
            <button type="button" class="btn btn-primary" id="btnAddAccInfo">Add</button>
            <button type="button" class="btn btn-info" id="btnEditAccInfo">Edit</button>
            <button type="button" class="btn btn-warning" id="btnDeleteAccInfo">Make Inactive</button>

        </div>
        <table class="table table-striped" id="accountsInfo">
            <thead>
            <tr>
                <th>ID</th>
                <th>Acct Name</th>
                <th>Acct No</th>
<!--                <th>Contact No</th>-->
                <th>Bank</th>
                <th>Department</th>
                <th>Date Updated</th>
                <th>Updated By</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $row){?>
                <tr>
                    <td><?php echo $row->id?></td>
                    <td><?php echo $row->name?></td>
                    <td><?php echo $row->acc_no?></td>
<!--                    <td>--><?php //echo $row->contact_no?><!--</td>-->
                    <td><?php echo $row->bank?></td>
                    <td><?php echo $row->dept?></td>
                    <td><?php echo $row->date_updated?></td>
                    <td><?php echo $row->updated_by ?></td>
                    <td><?php

                        if($row->status == '1'){
                            echo "<button class='btn btn-success'>Active</button>";
                        }
                        else {
                            echo "<button class='btn btn-warning'>Inactive</button>";
                        }


                        ?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
<!--                <td></td>-->
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


        var table = $('#accountsInfo').DataTable();

        $('#accountsInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnDeleteAccInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_account_info', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );


        $('#btnAddAccInfo').on('click', function(data){
            $('#myModal').modal('show');
            $.post('main/add_accounts_info', function(data){
                $('#modal_body').html(data);


            });

        });

        $('#btnEditAccInfo').on('click', function(data){
            var id = table.cell('.selected',0).data();
            var name = table.cell('.selected',1).data();
            var accno= table.cell('.selected',2).data();
            var bank = table.cell('.selected',3).data();
            var dept = table.cell('.selected',4).data();

            $('#myModal').modal('show');
            $.post('main/load_edit_accounts_info',{id:id,name:name,accno:accno,cno:cno,bank:bank,dept:dept}, function(data) {

                $('#modal_body').html(data);

            });


        });
    });
</script>
