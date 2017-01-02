<p><hr></p>
<h4>Actual Time Table</h4>
<div class="col-xs-12">
<!--    <div class="col-xs-2">-->
<!--        <div class="panel panel-primary">-->
<!--            <div class="panel-heading">-->
<!--                <h4>Potongan/Min.</h4>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <h3><b><center>Rp. --><?php //echo number_format($grand_total[0]->per_min,2,",",".")?><!--</center></b></h3>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="col-xs-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Total Terlambat</h4>
            </div>
            <div class="panel-body">
                <h3><b><center><?php echo $grand_total[0]->total_late?> mins.</center></b></h3>
            </div>
        </div>
        </div>
    <div class="col-xs-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4> Total Undertime</h4>
            </div>
            <div class="panel-body">
                <h3><b><center><?php echo $grand_total[0]->total_undertime?> mins.</center></b></h3>
            </div>
        </div>
       </div>
    <div class="col-xs-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4> Total Potongan Terlambat</h4>
            </div>
            <div class="panel-body">
                <h3><b><center>Rp. <?php echo number_format($grand_total[0]->total_late_deduction,2,",",".")?></center></b></h3>
            </div>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4> Total Potongan Undertime</h4>
            </div>
            <div class="panel-body">
                <h3><b><center>Rp. <?php echo number_format($grand_total[0]->total_undertime_deduction,2,",",".")?></center></b></h3>
            </div>
        </div>
        </div>
    <div class="col-xs-offset-2 col-xs-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4> Total Potongan</h4>
            </div>
            <div class="panel-body">
                <h3><b><center>Rp. <?php echo number_format($grand_total[0]->grand_total,2,",",".")?></center></b></h3>
            </div>
        </div>
        </div>

</div>
<div class="col-xs-12">

    <table class="table table-striped" id="myAttendance">
        <thead>
        <tr>
            <th>Date</th>
            <th>Code</th>
            <th>Description</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Late in Mins.</th>
            <th>Undertime in Mins.</th>
            <th>Late Deductions</th>
            <th>Undertime Deductions</th>
            <th>Sub-Total Deduction</th>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach($results as $row){
            ?>
            <tr>


                <td><?php echo $row->date?></td>
                <td><?php echo $row->code?></td>
                <td><?php echo $row->dsc?></td>
                <td><?php echo $row->timein?></td>
                <td><?php echo $row->timeout?></td>

                <td><?php echo $row->late?></td>
                <td><?php echo $row->undertime?></td>
                <td><?php echo $row->late_deduction?></td>
                <td><?php echo $row->undertime_deduction?></td>
                <td><?php echo $row->sub_total?></td>
            </tr>
        <?php
        }
        ?>


        </tbody>
    </table>

</div>

<script>
    $(document).ready(function(){

        var table = $('#myAttendance').DataTable({
            "bSort": true,
            "searching": false,
            "paginate": false
        });

        $('#myAttendance tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {

                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

//        var calendar = $("#calendar").calendar(
//            {
//                tmpl_path: "/ers/public/tmpls/",
//                events_source:
//                    <?php //print_r($jsonData)?>
//
//
//
//            });


    });





</script>