<h3>Last Login:</h3>
<?php foreach($last_login as $row){?>
    <div class="media">
<!--        <a class="pull-left" href="#">-->
<!--            <img class="media-object" src="--><?php //echo base_url()?><!--public/thumb/users/--><?php //echo $row->PATH?><!--" alt="Media Object" width="30">-->
<!--        </a>-->
        <div class="media-body">
            <h5 class="media-heading"><i class="glyphicon glyphicon-user "></i> <?php echo strtoupper($row->USERNAME)?></h5>
            <h6 class="media-body"><i class="glyphicon glyphicon-globe "></i> <strong><?php echo $row->DEPT?></strong></h6>
            <h6 class="media-bottom"><i class="glyphicon glyphicon-calendar "></i> <strong><?php echo $row->TIMEIN?></strong></h6>
        </div>
        <p>

        </p>
    </div>
<?php } ?>