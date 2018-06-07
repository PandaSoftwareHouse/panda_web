<?php 
'session_start()' 
?>
<style>

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
<!--onload Init
onload="window.location.reload() "-->
<body onload="document.refresh();">
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <a href="<?php echo site_url('Pchecker_controller/scan_barcode')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>price checker
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pchecker_controller/scan_result'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <!--<input type="hidden" value="<?php echo $_REQUEST['guid']?>" class="form-control" placeholder="Item Barcode" name="guid" id="textarea" autofocus/>-->
                            <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode" id="textarea" required />
                            
                            </span>
                            <br>
                        </div>
                    </form>
                  
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-4">
                        
                            <?php
                            if($result->num_rows() > 0)
                            {
                              foreach($result->result() as $row)
                              {
                                ?>
                                 <a href="<?php echo site_url('pchecker_controller/sku_info')?>"><button value="post"class="btn btn-primary btn-xs" style="float:right"><b>SKU INFO</b></button></a>
                                
                                <div style="overflow-x:auto;">
                                  <h4><b><?php echo $row->barDesc?><b></h4>
                                  <table >
                                    <tr>
                                        <th><h5><b>Price</b></h5></th>
                                        <td><h5>: <?php echo $row->barPrice?></h5></td>
                                    </tr>
                                    <tr>
                                        <th><h5><b>ItemLink</b></h5></th>
                                        <td><h5>: <?php echo $row->itemlink?> </h5></td>
                                    </tr>
                                    <tr>
                                        <th><h5><b>Pack Size</b></h5></th>
                                        <td><h5>: <?php echo $row->packsize?></h5></td>
                                    </tr>
                                  </table>

                                </div><br>
                                <a href="<?php echo site_url('pchecker_controller/stock')?>?itemlink=<?php echo $row->itemlink ?>&packsize=<?php echo $row->packsize?>"><button value="post" name="post" type="submit" class="btn btn-info btn-xs" style=""><b>STOCK</b></button></a>
                                <a href="<?php echo site_url('pchecker_controller/itemlink')?>?itemlink=<?php echo $row->itemlink ?>" style="margin-left:10px"><button value="post" name="post" type="submit" class="btn btn-success btn-xs" style=""><b>ITEMLINK</b></button><a>
                              <?php
                              }
                              
                            }
                            else
                            {
                              ?>
                              <h3 style="color:red">Barcode not found!</h3>
                              <?php
                            }
                            ?>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>d