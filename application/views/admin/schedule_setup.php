<style>
    thead th{
        font-size: 12px;
        width: 10px;

    }
    tbody td{
        font-size: 12px;

    }
</style>
<div id="table-wrapper">
    <div id="table-scroll">

    <table id="scheduler" width="2500" class="table table-bordered" >
            <thead>

            <tr>
<!--                <th rowspan="2">Id</th>-->
                <th rowspan="2">USERNAME</th>


                <?php for($x=1; $x<=$lastday; $x++){
                    echo "<th>".$x."</th>";
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
                            echo " <th align='center' width='8'>".$arraySun[$y]." </th>";
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
            <?php  foreach($emp_info as $row){$y = 1;?>
                <tr name="">
<!--                    <td id="id_update">--><?php //echo $row->id ?><!--</td>-->

                    <td class="nr"><span class="edit"><?php echo $row->username ?></span></td>

                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d1?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d2?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d3?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d4?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d5?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d6?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d7?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d8?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d9?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d10?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d11?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d12?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d13?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d14?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d15?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d16?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d17?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d18?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d19?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d20?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d21?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d22?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d23?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d24?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d25?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d26?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d27?></td>
                    <td class="canedit" id="<?php echo $row->id ?>"><input type="hidden" id="dayNo" value="<?php echo $y; $y++;?>"/><?php echo $row->d28?></td>
                    <?php

                    if($lastday == 29){

                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d29."</td>"; $y++;


                    }
                    if($lastday == 30){

                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d29."</td>"; $y++;
                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d30."</td>"; $y++;

                    }
                    if($lastday == 31){

                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d29."</td>"; $y++;
                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d30."</td>"; $y++;
                            echo "<td class='canedit' id='".$row->id."'> <input type='hidden' id='dayNo' value='".$y."'/>".$row->d31."</td>"; $y++;


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
    </div>
</div>

<script>
    $(document).ready(function() {
        var oTable;
        oTable = $('#scheduler').dataTable({
            bSort: false,
            paginate: false,
            searching: false
        });

        var dept = $('#dept').val();
        var month = $('#myDate').val();
        var dayNo;
//        var empupdateid = oTable.cell('.selected',0).data();


//        console.log(dept+month);
        $('.edit').on('click', function () {
            var sData = $('select', oTable.fnGetNodes()).serialize();
            alert( "The following data would have been submitted to the server: \n\n"+sData );
            return false;

        });




        $('#scheduler tbody td.canedit').editable('main/updateSched', {
            loadurl: 'main/getJSONData?dept='+$('#dept').val(),
            type   : 'select',
            tooltip: 'Saving...',
            id     : 'id',
            select : true,
            submitdata : function(value, settings){
                var dayNo = 'd'+$(value).val();
                return {dayNo: dayNo};

                },
            submit : '<i class="fa fa-save"></i>',
            callback : function(value, settings) {

                $(this).text(value);

            }



        }); /* Submit the form when bluring a field */




    });
//

</script>
