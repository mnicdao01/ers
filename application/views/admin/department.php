

<div class="container-fluid">
    <div class="row">
        <h1>Department <small>Manage Office and Department</small></h1>
        <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
            <button type="button" class="btn btn-primary" id="btnAddADInfo">Add</button>
            <button type="button" class="btn btn-info" id="btnEditADInfo">Edit</button>
                        <button type="button" class="btn btn-danger" id="btnDeleteADInfo">Delete</button>

        </div>
        <table class="table table-striped" id="departmentInfo">
            <thead>
            <tr>

                <th>ID</th>
                <th>Name</th>
<!--                <th>Office</th>-->
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $row){?>
                <tr>

                    <td ><?php echo $row->id?></td>
                    <td><?php echo $row->dsc?></td>
<!--                    <td>--><?php //echo $row->office?><!--</td>-->

                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
<!--                <td></td>-->

            </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>
    $(document).ready(function(){


        var table = $('#departmentInfo').DataTable({
            "bSort" : false
        });

        $('#departmentInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnDeleteADInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_dept', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );


        $('#btnAddADInfo').on('click', function(data){
            $('#myModal').modal('show');
            $.post('main/add_department_info', function(data){
                $('#modal_body').html(data);


            });

        });

        $('#btnEditADInfo').on('click', function(data){
            var id = table.cell('.selected',0).data();
            var dsc= table.cell('.selected',1).data();

            $('#myModal').modal('show');
            $.post('main/load_edit_dept',{id:id,dsc:dsc}, function(data){
                $('#modal_body').html(data);


            });

        });
    });
</script>
