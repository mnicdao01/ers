<table class="table wy-table-responsive" id="login">
    <thead>
    <tr>
        <th>Login Employees</th>
    </tr>
    <tr>
        <th hidden="hidden">ID</th>
        <th>FULL NAME</th>
        <th>TIME IN</th>
        <th>DEPARTMENT</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($results as $row){?>
        <tr>
            <td hidden="hidden"><?php echo $row->ID?></td>
            <td><?php echo strtoupper($row->FULLNAME)?></td>
            <td><?php echo $row->TIMEIN?></td>
            <td><?php echo $row->DEPT?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>