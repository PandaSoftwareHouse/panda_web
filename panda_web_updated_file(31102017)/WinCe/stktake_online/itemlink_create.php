<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Online Stock Take </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_online_controller/scan_item')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><b><?php echo $description?></b> <small>P/size : <?php echo $packsize?></small><br>
  QOH:<?php echo $QOH?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('stktake_online_controller/itemlink_create_insert')?>" type="submit" class="btn_primary">CREATE</a>
  </p>
<table width="200" class="cTable">
<thead>
  <tr>
    <td class="cTD">P/size</td>
    <td class="cTD">QOH</td>
    <td class="cTD">Description</td>
    <td class="cTD">Itemcode</td>
  </tr>
</thead>
   <?php
     foreach ($result_itemlink->result() as $row)
     {
   ?>
  <tr>
    <td class="cTD"><?php echo $row->packsize; ?></td>
    <td class="cTD"><?php echo $row->OnHandQty; ?></td>
    <td class="cTD"><?php echo $row->description; ?></td>
    <td class="cTD"><?php echo $row->itemcode; ?></td>
  </tr>
   <?php
      }
   ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>