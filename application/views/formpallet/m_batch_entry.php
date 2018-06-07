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
  p,input,div,h4 {
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
  td.big {
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

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);


function check()
{
    var answer=confirm("Confirm want to delete item ?");
    return answer;
}

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
                        
                        <a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>form pallet &nbsp&nbsp
                        <a href="<?php echo site_url('formpallet_controller/m_po_print')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>&print_type=batch_only" style="color: grey"><i class="fa fa-print fa-lg" ></i></a>
                        
                        <br><small><b><?php echo $_SESSION['manual_batch_barcode']?></b> </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">

                            <a href='<?php echo site_url('formpallet_controller/m_barcode_scan')?>'>
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>
                            <br> 
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <h5><b>Batch :</b><?php echo $batch->row('batch_id')?></h5>
                            <div style="overflow-x:auto;">

                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                <thead>
                                    <tr>
                                        <th>Line</th>
                                        <th>DO.Qty</th>
                                        <th>Rec.Qty</th>
                                        <th>Description</th>
                                        <th>Total Weight</th>
                                        <th>Average <br>Unit Weight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($item->result() as $row)
                                    {  
                                ?>
                                    <tr>
                                        <td class="big"><?php echo $row->lineno; ?></td>
                                        <td class="big"><?php echo $row->qty_do; ?></td>
                                        <td class="big"><?php echo $row->qty_rec; ?></td>
                                        <td class="big"><a href="<?php echo site_url('formpallet_controller/m_item_entry_edit')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo convert_to_chinese($row->scan_description, "UTF-8", "GB-18030"); ?></a>
                                        <a style="float:right;" href="<?php echo site_url('formpallet_controller/batch_itemDelete')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>" class="btn btn-xs btn-danger" onclick="return check()">
                                            <span class="glyphicon glyphicon-trash"></span> </a></td>
                                        <td class="big"><?php echo $row->scan_weight_total; ?></td>
                                        <td class="big"><?php echo $row->scan_weight; ?></td>
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