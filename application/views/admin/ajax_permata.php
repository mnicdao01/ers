<table class="table table-striped" id="tablePERMATA">
    <thead>
    <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>AMOUNT</th>
        <th>STATUS</th>
    </tr>
    </thead>

    <tbody>

    <?php

    foreach($results as $row){?>
        <tr data-id="<?php echo $row->id?>">

            <td><?php echo $row->id;?></td>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->amount;?></td>

            <td><?php
                if($row->status == 0){
                    echo "<button class='btnChangePermata btn btn-danger'>Unmatched</button>";
                }
                elseif($row->status == 1) {
                    echo "<button class='btn btn-info'>Matched</button>";
                }
                elseif($row->status == 2) {
                    echo "<button class='btn btn-alert'>Provisioned</button>";
                }


                ?></td>


        </tr>
    <?php }?>
    </tbody>
    <tfoot>
    <tr>
        <td>Total Matched:</td>
        <td>Total Unmatched</td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
<div class="modal fade" id="myMatchPermata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <form id="loginForm">

                    <div class="form-group" style="margin:10px; padding: 10px;">
                        <label for="description">Description</label>
                        <textarea id="description_permata" class="form-control" placeholder="You description here..."></textarea>

                        <button class="btn btn-primary" id="btnPermataupdate">Match</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
<script>
    $(document).ready(function(){

        $('.btnChangePermata').on('click', function(){
            $('#description_permata').val('');
            var id = $(event.target).closest('tr').data('id');
            var $row = $(event.target).closest("tr");

            $('#myMatchPermata').modal('toggle');
            $('#btnPermataupdate').on('click', function() {

                var fname = $('#txtFName').val();
                var dsc = $('#description_permata').val();

                $.post('main/match_permata',{id: id, dsc: dsc, fname: fname},function(data){

                    $('#myMatchPermata').modal('hide');
                    // Find the row
                    $row.find(".btnChangePermata").attr('class','btnChangePermata btn btn-info');
                    $row.find(".btnChangePermata").html('Matched');


                });

            });


        });

        $('#tablePERMATA').dataTable();
    });

</script>