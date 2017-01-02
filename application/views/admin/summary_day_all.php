<!--<label>Bank Name:</label>-->
<!--<input type="text" value="--><?php //echo $bank?><!--" disabled class="form-control">-->
<!--<label>Department:</label>-->
<!--<input type="text" value="--><?php //echo $dept?><!--" disabled class="form-control">-->
<!--<hr>-->
<h4>Summary per Day</h4>
<table class="table table-striped" id="wdDailyAll">
    <thead>
    <tr>
        <td>Bank: <strong><?php echo $bank?></strong></td>
        <td>Department: <strong><?php echo $dept?></strong></td>
        <td colspan="2">Date: <strong><?php echo $date?></strong></td>
    </tr>
    <tr>
        <th>Name</th>
        <th>Acct No.</th>
        <th>Amount (n * 1,000,000)</th>
        <th>Real Amount</th>


    </tr>
    </thead>
    <tbody>
    <?php
    $name = null;
    foreach($results as $row)
    {?>
        <tr>

            <?php


                if($name != $row->name){
                    echo "<td>$row->name</td>";
                    echo "<td>$row->acc_no</td>";
                    echo "<td>$row->amount</td>";
                    echo "<td>$row->x_real</td>";
                    $name = $row->name;
                } else {
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>$row->amount</td>";
                    echo "<td>$row->x_real</td>";
//                    $name = $row->name;
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

        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>

<script>
    var table = $('#wdDailyAll').DataTable({
        bSort: false,
        searching: false,
        paging : false

    });
    var column = table.column( 2 );

    $( column.footer() ).html('<strong>'+
        column.data().reduce( function (a,b) {
            a = parseInt(a);
            b = parseInt(b);
            return a+b;
        } )
    +'</strong>');
    var column2 = table.column( 3 );

    $( column2.footer() ).html('<strong>'+
        column2.data().reduce( function (a,b) {
            a = parseInt(a);
            b = parseInt(b);
            return a+b;
        } )
    +'</strong>');
</script>
