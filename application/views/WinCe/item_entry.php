<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br><font><small><b><?php echo $heading?></b></small></font></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_entry_update')?>?item_guid=<?php echo $_REQUEST['item_guid']?>">
    <table width="200" border="0">
    <tr>
      <td>Order: <b><?php echo $order_qty?></b></td>
      <td>FOC: <b><?php echo $foc_qty?></td>
      <td>Balance: <b><?php echo $balance_qty?></b></td>
    </tr>
    <tr>
      <td colspan="3">Description: <b><?php echo $description?></b></td>
    </tr>
    <tr>
      <td colspan="3"><b><?php echo $line_no?></b></td>
      </tr>
  </table>
  <table width="200" border="0">
    <tr>
      <td><h5 ><b>DO Qty</b></h5></td>
      <td> <h5><b>Received Qty</b></h5></td>
    </tr>
    <tr>
      <td><input value="<?php echo $do_qty?>" class="form-control" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" type="number"/>
        <input type="hidden" name="balance_qty" value="<?php echo $balance_qty?>">
      </td>
      <td><input value="<?php echo $received_qty?>" class="form-control" name="rec_qty" type="number" style="text-align:center;width:80px;background-color:#80ff80"/>
     </td>
    </tr>
    <tr>
      <td><h5><b>Weight(kg)</b></h5></td>
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
      <td><input autofocus value="<?php echo $scan_weight?>" type="number" class="form-control" name="weight" style="text-align:center;width:80px;background-color:#e6ccff" onfocus="this.select()"/>
</td>
<td>
  <?php
    if($check_trace_qty == '1')
    {
  ?>
  <input  value="<?php echo $trace_qty?>" type="number" class="form-control" name="trace_qty" style="text-align:center;width:80px;background-color:#f4b042"/>
  <?php
    }
    else
    {
  ?>
  <input type="hidden" value="<?php echo $WeightTraceQtyCount?>" class="form-control" name="trace_qty" type="hidden">
  <?php
    }
  ?>
</td>
    </tr>
    <tr>
      <td colspan="2"><input name="submit" type="submit" class="btn_success" id="submit" value="SAVE">
      </td>
      </tr>
    <tr>
      <td colspan="2"><h5><b>Expired Date</b></h5></td>
      </tr>
    <tr>
      <td colspan="2">
        <input type="date" class="form-control" value="<?php echo $expiry_date?>" name="expiry_date">
        </td>
    </tr>
    <tr>
      <td colspan="2"><h5><b>Reason</b></h5></td>
      </tr>
    <tr>
      <td colspan="2">
        <select name="reason" style="background-color:#ccf5ff" class="form-control" >
          <!-- <option selected data-default disabled style="display: none;">Select Reason:</option> -->
          <?php
            foreach($set_master_code->result() as $row)
              {
          ?>
          <option><?php echo $row->CODE_DESC;?></option>
          <?php
              }
          ?>
        </select>
      </td>
      </tr>
    <tr>
      <td colspan="2">
        <input value="<?php echo $balance_qty?>" name="balance_qty" type="hidden">
        <input value="<?php echo $WeightTraceQty?>" name="WeightTraceQty" type="hidden">
        <input value="<?php echo $WeightTraceQtyUOM?>" name="WeightTraceQtyUOM" type="hidden">
        <input value="<?php echo $PurTolerance_Std_plus?>" name="PurTolerance_Std_plus" type="hidden">
        <input value="<?php echo $PurTolerance_Std_Minus?>" name="PurTolerance_Std_Minus" type="hidden">
      </td>
      </tr>
  </table>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

