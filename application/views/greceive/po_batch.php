<?php 
'session_start()' 
?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;border:none;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-dx8v{font-size:12px;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
<style>

#poDetails, #promoDetails {
  display: none;
}


b .font {
    font-size: 90px;
}

@media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 90%;
  }
  h1 {
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  td.big {
    font-size: 10px;
  }
  font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
}

</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);


function check()
{
    var answer=confirm("Confirm want to delete item ?");
    return answer;
}

</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">

                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('greceive_controller/po_list')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po 
                        <br><small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font><br>
                        <?php
                        if($postButton == '1')
                        {
                            ?>
                            <a href="<?php echo site_url('greceive_controller/po_post_grn_scan?get_refno='.$grn_id)?>" ><button class="btn btn-default btn-sm" style=""><b>POST DOCUMENT</b></button></a>
                            <?php
                        }
                        ?>

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('greceive_controller/batch_add'); ?>">
                            
                            <a href="<?php echo site_url('greceive_controller/batch_check_pay_by_invoice'); ?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD BATCH</b></button></a>
                            
                            <a class="btn btn-warning btn-xs" href="<?php echo site_url('greceive_controller/po_print')?>?grn_guid=<?php echo $_REQUEST['grn_guid']?>&print_type=batch_list" style="float: right;color: black"><i class="fa fa-print fa-lg" ></i> GRDA LIST </a>
                            </form><br>
                            
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            

                            <?php
                            foreach ($result->result() as $row)
                                { 
                            ?>
                            <div style="overflow-x:auto;">

                           <table class="tg table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Pallet<br>&nbsp<br>&nbsp</th>
                                        <th>Goods.kg<br>Pallet.kg<br>&nbsp</th>
                                        <th>Gross<br>Q.var<br>W.var</th>
                                        <th>Net<br>&nbsp<br>&nbsp</th>
                                        <th>kg/qty<br>kg.TraceQty<br>Tolerance</th>
                                        <th>Qty<br>TraceQty<br>&nbsp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th class="tg-dx8v" rowspan="3" style="text-align: center">
                                    <b style="font-size: 32px"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->batch_id; ?></a></b>
                                        <br><br>
                                        <label>Printed</label>&nbsp<input type="checkbox" disabled
                                        <?php
                                        if($row->send_print == '1')
                                        {
                                            ?>
                                            checked
                                            <?php
                                        } 
                                        ?>>
                                        <br>
                                        <a href="<?php echo site_url('greceive_controller/po_print')?>?batch_guid=<?php echo $row->batch_guid?>&print_type=batch_only&grn_guid=<?php echo $_REQUEST['grn_guid']?>"><i class="fa fa-print fa-2x" ></i></a>
                                    </th>
                                    <th class="tg-yw4l"><?php echo $row->goods_weight?></th>
                                    <th class="tg-yw4l"><a href="<?php echo site_url('greceive_controller/batch_gross_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->goods_pallet_weight?></a></th>
                                    <th class="tg-yw4l"><?php echo $row->goods_weight_net?></th>
                                    <th class="tg-yw4l"><?php echo $row->goods_weight_perqty?></th>
                                    <th class="tg-yw4l"><?php echo $row->pallet_qty?></th>
                                  </tr>
                                  <tr>
                                    <td class="tg-yw4l"><a href="<?php echo site_url('greceive_controller/batch_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->pallet_weight?></a></td>
                                    <td class="tg-yw4l" style="color:red "><?php echo $row->goods_pallet_variance?></td>
                                    <td class="tg-yw4l"></td>
                                    <td class="tg-yw4l" style="color:red "><?php echo $row->goods_weight_traceqty?></td>
                                    <td class="tg-yw4l" style="color:red "><?php echo $row->trace_qty_sum?></td>
                                  </tr>
                                  <tr>
                                    <td class="tg-yw4l"></td>
                                    <td class="tg-yw4l" style="color:red "><?php echo $row->Weight_Variance?></td>
                                    <td class="tg-yw4l"></td>
                                    <td class="tg-yw4l"><?php echo $row->PurTolerance_Std_Minus?></td>
                                    <td class="tg-yw4l"></td>
                                  </tr>
                                </tbody>
                            </table>
                            </div>
                            <?php
                                }
                            ?>
                            </div>
                        

                    </div>
                        <!-- /. ROW  -->
                </div>

            </div>
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>