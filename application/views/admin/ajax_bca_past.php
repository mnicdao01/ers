
<div class="row">

    <div class="col-xs-6">
        <h3>Bank Past Unmatched</h3>
        <table class="table table-striped" id="tableBCApastBank">
            <thead>
            <tr>
                <th>DATE</th>

                <th>NAME</th>
                <th>AMOUNT</th>
                <th>FILE NAME</th>
                <th>ID</th>

            </tr>
            </thead>

            <tbody>

            <?php

            foreach($results as $row){?>
                <tr>
                    <td><?php echo $row->date_uploaded;?></td>

                    <td><?php echo $row->name;?></td>
                    <td><?php echo number_format($row->amount);?></td>
                    <td><?php echo $row->docno;?></td>
                    <td><?php echo $row->id;?></td>


                </tr>
            <?php }?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-xs-6">
        <h3>Admin Past Unmatched</h3>
        <table class="table table-striped" id="tableBCApastAdmin">
            <thead>
            <tr>
                <th>DATE</th>

                <th>NAME</th>
                <th>AMOUNT</th>
                <th>FILE NAME</th>
                <th>ID</th>

            </tr>
            </thead>

            <tbody>

            <?php

            foreach($results2 as $row){?>
                <tr>
                    <td><?php echo $row->date_uploaded;?></td>

                    <td><?php echo $row->name;?></td>
                    <td><?php echo number_format($row->amount);?></td>
                    <td><?php echo $row->docno;?></td>
                    <td><?php echo $row->id;?></td>


                </tr>
            <?php }?>
            </tbody>
            <tfoot>
            <tr>
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

<div class="modal fade" id="myMatchBCApast" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <form id="loginForm">

                    <div class="form-group" style="margin:10px; padding: 10px;">
                        <label for="description">Description</label>
                        <textarea id="description_bni" class="form-control" placeholder="You description here..."></textarea>

                        <button class="btn btn-primary" id="btnBCAupdate">Match</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

    <script>

        tablePastBank = $('#tableBCApastBank').DataTable({
            "bSort": false
        });
        tablePastAdmin = $('#tableBCApastAdmin').DataTable({
            "bSort": false
        });

        $(document).ready(function(){
            $('#tableBCApastBank tbody').on( 'click', 'tr', function () {

                if ( $(this).hasClass('selected') ) {

                    $(this).removeClass('selected');
                }
                else {
                    tablePastBank.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );

            $('#tableBCApastAdmin tbody').on( 'click', 'tr', function () {

                if ( $(this).hasClass('selected') ) {

                    $(this).removeClass('selected');
                }
                else {
                    tablePastAdmin.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );




        });

    </script>