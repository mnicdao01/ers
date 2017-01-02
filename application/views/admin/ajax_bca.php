<button id="btnMatch" class="btn btn-warning">Match</button>
<button id="btnDMatch" class="btn btn-primary">Rename / Descriptive Match</button>
<button id="btnDMatchPast" class="btn btn-info">Match to Past Data</button>
<button id="btnUnmatched" class="btn btn-danger">Unmatched</button>
<button id="btnWD" class="btn btn-danger" disabled>Withdrawal</button>
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Mark as <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#" class="btnWD">PB ke rek WD</a></li>
        <li><a href="#" class="btnWD">PB ke rek TP</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#" class="btnWD">PB dr rek DP</a></li>
        <li><a href="#" class="btnWD">PB dr rek TP</a></li>
    </ul>
</div>
<button id="btnSaveFile" class="btn btn-alert">Save</button>

<div class="row">

    <div class="col-xs-6">
        <h3>Bank List</h3>
        <hr>
        <table class="table table-striped" id="tableBCA">
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
                    <td><?php
                        if($row->amount){
                        echo number_format($row->amount);
                        }
                        else{
                            echo $row->amount;
                        }

                        ;?></td>

                    <td><?php
                        if($row->status == 0){
                            echo "<button class='btn btn-danger btn-small'>Unmatched</button>";
                        }
                        elseif($row->status == 1) {
                            echo "<button class='btn btn-info btn-small'>Matched</button>";
                        }
                        elseif($row->status == 2) {
                            echo "<button class='btn btn-warning btn-small'>Approved</button>";
                        }
                        elseif($row->status == 3) {
                            echo "<button class='btn btn-success btn-small'>Withdrawal</button>";
                        }
                        elseif($row->status == 4) {
                            echo "<button class='btn btn-alert btn-small'>Bank Charge</button>";
                        }
                        elseif($row->status == 5) {
                            echo "<button class='btn btn-primary btn-small'>Match to Past</button>";
                        }
                        elseif($row->status == 7) {
                            echo "<button class='btn btn-alert btn-small'>Others</button>";
                        }
                        elseif($row->status == 8) {
                            echo "<button class='btn btn-alert btn-small'>ADM</button>";
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
        <table class="table table-striped" id="tableBCAAdmin">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>AMOUNT</th>
                <th>ACCOUNT NO</th>
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
                    <td><?php
                        if($row->amount){
                            echo number_format($row->amount);
                        }
                        else{
                            echo $row->amount;
                        }?>

                    </td>
                    <td><?php echo $row->acc_no;?></td>

                    <td><?php
                        if($row->status == 0){
                            echo "<button class='btn btn-danger btn-small'>Unmatched</button>";
                        }
                        elseif($row->status == 1) {
                            echo "<button class='btn btn-info btn-small'>Matched</button>";
                        }
                        elseif($row->status == 2) {
                            echo "<button class='btn btn-warning btn-small'>Approved</button>";
                        }
                        elseif($row->status == 3) {
                            echo "<button class='btn btn-success btn-small'>Withdrawal</button>";
                        }
                        elseif($row->status == 5) {
                            echo "<button class='btn btn-primary btn-small'>Match to Past</button>";
                        }
                        elseif($row->status == 7) {
                            echo "<button class='btn btn-alert btn-small'>Others</button>";
                        }
                        elseif($row->status == 8) {
                            echo "<button class='btn btn-alert btn-small'>ADM</button>";
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
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal fade" id="myMatchBCA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

<!--                <form id="loginForm">-->

                    <div class="form-group" style="margin:10px; padding: 10px;">
                        <div id="d_match"></div>
                    </div>

<!--                </form>-->

            </div>
        </div>

    </div>
</div>
<script>



    var tableBank = $('#tableBCA').DataTable({
        "bSort": false,
        "iDisplayLength": 100
    });
    var tableAdmin = $('#tableBCAAdmin').DataTable({
        "bSort": false,
        "iDisplayLength": 100
    });

    var tablePastBank;
    var tablePastAdmin;
    var bank = $('#selBank').val();
    $(document).ready(function(){
        $('#tableBCA tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                tableBank.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

            }

        } );

        $('#tableBCAAdmin tbody').on( 'click', 'tr', function () {


            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');

            }
            else {

                tableAdmin.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                if($("#autoSearch").prop('checked')){
                    if(bank == "CIMB NIAGA"){
                        var adminNameSearch = tableAdmin.cell('.selected',3).data();
                        tableBank.search(adminNameSearch.substring(0,8)).draw();
                    }else{
                        var adminNameSearch = tableAdmin.cell('.selected',1).data();
                        tableBank.search(adminNameSearch.substring(0,5)).draw();
                    }

                }
            }





        } );


        $('#btnMatch').on('click', function(){
            var bankID = tableBank.cell('.selected',0).data();
            var adminID = tableAdmin.cell('.selected',0).data();
            var dscBank = 'Match with BID-'+bankID+' to AID-'+adminID;
            var dscAdmin = 'Match with AID-'+adminID+' to BID-'+bankID;

            var adminAmount = tableAdmin.cell('.selected',2).data();
            var bankAmount = tableBank.cell('.selected',2).data();

            if(adminAmount == bankAmount){
                if(bankID && adminID){
                    $.post('main/update_bca_status_match', {bankID:bankID, adminID:adminID,dscBank:dscBank,dscAdmin:dscAdmin}, function(data){
                        alertify.success(data);

                        $('#btnBCARefresh').trigger('click');
                    });
                }else {
                    alertify.alert('You need to select 1 from Bank List and 1 from Admin List');
                }
            }
            else {
                alertify.alert('Cannot match with diffrent amoutn');
            }
        });

        $('#btnSaveFile').on('click', function(){

            var fname = $('#txtFName').val();

            alertify.confirm('Are you sure you want to save?').set('onok', function(){

                $('#btnProcess').attr('disabled',true)
                $('#btnSubmit').attr('disabled',true)
                

                $.post('main/save_bca_final', {fname: fname}, function (data){
                    $(this).disable();
                    alertify.success(data);
                })
            });
            $('#userfile').val('');
            $('#fileAdmin').val('');
        });

        $('#btnDMatch').on('click', function(){


            var bankName = tableBank.cell('.selected',1).data();
            var adminName = tableAdmin.cell('.selected',1).data();
            var bankID = tableBank.cell('.selected',0).data();
            var adminID = tableAdmin.cell('.selected',0).data();

            if(bankID) {
                $('#myMatchBCA').modal('show');
                $.post('main/load_d_match', {bankName:bankName}, function(data){

                    $('#d_match').html(data);
                })

            }
            else if(adminID){
                $('#myMatchBCA').modal('show');
                $.post('main/load_d_match', {adminName:adminName}, function(data){

                    $('#d_match').html(data);
                })
            }
        });



        $('#btnUnmatched').on('click', function(){
            var bankID = tableBank.cell('.selected',0).data();
            var adminID = tableAdmin.cell('.selected',0).data();

            $.post('main/update_bca_status_unmatch', {bankID:bankID, adminID:adminID}, function(data){
                alertify.success(data);

                $('#btnBCARefresh').trigger('click');
            });

        });

        $('#btnDMatchPast').on('click', function(){
            if(tablePastAdmin && tablePastBank){
                var PastAdminID = tablePastAdmin.cell('.selected',4).data();
                var PastBankID = tablePastBank.cell('.selected',4).data();

                var bankID = tableBank.cell('.selected',0).data();
                var adminID = tableAdmin.cell('.selected',0).data();

                var bankDate = tablePastBank.cell('.selected',0).data();
                var adminDate = tablePastAdmin.cell('.selected',0).data();

                var bankAmount = tableBank.cell('.selected',2).data();
                var adminPAmount = tablePastAdmin.cell('.selected',2).data();

                var adminAmount = tableAdmin.cell('.selected',2).data();
                var bankPAmount = tablePastBank.cell('.selected',2).data();
                if(bankID && PastAdminID){
                    if(bankAmount == adminPAmount){
                        $.post('main/update_bca_status_match_with_past_banktopastadmin', {bankID:bankID, PastAdminID:PastAdminID, adminDate:adminDate}, function(data){
                            alertify.success(data);

                            $.post('main/get_bca_past', function(data){

                                $('#past_unmatched').html(data);

                            });

                            $('#btnBCARefresh').trigger('click');
                        });
                    }
                    else{
                        alertify.alert('You cannot match with different amount!');
                    }
                }
                else {
//                    alertify.alert('Select specified data to match!');
                }


                if(adminID && PastBankID){
                    if(adminAmount == bankPAmount){
                        $.post('main/update_bca_status_match_with_past_admintopastbank', {adminID:adminID, PastBankID:PastBankID, bankDate:bankDate}, function(data){
                            alertify.success(data);

                            $.post('main/get_bca_past', function(data){

                                $('#past_unmatched').html(data);

                            });

                            $('#btnBCARefresh').trigger('click');
                        });
                    }
                    else
                    {
                        alertify.alert('You cannot match with different amount!');
                    }
                }
                else {
//                    alertify.alert('Select specified data to match!');
                }

            }else {
                alertify.alert('Please select a past data.');

            };
            var fname = $('#txtFName').val();
            var type = $('#selType').val();

            $.post('main/get_bca_past',{fname:fname,type:type}, function(data){

                $('#past_unmatched').html(data);

            })
        });

        $('#btnWD').on('click', function(){


            var bankID = tableBank.cell('.selected',0).data();

            if(bankID){
                $.post('main/update_bca_status_wid', {bankID:bankID}, function(data){
                    alertify.success(data);

                    $('#btnBCARefresh').trigger('click');
                });
            }
        });
        $('.btnWD').on('click', function(){

            var dsc = $(this).html();

            var bankID = tableBank.cell('.selected',0).data();

            if(bankID){
                $.post('main/update_bca_status_wid', {bankID:bankID,dsc:dsc}, function(data){
                    alertify.success(data);

                    $('#btnBCARefresh').trigger('click');
                });
            }
        });

    })
</script>