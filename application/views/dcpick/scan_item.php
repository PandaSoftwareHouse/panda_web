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
    font-size: 7px;
  }
  h1,h3{
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  } 
  h6,td.big {
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
                        
                        <a href="<?php echo site_url('dcpick_controller')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>dc mobile pick<br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/scan_item_result'); ?>">
                        <div class="form-group">
                            
                            <!-- <h5><b>Request No :</b><a target="_blank" href="<?php echo site_url('dcpick_controller/itemlist') ?>?dc_trans_guid=<?php echo $dc_trans_guid?>&dc_refno=<?php echo $dc_refno?>"> <?php echo $dc_refno?></a></h5> -->
                            <h5><b>Request No :</b> <?php echo $dc_refno?></h5>
                            <h5><b>Location To :</b><?php echo $dc_locto?></h5>
                            
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Item Barcode" name="barcode" id="textarea" required autofocus onblur="this.focus()" />
                            </span>
                            <input type="hidden" name="dc_trans_guid" value="<?php echo $dc_trans_guid?>">
                            <h5><b>Total Records :</b><?php echo $count?></h5>
                        </div>
                    </form>
                    <br>
                    <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>

                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>No</th>
                                      <th>Itemcode</th>
                                      <th>Description</th>
                                      <th style="text-align:center;">Qty</th>
                                      <th style="text-align:center;">Qty Mobile</th>
                                      <th>Reason</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td class="big"><?php echo $row->line; ?></td>
                                              <td class="big"><?php echo $row->Itemcode; ?></td>
                                              <td class="big">
                                                <?php
                                                if($row->scan_type == 'BATCH')
                                                {
                                                    ?>
                                                    <a href="<?php echo site_url('Main_controller/scan_log')?>?type=<?php echo $row->type?>&item_guid=<?php echo $row->item_guid?>&dc_child_guid=<?php echo $row->CHILD_GUID?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); echo '&nbsp'?></a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?>
                                                    <?php
                                                }
                                                ?>
                                              </td>
                                              <td class="big" style="text-align:center;"><?php echo $row->qty; ?></td>
                                              <td class="big" style="text-align:center;"><?php echo $row->qty_mobile; ?></td>
                                              <td class="big"><?php echo $row->reason; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    ?> 
                                  </tbody>
                                </table>
                            </div>
                            
                        </div>

                    </div>
                        <!-- /. ROW  -->
                </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>