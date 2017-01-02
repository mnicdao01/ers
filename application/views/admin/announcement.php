

<div class="container-fluid">
    <div class="row">
        <h1>Announcements</h1>
        <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
            <button type="button" class="btn btn-primary" id="btnAddAInfo">Add</button>
            <button type="button" class="btn btn-info" id="btnEditAInfo">Edit</button>
            <button type="button" class="btn btn-danger" id="btnDeleteAInfo">Delete</button>

        </div>
        <table class="table table-striped" id="announcementInfo">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Updated By</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $row){?>
                <tr>
                    <td ><?php echo $row->id?></td>
                    <td><?php echo $row->title?></td>
                    <td><?php echo $row->dsc?></td>
                    <td><?php echo $row->date?></td>
                    <td><?php echo $row->updated_by?></td>
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


        var table = $('#announcementInfo').DataTable({

        });

        $('#announcementInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnDeleteAInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_announcements', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );


        $('#btnAddAInfo').on('click', function(data){
            $('#myModal').modal('show');
            $.post('main/add_announcement_info', function(data){
                $('#modal_body').html(data);


            });

        });

        $('#btnEditAInfo').on('click', function(data){
            var id = table.cell('.selected',0).data();
            var title = table.cell('.selected',1).data();
            var dsc= table.cell('.selected',2).data();

            $('#myModal').modal('show');
            $.post('main/load_edit_announcements',{id:id,title:title,dsc:dsc}, function(data){
                $('#modal_body').html(data);


            });

        });
    });
</script>
