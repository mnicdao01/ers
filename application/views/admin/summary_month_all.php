<!--<label>Bank Name:</label>-->
<!--<input type="text" value="--><?php //echo $bank?><!--" disabled class="form-control">-->
<!--<label>Department:</label>-->
<!--<input type="text" value="--><?php //echo $dept?><!--" disabled class="form-control">-->
<!--<hr>-->
<h4>Summary per Month</h4>
<table class="table table-striped" id="wdMonthAll">
    <thead>
    <tr>
        <td>Bank: <strong><?php echo $bank?></strong></td>
        <td>Department: <strong><?php echo $dept?></strong></td>
        <td colspan="4">For the month of: <strong><?php echo $month[0]->month?></strong></td>
    </tr>
    <tr>
        <th width="5">Approve</th>
        <th hidden>ID</th>
        <th>Date WD</th>
        <th>Name</th>
        <th>Acct No.</th>
        <th>Amount (n * 1,000,000)</th>
        <th>Real Amount</th>



    </tr>
    </thead>
    <tbody>
    <?php
    $date = null;
    foreach($results as $row)
    {?>
        <tr>

            <?php


            if($date != $row->date){
                if($row->status == 'Approved') {
                    echo "<td><div class='alert-success'><center>Approved</center></div></td>";
                }else{
                    echo "<td><div class='alert-warning'><center>Unapproved</center></div></td>";
                }
                echo "<td hidden>$row->id</td>";
                echo "<td>$row->date</td>";
                echo "<td>$row->name</td>";
                echo "<td>$row->acc_no</td>";
                echo "<td>".number_format($row->amount)."</td>";
                echo "<td>".number_format($row->x_real)."</td>";

                $date = $row->date;
            } else {
                if($row->status == 'Approved') {
                    echo "<td><div class='alert-success'><center>Approved</center></div></td>";
                }else{
                    echo "<td><div class='alert-warning'><center>Unapproved</center></div></td>";
                }
                echo "<td hidden>$row->id</td>";
                echo "<td></td>";
                echo "<td>$row->name</td>";
                echo "<td>$row->acc_no</td>";
                echo "<td>".number_format($row->amount)."</td>";
                echo "<td>".number_format($row->x_real)."</td>";
//                      $date = $row->date;
            }

            ?>

            <!--            <td>--><?php //echo $row->name?><!--</td>-->
            <!--            <td>--><?php //echo $row->acc_no?><!--</td>-->
            <!--            <td>--><?php //echo $row->amount?><!--</td>-->

        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td><strong>Total</strong></td>

        <td hidden></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>

</table>
<div class="form-group">
<button type="button" class="btn btn-primary" id="btnApprove">Approve</button>
</div>


<script>
    var level = '<?php echo $level?>';
    $('#btnApprove').hide();
    if(level == 3){
        $('#btnApprove').show();
    }
    var table = $('#wdMonthAll').DataTable({
        bSort: false,
        searching: false,
        paging : false

    });
    var column = table.column( 5 );

    $( column.footer() ).html('<strong>'+
    column.data().reduce( function (a,b) {
        a = parseInt(a);
        b = parseInt(b);
        return a+b;
    } )
    +'</strong>');
    var column2 = table.column( 6 );

    $( column2.footer() ).html('<strong>'+
    column2.data().reduce( function (a,b) {
        a = parseInt(a);
        b = parseInt(b);
        return (a+b);
    } )
    +',000,000.00</strong>');


    $('#wdMonthAll tbody').on( 'click', 'tr', function () {

            $(this).toggleClass('selected');

    } );


    $('#btnApprove').click( function () {
        var row = table.row();
        var selRowId = row.cells('.selected',1).data();
        var accname = row.cells('.selected',3).data();
        var rowCnt = table.rows('.selected').data().length;
        console.log(accname);
        for(x=0;x<rowCnt;x++){
            var id = selRowId[x];
            var accname2 = accname[x];


            $.ajax({
                url:'main/approve_monthly_wd',
                data:{id:id},
                type: 'POST',
                async: false,
                cache: false,
                timeout: 3000,
                success: function(msg) {
                    if(msg == true){
                    alertify.success("Account name <b>" +accname2 + "</b> was successfully approved.")
                    }
                    else{
                        alertify.error("Error in approving. Please refresh.")
                    }
                },
                error: function(msg){

                        alertify.error("Script Error: Please contact administrator.");

                }

            });


        }

        $('#myModal').modal('hide');




    } );

</script>
