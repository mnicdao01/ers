<p><hr></p>
<h4>List of Accounts</h4>
<div class="col-xs-12">
    <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
        <button type="button" class="btn btn-primary" id="btnAddWdInfo">Add WD</button>

    </div>
    <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
        <button type="button" class="btn btn-info" id="btnDaily">Summary per Day</button>
        <button type="button" class="btn btn-info" id="btnMonth">Summary per Month</button>
        <button type="button" class="btn btn-info" id="btnYear">Summary per Year</button>
        <!--        <button type="button" class="btn btn-danger" id="btnDeleteWdInfo">Delete</button>-->

    </div>
    <table class="table table-striped" id="wdInfo">
        <thead>
            <tr>
                <th>ID</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Total WD Year (n * 1,000,000)</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if($results) {
            foreach ($results as $row) {
                ?>
                <tr>
                    <td><?php echo $row->id ?></td>
                    <td><?php echo $row->name ?></td>
                    <td><?php echo $row->acc_no ?></td>
                    <td><?php echo $row->total_year ?></td>

                </tr>
            <?php
            }
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total per year</strong></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function(){

        var table = $('#wdInfo').DataTable();

        $('#wdInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnAddWdInfo').on('click', function(data){

            var id = table.cell('.selected',0).data();
            var name = table.cell('.selected',1).data();
            var accno= table.cell('.selected',2).data();

            $('#myModal').modal('show');

            $.post('main/load_add_wd_info',{id:id,name:name,accno:accno}, function(data){
                $('#modal_body').html(data);
            });

        });

        $('#btnDaily').on('click', function(){
            var bank = $('#sel_bank').val();
            var dept = $('#sel_dept').val();

            var id = table.cell('.selected',0).data();
            var name = table.cell('.selected',1).data();
            var accno= table.cell('.selected',2).data();

            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();

            if(year && month && day){
                if(name){
                    $('#myModal').modal('show');

                    $.post('main/get_daily', {id:id,name:name,accno:accno,year:year,month:month,day:day}, function(data){
                        $('#modal_body').html(data);
                    });
                }
                else
                {
                    $('#myModal').modal('show');
                    $.post('main/get_daily_all', {bank:bank, dept:dept,year:year,month:month,day:day}, function(data){
                        $('#modal_body').html(data);
                    });
                }
            }
            else {
                alertify.error('Please select specific date.')
            }

        });
        $('#btnMonth').on('click', function(){
            var bank = $('#sel_bank').val();
            var dept = $('#sel_dept').val();

            var id = table.cell('.selected',0).data();
            var name = table.cell('.selected',1).data();
            var accno= table.cell('.selected',2).data();

            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();

            if(year && month && day){
                if(name){
                    $('#myModal').modal('show');

                    $.post('main/get_month', {id:id,name:name,accno:accno,year:year,month:month,day:day}, function(data){
                        $('#modal_body').html(data);
                    });
                }
                else
                {
                    $('#myModal').modal('show');
                    $.post('main/get_month_all', {bank:bank, dept:dept,year:year,month:month,day:day}, function(data){
                        $('#modal_body').html(data);
                    });
                }
            }
            else {
                alertify.error('Please select specific date.')
            }

        });

        $('#btnYear').on('click', function(){
            var bank = $('#sel_bank').val();
            var dept = $('#sel_dept').val();
            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();
            if(bank && dept){
                if(bank){
                    $('#myModal').modal('show');

                    $.post('main/get_year_all', {bank:bank,dept:dept,year:year,month:month,day:day}, function(data){
                        $('#modal_body').html(data);
                    });
                }
                else
                {
                    alertify.error("No data to show.");
                }
            }
            else {
                alertify.error('Please select bank and department.')
            }

        });

        var column = table.column( 3 );

        console.log(column);
        if(column){
            $( column.footer() ).html('<strong>'+
            column.data().reduce( function (a,b) {
                a = parseInt(a || 0);
                b = parseInt(b || 0);

                return a+b;
            } )
            +'</strong>');
        }
    });





</script>