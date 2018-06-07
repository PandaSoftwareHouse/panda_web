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
                        
                        <a onclick="history.go(-1)" href="<?php echo site_url('Dnbatch_controller/scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>DN BATCH
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
                    action="<?php echo site_url('Dnbatch_controller/add_qty'); ?>">
                        <div class="form-group">
                          <?php 
                          foreach($item->result() as $row)
                          {
                            ?>
                            <h4><?php echo $_SESSION['batch_no'] ?></h4>
                            <h4><?php echo $row->name; ?></h4>
                            <h4><b>Description : </b><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></h4>
                            <h4><b>Barcode: </b><?php echo $row->barcode;?> </h4>
                            <h4><b>Tax Code Supply: </b><?php echo $row->tax_code_supply;?></h4>
                            <h4><b>Tax Code Purchase: </b><?php echo $row->tax_code_purchase;?></h4>
                            <h4><b>Last Purchase: </b><?php echo $row->podate;?></h4>
                            
                            <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
                            <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
                            <input value="<?php echo $_SESSION['batch_no'];?>" name="batch_no" type="hidden">
                            <input value="<?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?>" name="description" type="hidden">
                            <input value="<?php echo $scan_barcode;?>" name="scan_barcode" type="hidden">
                            <input value="<?php echo $_SESSION['decode_qty'];?>" name="decode_qty" type="hidden">
                            <!-- <input value="<?php echo $row->dbnote_c_guid;?>" name="decode_qty" type="text"> -->
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
                                    <h5 ><b>Qty</b></h5>
                               
                                    <input autofocus required value="<?php echo $qty;?>" type="number" step ="any" name="iqty" onfocus="this.select()" style="text-align:center;width:80px;" />
                              
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

           
                <?php // echo var_dump($_SESSION); ?>
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>