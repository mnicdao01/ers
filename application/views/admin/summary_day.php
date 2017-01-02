<label>Account Name:</label>
<input type="text" value="<?php echo $name?>" disabled class="form-control">
<label>Account No:</label>
<input type="text" value="<?php echo $accno?>" disabled class="form-control" id="txtWdDailyAccNo">
<hr>
<h4>Summary per Day</h4>
<table class="table table-striped" id="wdDaily">
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

<?php
    if($date == date("Y-m-d") || $level == 1 || $level == 3){
        echo "<button id='btnWdDaily' class='btn btn-primary'>Edit</button>";
    }
else {
    echo "<button id='btnWdDaily' class='btn btn-primary' disabled>Edit</button>";
}
?>

<script>
    var table = $('#wdDaily').DataTable();
    $('#wdDaily tbody').on( 'click', 'tr', function () {

        if ( $(this).hasClass('selected') ) {

            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

    $('#btnWdDaily').on('click', function(data){

        var amount = table.cell('.selected',0).data();
        var id = table.cell('.selected',4).data();
        var accno = $('#txtWdDailyAccNo').val();


        var newValue = prompt('Enter new amount');

        $.post('main/update_wd_info',{id:id,accno:accno,amount:newValue}, function(data){
            if(data == true){
            table.cell('.selected',0).data(newValue);
            table.cell('.selected',3).data('<?php echo $this->session->userdata('username'); ?>');
            alertify.success("Successfully updated!");

                $('#btnRefresh').trigger('click');

            }
            else {
                alertify.success("Error on saving.");

            }
        });

    });
</script>




