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

                        <a href="<?php echo site_url('stktake_controller/scan_binID?user_ID='.$_SESSION['user_ID'])?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>stock take</font>
                        
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_controller/scan_item_result'); ?>">
                        <div class="form-group">
                            <?php
                           // echo var_dump($_SESSION);
                            if ($_SESSION['user_ID'] != '')
                            {
                            $user_ID = $_SESSION['user_ID'];
                            $bin_ID = $_SESSION['bin_ID'];
                            $_SESSION['get_weight'] = '';
                            $_SESSION['get_price'] = '';
                            }
                            else
                            {
                              $user_ID = $_REQUEST['user_ID'];
                              $bin_ID = $_REQUEST['bin_ID'];
                              $_SESSION['get_weight'] = '';
                              $_SESSION['get_price'] = '';
                            }
                            ?>
                            <p style = "color:red; float:right;margin-right:10px " ><?php 
                                    { echo $_SESSION['printinfo'] ; }
                                    ?></p>
                            <h5><b>User ID :</b><?php echo $user_ID?><a href="<?php echo site_url('stktake_controller/send_print'); ?>" style="color: grey"><i style="float:right; margin-right:10px" class="fa fa-print fa-3x"  ></i> 
                            </a></h5>
                            <h5><b>Bin ID :</b><?php echo $bin_ID?></h5> 
                            <h5><b>Location :</b><?php echo $_SESSION['sublocation'];?></h5>
                            <span class="input-group-btn">

                            <!--<input type="hidden" value="<?php echo $_REQUEST['guid']?>" class="form-control" placeholder="Item Barcode" name="guid" id="textarea" autofocus/>-->
                            <input type="text" class="form-control" placeholder="Item Barcode" name="barcode" id="textarea" required autofocus onblur="this.focus()" />

                              <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            </span>
                        </div>
                    </form><br>
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
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