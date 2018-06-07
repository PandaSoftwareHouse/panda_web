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

                        <a href="<?php echo site_url('shelveLabel_controller/barcode_scan')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>Shelve Label
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                  <h4><b>BIN ID: </b><?php echo $_SESSION['get_binID']?>&nbsp&nbsp<b>Barcode: </b><?php echo $_SESSION['get_barcode']?>
                  </h4>
                  <h4><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?>&nbsp&nbsp<b>RM: </b><?php echo $price?>
                  </h4>
                   <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('shelveLabel_controller/save'); ?>">
                   <?php
                   if($_SESSION['formatButton'] == '1')
                   {
                    ?>
                    <input style="font-size: 12px" type="radio" name="format" value="0"><font style="font-size: 16px"> UP
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input checked type="radio" name="format" value="1"> DOWN </font>
                    <?php
                   }
                   else
                   {
                    ?>
                    <input checked type="radio" name="format" value="0"><font style="font-size: 16px"> UP
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="radio" name="format" value="1"> DOWN </font>
                    <?php
                   }
                   ?>
                     
                    <br>
                   <br><button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                </div></form>
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