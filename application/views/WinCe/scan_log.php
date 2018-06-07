<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>SCAN LOG <?php echo $type?></b> </h5></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><h5><b>Ref No :</b> <?php echo $refno?></h5></p>
<table width="200" class="cTable">
  <tr align="center">
    <td class="cTD">Line</td>
    <td class="cTD">Rec.Qty</td>
    <td class="cTD">Description</td>
    <td class="cTD">Itemcode</td>
    <td class="cTD">Created</td>
  </tr>
  <?php
      foreach ($result->result() as $row)
      {
          ?>
  <tr>
    <td class="cTD"><?php echo $row->lineno; ?></td>
    <td class="cTD"><center><?php echo $row->scan_qty; ?></center></td>
    <td class="cTD"><center><?php echo $row->scan_description; ?></center></td>
    <td class="cTD"><?php echo $row->scan_itemcode; ?></td>
    <td class="cTD"><center><?php echo $row->created_at; ?>
      <a style="float:right" href="<?php echo site_url('Main_controller/scan_log')?>?delete_scan&delete_batch_scan=<?php echo $row->scan_qty?>&item_guid=<?php echo $row->item_guid?>&scan_guid=<?php echo $row->scan_guid?>&type=<?php echo $type ?>&uniq_guid=<?php echo $uniq_guid?>" onclick="return check()" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a></center></td>

  </tr>
  <?php
        }
    ?> 
</table>
<p>
  </p>
</p>
</div>  
</body>
</html>