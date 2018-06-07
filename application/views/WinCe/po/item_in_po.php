<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>Purchase Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('PO_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<?php
    foreach ($header->result() as $row)
      {  
?>  

<p><h5><b><?php echo $row->acc_name; ?></b>
<br>(<?php echo $row->poprice_method; ?>)</h5></p>
<p><h5><b>Cost:</b> <?php echo $row->bill_amt_format; ?></h5>


<a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo $row->acc_code?>" class="btn_primary">+ ADD ITEM</a>
</p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('PO_controller/save_amount'); ?>?web_guid=<?php $_REQUEST['web_guid']?>&acc_code=<?php echo $_REQUEST['acc_code']?>">

  <input value="<?php echo $_REQUEST['web_guid'] ?>" type="hidden" name="web_guid">
  <input value="<?php echo $row->acc_code; ?>" type="hidden" name="acc_code">
  
<table width="200" class="cTable">
<thead>
  <tr>
    <td colspan="2"><input type="submit" name="submit" value="SAVE" class="btn_success"></td>
  </tr>
</thead>
  <tr>
    <td>Total exc tax</td>
    <td><input value="<?php echo $amount->row('amt_exc_tax')?>" type="number" step="any" name="amt_exc_tax" style="width: 100;" id="autofocus" onfocus="this.select()" placeholder="Total exc tax"></td>
  </tr>
  <tr>
    <td>Gst amount</td>
    <td><input value="<?php echo $amount->row('gst_amt')?>" type="number" step="any" name="gst_amt"  style="width: 100" placeholder="Gst amount"></td>
  </tr>
  <tr>
    <td>Total inc tax</td>
    <td><input value="<?php echo $amount->row('amt_inc_tax')?>" type="number" step="any" name="amt_inc_tax" style="width: 100" placeholder="Total inc tax"></td>
  </tr>
</table>
</form>
<?php
  }
?> 

<?php
  if($item->num_rows() != 0)
    {
?>

<table width="200" class="cTable">
<thead>
  <tr>
    <td class="cTD">Item Code</td>
    <td class="cTD">Barcode</td>
    <td class="cTD">Item Name</td>
    <td class="cTD"  style="text-align:center;">Price</td>
    <td class="cTD"  style="text-align:center;">Qty</td>
    <td class="cTD"  style="text-align:center;">Amt</td>
    <td class="cTD"  style="text-align:center;">Action</td>
  </tr>
</thead>
<?php
  foreach ($item->result() as $row)
    {  
?>        
                     
  <tr>
    <td class="cTD"><?php echo $row->itemcode; ?></td>
    <td class="cTD"><?php echo $row->barcode; ?></td>
    <td class="cTD">
    <?php if($row->scan_type == 'BATCH')
    {
    ?>
      <a href="<?php echo site_url('Main_controller/scan_log'); ?>?type=<?php echo $row->module_desc ;?>&item_guid=<?php echo $row->item_guid ;?>&web_c_guid=<?php echo $row->web_c_guid?>"><?php echo $row->description; echo '&nbsp'?><img src="<?php echo base_url('assets/icons/batch.jpg');?>"></a>
    <?php
    }
    else
    {
    ?>
      <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>"><?php echo $row->description; ?></a>
    <?php
    }
    ?>
    </td>
    <td class="cTD" style="text-align:center;">$ <?php echo $row->price; ?></td>
    <td class="cTD" style="text-align:center;"><?php echo $row->qty; ?></td>
    <td class="cTD" style="text-align:center;"><?php echo $row->amount; ?></td>
    <td class="cTD" style="text-align:center;">
    <a href="<?php echo site_url('PO_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()">
    <img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a> 

    </td>
  </tr>
  <?php
    }
  ?>
  </table>
  <?php
    }
    else
    {
  ?>
  <h3>No Records Found!!!<h3>
    <?php
      }
    ?>
<p>&nbsp;</p>
</div>
</body>
</html>

