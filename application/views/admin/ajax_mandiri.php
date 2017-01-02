<button id="btnMatch" class="btn btn-danger">Match</button>
<button id="btnDMatch" class="btn btn-warning">Descriptive Match</button>
<button id="btnSaveFile" class="btn btn-primary">Save</button>
<div class="row">

    <div class="col-xs-6">
        <h3>Bank List</h3>
        <hr>
        <table class="table table-striped" id="tableMandiri">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>REMARKS</th>
            </tr>
            </thead>

            <tbody>

            <?php

            foreach($results as $row){?>
                <tr>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->amount;?></td>

                    <td><?php
                        if($row->status == 0){
                            echo "<button class='btn btn-danger'>Unmatched</button>";
                        }
                        elseif($row->status == 1) {
                            echo "<button class='btn btn-info'>Matched</button>";
                        }
                        elseif($row->status == 2) {
                            echo "<button class='btn btn-alert'>Approved</button>";
                        }


                        ?></td>
                    <td><?php echo $row->dsc;?></td>

                </tr>
            <?php }?>
            </tbody>
            <tfoot>
            <tr>
                <td>Total Matched:</td>
                <td>Total Unmatched</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-xs-6">
        <h3>Admin List</h3>
        <hr>
        <table class="table table-striped" id="tableMandiriAdmin">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
                <th>REMARKS</th>
            </tr>
            </thead>

            <tbody>

            <?php

            foreach($resultsAdmin as $row){?>
                <tr>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->amount;?></td>

                    <td><?php
                        if($row->status == 0){
                            echo "<button class='btn btn-danger'>Unmatched</button>";
                        }
                        elseif($row->status == 1) {
                            echo "<button class='btn btn-info'>Matched</button>";
                        }
                        elseif($row->status == 2) {
                            echo "<button class='btn btn-alert'>Approved</button>";
                        }


                        ?></td>
                    <td><?php echo $row->dsc;?></td>


                </tr>
            <?php }?>
            </tbody>
            <tfoot>
            <tr>
                <td>Total Matched:</td>
                <td>Total Unmatched</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal fade" id="myMatchMandiri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <div class="form-group" style="margin:10px; padding: 10px;">
                        <label for="description">Description</label>
                        <textarea id="description_mandiri" class="form-control" placeholder="You description here..."></textarea>

                        <button class="btn btn-primary" id="btnMandiriDMatch">Match</button>
                    </div>


            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){

        var tableBank = $('#tableMandiri').DataTable({
            "bSort": false
        });
        var tableAdmin = $('#tableMandiriAdmin').DataTable({
            "bSort": false
        });

        $('#tableMandiri tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                tableBank.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#tableMandiriAdmin tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                tableAdmin.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('.btnMatchMandiri').on('click', function(){
            $('#description_mandiri').val('');
            var id = $(event.target).closest('tr').data('id');
            var $row = $(event.target).closest("tr");

            $('#myMatchMandiri').modal('toggle');
            $('#btnMandiriDMatch').on('click', function() {

                var fname = $('#txtFName').val();
                var dsc = $('#description_mandiri').val();

                $.post('main/match_mandiri',{id: id, dsc: dsc, fname: fname},function(data){

                    $('#myMatchMandiri').modal('hide');
                    // Find the row
                    $row.find(".btnMatchMandiri").attr('class','btnMatchMandiri btn btn-info');
                    $row.find(".btnMatchMandiri").html('Matched');


                });

            });


        });

        $('#btnMatch').on('click', function(){
            var bankID = tableBank.cell('.selected',0).data();
            var adminID = tableAdmin.cell('.selected',0).data();


            $.post('main/update_mandiri_status_match', {bankID:bankID, adminID:adminID}, function(data){
                alertify.success(data);

                $('#btnRefreshMandiri').trigger('click');
            });

        });

        $('#btnDMatch').on('click', function(){
            var bankID = tableBank.cell('.selected',0).data();

            var adminID = tableAdmin.cell('.selected',0).data();



            if(bankID) {
                $('#myMatchMandiri').modal('show');
            }
            else if(adminID){
                $('#myMatchMandiri').modal('show');
            }
        });

        $('#btnMandiriDMatch').on('click', function(){

            var bankID = tableBank.cell('.selected',0).data();
            var adminID = tableAdmin.cell('.selected',0).data();



            var dsc = $('#description_mandiri').val();
            if(bankID) {

                $.post('main/match_mandiri_bank',{id: bankID, dsc: dsc}, function(data){
                    alertify.success(data);

                    $('#myMatchMandiri').modal('hide');
                });
            }
            else if(adminID){
                $.post('main/match_mandiri_admin',{id: adminID, dsc: dsc}, function(data){
                    alertify.success(data);

                    $('#myMatchMandiri').modal('hide');
                });
            }
        });
        $('#myMatchMandiri').on('hidden.bs.modal', function(){
            $('#btnRefreshMandiri').trigger('click');
        });

        $('#btnSaveFile').on('click', function(){
            var fname = $('#txtFName').val();

            alertify.confirm('Are you sure you want to save?').set('onok', function(){

                $('#btnProcess').attr('disabled',true)
                $('#btnSubmit').attr('disabled',true)


                $.post('main/save_mandiri_final', {fname: fname}, function (data){

                    alertify.success(data);
                })
            });
        });

        $('#tableMANDIRI').dataTable();
    });
</script>