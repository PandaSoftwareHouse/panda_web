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
                        
                        <a href="<?php echo site_url('stktake_pre_controller/scan_binID')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Stock take - prelisting
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>

            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    
                        <div class="form-group">
                            
                           <!-- <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('stktake_pre_controller/pre_itemscan'); ?>"> -->

                                <?php
                                foreach($result->result() as $row)
                                {
                                    $_SESSION['locBin'] = $row->Location;
                                    
                                }
                                ?>
                            <a href="<?php echo site_url('stktake_pre_controller/pre_itemscan'); ?>?locBin=<?php echo $_SESSION['locBin']?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> SCAN ITEM</b></button></a>

                        </br>
                        <!-- </form> -->
                        </div>
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            
                            <div style="overflow-x:auto;">
                                <h5><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?> &nbsp</h5>
                                
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                <a style="color:black;float:right" href="<?php echo site_url('stktake_pre_controller/pre_itemPrint')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" >
                                    <i class="fa fa-print fa-3x" style="color: grey"></i></a>

                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;"><b>Qty</b></td>
                                        <td><b>Description</b></td>
                                    </tr>
                                </thead>
                                <?php
                               
                                    if($itemlist->num_rows() != 0)
                                    {
                                        foreach ($itemlist->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        <td class="big" style="text-align:center;"><?php echo $row->Qty; ?></td>
                                        <td class="big"><a href="<?php echo site_url('stktake_pre_controller/pre_itemEdit')?>?Barcode=<?php echo $row->Barcode?>&TRANS_GUID=<?php echo $row->TRANS_GUID ?>&binID=<?php echo $row->BIN_ID?>&locBin=<?php echo $_SESSION['locBin']?>">
                                            <?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></a>

                                            <a style="float:right" style="" href="<?php echo site_url('stktake_pre_controller/pre_itemDelete')?>?TRANS_GUID=<?php echo $row->TRANS_GUID?>" 
                                                class="btn btn-xs btn-danger" onclick="return check()">
                                            <span class="glyphicon glyphicon-trash" ></span> </a>
                                            </td>
                                        <input type="hidden" name="item_guid" value="<?php echo $row->TRANS_GUID; ?>"/>
                                    </tr>
                                </tbody>
                                <?php
                                        }
                                    }   
                                        else
                                        {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="5" style="text-align:center;">No Record Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>
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