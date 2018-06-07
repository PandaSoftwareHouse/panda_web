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

                        <a href="<?php echo site_url('minmax_controller/backhome')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('minmax_controller/scan_barcode')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                         <font><?php echo $heading?>
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                         </font> 

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">
                        <div class="form-group">
                          <h5><b>Loc: </b><?php echo $_SESSION['locBin']?>&nbsp
                          <b>BinID: </b><?php echo  $_SESSION['bin_ID']?></h5>
                          <h5><b>Description: </b><?php echo convert_to_chinese($bardesc, "UTF-8", "GB-18030");?></h5>
                          <h5><b>Barcode: </b><?php echo $barcode?></h5>
                          <h5><b>Itemcode: </b><?php echo $itemcode?></h5>

                          <h5><b>Set Min : </b>
                          <input  class="form-control" autofocus id="set_min" onkeyup="automax()" onfocus="this.select()" required type="number" name="set_min" style="text-align:center;width:80px;" min="0" value="<?php echo $set_min ?>"/> 
                          <b>Set Max: </b>
                          <input class="form-control" id="set_max" onclick="this.select()" required type="number" name="set_max" style="text-align:center;width:80px;" max="100000" value="<?php echo $set_max ?>"/></h5>

                          <input type="hidden" value="<?php echo $itemcode ?>" name="itemcode">
                          <?php // echo var_dump($_SESSION); ?>
                           <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                        </div>
                    </form>
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    
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

<script type="text/javascript">
  function automax(){
    document.getElementById("set_max").value = document.getElementById("set_min").value;
  }
</script>