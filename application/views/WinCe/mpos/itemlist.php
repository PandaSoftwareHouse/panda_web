<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>MOBILE POS</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('Mpos_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a>
    </td>
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

<p>
  <a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo ''?>" class="btn_primary">+ ADD ITEM</a>
  <?php 
    } 
  ?>
  </p>
   <input value="<?php echo $_REQUEST['web_guid']?>" name="web_guid" type="hidden">
<table width="200"  class="cTable">
<thead>
  <tr>
    <td class="cTD">Description</td>
    <td class="cTD" style="text-align:center;">Qty</td>
    </tr>
</thead>
   <?php
    foreach ($result->result() as $row)
    {
    ?>                         
  <tr>

    <td class="cTD">
    <a href="<?php echo site_url('general_scan_controller/scan_itemresult')?>?web_c_guid=<?php echo $row->web_c_guid; ?>&web_guid=<?php echo $row->web_guid; ?>&itemcode=<?php echo $row->itemcode; ?>&barcode=<?php echo $row->barcode; ?>"><?php echo $row->description; ?></a>
    <a style="float: right" href="<?php echo site_url('Adjin_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a>
  </td>
    <td class="cTD" style="text-align:center;"><?php echo $row->qty ?></td>
    </tr>
      <?php
          }
      ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

