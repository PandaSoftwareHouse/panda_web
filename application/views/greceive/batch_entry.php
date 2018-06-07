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
                        
                        <a href="<?php echo $backbutton?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>&scode=<?php echo $_SESSION['scode'] ?>&doc_posted=<?php echo $_SESSION['doc_posted'] ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po 
                        <br><small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                        <br>
                        <?php
                        if($postButton == '1' && $_SESSION['grn_by_weight'] == '0'  && $item->num_rows() != 0)
                        {
                            ?>
                            <a href="<?php echo site_url('greceive_controller/po_post_grn_scan?get_refno='.$grn_id)?>" ><button class="btn btn-default btn-sm" style=""><b>POST DOCUMENT</b></button></a>
                            <?php
                        }
                        ?>
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
                            
                            <a href="<?php echo site_url('greceive_controller/barcode_scan?by_qty'); ?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>

                            <?php
                            if($_SESSION['grn_by_weight'] == '0')
                            {
                                ?>
                                <a class="btn btn-default btn-xs" href="<?php echo site_url('greceive_controller/po_print')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>&print_type=batch_only&grn_guid=<?php echo $_SESSION['grn_guid']?>" style="float: right;color: black"><i class="fa fa-print fa-2x" ></i> ITEM LIST
                                <input type="checkbox" 
                                <?php
                                if($batch->row('send_print') != 0)
                                {
                                    ?>
                                    checked disabled
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    disabled
                                    <?php
                                }
                                ?>
                                ></a>
                                <?php
                                if($grda_button != 0)//more than 1
                                {
                                    ?>
                                    <a class="btn btn-warning btn-xs" href="<?php echo site_url('greceive_controller/po_print')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&print_type=batch_list" style="float: right;color: black;margin-right: 12px"><i class="fa fa-print fa-2x" ></i> GRDA LIST </a>
                                    <?php

                                };
                                
                            };
                            ?>

                            <br>

                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <h5><b>Batch ID :</b><?php echo $batch->row('batch_id')?></h5>
                            <h5><b>Batch barcode :</b><?php echo $batch->row('batch_barcode')?></h5>
                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                <thead>
                                    <tr>
                                        <th>Line</th>
                                        <?php if($check_pay_by_invoice == '1') { ?>
                                        <th>DO.Qty</th>
                                        <?php } ?>
                                        <th>Rec.Qty</th>
                                        <th>Var.Qty</th>
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
                                        <?php if($check_pay_by_invoice == '1') { ?>
                                        <td class="big"><?php echo $row->qty_do; ?></td>
                                        <?php } ?>
                                        <td class="big"><?php echo $row->qty_rec; ?></td>
                                        <td class="big"><?php echo $row->qty_diff; ?></td>
                                        <td class="big">
                                            <?php
                                            if($row->scan_type == 'BATCH')
                                            {
                                                ?>
                                                <a href="<?php echo site_url('greceive_controller/item_c')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->scan_description; echo '&nbsp'?><i class="fa fa-th-list" style="color:#4380B8"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="<?php echo site_url('greceive_controller/item_entry_flow')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->scan_description; ?></a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="big"><?php echo $row->scan_weight_total; ?></td>
                                        <td class="big"><?php echo $row->scan_weight; ?>
                                            <a style="float:right;" href="<?php echo site_url('greceive_controller/batch_itemDelete')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>" class="btn btn-xs btn-danger" onclick="return check()">
                                            <span class="glyphicon glyphicon-trash"></span> </a>
                                        </td>
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