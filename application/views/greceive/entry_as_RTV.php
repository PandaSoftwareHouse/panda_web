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
                        
                        <a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>GRN BY PO<br>
                         <small><b>RTV <?php echo $type?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
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
                          <h4>Description: <b></b></h4>
                          <input required <?php echo $disabled?> value="<?php echo htmlentities(convert_to_chinese($description, "UTF-8", "GB-18030"));?>" style="background-color:#ffff99" name="description"/>

                          <h5>Qty: </h5>
                          <input autofocus onfocus="this.select()" required value="<?php echo $qty_do?>" name="qty_do" style="width:80px;background-color:#80ff80" type="number" step="any"/>           
                        </div>
                          <input type="hidden" name="guid" value="<?php echo $guid?>">
                          <input type="hidden" name="scan_barcode" value="<?php echo $scan_barcode?>">
                        <br><button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
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