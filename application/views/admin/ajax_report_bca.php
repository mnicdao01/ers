<h1>Per Day Report</h1><hr/>
<h3>Bank</h3>
<div class="well">
    <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_bank_no ? $total_bank_no : 0 ?></div>
                        <div>Total Number of Bank Deposit</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-credit-card fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_bank_amount ? number_format($total_bank_amount) : 0 ?></div>
                        <div>Total Amount of Bank Deposit</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-forward fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_transfer_wd ? number_format($total_transfer_wd) : 0 ?></div>
                        <div>Total Amount Transfer to WD</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-save fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_transfer_tp ? number_format($total_transfer_tp) : 0 ?></div>
                        <div>Total Amount Transfer to TP</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-area-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $no_match_bank ? number_format($no_match_bank) : 0 ?></div>
                        <div>Number of Matched</div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="col-lg-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-dollar fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $match_bank ? number_format($match_bank) : 0 ?></div>
                        <div>Total Amount of Matched</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-crosshairs fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $no_unmatch_bank ? number_format($no_unmatch_bank) : 0 ?></div>
                            <div>Number of Unmatched</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-level-down fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $unmatch_bank ? number_format($unmatch_bank) : 0 ?></div>
                        <div>Total Amount of Unmatched</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-fast-backward fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_bank_past_no ? number_format($total_bank_past_no) : 0 ?></div>
                            <div>Total Past Data Match</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-dollar fa-5x"></i> <i class="fa fa-fast-backward fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_bank_past_amount ? number_format($total_bank_past_amount) : 0 ?></div>
                            <div>Total Past Data Amount</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
</div>

<h3>Administrator</h3>
<div class="well">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_admin_no ? $total_admin_no : 0 ?></div>
                            <div>Total Number of Bank Deposit</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-credit-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_admin_amount ? number_format($total_admin_amount) : 0 ?></div>
                            <div>Total Amount of Bank Deposit</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

     <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-area-chart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $no_match ? number_format($no_match) : 0 ?></div>
                            <div>Number of Matched</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-dollar fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $match ? number_format($match) : 0 ?></div>
                            <div>Total Amount of Matched</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

         <div class="col-lg-3 col-md-6">
             <div class="panel panel-danger">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-crosshairs fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                             <div class="huge"><?php echo $no_unmatch ? number_format($no_unmatch) : 0 ?></div>
                             <div>Number of Unmatched</div>
                         </div>
                     </div>
                 </div>

             </div>
         </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-level-down fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $unmatch ? number_format($unmatch) : 0 ?></div>
                            <div>Total Amount of Unmatched</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
         <div class="col-lg-6 col-md-6">
             <div class="panel panel-primary">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-fast-backward fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                             <div class="huge"><?php echo $total_admin_past_no ? number_format($total_admin_past_no) : '0' ?></div>
                             <div>Total Past Data Match</div>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
         <div class="col-lg-6 col-md-6">
             <div class="panel panel-primary">
                 <div class="panel-heading">
                     <div class="row">
                         <div class="col-xs-3">
                             <i class="fa fa-dollar fa-5x"></i> <i class="fa fa-fast-backward fa-5x"></i>
                         </div>
                         <div class="col-xs-9 text-right">
                             <div class="huge"><?php echo $total_admin_past_amount ? number_format($total_admin_past_amount) : '0.00' ?></div>
                             <div>Total Past Data Amount</div>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div>

</div>