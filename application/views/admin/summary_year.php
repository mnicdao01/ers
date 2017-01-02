<?php //var_dump($results)?>
<h4>Summary per Year</h4>
<table class="table table-striped" id="wdYear">
    <thead>
    <tr>
        <td>Bank: <strong><?php echo $bank?></strong></td>
        <td>Department: <strong><?php echo $dept?> Year: <strong><?php echo $year?></strong></td>

    </tr>
    <tr>
        <th>Month</th>
        <th>Amount</th>

    </tr>
    </thead>
    <tbody>
    <?php
    foreach($results as $row)
    {?>
        <tr>

                        <td><?php echo $row->month_name?></td>
                        <td><?php echo $row->amount_month?></td>

        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td><strong>Total</strong></td>

        <td></td>
        <td></td>

    </tr>
    </tfoot>
</table>

<!--<script>-->
<!--    var table = $('#wdMonthAll').DataTable({-->
<!--        bSort: false,-->
<!--        searching: false,-->
<!--        paging : false-->
<!---->
<!--    });-->
<!--    var column = table.column( 3 );-->
<!---->
<!--    $( column.footer() ).html('<strong>'+-->
<!--    column.data().reduce( function (a,b) {-->
<!--        a = parseInt(a);-->
<!--        b = parseInt(b);-->
<!--        return a+b;-->
<!--    } )-->
<!--    +'</strong>');-->
<!--    var column2 = table.column( 4 );-->
<!---->
<!--    $( column2.footer() ).html('<strong>'+-->
<!--    column2.data().reduce( function (a,b) {-->
<!--        a = parseInt(a);-->
<!--        b = parseInt(b);-->
<!--        return (a+b);-->
<!--    } )-->
<!--    +',000,000.00</strong>');-->
<!--</script>-->
