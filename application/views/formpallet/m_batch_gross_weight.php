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
                        
                        <a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>form pallet
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small><br></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('formpallet_controller/goods_pallet_weight_update'); ?>">
                    <h4><b>Pallet ID :</b>
                    <?php foreach($result->result() as $row)
                    {
                      echo $row->batch_id;
                      $_SESSION['goods_pallet_weight'] = $row->goods_pallet_weight;
                    }
                    ?><br><small>Gross Weight (kg)</small></h4>
                        <div class="form-group">
                            
                            
                            <input  type="text" name="goods_pallet_weight" style="width:170px;background-color:#ffff99" value="<?php echo $_SESSION['goods_pallet_weight']?>" onfocus="this.select()" autofocus>

                            
                        </div><br>
                        <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>DONE</b></button>
                    </form>
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