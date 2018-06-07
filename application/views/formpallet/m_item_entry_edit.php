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
                        
                        <a href="<?php echo site_url('formpallet_controller/m_batch_entry?batch_guid='.$_SESSION['batch_guid'])?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>form pallet<br>
                         <small><b><?php echo $heading?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                    <!-- <?php echo var_dump($_SESSION)?>  -->
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/item_entry_update')?>">
                        <div class="form-group">
                            
                           <h4><b><?php echo $line_no?>&nbsp&nbsp <?php echo $WeightTraceQtyUOM?></b></h4>
                              
                                <h4><b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030"); ?></b></h4>
                            
                                <div style="float:left">

                                  <h5><b>Weight(kg)</b></h5>
                                    <input autofocus onfocus="this.select()" value="<?php echo $scan_weight?>" type="number" step="any" style="text-align:center;width:80px;background-color:#ffff99" name="weight" />

                                    <br>

                                    <h5><b>Received Qty</b></h5>
                                    <input autofocus name="rec_qty" type="number" step="any" style="text-align:center;width:80px;background-color:#80ff80" onfocus="this.select()"
                                      value="<?php echo $received_qty?>"/>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    <?php
                                    if($check_trace_qty == '1')
                                    {
                                      ?>
                                      <h5><b>Trace Qty</b></h5>
                                      <input  value="<?php echo $trace_qty?>" type="number" step="any" 
                                      name="trace_qty" style="text-align:center;width:80px;background-color:#f4b042"/>
                                      <br><br>
                                      <?php
                                    }
                                    else
                                    {
                                      ?>
                                       <input value="<?php echo $trace_qty?>" name="trace_qty" type="hidden"> 
                                      <?php
                                    }
                                    ?>
                                    

                                    <!-- <h5><b>Remarks</b></h5>
                                    <textarea rows="2" name="remark" cols="35" ></textarea> -->
                                </div>

                                
                                <br><br><br><br><br><br>
                                <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                                
                                </select>
                                   
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