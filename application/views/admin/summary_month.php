<label>Account Name:</label>
<input type="text" value="<?php echo $name?>" disabled class="form-control">
<label>Account No:</label>
<input type="text" value="<?php echo $accno?>" disabled class="form-control" id="txtWdDailyAccNo">
<hr>
<h4>Summary per Month</h4>
<table class="table table-striped" id="wdMonth">
    <thead>
    <tr>
        <th>Amount (n * 1,000,000)</th>
        <th>Date</th>
        <th>Date Updated</th>
        <th>Updated By</th>
        <th hidden>ID</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach($results as $row){?>
        <tr>
            <td><?php echo $row->amount?></td>
            <td><?php echo $row->date?></td>
            <td><?php echo $row->date_updated?></td>
            <td><?php echo $row->updated_by?></td>
            <td hidden><?php echo $row->id?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td hidden></td>
    </tr>
    </tfoot>
</table>


<script>
    var table = $('#wdMonth').DataTable();


</script>




