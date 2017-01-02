
<script type="text/javascript">
    (function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/fc5efec33b89f3bd2bf66f21475b0f73.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);
</script>


<div class="container-fluid">
    <div class="row">
        <h1>IT Reporting <small>Logs of all IT Department Troubleshooting</small></h1>
        <div class="btn-group" role="group" style="margin-bottom: 10px; padding: 10px; border: 1px lightgray solid;">
            <button type="button" class="btn btn-primary" id="btnAddAInfo">Add</button>
            <button type="button" class="btn btn-success" id="btnEditAInfo">Read / Make an Action</button>
<!--            <button type="button" class="btn btn-info" id="btnNotif">Make an Notif</button>-->
<!--            <button type="button" class="btn btn-danger" id="btnDeleteAInfo">Delete</button>-->

        </div>
        <table class="table table-striped" id="itInfo">
            <thead>
            <tr>

                <th>ID</th>
                <th>Title</th>
                <th></th>
                <th>Description</th>
                <th>Date</th>
                <th>Created By</th>
                <th>Last Touch</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>


            <?php foreach($results as $row){?>
                <tr>

                    <td width="5%"><?php echo $row->id?></td>
                    <td width="5%" style="font-weight: bold;"><?php echo $row->title?></td>
                    <td width="3%">
                        <?php
                            if($row->read_status == 'Read'){
                                echo "<div class='alert alert-success'>".$row->read_status."</div>";
                            }else {
                                echo "<div class='alert alert-warning'>".$row->read_status ? "<div class='alert alert-warning'>Unread</div>" : $row->read_status ."</div>";
                            }

                        ?>

                    </td>
                    <td width="67%"><?php echo $row->dsc?></td>
                    <td width="5%"><?php echo $row->date_updated?></td>
                    <td width="5%"><?php echo $row->updated_by?></td>
                    <td width="5%"><?php echo $row->last_touch?></td>
                    <td width="5%"><?php

                        if($row->status == "Fixed"){
                            echo "<div class='label label-success'>Fixed</div>";
                        }elseif($row->status == "For Continuation"){
                            echo "<div class='label label-danger'>For Continuation</div>";
                        }elseif($row->status == "For Checking"){
                            echo "<div class='label label-warning'>For Checking</div>";
                        }



                        ?></td>
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
            </tr>
            </tfoot>
        </table>
    </div>

</div>

<script>
    $(document).ready(function(){


        var table = $('#itInfo').DataTable({
            "bSort" : false
        });

        $('#itInfo tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('#itInfo tbody').on( 'dblclick', 'tr', function () {

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


        $('#btnAddAInfo').on('click', function(data){

            $('#myModal').modal('show');
            $.post('main/add_it_info', function(data){
                $('#modal_body').html(data);


            });

        });

        $('#btnEditAInfo').on('click', function(data){

            var id = table.cell('.selected',0).data();
            var title = table.cell('.selected',1).data();
            var dsc= table.cell('.selected',3).data();
            var status = table.cell('.selected',7).data();

            if(id){
            $('#myModal').modal('show');
            $.post('main/load_edit_it',{id:id,title:title,dsc:dsc,status:status}, function(data){
                $('#modal_body').html(data);
                table.cell('.selected',2).data("<div class='alert alert-success'>Read</div>");

            });
            }
            else {
                alertify.alert("Please select a log below.");
            }

        });

        


    });
</script>
