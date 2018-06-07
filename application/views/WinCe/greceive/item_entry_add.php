<html>
<body>
<div class="container">
<table width="200" border="0" style="margin-bottom: -20px;">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br>
      <font><small><b><?php echo $heading?></b></small></font></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<?php
                  if($this->session->userdata('message') )
                  {
                     echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                  }
                  ?>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_entry_insert')?>?item_guid=">
   <?php
    if($hide_po_info == 1)
    {
      ?>
                          
      <?php
    }
    else
    {
      ?>
  <table width="200" border="0" style="margin-top: -30px;">
    <tr>
      <td>Order:<b><?php echo $order_qty?>

        <?php if($check_bulk_qty > '1')
        { ?>
          (<?php echo $bulk_qty; ?>)
        <?php } ?>
      </b></td>
      <td>Balance:<b><?php echo $balance_qty?></b></td>
      <td>FOC:<?php echo $foc_qty?></td>
    </tr>
    
    <tr >
      <td colspan="3" >
        <?php
          }
        ?>
      <br><b><?php echo $_SESSION['barcode']?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $line_no?></b></b></td>
      </tr>
    <tr>
      <td colspan="3">Description:<b><?php echo $description?></b></td>
    </tr>
    <tr>
      <td colspan="3">
        <?php
          if($hide_supplier_do_entry == 1)
          {
        ?>

     <input value="<?php echo $do_qty?>" type="number" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" type="hidden"/>
      <?php
        }
        else
        {
      ?>
      </td>
      </tr>
</table>
  <table width="200" border="0" style="margin-top: -15px;">
    <tr>
      <td><h5 ><b>D/O Qty</b></h5></td>
      <td> <h5><b>Rec Qty/Kg</b></h5></td>
    </tr>
    <tr>
      <td>
        <input autofocus onfocus="this.select()" value="<?php echo $do_qty?>" type="number" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" id="autofocus"/>
        <?php
          }
        ?>
      </td>
      <td>
        <input name="rec_qty" type="number" style="text-align:center;width:80px;background-color:#80ff80" onfocus="this.select()"
      <?php
        if($check_recqty_aspoqty == 1)
        {
      ?>
        value="<?php echo $received_qty?>"
      <?php
        } 
        else
        {
      ?>
        value="0"
      <?php
        }
      ?>/>
      </td>
    </tr>
    <tr>
      <td class="<?php echo $hide_weight?>"><h5><b>Weight(kg)</b></h5></td>
      <td>
      <?php
        if($check_trace_qty == '1')
        {
      ?>
      <h5><b>Trace Qty</b></h5>
       <?php
      }
    else
    {
      ?>
         
      <?php
    }
    ?>
      </td>
      </tr>
    <tr>
      <td class="<?php echo $hide_weight?>">
        <input  value="<?php echo $scan_weight?>" type="number" name="weight" style="text-align:center;width:80px;background-color:#e6ccff" />
      </td>
<td>
 <?php
    if($check_trace_qty == '1')
            {
          ?>
    <?php
      }
    else
    {
      ?>
        <input type="hidden" value="<?php echo $WeightTraceQtyCount?>" name="trace_qty" type="hidden"> 
      <?php
    }
    ?>
</span></td>
    </tr>
    <tr>
      <td colspan="2"><input name="submit" type="submit" class="btn_success" id="submit" value="SAVE"></td>
      </tr>
    <?php
    if($superid_required == 1)
    {
      ?>
      <tr>
        <td colspan="2"><h5><b>Supervisor Password</b></h5></td>
        </tr>
      <tr>
        <td colspan="2">
          <input type="date" class="form-control" value="" name="superid">
          </td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td colspan="2"><h5><b>Expired Date</b></h5></td>
      </tr>
    <tr>
      <td colspan="2">
        <input type="date" value="<?php echo $expiry_date?>" name="expiry_date">
      </td>
    </tr>
    <tr>
      <td colspan="2"><h5><b>Reason</b></h5></td>
      </tr>
    <tr>
      <td colspan="2">
        <select name="reason" style="background-color:#ccf5ff" class="form-control" >
          <!-- <option selected data-default disabled style="display: none;">Select Reason:</option> -->
          <option value="" disabled selected>Select Reason:</option>
          <?php
            foreach($set_master_code->result() as $row)
              {
          ?>
          <option value="<?php echo $row->CODE_DESC;?>"><?php echo $row->CODE_DESC;?></option>
          <?php
              }
          ?>
        </select>
      </td>
      </tr>
    <tr>
      <td colspan="2">
        <input value="<?php echo $_REQUEST['scan_itemcode']?>" name="scan_itemcode" type="hidden">
        <input value="<?php echo $balance_qty?>" name="balance_qty" type="hidden">
        <input value="<?php echo $order_qty?>" name="order_qty" type="hidden">
        <input value="<?php echo $foc_qty?>" name="foc_qty" type="hidden">
        <input value="<?php echo $WeightTraceQty?>" name="WeightTraceQty" type="hidden">
        <input value="<?php echo $WeightTraceQtyUOM?>" name="WeightTraceQtyUOM" type="hidden">
        <input value="<?php echo $PurTolerance_Std_plus?>" name="PurTolerance_Std_plus" type="hidden">
        <input value="<?php echo $PurTolerance_Std_Minus?>" name="PurTolerance_Std_Minus" type="hidden">
        <input value="<?php echo $superid_required?>" name="superid_required" type="hidden">
      </td>
      </tr>
  </table>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

