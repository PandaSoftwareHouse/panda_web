<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>SIMPLE PO</b><br>
    </h5></td>
    <td width="20"> <a onclick="history.go(-1); return false;" href="<?php echo site_url('simplepo_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
  <?php 
    foreach($chekview->result() as $row)
    {
  ?>
<p><b>Itemcode :</b><?php echo $row->ITEMCODE;?><br>
  <b>Description : </b><?php echo $row->DESCRIPTION?><br>
  <b>Qty : </b><?php echo $row->QTY_ORDER?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Price :</b><?php echo $row->PRICE_PURCHASE?>
  <br>
  <b>Supplier :</b><?php if($row->SUP_CODE == '') { echo ' --NULL--';} else { echo $row->SUP_CODE;} ?>&nbsp;&nbsp; <?php echo $row->SUP_NAME?></p>
     <?php
        }
      ?>
<p>
<a href="<?php echo site_url("simplepo_controller/delete_item?po_guid=".$_REQUEST['po_guid'])?>" style="float:left" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()" class="btn_delete">DELETE</a></p>
                    
<p>&nbsp;</p>
</div>
</body>
</html>

