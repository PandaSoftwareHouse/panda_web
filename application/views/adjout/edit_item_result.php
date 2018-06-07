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
                        
                        <a onclick="history.go(-1)" href="<?php echo site_url('general_scan_controller/scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font><?php echo $module ?>
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
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('general_scan_controller/update_qty'); ?>">
                        <div class="form-group">
                        <?php //  echo $sellingprice  ?>
                          <?php 
                          foreach($itemresult->result() as $row)
                          {
                            ?>
                            
                            <h5><b>Barcode .: </b><?php echo $row->barcode;?> &nbsp
                            <b>P/Size: </b><?php echo $row->packsize;?></h5>
                            <h5><b>Desc: </b><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></h5>
                            <h5><b>Selling Price: </b><?php echo $row->sellingprice?> &nbsp 

                            <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
                            <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
                            <input value="<?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?>" name="description" type="hidden">
                            <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden"> 
                         <!--    <input value="<?php echo $row->itemlink?>" name="itemlink" type="hidden"> -->
                        <?php
                          }
                          foreach($itemQOH->result() as $row)
                            {
                              ?>
                              <b>QOH: </b><?php echo $row->SinglePackQOH?></h5>
                              <input value="<?php echo $row->SinglePackQOH?>" name="SinglePackQOH" type="hidden">
                             <?php
                            }
                            ?>
                            

                        </div>
                    <br>
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">

                         

                           <?php  // echo var_dump($_SESSION)?> 
                        
                                <div style="float:left">
                                    <h5 ><b>Qty</b></h5>
                                    
                                    <input type="number" name="qty" style="text-align:center;width:80px;" 
                                    min="0" max="100000" disabled 
                                    <?php 
                                     foreach ($itemQty -> result() as $row)
                                    {
                                    ?> 
                                    value="<?php echo $row->qty?>"/>
                                    <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
                                    <?php 
                                     }
                                     ?>
                                     
                                    <b style="font-size:28px">&nbsp +&nbsp</b>

                               
                                
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    <h5><b>Input Qty</b></h5>
                                    <input autofocus required type="decimal" name="iqty" style="text-align:center;width:80px;" max="100000"/>
                                    <h5><b>Remarks</b></h5>
                                    <textarea rows="2" name="remark" cols="35" ></textarea>
                                   
                                </div>
                             
                                <br><br><br><br>
                                <input value="<?php echo $this->session->userdata('web_c_guid'); ?>" type="hidden" name="web_c_guid">  
                          
                            </div>
                          </div>

                                <div style="float:left">
                                  <button value="view" name="view" type="submit" class="btn btn-default btn-sm" 
                                  style="margin-left: 0px;background-color:#00b359;width:70px;margin-right:8px;">
                                  <b>SAVE</b></button>
                                </div>
                            </form>
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>