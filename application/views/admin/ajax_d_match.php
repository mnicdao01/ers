<label for="description">Edit Account Name</label>
<input type="text" class="form-control" id="txtBankName" value="<?php echo $accountName?>"/>
<label for="description">Description</label>
<textarea id="description_bca" class="form-control" placeholder="You description here..."></textarea>

<button class="btn btn-primary" id="btnBCAupdateMatch">Others</button>
<button class="btn btn-primary" id="btnBCAADM">ADM</button>
<button class="btn btn-primary" id="btnBCARename">Rename</button>

<script>
    $('#btnBCAupdateMatch').on('click', function(){
        var bankName = $('#txtBankName').val();
        var bankID = tableBank.cell('.selected',0).data();
        var adminID = tableAdmin.cell('.selected',0).data();
        var dsc = $('#description_bca').val();
        var status = '7';
        if(bankID) {

            $.post('main/match_bca_bank',{id: bankID, dsc: dsc, bankName:bankName,status:status}, function(data){
                alertify.success(data);
                $('#myMatchBCA').modal('hide');

            });
        }
        else if(adminID){
            $.post('main/match_bca_admin',{id: adminID, dsc: dsc, bankName:bankName,status:status}, function(data){
                alertify.success(data);
                $('#myMatchBCA').modal('hide');

            });
        }




    });

    $('#btnBCAADM').on('click', function(){
        var bankName = $('#txtBankName').val();
        var bankID = tableBank.cell('.selected',0).data();
        var adminID = tableAdmin.cell('.selected',0).data();
        var dsc = $('#description_bca').val();
        var status = '8';
        if(bankID) {

            $.post('main/match_bca_bank',{id: bankID, dsc: dsc, bankName:bankName,status:status}, function(data){
                alertify.success(data);
                $('#myMatchBCA').modal('hide');

            });
        }
        else if(adminID){
            $.post('main/match_bca_admin',{id: adminID, dsc: dsc, bankName:bankName,status:status}, function(data){
                alertify.success(data);
                $('#myMatchBCA').modal('hide');

            });
        }




    });

    $('#btnBCARename').on('click', function(){
        var bankName = $('#txtBankName').val();
        var bankID = tableBank.cell('.selected',0).data();

        $.post('main/rename_bca',{id: bankID, bankName:bankName}, function(data){
            alertify.success(data);
            $('#myMatchBCA').modal('hide');

        });
    })

    $('#myMatchBCA').on('hidden.bs.modal', function(){
        $('#btnBCARefresh').trigger('click');
    });

</script>