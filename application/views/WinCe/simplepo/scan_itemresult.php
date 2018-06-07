<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>SIMPLE PO</b><br>
    </h5></td>
    <td width="20"> <a onclick="history.go(-1); return false;" href="<?php echo site_url('simplepo_controller/scan_item')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('simplepo_controller/add_qty'); ?>">
  <?php 
    foreach($item->result() as $row)
    {
  ?>
  <table width="200" border="0">
    <tr>
      <td colspan="4"><b>Itemcode: </b><?php echo $row->Itemcode;?></td>
    </tr>
    <tr>
      <td width="84"><b>QOH: </b><?php echo $row->OnHandQty?></td>
      <td colspan="3"><b>Avg: </b><?php echo $row->AverageCost?></td>
      </tr>
    <tr>
      <td colspan="2"><b>Last: </b><?php echo $row->LastCost?></td>
      <td colspan="2"><b>Selling: </b><?php echo $row->BarPrice?></td>
      </tr>
    <tr>
      <td colspan="3"><b>Margin : </b><?php echo $row->Margin?>%</td>
      <td width="77"><b>Sold: </b><?php echo $row->SalesTempQty?></td>
      </tr>
    <tr>
      <td colspan="4"><b>Description : </b><?php echo $row->Description?></td>
    </tr>
    <input value="<?php echo $row->Itemcode?>" name="itemcode" type="hidden">
    <input value="<?php echo $row->Description?>" name="description" type="hidden">
    <input value="<?php echo $row->LastCost?>" name="lastcost" type="hidden">
    <input value="<?php echo $row->BarPrice?>" name="barprice" type="hidden">
    <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
    </table>
      <?php
        }
      ?>
  <p><br>
    <label for="textfield">Order Qty</label>
    <br>
  <input autofocus required type="decimal" value="0" onfocus="this.select()" class="form-control" name="iqty" style="text-align:center;background: #e6fff2;width: 80px" />
  </p>
  <p><input type="submit" value="SAVE" class="btn_success"></p>
</form>
<?php foreach ($grn->result() as $row)
    {
?>
<p><?php echo $row->GRDate?>&nbsp;&nbsp;<?php echo $row->Qty?>&nbsp;&nbsp;<?php echo $row->UnitPrice ?><br>
 <?php echo $row->Name?>
</p>
<?php 
    }
?>
<p>&nbsp;</p>
</div>
</body>
</html>

