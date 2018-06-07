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
                        
                        <a href="<?php echo site_url('stktake_online_controller/itemlink_list')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>online stock take</font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                <h4><b><?php echo $Desc?></b>
                <small>P/size : <?php echo $Size?></small></h4>
                <h5><b>QOH : </b><?php echo $OnHand?> &nbsp&nbsp</h5>
                
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_online_controller/item_edit_save')?>">
                        <div class="form-group">           
                            <div style="float:left">
                              <h5 ><b>Actual:</b></h5>
                              <input type="number" style="text-align:center;width:80px;" min="0" max="100000" disabled value="<?php echo $Actual?>" step='any'/>&nbsp;&nbsp;&nbsp;&nbsp; <b style="font-size:28px">+</b>     
                            </div>
                                
                            <div style="float:left;margin-left:12px">
                              <h5><b>&nbsp</b></h5>
                              <input autofocus required type="number" value="0" onfocus="this.select()" name="qty_add" style="text-align:center;width:80px;" max="100000" step='any'/>     
                            </div> 
                        </div><br><br><br>
                        <input type="hidden" name="qty_actual" value="<?php echo $Actual?>">
                        <input type="hidden" name="qty_curr" value="<?php echo $OnHand?>">
                        <input type="hidden" name="trans_guid" value="<?php echo $_REQUEST['trans_guid']?>">
                          <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" 
                                  style="background-color:#00b359;"><b>SAVE</b></button>
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