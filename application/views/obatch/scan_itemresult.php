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
                        
                        <a onclick="history.go(-1)" href="<?php echo site_url('obatch_controller/scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>Batch Transfer Out <br> <small><?php echo $_SESSION['refno'] ?> &nbsp&nbsp <?php echo $_SESSION['location'] ?></small></font>

                        
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('obatch_controller/add_qty'); ?>">
                        <div class="form-group">
                          <?php 
                          foreach($item->result() as $row)
                          {
                            ?>
                            
                            <h5><b>Batch Barcode: </b><?php echo $row->batch_barcode; ?></h5>
                            <h5><b style="color:red" >Original Gross Weight : </b><?php echo $row->goods_pallet_weight?></h5>
                                             
                            <input value="<?php echo $row->goods_pallet_weight?>" name="goods_pallet_weight" type="hidden"> 
                            <input value="<?php echo $row->batch_barcode?>" name="barcode" type="hidden">
                            <?php
                          }
                              ?>

                        </div>
              
                </div>
            </div>

            <div class="row" >
                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                        
                                <div style="float:left">
                                    <h5><b style="color:blue">Re Weight : </b>&nbsp
                               
                                    <input autofocus required value="<?php foreach($qty->result() as $row)
                                    { echo $row->pick_gdpl_weight; } ?>" type="number" step ="any" name="iqty" onfocus="this.select()" style="text-align:center;width:80px;" />
                                   </h5>
                                    <br>
                                </div>
                                
                            </div>
                          </div>

                                <div style="float:left">
                                <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button> <br><br>
                                <input type="text" class="form-control" placeholder="Remarks" name="remarks" id="textarea" />
                                </div>
                            </form>
                            <br><br>
                             
                    </div>
            </div>

           
                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>