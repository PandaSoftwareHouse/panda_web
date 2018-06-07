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
                        
                        <a  style="float:right">
                        <i onclick="history.go(-1);" class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

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
                        <div class="form-group">
                        <?php
                        if($qty_diff < 0)
                        {
                          ?>
                          <h4><b style="color:red">Short Qty !!!</b></h4>
                          <?php
                        }
                        else
                        {
                          ?>
                          <h4><b style="color:red">Excess Qty !!!</b></h4>
                          <?php
                        }
                        ?>
                            
                            <h4><b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?></b></h4>
                                   <h3><b style="color:red">&nbsp&nbsp&nbsp<?php echo $qty_diff?></b></h3>
                        </div>
                        <?php
                        if($qty_diff > 0)
                        {
                          ?>
                          <a href="<?php echo site_url('greceive_controller/convert_excess_to_foc_1')?>?item_guid=<?php echo $item_guid?>"><button value="submit" name="submit" type="submit" class="btn btn-primary btn-xs" ><b>FOC</b></button></a>
                          &nbsp&nbsp&nbsp
                          <button class="btn btn-success btn-xs" onclick="history.go(-1);" ><b>BACK</b></button>
                          <?php
                        }
                        else
                        {
                          ?>
                          <a href="<?php echo site_url('greceive_controller/barcode_scan?')?><?php echo $_SESSION['method']?>"><button class="btn btn-success btn-xs" ><b>NEXT</b></button></a>
                          <?php
                        }
                        ?>
                        
                        
                </div>
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