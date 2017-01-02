

<div class="container-fluid">
    <div class="row">
        <h1>IT Godaddy Domain Tool <small>Tools for Godaddy Domain Management</small></h1>
        <div class="col-md-2">
            <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">

                <select id="selAccount" class="form-control">
                    <?php foreach($accounts as $account){ ?>
                        <option value="<?php echo $account->account?>"><?php echo $account->account?></option>

                    <?php }?>
                </select>
                </div>
        </div>
        <div class="col-md-5">
            <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">


                <button type="button" class="btn btn-primary" id="btnGDUpdateInfo">Update Accounts</button>
<!--                <button type="button" class="btn btn-success" id="btnEditAInfo">Activate Development Mode for 3 hours</button>-->
<!--                <button type="button" class="btn btn-warning" id="btnPurgeCache">Purge all Cache</button>-->
                <!--            <button type="button" class="btn btn-info" id="btnNotif">Make an Notif</button>-->
                <!--            <button type="button" class="btn btn-danger" id="btnDeleteAInfo">Delete</button>-->

            </div>
        </div>

        <div class="col-md-12">
            <div class="alert alert-danger">Note:<b>Do not update the accounts unless you added new sites or made changes from Godaddy.</b> </div>
        </div>

        <table class="table table-striped" id="itCF">
            <thead>
            <tr>

                <th>ID</th>
                <th>ACCOUNT</th>
                <th>DOMAIN ID</th>
                <th>DOMAIN</th>
                <th>STATUS</th>
                <th>EXPIRES</th>
                <th>PRIVACY</th>
                <th>AUTO RENEW</th>
                <th>LOCKED</th>
                <th>DAYS LEFT</th>


            </tr>
            </thead>
            <tbody>


            <?php foreach($results as $row){
//                if($row->dev_mode == 1) {
//                    echo "<tr style='background-color: #e8b974'>";
//                }else {
//                    echo "<tr>";
//                }

                    ?>

                <?php
                    if($row->remdays <= 60){

                        echo "<tr style='background-color: #f1dddd; font-weight: bold; color: #aa445a; border-color: #a9445a'>";
                    }
                else{
                    echo "<tr>";
                }
                ?>



                    <td><?php echo $row->id?></td>
                    <td><?php echo $row->account?></td>
                    <td><?php echo $row->domainId?></td>
                    <td><?php echo $row->domain?></td>
                    <td><?php echo $row->status?></td>

                    <td><?php echo $row->expires?></td>

                    <td><?php echo $row->privacy?></td>
                    <td><?php echo $row->renewAuto?></td>
                    <td><?php echo $row->locked?></td>
                    <td><?php echo $row->remdays?></td>

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
                <td></td>
                <td></td>


            </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>
    $(document).ready(function(){


        var table = $('#itCF').DataTable({
            "bSort" : false
        });

        $('#itCF tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#itCF tbody').on( 'dblclick', 'tr', function () {

            if ( $(this).hasClass('selected') ) {
                var id = table.cell('.selected',0).data();
                var title = table.cell('.selected',1).data();
                var dsc= table.cell('.selected',3).data();
                var status = table.cell('.selected',7).data();

                $('#myModal').modal('show');
                $.post('main/load_edit_it',{id:id,title:title,dsc:dsc,status:status}, function(data){
                    $('#modal_body').html(data);


                });
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }



        } );

        $('#btnDeleteAInfo').click( function () {

            alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
                var id = table.cell('.selected',0).data();



                table.row('.selected').remove().draw( false );

                $.post('main/delete_announcements', {id: id}, function (data){

                    alertify.success(data);
                })
            });

        } );


        $('#btnGDUpdateInfo').on('click', function(data){
            alertify.confirm('Are you sure you want to update the records from Godaddy?').set('onok', function(closeEvent) {
                var account = $('#selAccount').val();
                $.post('main/getGDAccountInfo', {account: account}, function (data) {
                    table.search(email).draw();
                    $('#btnITGDDomains').trigger('click')
                });

            });

        });

        $('#selAccount').on('change', function() {
            var email = $('#selAccount').val();
            table.search(email).draw();
        });

        $('#btnEditAInfo').on('click', function(data){

            var domain = table.cell('.selected',1).data();
            var email = table.cell('.selected',2).data();
            var api= table.cell('.selected',3).data();
            var zone = table.cell('.selected',4).data();

            if(email){

                $.post('main/setDevMode',{domain:domain,email:email,api:api,zone:zone}, function(data){
                    var message = JSON.parse(data);

                    if(message.success == true){
                        alertify.alert("Successfully Activated Dev Mode.")
                    }

                });
            }
            else {
                alertify.alert("Please select a log below.");
            }

        });

        $('#btnPurgeCache').on('click', function(data){

            var domain = table.cell('.selected',1).data();
            var email = table.cell('.selected',2).data();
            var api= table.cell('.selected',3).data();
            var zone = table.cell('.selected',4).data();

            if(email){

                $.post('main/setPurgeCache',{domain:domain,email:email,api:api,zone:zone}, function(data){
                    var message = JSON.parse(data);

                    if(message.success == true){
                        alertify.alert("Successfully Purge All Cache. Please wait 30 second before for the effects.")
                    }

                });
            }
            else {
                alertify.alert("Please select a log below.");
            }

        });

        $('#btnNotif').on('click', function(){
            var title = "Notif Title";
            var message = "Notif MessageNotif MessageNotif MessageNotif MessageNotif MessageNotif Message";

            var urlRun = 'http://admin-sfx.com/ers/admin/main';
            notifyMe(title, message, url, urlRun);
        });



    });
</script>
