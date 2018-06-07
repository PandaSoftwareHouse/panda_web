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

                        <a href="<?php echo $backbutton; ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>GRN BY PO
                            <br>
                            <small><b><?php echo $pomain->row('SName')?></b></small>
                            <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                            <?php if($_SESSION['xsetup_send_print'] == '1') { ?>
                            <br>
                         <a href="<?php echo site_url('general_scan_controller/general_post')?>?type=PO&header_guid=<?php echo $pomain->row('RefNo') ?>&location=<?php echo $_SESSION['location'] ?>&refno=<?php echo $pomain->row('RefNo') ?>&po_no=<?php echo $pomain->row('RefNo') ?>&po_date=<?php echo $pomain->row('PODate') ?>&localdate=<?php echo $_REQUEST['localdate'] ?>&scode=<?php echo $pomain->row('SCode') ?>&s_name=<?php echo $pomain->row('SName') ?>&redirect_controller=greceive_controller&redirect_function=outstanding_po" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-print fa-lg"></i> Send Print </b></button></a> 
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
                            
                        <!--<form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('greceive_controller/outstanding_po'); ?>">
                              
                                <h6>Expected Delivery Date : <input class="form-control" type="date" name= "selected_date" value="<?php echo $selected_date ?>"> </h6>
                              <button type="submit" class="form-control" > Submit</button>  
                        </br>
                        </form>-->

                            <div style="overflow-x:auto;">
                                <h6 style="float:left"><b>RefNo:</b><?php echo $pomain->row('RefNo');?></h6>

                                <h6 style="float:right"><b>Total Records:</b><?php echo $pochild->num_rows();?></h6>
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                
                                <thead>
                                    <tr>
                                        <th>Itemcode</th>
                                        <th>Qty</th>
                                        <th style="text-align:center;">Description</th>
                                   <!--      <th>Created by</th>
                                        <th style="text-align:center;">Date</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        foreach ($pochild->result() as $row)
                                        {  
                                ?>        
                                
                                    <tr>
                                        <td class="big">
                                             <?php echo $row->Itemcode; ?> 
                                        </td>
                                        <td class="big"><?php echo $row->Qty; ?></a></td>
                                        
                                        <td class="big"><?php echo $row->Description; ?></td>
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