<html>
<body onload="autofocus()">
<div class="container">
   <table width="200" border="0">
    <tr>
        <td width="120"><h5><b>STOCK PICK</b><br>
        </h5></td>
        <td width="20"><a id="dontprint" href="<?php echo site_url('pandarequest_controller/stock_view_transaction')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a id="dontprint" href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
    </tr>
   </table>      
  <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
      <form role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scan_item_request'); ?>">
          <label>Item Barcode</label><br>
          <input type="text" style="background-color:#e6fff2" class="form-control input-md" placeholder="Search by" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/>

          <?php
            foreach ($item->result() as $row)
              {
                $_SESSION['Itemcode'] = $row->Itemcode;
                $_SESSION['ItemLink'] = $row->Itemlink;
                $_SESSION['Description'] = $row->Description;
                $_SESSION['OnHandQty'] = $row->qty_request;
          ?>   
          <?php
              }
          ?>

            <?php
              foreach ($TransID->result() as $row)
                {
            ?>
              <input type="hidden" name="TransID" value="<?php echo $row->Trans_ID?>"/>
            <?php
                }
            ?>
      </form>   
                        
      <table width="200" class="cTable">
        <thead>
            <tr>
                <td class="cTD"><b>Item Code</b></td>
                <td class="cTD"><b>Item Link</b></td>
                <td class="cTD"><b>Description</b></td>
                <td class="cTD" style="text-align:center;"><b>Qty On<br> Hand</b></td>
                <td class="cTD" style="text-align:center;"><b>Qty<br> Request</b></td>
                <td class="cTD" style="text-align:center;"><b>Carton<br> Qty</b></td>
                <td class="cTD" style="text-align:center;"><b>Qty<br> Pick</b></td>
                <td class="cTD" style="text-align:center;"><b>Qty<br> Balance</b></td>
            </tr>
        </thead>

        <?php
        if($item->num_rows() != 0)
        {
            foreach ($item->result() as $row)
            {
            $_SESSION['Itemcode'] = $row->Itemcode;
            $_SESSION['ItemLink'] = $row->Itemlink;
            $_SESSION['Description'] = $row->Description;
            $_SESSION['OnHandQty'] = $row->qty_request;
        ?>   
                                
        <tbody>
          <tr>
            <td class="cTD" class="big"><?php echo $row->Itemcode; ?></td>
            <td class="cTD" class="big"><?php echo $row->Itemlink; ?></td>
            <td class="cTD"><?php echo $row->Description; ?></td>
            <td class="cTD" style="text-align:center;"><?php echo $row->Qoh; ?></td>
            <td class="cTD" style="text-align:center;"><?php echo $row->qty_request; ?></td>
            <td class="cTD" style="text-align:center;">
            <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
            <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
            <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
            <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/add_qty_pick')?>">

            <td class="cTD" style="text-align:center;">
            <input type="number" class="form-control input-md" name="qty_pick[]" style="text-align:center;background-color:#e6fff2;">
            </td>
            <td class="cTD" style="text-align:center;"><?php echo $row->qty_balance; ?></td>
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
         <br><br>
         <a href="<?php echo site_url('pending_submit_c/viewdata'); ?>"><input type="submit" name="submit" value="SUBMIT" class="btn_success"></a>
         
                                    
      </form>  
</div>
<p>&nbsp;</p>
</body>
</html>                                        