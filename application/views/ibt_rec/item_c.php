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
                        
                        <a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po 
                        <br><small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                        <br>
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
                            
                            <div style="float: right">
                                <form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_c_update_do_qty')?>?item_guid=<?php echo $_REQUEST['item_guid']?>&batch_guid=<?php echo $_REQUEST['batch_guid']?>">
                                    <h5 ><b>DO Qty</b></h5>
                                    <input value="<?php echo $do_qty?>" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" type="number" step="any" onchange="this.form.submit()" onfocus="this.select()"/>
                                </form>
                                
                            </div>

                            <br>
                            <h4>Scan By Batch List</h4>
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                <thead>
                                    <tr>
                                        <th>Line</th>
                                        <th>Rec.Qty</th>
                                        <th>Description</th>
                                        <th>Barcode</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($get_item_c->result() as $row)
                                    {  
                                ?>
                                    <tr>
                                        <td class="big"><?php echo $row->lineno; ?></td>
                                        <td class="big"><?php echo $row->qty_rec; ?></td>
                                        <td class="big"><?php echo convert_to_chinese($row->scan_description, "UTF-8", "GB-18030"); ?></td>
                                        <td class="big"><?php echo $row->scan_barcode; ?></td>
                                        <td class="big"><?php echo $row->created_at; ?>
                                            <a style="float:right;" href="<?php echo site_url('greceive_controller/item_entry_edit')?>?item_c&item_guid_c=<?php echo $row->item_guid_c?>&item_guid=<?php echo $row->item_guid ?>&batch_guid=<?php echo $row->batch_guid?>&posum_guid=<?php echo $row->posum_guid?>&redirect=<?php echo $_SERVER['REQUEST_URI']?>" class="btn btn-xs btn-danger" onclick="return check()">
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