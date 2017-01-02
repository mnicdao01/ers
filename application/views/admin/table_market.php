<div class="col-xs-12">
    <hr>
    <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">

        <button type="button" class="btn btn-primary" id="btnAddGBInfo">Add</button>
        <button type="button" class="btn btn-info" id="btnEditGBInfo">Edit</button>
        <button type="button" class="btn btn-danger" id="btnDeleteGBInfo">Delete</button>
        <button type="button" class="btn btn-success" id="btnMarketReport">Toggle Graph</button>

    </div>

</div>
<div id="graph_content_market" class="">
    <div class="row">
        <div class="col-xs-12">
            <div id="line-example"></div>
        </div>
    </div>
</div>
<table class="table table-striped" id="marketGlobalInfo">
    <thead>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Gross</th>
        <th>Discount</th>
        <th>Kei</th>
        <th>Omset Bersih</th>
        <th>Price</th>
        <th>Referral</th>
        <th>Total</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php setlocale(LC_MONETARY, 'en_US'); foreach($results as $row){?>
        <tr>
            <td><?php echo $row->id?></td>
            <td><?php echo $row->date?></td>
            <td><?php echo number_format($row->gross)?></td>
            <td><?php echo number_format($row->dc)?></td>
            <td><?php echo number_format($row->kei)?></td>
            <td><?php echo number_format($row->omset)?></td>
            <td><?php echo number_format($row->gift)?></td>
            <td><?php echo number_format($row->referral)?></td>
            <td><?php echo number_format($row->total)?></td>
            <td><?php if($row->total > 0){
                    echo "<button class='btn btn-success'>WIN</button>";
                }
                else{
                    echo "<button class='btn btn-danger'>LOSE</button>";
                }?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td>Total</td>
        <td><b><?php echo number_format($totals ? $totals[0]->gross:0)?></b></td>
        <td><b><?php echo number_format($totals ? $totals[0]->dc:0)?></td>
        <td><b><?php echo number_format($totals ? $totals[0]->kei:0)?></td>
        <td><b><?php echo number_format($totals ? $totals[0]->omset:0)?></td>
        <td><b><?php echo number_format($totals ? $totals[0]->gift:0)?></td>
        <td><b><?php echo number_format($totals ? $totals[0]->referral:0)?></td>
        <td><b><?php echo number_format($totals ? $totals[0]->total:0)?></td>
        <td><b><?php if(($totals?$totals[0]->total:0) > 0){
                echo "<button class='btn btn-success'><b>WIN</b></button>";
            }else if(($totals?$totals[0]->total:0) == 0) {
                echo "<button class='btn btn-alert'><b>NO DATA</b></button>";
            }else{
                echo "<button class='btn btn-danger'><b>LOSE</b></button>";
            }


            ?></td>
    </tr>
    </tfoot>
</table>
<?php
$resultsJSON = json_encode($results);
?>
<script>

    $(document).ready(function() {
        var table = $('#marketGlobalInfo').DataTable({
            "bSort": false,
            "bPaginate" : false
        });


    $('#marketGlobalInfo tbody').on( 'click', 'tr', function () {

        if ( $(this).hasClass('selected') ) {

            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );




    $('#btnEditGBInfo').on('click', function(data){

        var dept = $('#selDept').val();
        var pool = $('#selPool').val();
        var id = table.cell('.selected',0).data();
        var date = table.cell('.selected',1).data();
        var gross = table.cell('.selected',2).data();
        var dc = table.cell('.selected',3).data();
        var kei = table.cell('.selected',4).data();
        var gift = table.cell('.selected',6).data();
        var referral = table.cell('.selected',7).data();


        $('#myModal').modal('show');
        $.post('main/load_edit_market_info',{id:id,dept: dept,pool: pool, date: date, gross: gross, dc: dc, kei: kei, gift: gift, referral: referral}, function(data){
            $('#modal_body').html(data);


        });
    });
        $('#btnAddGBInfo').on('click', function(){
            var dept = $('#selDept').val();
            var pool = $('#selPool').val();
            var date = $('#myDateAll').val()

            if(dept && pool && date){
                $('#myModal').modal('show');
                $.post('main/add_market_info', function(data){
                    $('#modal_body').html(data);


                });
            }else{
                alertify.error("Please select department, date and pool.")
            }


        });

        $('#btnDeleteGBInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_market_info', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );

        $('#btnMarketReport').click( function () {


        } );
        $('#btnMarketReport').on('click', function(){
            $('#graph_content_market').toggleClass('hidden');
        })

    });
</script>

<script>

    Morris.Line({
        element: 'line-example',
        data: <?php echo $resultsJSON ?>,
        xkey: 'date',
        ykeys: ['gross', 'omset','total'],
        labels: ['Gross', 'Omset', 'Total']
    });
</script>