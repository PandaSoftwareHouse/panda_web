<?php 
'session_start()' 
?>
<style>

@media screen and (max-width: 768px) {
  p,input,div,h4 {
    font-size: 7px;
  }
  h1,h3{
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  } 
  h6,td.big {
    font-size: 10px;
  }
  td{
    font-size: 12px
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
                        
                        <a href="<?php echo site_url("Adjout_controller/main?type=".$_SESSION['aotype']) ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>adjust out <?php if($_SESSION['aotype'] == 'DP') { echo '- Disposal';}; if($_SESSION['aotype'] == 'OU') { echo '- Own Use';}; ?>
                          <?php if($_SESSION['xsetup_send_print'] == '1') { ?>
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                          <br>
                          <a href="<?php echo site_url('general_scan_controller/general_post')?>?type=Adjust-Out&header_guid=<?php echo $_REQUEST['web_guid'] ?>&location=<?php echo $_SESSION['location'] ?>&redirect_controller=adjout_controller&redirect_function=main" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-print fa-lg"></i> Send Print</b></button></a> 
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
                                   // echo var_dump($_SESSION);
                                {  
                            ?> 

                            <a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo ''?>" >
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>
                           <?php } ?>
                            <input value="<?php echo $_REQUEST['web_guid']?>" name="web_guid" type="hidden">
                       
                        </form>
                        <br><br>
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>No</th>
                                      <th>Itemcode</th>
                                      <th>Description</th>
                                      <th style="text-align:center;">Qty</th>
                                      <th><center>Remarks</center></th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $count = 0;
                                        foreach ($result->result() as $row)
                                        { $count++;
                                            ?>
                                            <tr>
                                              <td> <?php echo $count; ?> </td>
                                              <td> <?php echo $row->itemcode; ?> </td>
                                              <td>

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
                                                <a href="<?php echo site_url('general_scan_controller/scan_itemresult')?>?web_c_guid=<?php echo $row->web_c_guid; ?>&web_guid=<?php echo $row->web_guid; ?>&itemcode=<?php echo $row->itemcode; ?>&barcode=<?php echo $row->barcode; ?>"><?php echo $row->description; ?></a>
                                                <?php
                                            }
                                            ?>
                                                

                                              <a style="float:right" href="<?php echo site_url('Adjout_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a>
                                              </td>
                                              <td style="text-align:center;"><?php echo $row->qty ?></td>
                                              <td><center><?php echo $row->remark_c; ?></center></td>
                                              

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