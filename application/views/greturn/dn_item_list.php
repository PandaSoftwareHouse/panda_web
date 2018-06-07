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
                        
                        <a href="<?php echo site_url('greturn_controller/dn_list')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>goods return<br>
                        <small><b><?php echo $result->row('sup_name')?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        <?php if($_SESSION['xsetup_send_print'] == '1') { ?>
                        <br>
                        <a href="<?php echo site_url('general_scan_controller/general_post')?>?type=DN&header_guid=<?php echo $_REQUEST['sup_code'] ?>&location=<?php echo $_SESSION['location'] ?>&redirect_controller=greturn_controller&redirect_function=dn_list" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-print fa-lg"></i> Send Print </b></button></a> 
                        <?php } ?>
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
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <br>
                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                <thead>
                                    <tr>
                                        <td style="text-align: center"><b>Qty</b></td>
                                        <td><b>Barcode</b></td>
                                        <td><b>Name</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($result->result() as $row)
                                    {  
                                ?>        
                                    <tr>
                                        <td class="big" style="text-align: center"><?php echo $row->qty; ?></td>
                                        <td class="big"><?php echo $row->scan_barcode; ?><b style="float:right">P/S: <?php echo $row->packsize; ?></b></td>
                                        <td class="big">
                                        <a href="<?php echo site_url('greturn_controller/dn_item_edit')?>?item_guid=<?php echo $row->item_guid; ?>&edit_mode=edit&sup_code=<?php echo $_REQUEST['sup_code']?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></a><a href="<?php echo site_url('greturn_controller/delete_item')?>?item_guid=<?php echo $row->item_guid; ?>&sup_code=<?php echo $_REQUEST['sup_code']?>" class="btn btn-xs btn-danger" onclick="return check()" style="float:right">
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

            </div><?php // echo var_dump($_SESSION) ?>
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>