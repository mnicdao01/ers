

<div class="container-fluid">
    <div class="row">
        <h1>IT Server Information <small>Server Management</small></h1>
        <div class="col-md-1">
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

              <button type="button" class="btn btn-primary" id="btnGDUpdateInfo">Get Server Info</button>

            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-1">
                            <i class="fa fa-tasks fa-3x"></i>
                        </div>
                        <div class="col-xs-5">
                            <div class="huge">Shiokambing</div>
                        </div>
                        <div class="col-xs-6">

                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-xs-4">
                            <center>
                                <div class="row">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">

                                                <div class="col-xs-12 text-right">
                                                    <div class="huge"><?php echo $loadave->one." | ".$loadave->five." | ".$loadave->fifteen?></div>
                                                    <div>Load Average</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </center>
                        </div>
                        <div class="col-xs-4">
                            <center>
                                <div class="row">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <div class="row">

                                                <div class="col-xs-12 text-right">
                                                    <div class="huge"><?php echo $diskusg->metadata->partition[0]->disk?></div>
                                                    <div>Disk Usage</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </center>
                        </div>
                        <div class="col-xs-4">
                            <center>
                                Bandwidth
                            </center>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
    $(document).ready(function(){






    });
</script>

