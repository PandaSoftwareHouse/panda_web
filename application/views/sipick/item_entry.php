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
                        
                        <a href="<?php echo site_url('sipick_controller/scan_item_error')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>si mobile pick<br>
                         <small><b><?php echo $si_refno?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('sipick_controller/item_entry_add')?>">
                        <div class="form-group">
                                <h4><b><?php echo $si_description?></b>&nbsp&nbsp
                                 <br><b><?php echo $iteminfo?></h4>
                                <div style="float:left">
                                    <h5 >Req Qty</h5>
                                    <input disabled type="number"
                                     value="<?php echo $si_qty?>" style="text-align:center;width:80px" name=""/>
                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <h5><b>Actual Qty</b></h5>
                                    <input type="number"
                                     value="<?php echo $si_qty_mobile ?>" style="text-align:center;width:80px;background-color:#ffff99" name="qty_mobile" autofocus onblur="this.focus()" onfocus="this.select()"
                                     />
                                </div>
                                <br><br><br>

                                <input type="hidden" name="itemcode" value="<?php  ?>">
                                
                                <button value="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                        </div>
                        <br><br><br><br>
                                  
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