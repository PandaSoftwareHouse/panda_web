<?php 
'session_start()' 
?>
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
  input {
    font-size: 16px;
  }
   font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  p {
    font-size: 12px;
  }
}

</style>

<script type="text/javascript">
$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});

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
                        
                        <a href="<?php echo site_url('greceive_controller/barcode_scan')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>GRN BY PO<br>
                         <small><b><?php echo $heading?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                    <!-- <?php echo var_dump($_SESSION)?>  -->
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                  <?php
                  if($this->session->userdata('message') )
                  {
                     echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                  }
                  ?>
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_entry_insert')?>?item_guid=">
                        <div class="form-group">
                        <?php
                        if($hide_po_info == 1)
                        {
                          ?>
                          
                          <?php
                        }
                        else
                        {
                          ?>
                          
                          <h5>Order: <b><?php echo $order_qty; ?>
                            
                            <?php if($check_bulk_qty > '1')
                            { ?>

                              (<?php echo $bulk_qty; ?>)</b></h5></b>

                            <?php }
                            else
                            { ?>

                              </b>&nbsp&nbsp

                            <?php } ?>

                           Balance: <b><?php echo $balance_qty?></b>&nbsp&nbsp
                           FOC: <b><?php echo $foc_qty?></h5>
                          <?php
                        }
                        ?>

                        

                           <h4><?php echo $_SESSION['barcode']?>&nbsp&nbsp&nbsp&nbsp<b><?php echo $line_no?></b></h4><!-- <?php echo var_dump($_SESSION)?> -->
                              
                                <h4>Description: <b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?></b></h4>

                                <div class="row">
                                  <?php if($check_pay_by_invoice == '1') { ?>
                                  <div class="col-md-5 col-xs-3 form-group">
                                    <?php
                                    if($hide_supplier_do_entry == 1)
                                    {
                                      ?>

                                      <h5 >&nbsp</h5>
                                        <input
                                         value="<?php echo $do_qty?>" type="hidden" step="any" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty"/>
                                      <?php
                                    }
                                    else
                                    {
                                      ?>
                                      
                                     
                                      <h5 ><b>D/O Qty</b></h5>
                                        <input autofocus
                                         value="<?php echo $do_qty?>" type="number" step="any" style="text-align:center;width:80px;background-color:#ffff99" onfocus="this.select()" name="do_qty"/>
                                       
                                      <?php
                                    }
                                    ?>
                                  </div>
                                  <?php } else {  ?> 
                                  <input  value="<?php echo $do_qty?>" type="hidden" step="any" name="do_qty"/> 
                                  <?php } ?>
                                  <div class="col-md-6 col-xs-6 form-group">
                                    <h5><b>Rec Qty/Kg</b></h5>
                                      <input  name="rec_qty" type="number" step="any" style="text-align:center;width:80px;background-color:#80ff80" onfocus="this.select()"
                                      <?php

                                      if($check_recqty_aspoqty == 1 || isset($_REQUEST['received_qty']))
                                      {
                                        ?>
                                        value="<?php echo $received_qty?>"
                                        <?php
                                      }
                                      else
                                      {
                                        ?>
                                        value="0"
                                        <?php
                                      }
                                      ?>/>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col-md-5 col-xs-3 form-group <?php echo $hide_weight?>" >
                                  <h5><b>Weight(kg)</b></h5>
                                    <input  value="<?php echo $scan_weight?>" type="number" step="any" name="weight" style="text-align:center;width:80px;background-color:#e6ccff" />
                                  </div>
                                  <div class="col-md-6 col-xs-6 form-group">
                                    <?php
                                    if($check_trace_qty == '1')
                                    {
                                      ?>
                                      <h5><b>Trace Qty</b></h5>
                                      <input  value="<?php echo $trace_qty?>" type="number" step="any" name="trace_qty" style="text-align:center;width:80px;background-color:#f4b042"/>
                                      <br><br>
                                      <?php
                                    }
                                    else
                                    {
                                      ?>
                                       <input  value="<?php echo $WeightTraceQtyCount?>" name="trace_qty" type="hidden"> 
                                      <?php
                                    }
                                    ?>
                                  </div>
                                </div>

                                <br>
                                <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>

                                <?php
                                if($superid_required == 1)
                                {
                                  ?>
                                  <h5><b>Supervisor Password</b></h5>
                                  <label><small>Item is HIGH SHRINK type. You are required to get approval from supervisor.</small></label>
                                  <input type="password" class="form-control" value="" 
                                  style="width: 220px;background-color:#efd899" name="superid">
                                  <?php
                                }
                                ?>

                                <h5><b>Expired Date</b></h5>
                                <input type="date" class="form-control" value="<?php echo $expiry_date?>" style="width: 220px" name="expiry_date">

                                <h5><b>Reason</b></h5>
                                <select id="reason" name="reason" class="form-control" style="width: 220px;background-color:#ccf5ff"  >
                                <option value="" disabled selected>Select Reason:</option>
                                <?php
                                foreach($set_master_code->result() as $row)
                                {
                                    ?>
                                <option value="<?php echo $row->CODE_DESC;?>"><?php echo $row->CODE_DESC;?></option>
                                    <?php
                                }
                                ?>
                                
                                </select>
                                <input value="<?php echo $_REQUEST['scan_itemcode']?>" name="scan_itemcode" type="hidden">
                                <input value="<?php echo $balance_qty?>" name="balance_qty" type="hidden">
                                <input value="<?php echo $order_qty?>" name="order_qty" type="hidden">
                                <input value="<?php echo $foc_qty?>" name="foc_qty" type="hidden">
                                
                                <input value="<?php echo $WeightTraceQty?>" name="WeightTraceQty" type="hidden">
                                <input value="<?php echo $WeightTraceQtyUOM?>" name="WeightTraceQtyUOM" type="hidden">
                                
                                <input value="<?php echo $PurTolerance_Std_plus?>" name="PurTolerance_Std_plus" type="hidden">
                                <input value="<?php echo $PurTolerance_Std_Minus?>" name="PurTolerance_Std_Minus" type="hidden">
                                <input value="<?php echo $superid_required?>" name="superid_required" type="hidden">
                                   
                        </div><br><br><br><br>
                                  
                    </form>

                </div>
            </div>      

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>