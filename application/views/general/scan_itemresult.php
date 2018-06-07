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
                        
                        <a onclick="history.go(-1); return false;" href="<?php echo site_url('general_scan_controller/scan_item')?>" style="float:right">
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
                    action="<?php echo site_url('general_scan_controller/add_qty'); ?>">
                        <div class="form-group">
                          <?php 
                          foreach($itemresult->result() as $row)
                          {
                            ?>
                            <h5><b>Barcode: </b><?php echo $row->barcode;?> &nbsp
                            <b>P/Size: </b><?php echo $row->packsize;?></h5>
                            <h5><b>Desc: </b><?php echo htmlentities(convert_to_chinese($row->description, "UTF-8", "GB-18030"));?></h5>
                            <h5><b>Selling Price: </b><?php echo $row->sellingprice?> &nbsp

                            <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
                            <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
                            <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
                            <input value="<?php echo htmlentities(convert_to_chinese($row->description, "UTF-8", "GB-18030")); ?>" name="description" type="hidden">
                            <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">
                            <input value="<?php echo $row->soldbyweight?>" name="soldbyweight" type="hidden">
                            <input value="<?php echo $row->itemlink?>" name="itemlink" type="hidden">
                            <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
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
                        
                                <div style="float:left">
                                    <h5 ><b>Qty</b></h5>
                                    
                                    <input type="number" name="qty" style="text-align:center;width:80px;" 
                                    min="0" max="100000" disabled 
                                    <?php 
                                    if($_SESSION['get_weight'] == '' ) 
                                    {
                                      foreach ($itemQty -> result() as $row)
                                      {
                                      ?> 
                                      value="<?php echo $row->qty?>"/>
                                      <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
                                    <?php 
                                      }
                                    }
                                    else
                                    {
                                      ?>
                                      <input type="hidden" name="defaultqty" value="0">
                                      <?php 
                                    } 
                                    ?>
                                     
                                    <b style="font-size:28px">&nbsp&nbsp&nbsp&nbsp +</b>

                                    <br>

                                    <!-- <h5><b>FOC Qty</b></h5>
                                    <input type="number"  name="foc_qty" style="text-align:center;width:80px;" max="100000"/> -->
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    <h5><b>Input Qty</b></h5>
                                     <?php 
                                     if($_SESSION['get_weight'] == '' ) 
                                      {
                                        if(isset($_SESSION['decode_qty']))
                                        {
                                          ?>
                                          <input autofocus required type="number"  max="100000" value="<?php echo $_SESSION['decode_qty']?>" onfocus="this.select()" step="any" name="iqty" style="text-align:center;width:80px;" />
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                            <input autofocus required type="number" value="0" onfocus="this.select()" step="any" max="100000" name="iqty" style="text-align:center;width:80px;" />
                                          <?php 
                                        }
                                        
                                      }
                                      else 
                                      {
                                        ?>
                                        <input disabled type="number" step="any" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" max="100000" style="text-align:center;width:80px;" />
                                         <input hidden type="number" step="any" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" max="100000" style="text-align:center;width:80px;" />
                                        <?php 
                                      }
                                      ?>
                                    <h5><b>Remarks</b></h5>
                            <textarea rows="2" name="remark" cols="24" ></textarea>
                                    
                                </div>
                                
                                <br><br><br><br>
                                <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid">
                            </div>
                          </div>

                                <div style="float:left">
                                <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
                                </div>
                            </form>
                            <br>
                            
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>