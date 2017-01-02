

<div class="container-fluid">
    <div class="row">
        <h1>Expenses Information</h1>
        <div class="col-xs-3">
            <label for="selDept">Select Department</label>
            <select id="selDept" name="selDept" class="form-control">
                <option value="" selected>- Select the Department -</option>
                <?php foreach($dept as $row){?>
                    <option value="<?php echo $row->dsc?>"><?php echo $row->dsc?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-3">
            <label for="dateAll">Select Year and Month</label>
            <div class='input-group date' id='datetimepicker1' >
                <input type='text' class="form-control" id="myDateAll"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
            </div>
        </div>
        <div class="col-xs-6">

            <button type="button" id="btnFilterExpense" class="btn btn-primary">Filter</button>

        </div>

        <div class="col-xs-12">
            <hr>
            <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
                <button type="button" class="btn btn-primary" id="btnAddExp">Add</button>
                <button type="button" class="btn btn-info" id="btnEditExp">Edit</button>
                <button type="button" class="btn btn-danger" id="btnDeleteExp">Delete</button>

            </div>
        </div>
        <table class="table table-striped" id="expensesInfo">
            <thead>
            <tr>
                <th>ID</th>
                <th>DATE</th>
                <th>AMOUNT</th>
                <th>DEPT</th>
                <th>FROM</th>
                <th>TO</th>
                <th>REMARKS</th>
            </tr>
            </thead>
            <tbody>
<!--            --><?php //foreach($results as $row){?>
<!--                <tr>-->
<!--                    <td >--><?php //echo $row->id?><!--</td>-->
<!--                    <td>--><?php //echo $row->date?><!--</td>-->
<!--                    <td>--><?php //echo number_format($row->amount)?><!--</td>-->
<!--                    <td>--><?php //echo $row->dept?><!--</td>-->
<!--                    <td>--><?php //echo $row->account_from?><!--</td>-->
<!--                    <td>--><?php //echo $row->account_to?><!--</td>-->
<!--                    <td>--><?php //echo $row->remarks?><!--</td>-->
<!--                </tr>-->
<!--            --><?php //} ?>
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
            </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>

    $(document).ready(function(){
        $('#myDateAll').datepicker({
            autoclose: true,
            startDate: new Date(),
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });

        var tableExpenses = $('#expensesInfo').DataTable({
            "serverSide": true,
            "ajax": 'main/json_expenses'
        });

        $('#expensesInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                tableExpenses.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnDeleteExp').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = tableExpenses.cell('.selected',0).data();



                tableExpenses.row('.selected').remove().draw( false );

                $.post('main/delete_expenses', {id: id}, function (data){

                    alertify.success(data);
                    tableExpenses.draw();
                })
            });

        } );


        $('#btnAddExp').on('click', function(data){
            $('#myModal').modal('show');
            $.post('main/add_expenses', function(data){
                $('#modal_body').html(data);

            });

        });

        $('#btnEditExp').on('click', function(data){
            var id = tableExpenses.cell('.selected',0).data();
            var date = tableExpenses.cell('.selected',1).data();
            var amount = tableExpenses.cell('.selected',2).data();
            var from = tableExpenses.cell('.selected',4).data();
            var to = tableExpenses.cell('.selected',5).data();
            var remarks = tableExpenses.cell('.selected',6).data();

            $('#myModal').modal('show');
            $.post('main/load_edit_expenses',{id:id,date:date,amount:amount,from:from, to:to,remarks:remarks}, function(data){
                $('#modal_body').html(data);


            });

        });

//        $('#btnFilterExpense').on('click', function(){
//            var selDept = $('#selDept').val();
//            var date = $('#myDateAll').val();
//
//            tableExpenses.column( 3 ).search(selDept).draw();
//
//        });

//        $('#myModal').on('hidden.bs.modal', function(){
//
//            tableExpenses.draw();
//
//        });


    });
</script>
