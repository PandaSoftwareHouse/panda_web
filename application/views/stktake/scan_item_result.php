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
                        
                        <a href="<?php echo site_url('stktake_controller/scan_item?bin_ID='.$_SESSION['bin_ID']."&user_ID=".$_SESSION['user_ID'])?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                      

                        <font>Stock take
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('Stktake_controller/add_qty'); ?>">
                        <div class="form-group">
                          <?php 
                          foreach($item->result() as $row)
                          {
                            ?>
                            <?php // echo var_dump($_SESSION) ?>
                            <h5><b>Barcode: </b><?php echo $row->barcode;?> &nbsp
                            <b>P/Size: </b><?php echo $row->packsize;?></h5>
                            <h5><b>Desc: </b><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></h5>
                            <h5><b>Selling Price: </b><?php echo $row->sellingprice?></h5>
                            <h5><b>Location : </b><?php echo $_SESSION['bin_location']; ?></h5>

                            <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
                            <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
                            <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
                            <input value="<?php echo htmlentities(convert_to_chinese($row->description, "UTF-8", "GB-18030"));?>" name="description" type="hidden">
                            <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">
                            <input value="<?php echo $row->itemlink?>" name="itemlink" type="hidden">
                            <?php
                          }
                          ?>
                              
                         
                        </div>
                    
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
                                    min="0" max="100000" step='any' disabled 
                                    
                                    <?php 
                                    foreach ($itemQty -> result() as $row)
                                    {
                                    ?> 
                                      value="<?php echo $row->qty?>"/>
                                      <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
                                    <?php 
                                    }
                                    ?>
                                    <input type="hidden" name="defaultqty" value="0"/>
                                     
                                    <b style="font-size:28px">&nbsp +</b>

                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    <h5><b>Qty Input</b></h5>
                                   <?php if($_SESSION['get_weight'] == '' ) 
                                   {
                                    ?>
                                    <input autofocus required type="decimal" value="0" onfocus="this.select()" name="iqty" style="text-align:center;width:80px;" max="100000" step='any'/>
                                    <?php 
                                  }
                                  else 
                                  {
                                    ?>
                                    <input autofocus onclick="this.focus();this.select()" required  type="decimal" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" style="text-align:center;width:80px;" step='any'/>
                                    <?php 
                                  }
                                  ?>

                                </div>
                                
                                <br><br>
                                <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid"> 
                          
                            </div>
                          </div>

                                <div style="float:left">
                                 <h5 style = "color:red">
                                  <?php 
                                    foreach ($detail -> result() as $row)
                                    { 
                                  ?>
                                    <br>
                                  <?php 
                                        echo $row->detail;
                                    }
                                  ?> 
                                </h5>
                                   <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                                   
                                  <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
                                </div>
                            </form>
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>