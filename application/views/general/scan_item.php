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
                        
                        <a href="<?php echo $back ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Scan Items 
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                       
                        
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">


                          <?php
                          $web_guid = $this->session->userdata('web_guid');
                          $acc_code = $this->session->userdata('acc_code');
                          ?>

                          <input value="<?php echo $web_guid?>" name="web_guid" type="hidden">
                          <input value="<?php echo $acc_code?>" name="acc_code" type="hidden">
                           <!-- <input value="<?php echo $_SESSION['acc_code']?>" name="acc_code" type="hidden"> -->
                          <?php 
                          foreach ($module_desc->result() as $row) 
                          {
                          ?>
                          <input value= "<?php echo $row->module_desc?>" name = "module_desc" type = "hidden">
                          <?php 
                          }
                          ?>

                            <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode" id="textarea" required autofocus />


                            <br>
                            <br>
                             <!--  <?php
                                  $web_guid = $this->session->userdata('web_guid');
                               ?> -->
                            <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                           
                            <!-- <h5><a href="<?php echo site_url('general_scan_controller/weight_scan')?>?web_guid=<?php echo $web_guid; ?>">18 digit</a></h5> -->
    

                        
                            </span>
                        </div>
                    </form>
                    
                    <br>
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