<div class="container-fluid">
    <div class="row">

        <div class="col-xs-12">
            <h1>User Accounts<small> Manage User Accounts</small></h1>

            <table class="table table-bordered" id="table_users">

                <thead>

                <tr>

                    <th>ID</th>
                    <th>USERNAME</th>
                    <th>USERNAME</th>
                    <th>FULL NAME</th>
                    <th>RIGHTS</th>

                </tr>
                </thead>
                <tbody>

                <?php foreach($users as $row){?>
                    <tr value="<?php echo $row->ID?>">

                        <td class="nr"><span><?php echo $row->ID?></span></td>
                        <td><?php echo $row->EMP_NO?></td>
                        <td><?php echo $row->USERNAME?></td>
                        <td><?php echo strtoupper($row->FNAME." ".$row->LNAME)?></td>
                        <td><?php

                            if($row->RIGHTS==0){
                                echo "<button class='btn btn-primary'>Member</button>";
                            }
                            elseif($row->RIGHTS=='1'){
                                echo "<button class='btn btn-success'>Administrator</button>";
                            }
                            elseif($row->RIGHTS=='2'){
                                echo "<button class='btn btn-info'>Supervisor</button>";
                            }
                            elseif($row->RIGHTS=='3'){
                                echo "<button class='btn btn-info'>Head Finance</button>";
                            }
                            elseif($row->RIGHTS=='4'){
                                echo "<button class='btn btn-info'>Finance Staff</button>";
                            }


                            ?></td>

                    </tr>
                <?php } ?>
                </tbody>


            </table>

        </div>
    </div>
</div>

<script>
    var base_url = $('#base_url').val();
    $(document).ready( function () {
        $('#btnAddUsers').on('click', function(){

            $('#myModal').modal('show');
            $.post(base_url + 'main/add_users', function(data){
                $('#modal_body').html(data);

            });

        });

        $('.edit').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text
            alert($text);
            // Let's test it out
            $('#myModal').modal('show');
            $.post(base_url + 'main/edit_users', {id: $text}, function(data){
                $('#modal_body').html(data);
            });
        });

        $('.delete').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text

            // Let's test it out
            var ans = alertify.confirm("Remove this user?").set('onok',  function(closeEvent){
                $.post('main/delete_users', {id: $text}, function(data){

                    $.post('main/load_users',function(data){
                        $('#body_content').html(data);
                    });
                    alertify.success(data);

                });

            });


        });

        $('.admin').on('click', function(){

            var $row = $(this).closest("tr");    // Find the row
            var id = $row.find(".nr").text(); // Find the text
            var ans = alertify.confirm("<strong>I understand the risk.</strong> Are you sure you want to make this user as Administrator?").set('onok',  function(closeEvent){
                $.post('main/make_admin', {id: id}, function(data){
                    $('.alertify .ajs-header').html('App Message');
                    $.post('main/load_users',function(data){
                        $('#body_content').html(data);
                    });
                    alertify.success(data);
                })

            });

        });

        $('.supervisor').on('click', function(){

            var $row = $(this).closest("tr");    // Find the row
            var id = $row.find(".nr").text(); // Find the text
            var ans = alertify.confirm("<strong>I understand the risk.</strong> Are you sure you want to make this user as <strong>Supervisor</strong>?").set('onok',  function(closeEvent){
                $.post('main/make_supervisor', {id: id}, function(data){
                    $('.alertify .ajs-header').html('App Message');
                    $.post('main/load_users',function(data){
                        $('#body_content').html(data);
                    });
                    alertify.success(data);
                })

            });

        });

        $('#table_users').dataTable();
    } );
</script>