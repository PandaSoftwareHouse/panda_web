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
  p {
    font-size: 12px;
  }

  td.big{
    font-size: 8px;
  }
  h1.page-head-line{
    font-size: 25px;
  }

}

</style>

<script type="text/javascript">

function check()
{
    var answer=confirm("Confirm want request item ?");
    return answer;
}

$('[required]').on('blur', function () {
    if (!$(this).val().length) { // check if the value is empty
        // Could do an alert or something else
    }
});

var input = document.getElementById('required').value;

if( input == null || input == "" )
        {
            alert("please insert this field");
            return false;
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

                        <a href="<?php echo site_url('main_controller/homemenu')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <a href="<?php echo site_url('pandarequest_controller/scanbarcodeview')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px""></i></a>

                        <font>Stock request</font>

                      </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                    </div>
                </div>

                <!--1-->
                <div class="row">
                    <!--1.1-->
                    <div class="col-md-4">
                        <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scanbarcode'); ?>">
                          <div class="form-group">
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Item Barcode" name="barcode" id="textarea"/>
                            </span>
                          </div>
                        </form><br>

                    </div>
                </div>

                <!-- ROW  -->
                <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                            <div class="col-md-12">
                            <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Link</b></td>
                                        <td><b>Description</b></td>
                                        <td style="text-align:center;"><b>Pack<br> Size</b></td>                                        
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Bulk<br> Qty</b></td>
                                    </tr>
                                </thead>
                                <?php
                                if($h->num_rows() != 0)
                                {
                                    foreach ($h->result() as $row)
                                    {
                                    $_SESSION['Itemcode'] = $row->Itemcode;
                                    $_SESSION['ItemLink'] = $row->ItemLink;
                                    $_SESSION['Description'] = convert_to_chinese($row->Description, "UTF-8", "GB-18030");
                                    $_SESSION['OnHandQty'] = $row->OnHandQty;
                                ?>   
                                <tbody>
                                    <tr>
                                      <td class="big"><?php echo $row->Itemcode; ?></td>
                                      <td class="big"><?php echo $row->ItemLink; ?></td>
                                      <td><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $row->PackSize; ?></td>
                                      <td style="text-align:center;"><?php echo round($row->OnHandQty, 2) ; ?></td>
                                <form class="form-inline" role="form" method="POST" id="myForm" 
                                action="<?php echo site_url('pandarequest_controller/add_request')?>">
                                      <td style="text-align:center;width:80px">
                                        <input autofocus id="required" class="big" type="number" step="any" name="qty_request[]" value="" 
                                        style="text-align:center;width:70px;" required></td>
                                    <td style="text-align:center;"><?php echo $row->BulkQty; ?></td>
                                    </tr>
                                </tbody>
                                <input type="hidden" name="PackSize[]" value="<?php echo  $row->PackSize ?>" />
                                <input type="hidden" name="BulkQty[]" value="<?php echo  $row->BulkQty ?>" />
                                <input type="hidden" name="Itemcode[]" value="<?php echo  $row->Itemcode ?>" />
                                <input type="hidden" name="ItemLink[]" value="<?php echo $row->ItemLink ?>" />
                                <input type="hidden" name="Description[]" value="<?php echo htmlentities(convert_to_chinese($row->Description, "UTF-8", "GB-18030")); ?>" />
                                <input type="hidden" name="OnHandQty[]" value="<?php echo $row->OnHandQty; ?>" /> 
                                <?php
                                    }
                                }
                                else
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="7" style="text-align:center;">No Item Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }

                                ?>
                                </table>
                            </div>
                                 <?php foreach ($guid->result() as $row)
                                    {
                                    $_SESSION['guid'] = $row->Trans_ID;
                                    } 
                                ?>   
                                    <input type="hidden" name="guid[]" value="<?php echo $_SESSION["guid"] ?>" style="text-align:center;width:80px;" max="100000"/> 

                                    <?php 
                                    foreach ($h1->result() as $row)
                                    {
                                        //$_SESSION['Itemcode1'] = $row->Itemcode;
                                        //$_SESSION['ItemLink1'] = $row->ItemLink;
                                        //$_SESSION['Description1'] = $row->Description;
                                        //$_SESSION['OnHandQty1'] = $row->OnHandQty;
                                    ?>
                                    <input type="hidden" name="Itemcode1" value="<?php echo $row->Itemcode; ?>"/>
                                    <input type="hidden" name="ItemLink1" value="<?php echo $row->ItemLink; ?>"/>
                                    <input type="hidden" name="Description1" value="<?php echo htmlentities(convert_to_chinese($row->Description, "UTF-8", "GB-18030")); ?>"/>
                                    <input type="hidden" name="OnHandQty1" value="<?php echo $row->OnHandQty; ?>"/>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    foreach ($qty_balance->result() as $row)
                                    {
                                        ?>
                                        <p><b>Qty Balance: <?php echo $row->qty_balance;?></p><br/>
                                        <input type="hidden" name="qty_balance" value="<?php echo $row->qty_balance; ?>"/>
                                        <input type="hidden" name="qty_requested" value="<?php echo $row->qty_request; ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if($h->num_rows() != 0)
                                    {
                                        ?>
                                        <button value="add" name="add" type="submit" class="btn btn-primary  btn-xs" onclick="return check()">
                                        <a href=<?php echo site_url('pandarequest_controller/view_item'); ?> style="color:black;text-decoration:none"><b>ADD</b></a></button>
                                        
                                        <!--<button value="cancel "name="cancel" type="button" onclick="location='itemdetails.php'" class="btn btn-default btn-sm" style="margin-left: 0px;background-color:#f44336;width:70px;margin-right:8px">
                                        <a href=<?php echo site_url('pending_submit_c/viewdata'); ?>?guid=<?php echo 
                                        $_SESSION['guid']; ?> style="color:black;text-decoration:none"><b>CANCEL</b></a></button>-->
                                        
                                        &nbsp&nbsp&nbsp&nbsp<button value="go" name="go" type="submit" class="btn btn-success  btn-xs"  onclick="return check()">
                                        <a href=<?php echo site_url('pending_submit_c/viewdata'); ?> style="color:black;text-decoration:none"><b>DONE</b></a></button>
                                    
                                        <?php
                                    }
                                    ?>
                                    
                                </form>

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