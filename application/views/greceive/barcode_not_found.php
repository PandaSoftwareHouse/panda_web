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
                        
                        <a href="<?php echo site_url('greceive_controller/barcode_scan')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po</font>
                        <br><small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                    <br>
                    <h5>Option :</h5>
                    <h5>1. <a href="<?php echo site_url('greceive_controller/entry_as_itemcode_view')?>?itemcode=<?php echo $_SESSION['barcode']?>">Receive as Item Code</a></h5>
                    
                    <!-- <?php
                    if(isset($_SESSION['item_guid']))
                    {
                      ?>
                      <h5>2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=<?php
                      echo $_SESSION['item_guid']?>">RTV - Return To Vendor</a></h5>
                      <?php
                    }
                    else
                    {
                      ?>
                      <h5>2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=">RTV - Return To Vendor</a></h5>
                      <?php
                    }
                    ?> -->
                    <h5>2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=">RTV - Return To Vendor</a></h5>

                    
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                              
                              </div>
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>