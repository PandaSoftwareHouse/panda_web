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
  p, label {
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
                        
                        <a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>&scode=<?php echo $_SESSION['scode'] ?>&doc_posted=<?php echo $_SESSION['doc_posted'] ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>GRN BY PO
                         <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/batch_weight_save')?>">
                        <div class="form-group">
                                <h4>Method: <?php echo $Method ?>&nbsp&nbsp&nbsp&nbsp<b><?php echo $PalletID?></b></h4>
                                <br>
                            
                                <div style="float:left">
                                    <label><b><?php echo $MethodCode?></b></label>
                                    <?php
                                    if($StockValueShow == true)
                                    {
                                      ?>
                                      <input type="number" autofocus value="<?php echo $StockValue?>" style="text-align:center;width:80px;background-color:" name="StockValue" onfocus="this.select()"/>
                                      <?php
                                    }
                                    ?>
                                    
                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <label><b><?php echo $UOM?></b></label>
                                    <?php
                                    if($MultiplyShow == true)
                                    {
                                      ?>
                                      <input value="<?php echo $Multiply ?>" name="Multiply" style="text-align:center;width:80px;background-color:"/>
                                      <?php
                                    }
                                    ?>
                                    
                                    <br>

                                </div>

                                <input type="hidden" name="guid" value="<?php echo $guid?>">
                                <br><br><br>
                                <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                                   
                        </div><br><br><br><br>
                                  
                    </form>

                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                                         
                              
                                
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>