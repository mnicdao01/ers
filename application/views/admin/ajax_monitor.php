<div class="container-fluid">
    <div class="row">

        <div class="col-xs-11">
            <h1>Employee Information<small> Manage Employee Information</small></h1>
            <table class="table table-bordered" id="table_employee">
                <thead>
                <tr>
                    <th>ACTIONS</th>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>DEPARTMENT</th>
                    <th>PERM. ADDRESS</th>
                    <th>TEMP. ADDRESS</th>
                    <th>INDO. PHONE</th>
                    <th>WORK PHONE</th>
                    <th>PLACE OF BIRTH</th>
                    <th>BIRTHDAY</th>
                    <th>VISA NO.</th>
                    <th>VISA CREATED</th>
                    <th>VISA EXP</th>
                    <th>JOIN DATE</th>
                    <!--                    <th>EMAIL</th>-->
                    <!--                    <th>EMP ID</th>-->
                </tr>
                </thead>
                <tbody>

<!--                --><?php //foreach($employee as $row){?>
<!--                    <tr value="--><?php //echo $row->id?><!--">-->
<!--                        <td><a href="#" class="edit"><i class="fa fw fa-edit fa-2x"></i></a>  <a href="#" class="delete"><i class="fa fw fa-remove fa-2x"></i></a></td>-->
<!--                        <td class="nr"><span>--><?php //echo $row->id?><!--</span></td>-->
<!--                        <td>--><?php //echo strtoupper($row->fname." ".$row->mname." ".$row->lname)?><!--</td>-->
<!--                        <td>--><?php //echo $row->dept?><!--</td>-->
<!--                        <td>--><?php //echo $row->paddress?><!--</td>-->
<!--                        <td>--><?php //echo $row->taddress?><!--</td>-->
<!--                        <td>--><?php //echo $row->i_cno?><!--</td>-->
<!--                        <td>--><?php //echo $row->w_cno?><!--</td>-->
<!--                        <td>--><?php //echo $row->p_birth?><!--</td>-->
<!--                        <td>--><?php //echo $row->d_birth?><!--</td>-->
<!--                        <td>--><?php //echo $row->visano?><!--</td>-->
<!--                        <td>--><?php //echo $row->c_visa?><!--</td>-->
<!--                        <td>--><?php //echo $row->e_visa?><!--</td>-->
<!--                        <td>--><?php //echo $row->join_date?><!--</td>-->
<!--                        <!--                        <td>-->--><?php ////echo $row->email?><!--<!--</td>-->-->
<!--                        <!--                        <td>-->--><?php ////echo $row->empid?><!--<!--</td>-->-->
<!---->
<!--                    </tr>-->
<!--                --><?php //} ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <button class="btn btn-primary" id="btnAddEmp">Add</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    var base_url = $('#base_url').val();
    $(document).ready( function () {
        $('#btnAddEmp').on('click', function(){

            $('#myModal').modal('show');
            $.post(base_url + 'main/add_emp', function(data){
                $('#modal_body').html(data);

            });

        });

        $('.edit').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text

            // Let's test it out
            $('#myModal').modal('show');
            $.post(base_url + 'main/edit_emp', {id: $text}, function(data){
                $('#modal_body').html(data);
            });
        });

        $('.delete').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text

            // Let's test it out
            $('#myAlert').modal('show');
            $.post(base_url + 'main/delete_emp', {id: $text}, function(data){
                $('#modal_body').html(data);
                $.post(base_url + 'admin/main/load_employee',function(data){
                    $('#body_content').html(data);
                });

            });
        });

        $('#table_employee').dataTable();

    } );
</script>