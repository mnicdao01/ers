
            <h1>Employee Information<small> Manage Employee Information</small></h1>
            <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
                <button type="button" class="btn btn-primary" id="btnAddEmp">Add</button>
                <button type="button" class="btn btn-danger" id="btnDeleteEmp">Delete</button>
                <button type="button" class="btn btn-info" id="btnLoadEmp">Load Employee Information</button>
                <button type="button" class="btn btn-success" id="btnFChangePass">Force Change Password</button>
                <button type="button" class="btn btn-alert" id="btnResigned">Mark as Resigned</button>

            </div>

            <table class="table table-striped" id="table_employee">
                <thead>
                    <tr>

                        <th>ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Length of Stay</th>
                        <th>Visa Remaining Days</th>
                        <th hidden="hidden"></th>
                        <th hidden="hidden"></th>
                        <th>Visa Expiration Date</th>

                    </tr>
                </thead>
                <tbody>

                <?php foreach($employee as $row){?>
                    <tr>
                        <td><?php echo $row->id?></td>
                        <td><?php echo $row->empid?></td>
                        <td><?php echo strtoupper($row->fname." ".$row->mname." ".$row->lname)?></td>
                        <td><?php echo $row->dept?></td>
                        <td><?php
                            echo substr($row->years,0,1)." year/s - ".
                                 substr($row->years,2,1)." month/s"
                            ?></td>
                        <td>
                            <?php
                            $expdays = $row->visa_exp;

                            if($expdays == '' || $expdays == null){
                                echo "<i class='alert-danger'>Visa date not specified in profile. Please update.</i>";
                            }
                            elseif($expdays <= 7 && $expdays >= 0){
                                echo "<b class='alert-warning'>Expiring in <b>".$expdays." day/s</b></b>";

                            }
                            elseif($expdays < 0){
                                echo "<i class='alert-danger'>Expired</i>";
                            }
                            else{
                                echo "<b>".$expdays . "</b> days left";
                            }
//                            echo $row->visa_exp

                            ?>

                        </td>
                        <td><?php
                            echo $row->e_visa
                            ?>
                        </td>
                        <td hidden="hidden">
                            <?php
                            $expdays = $row->visa_exp;

                            if($expdays == '' || $expdays == null){
                                echo "3";
                            }
                            elseif($expdays <= 7 && $expdays >= 0){
                                echo "1";

                            }
                            elseif($expdays < 0){
                                echo "0";
                            }
                            else{
                                echo "2";
                            }
                            //                            echo $row->visa_exp

                            ?>
                        </td>
                        <td hidden="hidden"><?php echo $row->visa_exp?></td>

                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">

                    </td>
                    <td></td>
                    <td hidden="hidden"></td>
                    <td hidden="hidden"></td>
                </tr>
                </tfoot>
            </table>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <div id="more_info"></div>
                    </div>
                </div>
            </div>
<script>

    $(document).ready( function () {

        var table = $('#table_employee').DataTable({

        });

        table
            .order( [ 7, 'asc' ], [8,'asc'])
            .draw();

        $('#table_employee tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#btnAddEmp').on('click', function(){

            $('#myModal').modal('show');
            $.post('main/add_emp', function(data){
                $('#modal_body').html(data);

            });

        });

        $('#btnDeleteEmp').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();
                var uname = table.cell('.selected',1).data();

                table.row('.selected').remove().draw( false );

                $.post('main/delete_emp', {id: id, uname: uname}, function (data){

                    if(data==true){
                        alertify.success("Deleted Successfully");
                    }
                    else {
                        alertify.error("Error in deleting record");
                    }

                })
            });

        } );

        $('#btnLoadEmp').on('click', function(data){
            var empid = table.cell('.selected',1).data();

            $.post('main/load_profile_specific',{empid:empid}, function(data){
                $('#more_info').html(data);


            });

            $('#selDept').removeAttr('disabled')

        });

        $('#btnFChangePass').on('click', function(){
            var empid = table.cell('.selected',1).data();
            $('#myModal').modal('show');
            $.post('main/change_pass_force', {empid: empid},function(data){
                $('#modal_body').html(data);

            });

        });

        $('#btnResigned').click( function () {

            alertify.confirm('Are you sure you want to mark as resign this employee?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();

                table.row('.selected').remove().draw( false );

                $.post('main/mark_resign', {id: id}, function (data){

                    if(data==true){
                        alertify.success("Deleted Successfully");
                    }
                    else {
                        alertify.error("Error in deleting record");
                    }

                })
            });

        } );



    } );
</script>