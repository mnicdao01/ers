
<table id="mySchedule" width="2500" class="table table-bordered">
<thead>
<tr>




    <?php for($x=1; $x<=$lastday; $x++){
        echo "<th align='center'>".$x."</th>";
    }?>

</tr>
<tr>
    <?php
    $arraySun = ['Su', 'M', 'T', 'W', 'Th', 'F', 'Sa'];
    $arrayMon = ['M', 'T', 'W', 'Th', 'F', 'Sa','Su'];
    $arrayTue = ['T', 'W', 'Th', 'F', 'Sa','Su', 'M'];
    $arrayWed = ['W', 'Th', 'F', 'Sa','Su','M', 'T'];
    $arrayThu = ['Th', 'F', 'Sa','Su', 'M', 'T', 'W'];
    $arrayFri = ['F', 'Sa','Su', 'M', 'T', 'W', 'Th'];
    $arraySat = ['Sa','Su','M', 'T', 'W', 'Th', 'F'];
    $y = 0;

    if($dayname == 'Sunday'){
        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arraySun[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arraySun[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Monday'){
        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arrayMon[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arrayMon[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Tuesday'){
        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arrayTue[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arrayTue[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Wednesday'){
        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arrayWed[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arrayWed[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Thursday'){
        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arrayThu[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arrayThu[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Friday'){

        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arrayFri[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arrayFri[$y]." </th>";

                $y++;
            }



        }
    }
    if($dayname == 'Saturday'){

        $y = 0;
        for($x=1; $x<=$lastday; $x++){

            if($y == 7){

                $y = 0;
                echo " <th align='center'>".$arraySat[$y]." </th>";
                $y++;
                //                    echo $x;
            } else {
                echo " <th align='center'>".$arraySat[$y]." </th>";

                $y++;
            }



        }
    }

    ?>
</tr>
</thead>
<tbody>

<?php  foreach($emp_info as $row){?>
    <tr>

            <td class="<?php echo $row->d1 ?>"><?php echo $row->d1 ?></td>
            <td class="<?php echo $row->d2 ?>"><?php echo $row->d2 ?></td>
            <td class="<?php echo $row->d3 ?>"><?php echo $row->d3 ?></td>
            <td class="<?php echo $row->d4 ?>"><?php echo $row->d4 ?></td>
            <td class="<?php echo $row->d5 ?>"><?php echo $row->d5 ?></td>
            <td class="<?php echo $row->d6 ?>"><?php echo $row->d6 ?></td>
            <td class="<?php echo $row->d7 ?>"><?php echo $row->d7 ?></td>
            <td class="<?php echo $row->d8 ?>"><?php echo $row->d8 ?></td>
            <td class="<?php echo $row->d9 ?>"><?php echo $row->d9 ?></td>
            <td class="<?php echo $row->d10 ?>"><?php echo $row->d10 ?></td>
            <td class="<?php echo $row->d11 ?>"><?php echo $row->d11 ?></td>
            <td class="<?php echo $row->d12 ?>"><?php echo $row->d12 ?></td>
            <td class="<?php echo $row->d13 ?>"><?php echo $row->d13 ?></td>
            <td class="<?php echo $row->d14 ?>"><?php echo $row->d14 ?></td>
            <td class="<?php echo $row->d15 ?>"><?php echo $row->d15 ?></td>
            <td class="<?php echo $row->d16 ?>"><?php echo $row->d16 ?></td>
            <td class="<?php echo $row->d17 ?>"><?php echo $row->d17 ?></td>
            <td class="<?php echo $row->d18 ?>"><?php echo $row->d18 ?></td>
            <td class="<?php echo $row->d19 ?>"><?php echo $row->d19 ?></td>
            <td class="<?php echo $row->d20 ?>"><?php echo $row->d20 ?></td>
            <td class="<?php echo $row->d21 ?>"><?php echo $row->d21 ?></td>
            <td class="<?php echo $row->d22 ?>"><?php echo $row->d22 ?></td>
            <td class="<?php echo $row->d23 ?>"><?php echo $row->d23 ?></td>
            <td class="<?php echo $row->d24 ?>"><?php echo $row->d24 ?></td>
            <td class="<?php echo $row->d25 ?>"><?php echo $row->d25 ?></td>
            <td class="<?php echo $row->d26 ?>"><?php echo $row->d26 ?></td>
            <td class="<?php echo $row->d27 ?>"><?php echo $row->d27 ?></td>
            <td class="<?php echo $row->d28 ?>"><?php echo $row->d28 ?></td>
            <?php

            if ($lastday == 29) {

                echo "<td class='$row->d29'>" . $row->d29 . "</td>";
                $y++;


            }
            if ($lastday == 30) {

                echo "<td class='$row->d29'>" . $row->d29 . "</td>";
                $y++;
                echo "<td class='$row->d30'>" . $row->d30 . "</td>";
                $y++;

            }
            if ($lastday == 31) {

                echo "<td class='$row->d29'>" . $row->d29 . "</td>";
                $y++;
                echo "<td class='$row->d30'>" . $row->d30 . "</td>";
                $y++;
                echo "<td class='$row->d31'>" . $row->d31 . "</td>";
                $y++;


            }

            //                    if($row->d30){
            //                        echo "<td class='canedit'> ".$row->d30."</td>";
            //                    }
            //                    else {
            //                        echo "<td class='canedit'></td>";
            //                    }
            //                    if($row->d31){
            //                        echo "<td class='canedit'> ".$row->d31."</td>";
            //                    }

        ?>

    </tr>

<?php }?>

</tbody>
</table>

<hr>
<h3>Legend:</h3>
<div class="well">
<table id="myTemplate" class="table table-striped">
    <thead>
        <tr>
            <th width="5" style="padding: 2px;">Text Color</th>
            <th>Code</th>
            <th>Description</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($sched_template as $row2){?>
        <tr>
            <td style="background-color: <?php echo $row2->color?>"></td>
            <td><?php echo $row2->code ?></td>
            <td><?php echo $row2->dsc ?></td>
            <td><?php echo $row2->start_time ?></td>
            <td><?php echo $row2->end_time ?></td>
        </tr>
    <?php }?>
    </tbody>
</table>
</div>

<script>
    <?php foreach($sched_template as $row3){?>

    if ( $('td').hasClass('<?php echo $row3->code; ?>') ) {

        $('.<?php echo $row3->code; ?>').css('color','<?php echo $row3->color; ?>');
    }

    <?php }?>


    $('#btnPrevious').html('<i class="fa fa-backward"></i> <?php echo $monthprev ?>');
    $('#btnThisMonth').html('<i class="fa fa-circle-o"></i> <?php echo $monthnow ?>');
    $('#btnNext').html('<?php echo $monthnext ?> <i class="fa fa-forward"></i>');

</script>



