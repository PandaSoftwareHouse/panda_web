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
  td.big {
    font-size: 12px;
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
                        
                        <a href="<?php echo site_url('formpallet_controller/m_barcode_scan')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>FORM pallet
                         <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_entry_update')?>?>">
                        <div class="form-group">
                            <h4><b><?php echo convert_to_chinese($query_heading->row('description'), "UTF-8", "GB-18030");?><br><br><?php echo $_SESSION['barcode']?>&nbsp&nbsp</b>
                            <?php
                            if($query_heading->row('grn_by_weight_hide_po_info') == 0 )
                            {
                                ?>
                                <b style="float:right"><?php echo $query_heading->row('po_bal')?></b>
                                <?php
                            } 
                            ?>
                          </h4>  
                        </div>
                                  
                    </form>

                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                                         
                              <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <th>Pack Size</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                   <?php
                                    foreach($query_item->result() as $row)
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="big"><?php echo $row->packsize?>
                                                <?php
                                                  if($po_itemcode == $row->itemcode )
                                                  {
                                                    ?>
                                                    <b style="color:red">**</b>
                                                    <?php
                                                  };
                                                  ?>
                                                  </td>
                                                <td class="big"><a href="<?php echo site_url('formpallet_controller/m_item_entry_add')?>?scan_itemcode=<?php echo $row->itemcode?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></a></td>
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