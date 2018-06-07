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
                        
                        <a onclick="history.go(-1)" href="<?php echo site_url('simplepo_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>SIMPLE PO
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                        <div class="form-group">
                          <?php 
                          foreach($chekview->result() as $row)
                          {
                            ?>
                            <h5><b>Itemcode: </b><?php echo $row->ITEMCODE;?></h5>
                            <h5><b>Description : </b><?php echo $row->DESCRIPTION?></h5>
                            <h5><b>Qty : </b><?php echo $row->QTY_ORDER?>&nbsp <b>Price :</b><?php echo $row->PRICE_PURCHASE?>
                            </h5>

                            <h5><b>Supplier :</b><?php if($row->SUP_CODE == '') { echo ' --NULL--';} 
                              else { echo $row->SUP_CODE;} ?>&nbsp&nbsp <?php echo $row->SUP_NAME?></h5>
                            <?php
                          }
                              ?>
                        <a href="<?php echo site_url("simplepo_controller/delete_item?po_guid=".$_REQUEST['po_guid'])?>" style="float:left">
                        <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span> DELETE</button></a>
                        </div>
                    <br>
                </div>
            </div>
  
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>