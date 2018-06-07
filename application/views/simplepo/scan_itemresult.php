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
  p {
    font-size: 12px;
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
                        
                        <a href="<?php echo site_url('simplepo_controller/scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>SIMPLE PO
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('simplepo_controller/add_qty'); ?>">
                        <div class="form-group">
                          <?php 
                          foreach($item->result() as $row)
                          {
                            ?>
                            <h5><b>Itemcode: </b><?php echo $row->Itemcode;?> &nbsp
                            <b>QOH: </b><?php echo $row->OnHandQty?>&nbsp
                            <b>Avg: </b><?php echo $row->AverageCost?>&nbsp
                            </h5>
                            <h5><b>Last: </b><?php echo $row->LastCost?>&nbsp
                            <b>Selling: </b><?php echo $row->BarPrice?>&nbsp
                            <b>Margin : </b><?php echo $row->Margin?>% &nbsp
                            <b>Sold: </b><?php echo $row->SalesTempQty?>&nbsp
                            </h5>
                            <h5><b>Description : </b><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030");?> &nbsp</h5>

                            <input value="<?php echo $row->Itemcode?>" name="itemcode" type="hidden">
                            <input value="<?php echo htmlentities(convert_to_chinese($row->Description, "UTF-8", "GB-18030"));?>" name="description" type="hidden">
                            <input value="<?php echo $row->LastCost?>" name="lastcost" type="hidden">
                            <input value="<?php echo $row->BarPrice?>" name="barprice" type="hidden">
                            <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
                            <?php
                          }
                              ?>

                        </div>
                    <br>
                </div>
            </div>

            <div class="row" >
                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                        
                                <div style="float:left">
                                    <h5 ><b>Order Qty</b></h5>
                                    <input autofocus required type="number" value="0" onfocus="this.select()" step="any" name="iqty" style="text-align:center;width:80px;" />
                                    <br>
                                </div>
                                <br><br><br><br>
                            </div>
                          </div>

                                <div style="float:left">
                                <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button> <br><br>
                                </div>
                            </form>
                            <br><br>
                             
                    </div>
            </div>

            <div class="row" >
                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-12">
                          <table style="font-size:14px">
                          <tbody>
                          <?php foreach ($grn->result() as $row)
                          {
                           ?>
                           <tr>
                           <td><?php echo $row->GRDate?></td>
                           <td width="50" align="center"><?php echo $row->Qty?></td>
                           <td align="right"><?php echo $row->UnitPrice ?></td>
                           </tr>
                           <tr>
                           <td colspan="3"><?php echo $row->Name?></td>
                           </tr>

                          <?php 
                          }
                          ?>
                          </tbody>
                          </table>                        
                          
                          </div>
                        </div>
                    </div>
            </div>


                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>