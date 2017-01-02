

<h1>IP Addresses<small> Manage Accepted IP Addresses</small></h1>

<table class="table table-bordered" id="table_ip">
    <thead>
        <tr>
            <th>ACTIONS</th>
            <th>ID</th>
            <th>IP ADDRESS</th>
            <th>LOCATION</th>

        </tr>
    </thead>
    <tbody>

    <?php foreach($ipaddresses as $row){?>
        <tr value="<?php echo $row->id?>">
            <td><a href="#" class="edit"><i class="fa fw fa-edit fa-2x"></i></a>  <a href="#" class="delete"><i class="fa fw fa-remove fa-2x"></i></a></td>
            <td class="nr"><span><?php echo $row->id?></span></td>
            <td><?php echo $row->ip_address?></td>
            <td><?php echo $row->dsc?></td>
<!--            <td>--><?php //echo $row->logo?><!--</td>-->

        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <button class="btn btn-primary" id="btnAdd">Add</button>
            </td>
        </tr>
    </tfoot>
</table>





<script>
    var base_url = $('#base_url').val();
    $(document).ready( function () {
        $('#btnAdd').on('click', function(){

            $('#myModal').modal('show');
            $.post(base_url + 'main/add_ip', function(data){
                $('#modal_body').html(data);

            });

        });

        $('.edit').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text

            // Let's test it out
            $('#myModal').modal('show');
            $.post(base_url + 'main/edit_ip', {id: $text}, function(data){
                $('#modal_body').html(data);
            });
        });

        $('.delete').on('click', function(){
            var $row = $(this).closest("tr");    // Find the row
            var $text = $row.find(".nr").text(); // Find the text

            // Let's test it out
            $('#myAlert').modal('show');
            $.post(base_url + 'main/delete_ip', {id: $text}, function(data){
                $('#modal_body').html(data);
                $.post(base_url + 'admin/main/load_ipaddress',function(data){
                    $('#body_content').html(data);
                });

            });
        });

    } );
    $('#table_ip').dataTable();
</script>