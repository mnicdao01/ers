

<h1>Schedule Templates<small> Manage Scheduling Templates</small></h1>
<div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
    <button type="button" class="btn btn-primary" id="btnAddTempInfo">Add</button>
    <button type="button" class="btn btn-info" id="btnEditTempInfo">Edit</button>
    <button type="button" class="btn btn-danger" id="btnDeleteTempInfo">Delete</button>

</div>
<table class="table table-bordered" id="table_template">
    <thead>
    <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Description</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Department</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($templates as $row){?>
        <tr value="<?php echo $row->id?>">
            <td><?php echo $row->id?></td>
            <td><?php echo $row->code?></td>
            <td><?php echo $row->dsc?></td>
            <td><?php echo $row->start_time?></td>
            <td><?php echo $row->end_time?></td>
            <td><?php echo $row->by_dept?></td>

        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6">
            <button class="btn btn-primary" id="btnAdd">Add</button>
        </td>
    </tr>
    </tfoot>
</table>





<script>

    $(document).ready( function () {

        var table = $('#table_template').DataTable({

        });

        $('#table_template tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );



        $('#btnAddTempInfo').on('click', function(){

            $('#myModal').modal('show');

            $.post('main/load_template', function(data){
                $('#modal_body').html(data);

            });

        });

        $('#btnDeleteTempInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_template', {id: id}, function (data){

                    if(data == true){
                        alertify.success("Successfully deleted!");
                    }
                    else
                    {
                        alertify.error("Error on deleting template");
                    }
                })
            });

        } );

        $('#btnEditTempInfo').on('click', function(data){
            var id = table.cell('.selected',0).data();
            var code = table.cell('.selected',1).data();
            var dsc= table.cell('.selected',2).data();
            var timein = table.cell('.selected',3).data();
            var timeout = table.cell('.selected',4).data();
            var dept = table.cell('.selected',5).data();

            $('#myModal').modal('show');
            $.post('main/edit_template',{id:id,code:code,dsc:dsc,timein:timein,timeout:timeout,dept:dept}, function(data) {

                $('#modal_body').html(data);

            });


        });
//
//        $('.edit').on('click', function(){
//            var $row = $(this).closest("tr");    // Find the row
//            var $text = $row.find(".nr").text(); // Find the text
//
//            // Let's test it out
//            $('#myModal').modal('show');
//            $.post(base_url + 'main/edit_template', {id: $text}, function(data){
//                $('#modal_body').html(data);
//            });
//        });
//
//        $('.delete').on('click', function(){
//            var $row = $(this).closest("tr");    // Find the row
//            var $text = $row.find(".nr").text(); // Find the text
//
//            // Let's test it out
//            $('#myAlert').modal('show');
//            $.post(base_url + 'main/delete_template', {id: $text}, function(data){
//                $('#modal_body').html(data);
//                $.post(base_url + 'main/load_scheduling_template',function(data){
//                    $('#body_content').html(data);
//                });
//
//            });
//        });
//
    } );

</script>