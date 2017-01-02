
<table border="1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Code</th>
            <th>Description</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Start Diff</th>
            <th>End Diff</th>
            <th>Late</th>
            <th>Undertime</th>
            <th>Deduction</th>

        </tr>
    </thead>
    <tbody>
    <?php
    foreach($summary as $row){
    ?>
    <tr>


        <td><?php echo $row->date?></td>
        <td><?php echo $row->code?></td>
        <td><?php echo $row->dsc?></td>
        <td><?php echo $row->start_time?></td>
        <td><?php echo $row->end_time?></td>
        <td><?php echo $row->timein?></td>
        <td><?php echo $row->timeout?></td>
        <td><?php echo $row->start_diff?></td>
        <td><?php echo $row->end_diff?></td>
        <td><?php echo $row->late?></td>
        <td><?php echo $row->undertime?></td>
        <td>TBA</td>
    </tr>
    <?php
    }
    ?>


    </tbody>
</table>

