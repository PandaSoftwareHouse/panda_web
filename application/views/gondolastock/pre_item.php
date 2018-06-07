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
  
  p,input,div,h4 {
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
                        
                        <a href="<?php echo site_url('gondolastock_controller/main')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Gondola Stock
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <a href="<?php echo site_url('gondolastock_controller/scan_binID'); ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> SCAN BIN ID</b></button></a>
<!--                         <div class="form-group">
                            
                           <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('gondolastock_controller/scan_binID'); ?>">
                            
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> SCAN BIN ID</b></button>

                        </br>
                        </form>
                        </div>
                    <br> -->
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12"> 
                                 <?php
                                foreach($pre_item->result() as $row)
                                {
                                ?>
                                <h4><a href="<?php echo site_url('gondolastock_controller/pre_itemlist')?>?bin_ID=<?php echo $row->BIN_ID?>" style="color:black"><i class="fa fa-dot-circle-o" style="color:grey"></i>
                                <b><?php echo $row->BIN_ID; ?></b></a></h4><br>
                                <?php
                                }
                                ?>
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>