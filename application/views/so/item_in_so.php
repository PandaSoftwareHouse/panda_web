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
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">

                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('SO_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>sales order
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
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
                            <h4><b><?php echo $row->acc_name; ?></b>

                            <br>(<?php if($row->Type = 'C') 
                            {
                                echo $row->tax_code;
                            }
                                elseif($row->Type = 'S')
                            {
                                echo $row->poprice_method;
                            }; ?>)</h4>
                            <h5><b>Cost:</b><?php echo $row->bill_amt_format; ?></h5><br>

                            <a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo $row->acc_code?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>
                            
                             <?php
                            }
                            ?> 
                        </br></br>
                       

                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">

                                <thead>
                                    <tr>
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Name</b></td>
                                        <td style="text-align:center;"><b>Price</b></td>
                                        <td style="text-align:center;"><b>Quantity</b></td>
                                         <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($item->result() as $row)
                                    {  
                                ?>        
                                
                                    <tr>
                                        <td class="big"><?php echo $row->itemcode; ?></td>
                                        <td class="big">
                                            <?php
                                            if($row->scan_type == 'BATCH')
                                            {
                                                ?>
                                                <a href="<?php echo site_url('Main_controller/scan_log'); ?>?type=<?php echo $row->module_desc ;?>&item_guid=<?php echo $row->item_guid ;?>&web_c_guid=<?php echo $row->web_c_guid?>"><?php echo $row->description; echo '&nbsp'?><i class="fa fa-th-list" style="color:#4380B8"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>"><?php echo $row->description ?>
                                                <?php
                                            }
                                            ?>
                                            <!-- <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>"><?php echo $row->description; ?> -->
                                        </td>
                                        <td class="big" style="text-align:center;">$ <?php echo $row->price; ?></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->qty; ?></td>
                                         <td align="center"><a href="<?php echo site_url('SO_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a> </td>
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