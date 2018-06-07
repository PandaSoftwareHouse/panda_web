<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>SIMPLE PO</b><br>
    </h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
  <a href="<?php echo site_url('simplepo_controller/scan_item'); ?>" class="btn_primary">+ ADD ITEM</a></p>
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
   <a href="<?php echo site_url('simplepo_controller/view_item')?>?po_guid=<?php echo $row->PO_GUID;?>"><?php echo $row->DESCRIPTION; ?></a>
  </td>
    <td class="cTD" style="text-align:center;"><?php echo $row->QTY_ORDER ?></td>
    </tr>
      <?php
          }
      ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

