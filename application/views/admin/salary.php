<div class="container-fluid">
    <div class="row">
        <h1>Finance Head<small> Salary and Deductions</small></h1>
        <div class="col-xs-2">
            <label for="">
                Actions
            </label>
            <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnEditSInfo">Modify Salary</button>
            </div>
        </div>
        <div class="col-xs-3">
            <label for="dept">
                Department
            </label>
        <select class="form-control" id="dept">
            <?php foreach($dept as $row){?>
                <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
            <?php } ?>
        </select>
        </div>
        <table class="table table-striped" id="salaryInfo">
            <thead>
            <tr>


                <th>First Name</th>
                <th>Last Name</th>
                <th>Salary(Rupiah)</th>
                <th>Department</th>
                <th>Bank</th>
                <th>Account Name</th>
                <th>Account No</th>
                <th>Account Address</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $row){?>
                <tr>


                    <td><?php echo strtoupper($row->fname)?></td>
                    <td><?php echo strtoupper($row->lname)?></td>
                    <td><?php echo number_format($row->salary,2,",",".")?></td>
                    <td><?php echo $row->dept?></td>
                    <td><?php echo strtoupper($row->bank)?></td>
                    <td><?php echo strtoupper($row->bank_name)?></td>
                    <td><?php echo strtoupper($row->bank_accno)?></td>
                    <td><?php echo strtoupper($row->bank_accadd)?></td>

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
    </div>

</div>

<script>
    $(document).ready(function(){

        var table = $('#salaryInfo').DataTable({
            "bSort" : false
        });


        $('#salaryInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );


        $('#dept').change(function(){

            var department =  $('#dept').val();
            table.search(department.substring(0,20)).draw();
        });


        $('#btnEditSInfo').on('click', function(data){
            var empid = table.cell('.selected',0).data();
            var fname = table.cell('.selected',1).data();
            var lname= table.cell('.selected',2).data();
            var salary= table.cell('.selected',3).data();


            $('#myModal').modal('show');
            $.post('main/load_edit_salary',{empid:empid,fname:fname,lname:lname,salary:salary}, function(data){
                $('#modal_body').html(data);


            });

        });
    });
</script>
