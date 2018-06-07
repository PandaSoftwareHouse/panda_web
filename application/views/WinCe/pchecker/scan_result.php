<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Price Checker </b></h5></td>
    <td width="20"><a href="<?php echo site_url('Pchecker_controller/scan_barcode')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('pchecker_controller/scan_result'); ?>">
  <p>
    <label>Scan Barcode<br>
    </label>
    <input type="text" style="background-color: #e6fff2" class="form-control input-md"  name="barcode" id="autofocus"/>
  </p>
</form>

<?php
  if($result->num_rows() > 0)
  {
    foreach($result->result() as $row)
    {
      ?>

<p>
 <a href="<?php echo site_url('pchecker_controller/sku_info')?>" class="btn_primary"><b>SKU INFO</b></a><br>
<b><?php echo convert_to_chinese($row->barDesc, "UTF-8", "GB-18030");?><b><br>
<b>Price :</b><?php echo $row->barPrice?><br>
<b>ItemLink :</b><?php echo $row->itemlink?><br>
<b>Pack Size :</b><?php echo $row->packsize?></p>
<p>
<a href="<?php echo site_url('pchecker_controller/stock')?>?itemlink=<?php echo $row->itemlink ?>&packsize=<?php echo $row->packsize?>" class="btn_info"><b>STOCK</b></a>

&nbsp;&nbsp;

<a href="<?php echo site_url('pchecker_controller/itemlink')?>?itemlink=<?php echo $row->itemlink ?>" class="btn_success"><b>ITEMLINK</b><a></p>

<?php
    }
                              
  }
  else
  {
    ?>
    <h3 style="color:red">Barcode not found!</h3>
    <?php
  }
  ?>
<p>&nbsp;</p>
</div>
</body>
</html>