
<form role="form" id="frmIpAddress" enctype="multipart/form-data" method="post">
   <table class="table table-bordered">
       <thead>
        <tr>
            <th>ID</th>
            <th>CODE</th>
            <th>DSC</th>
            <th>TIME IN</th>
            <th>TIME OUT</th>
        </tr>

       </thead>
       <tbody>
       <?php foreach($result as $row){?>
       <tr>
            <td><?php echo $row->id?></td>
            <td><?php echo $row->code?></td>
            <td><?php echo $row->dsc?></td>
            <td><?php echo $row->start_time?></td>
            <td><?php echo $row->end_time?></td>
        </tr>
       <?php }?>
       </tbody>
   </table>


</form>

