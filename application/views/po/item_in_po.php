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
    font-size: 7px;
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
  h6,td.big {
    font-size: 12px;
  }
  td {
    font-size: 12px;
  }
  font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  label{
     font-size: 12px;
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
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('PO_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>purchase order
                            <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                             <?php if($_SESSION['xsetup_send_print'] == '1') { ?>
                          <br>
                          <a href="<?php echo site_url('general_scan_controller/general_post')?>?type=PO&header_guid=<?php echo $_REQUEST['web_guid'] ?>&location=<?php echo $_SESSION['location'] ?>&redirect_controller=po_controller&redirect_function=main" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-print fa-lg"></i> Send Print</b></button></a> 
                          <?php } ?>
                        </font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                          
                                foreach ($header->result() as $row)
                                {  
                            ?>  
                            <h5><b><?php echo $row->acc_name; ?></b>
                            <br>(<?php echo $row->poprice_method; ?>)</h5>
                            <h5><b>Cost:</b> <?php echo $row->bill_amt_format; ?></h5>
                              
                                
                            <a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo $row->acc_code?>">
                            <button class="btn btn-default btn-sm" style="background-color:#4380B8;color:white;float:right">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>
<!-- 
                            <form role="form" method="POST" id="myForm" action="<?php echo site_url('PO_controller/save_amount'); ?>?web_guid=<?php $_REQUEST['web_guid']?>&acc_code=<?php echo $_REQUEST['acc_code']?>">
                                <button type="submit" name="save" class="btn btn-success btn-sm" style="color:white">
                                    <b> SAVE</b></button></a>
                                <br><br>

                                <input value="<?php echo $_REQUEST['web_guid'] ?>" type="hidden" name="web_guid">
                                <input value="<?php echo $row->acc_code; ?>" type="hidden" name="acc_code">

                                <label>Total exc tax</label>
                                <input value="<?php echo $amount->row('amt_exc_tax')?>" type="number" step="any" name="amt_exc_tax" class="form-control" style="width: 50%" placeholder="Total exc tax" onfocus="this.select()">
                                
                                <label>Gst amount</label>
                                <input value="<?php echo $amount->row('gst_amt')?>" type="number" step="any" name="gst_amt" class="form-control" style="width: 50%" placeholder="Gst amount" onfocus="this.select()">
                                
                                <label>Total inc tax</label>
                                <input value="<?php echo $amount->row('amt_inc_tax')?>" type="number" step="any" name="amt_inc_tax" class="form-control" style="width: 50%" placeholder="Total inc tax" onfocus="this.select()">
                            </form> -->
                            <?php
                            }
                            ?> 
                        </div>
                        <br>

                        <div class="col-md-12">
                        <?php
                        if($item->num_rows() != 0)
                            {
                                ?>
                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Barcode</th>
                                        <th>Item Name</th>
                                        <th style="text-align:center;">Price</th>
                                        <th style="text-align:center;">Quantity</th>
                                        <th style="text-align:center;">Amount</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        foreach ($item->result() as $row)
                                        {  
                                ?>        
                                
                                    <tr>
                                        <td ><?php echo $row->itemcode; ?></td>
                                        <td ><?php echo $row->barcode; ?></td>
                                        <td >
                                        <?php
                                            if($row->scan_type == 'BATCH')
                                            {
                                                ?>
                                                <a href="<?php echo site_url('Main_controller/scan_log'); ?>?type=<?php echo $row->module_desc ;?>&item_guid=<?php echo $row->item_guid ;?>&web_c_guid=<?php echo $row->web_c_guid?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); echo '&nbsp'?><i class="fa fa-th-list" style="color:#4380B8"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>">
                                                <?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></a>
                                                <?php
                                            }
                                            ?>
                                            <!-- <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>">
                                            <?php echo $row->description; ?></a> -->
                                        </td>
                                        <td style="text-align:center;">$ <?php echo $row->price; ?></td>
                                        <td style="text-align:center;"><?php echo $row->qty; ?></td>
                                        <td style="text-align:center;"><?php echo $row->amount; ?></td>
                                        
                                        <td align="center">
                                        <a href="<?php echo site_url('PO_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" > 
                                        <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a> 
                                        </td>
                                    </tr>
                                
                                <?php
                                        }
                                    
                                ?>
                            </tbody>
                            </table>
                            </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <h4>No Records Found</h4>
                                <?php
                            }
                        ?>
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