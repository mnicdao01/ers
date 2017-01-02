<table class="table table-striped" id="salaryReportInfo">
    <thead>
    <tr>

        <th>Employee ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Salary(Rupiah)</th>
        <th>Attendance Deductions</th>
        <th>Grace Period in Mins</th>
        <th>Amount Considered</th>
        <th>Total Salary</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach($results as $row){?>
        <tr>

            <td ><?php echo $row->empid?></td>
            <td><?php echo $row->empid?></td>
            <td><?php echo $row->empid?></td>
            <td><?php echo number_format($row->salary,2,",",".")?></td>
            <td><?php echo "(".number_format($row->total_attendance_deductions,2,",",".").")" ?></td>
            <td><?php echo $row->grace_period ?></td>
            <td><?php echo number_format($row->amount_considered,2,",",".") ?></td>
            <td><?php echo number_format($row->total_salary,2,",",".") ?></td>

        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
    </tfoot>
</table>

<script>

    var table = $('#salaryReportInfo').DataTable({
        "bSort" : false
        "pagination": false
    });

</script>