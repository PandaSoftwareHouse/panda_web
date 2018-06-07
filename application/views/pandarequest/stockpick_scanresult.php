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

}

</style>

<script type="text/javascript">

function check()
{
    var answer=confirm("Confirm want pick item ?");
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

                        <a href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <a href="<?php echo site_url('pandarequest_controller/stock_view_transaction')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px""></i></a>

                        <font>Stock pick</font>

                      </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                    </div>
                </div>

                <!--1-->
                <div class="row">
                    <!--1.1-->
                    <div class="col-md-4">
                        <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scan_item_request'); ?>">
                          <div class="form-group">
                            <span class="input-group-btn">
                            
                            <input type="text" class="form-control" placeholder="Item Barcode" name="barcode" id="textarea"/>
                           
                            </span>
                          </div>
                          <?php
                               foreach ($item->result() as $row)
                                    {
                                    $_SESSION['Itemcode'] = $row->Itemcode;
                                    $_SESSION['ItemLink'] = $row->Itemlink;
                                    $_SESSION['Description'] = convert_to_chinese($row->Description, "UTF-8", "GB-18030");
                                    $_SESSION['OnHandQty'] = $row->qty_request;
                                ?>   
                          <!--<input type="" name="TransID" value="<?php echo $row->Trans_ID; ?>"/>-->
                          <?php
                                    }
                          ?>
                          <?php
                            foreach ($TransID->result() as $row)
                            {
                              ?>
                              <input type="hidden" name="TransID" value="<?php echo $row->Trans_ID; ?>"/>
                              <?php
                            }
                          ?>

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
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Carton<br> Qty</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Pick</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Balance</b></td>
                                    </tr>
                                </thead>
                                <?php
                                if($item->num_rows() != 0)
                                {
                                    foreach ($item->result() as $row)
                                    {
                                    $_SESSION['Itemcode'] = $row->Itemcode;
                                    $_SESSION['ItemLink'] = $row->Itemlink;
                                    $_SESSION['Description'] = convert_to_chinese($row->Description, "UTF-8", "GB-18030");;
                                    $_SESSION['OnHandQty'] = $row->qty_request;
                                ?>   
                                
                                <tbody>
                                    <tr>
                                      <td class="big"><?php echo $row->Itemcode; ?></td>
                                      <td class="big"><?php echo $row->Itemlink; ?></td>
                                      <td><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $row->Qoh; ?></td>
                                      <td style="text-align:center;"><?php echo $row->qty_request; ?></td>
                                      <td style="text-align:center;">
                                      <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
                                      <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
                                      <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
                                <form class="form-inline" role="form" method="POST" id="myForm" 
                                action="<?php echo site_url('pandarequest_controller/add_qty_pick')?>">
                                      <td style="text-align:center;width:80px">
                                        <input autofocus id="required" class="big" type="number" step="any" name="qty_pick[]" value="" 
                                        style="text-align:center;width:70px;" required autofocus></td>
                                    <td style="text-align:center;"><?php echo $row->qty_balance; ?></td>
                                    </tr>
                                </tbody>
                                
                                <input type="hidden" name="Itemcode[]" value="<?php echo  $row->Itemcode ?>" />
                                <input type="hidden" name="qty_balance[]" value="<?php echo  $row->qty_balance ?>" />
                                <input type="hidden" name="qty_request[]" value="<?php echo  $row->qty_request ?>" />
                                <input type="hidden" name="Trans_ID[]" value="<?php echo $row->Trans_ID ?>" /> 
                                <?php
                                    }
                                }
                                else
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="8" style="text-align:center;">No Item Found</td>
                                            </tr>
                                        </tbody>
                                        <?php        
                                    }
                                ?>
                                </table>
                            </div>
                            <?php
                            if($item->num_rows() != 0)
                            {
                              ?>
                              <button value="go" name="go" type="submit" class="btn btn-success btn-xs"  
                                onclick="return check()">
                                <a href=<?php echo site_url('pending_submit_c/viewdata'); ?> style="color:black;text-decoration:none">
                                <b>SUBMIT</b></a></button>
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