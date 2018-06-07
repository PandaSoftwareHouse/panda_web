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
                  <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/sendprint'); ?>">
                    
                    <h1 class="page-head-line">

                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/homemenu')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <a href="<?php echo site_url('pandarequest_controller/scan_binID_view')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px""></i></a>

                        <a id="dontprint" href='' style="float:right" target="_blank" >
                        <button type="submit" name="print" value="print" class="btn btn-default btn-sm" style="float:right;margin-right:20px;background-color:#00b359">
                        <i id="dontprint" class="glyphicon glyphicon-print" style="font-size:12px;color:black;margin-right:8px"></i><b>PRINT</b></button></a>

                        <font>Stock request</font>
                        
                        <?php
                    foreach ($item->result() as $row)
                      {
                    ?>
                    <input style="display:none;" type="hidden" name="guid" value="<?php echo $row->Trans_ID?>">
                    <input style="display:none;" name="Itemcode[]" value="<?php echo $row->Itemcode?>">
                    <?php  
                      }
                    ?>
                        </form>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scanbarcode'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <!--<input type="hidden" value="<?php echo $_REQUEST['guid']?>" class="form-control" placeholder="Item Barcode" name="guid" id="textarea" autofocus/>-->
                            <input type="text" class="form-control" placeholder="Item Barcode" name="barcode" id="textarea" required autofocus onblur="this.focus()" />
                            <!--<button class="btn btn-default" style="background-color:#00b359" type="submit" name="submit" >
                                <i class="fa fa-gear fa-spin"></i>&nbsp;&nbsp;SEARCH
                            </button>-->
                            </span>
                        </div>
                    </form><br>
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <?php
                            $bin_ID = $this->session->userdata('bin_ID');
                            ?>
                            <p><b>Bin_ID :</b><?php echo $bin_ID?></p>
                            <div style="overflow-x:auto;">
                              <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Link</b></td>
                                        <td><b>Description</b></td>                                    
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Carton<br> Qty</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Balance</b></td>
                                    </tr>
                                </thead>
                                <?php
                                if($item->num_rows() != 0)
                                {
                                    foreach ($item->result() as $row)
                                    {
                                ?>   
                                <tbody>
                                    <tr>
                                      <td class="big"><?php echo $row->Itemcode; ?></td>
                                      <td class="big"><?php echo $row->Itemlink; ?></td>
                                      <td><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $row->Qoh; ?></td>
                                      <td style="text-align:center;"><?php echo $row->qty_request; ?></td>
                                      <td style="text-align:center;">
                                      <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
                                      <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
                                      <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
                                      <?php
                                      if($row->qty_balance == '0')
                                      {
                                        ?>
                                        <td style="text-align:center;">NO QTY</br> BALANCE</td>
                                        <?php
                                      }
                                      else
                                      {
                                        ?>
                                        <td style="text-align:center;"><?php echo $row->qty_balance; ?></td>
                                        </tr>
                                      </tbody>
                                      <?php
                                      }
                                    }
                                }
                                else
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="7" style="text-align:center;">No Item Scaned</td>
                                            </tr>
                                        </tbody>
                                        <?php       
                                        }
                                ?>
                                </table>
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