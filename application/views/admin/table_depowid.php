<div class="col-xs-12">
    <hr>
    <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">

        <button type="button" class="btn btn-primary" id="btnAddDWInfo">Add</button>
        <button type="button" class="btn btn-info" id="btnEditDWInfo">Edit</button>
        <button type="button" class="btn btn-danger" id="btnDeleteDWInfo">Delete</button>
        <button type="button" class="btn btn-success" id="btnShowGraph">Toggle Graph</button>

    </div>

</div>
<div id="graph_content" class="">
    <div class="row">
        <div class="col-xs-12">
        <div id="line-example"></div>
        </div>
    </div>
</div>
<table class="table table-striped" id="depowidInfo">
    <thead>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Deposit</th>
        <th>Withdraw</th>
        <th>Total</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach($results as $row){?>
        <tr>
            <td><?php echo $row->id?></td>
            <td><?php echo $row->date?></td>
            <td><?php echo number_format($row->deposit)?></td>
            <td><?php echo number_format($row->withdraw)?></td>
            <td><?php echo number_format($row->total)?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td>Total</td>
        <td></td>
        <td><b><?php echo $total ? number_format($total[0]->deposit): 0?></b></td>
        <td><b><?php echo $total ? number_format($total[0]->withdraw): 0?></b></td>
        <td><b><?php echo $total ? number_format($total[0]->total): 0?></b></td>
    </tr>
    </tfoot>
</table>
<?php
$resultsJSON = json_encode($results);

?>
<script>

    $(document).ready(function() {
        var table = $('#depowidInfo').DataTable({
            "bSort": false,
            "bPaginate" : false
        });


        $('#depowidInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );




        $('#btnEditDWInfo').on('click', function(data){

            var id = table.cell('.selected',0).data();
            var date = table.cell('.selected',1).data();
            var depo = table.cell('.selected',2).data();
            var wid = table.cell('.selected',3).data();


            $('#myModal').modal('show');
            $.post('main/load_edit_depowid',{id:id,date: date, depo: depo, wid: wid}, function(data){
                $('#modal_body').html(data);


            });
        });
        $('#btnAddDWInfo').on('click', function(){

                $('#myModal').modal('show');
                $.post('main/load_add_depowid', function(data) {
                    $('#modal_body').html(data);
                });

        });

        $('#btnDeleteDWInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_depowid', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );

        $('#btnShowGraph').on('click', function(){
            $('#graph_content').toggleClass('hidden');
        })


    });
</script>
<script>

    Morris.Line({
        element: 'line-example',
        data: <?php echo $resultsJSON ?>,
        xkey: 'date',
        ykeys: ['deposit', 'withdraw', 'total'],
        labels: ['Deposit', 'Withdraw', 'Total']
    });
</script>