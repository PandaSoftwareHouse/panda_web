<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER OUT</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>           
 <a href="<?php echo site_url('obatch_controller/post_scan'); ?>" type="submit" class="btn_default"><small>POST</small></a>
<br><br>
<p>
<a href="<?php echo site_url('obatch_controller/add_remark'); ?>" class="btn_primary">+ ADD TRANS</a>
</p>
<table class="cTable">
  <thead style="cursor:s-resize">
    <tr>
      <th class="cTD">Refno</th>
      <th class="cTD" style="text-align:center;">Location To</th>
      <th class="cTD" style="text-align:center;">Remark</th>
      <th class="cTD" style="text-align:center;">Created By</th>
      <th class="cTD" style="text-align:center;">Created At</th>
    </tr>
  </thead>
  <tbody>
  <?php
      foreach ($result->result() as $row)
      {
  ?>
  <tr>
    <td class="cTD">
      <a href="<?php echo site_url('obatch_controller/itemlist')?>?trans_guid=<?php echo $row->trans_guid;?>"><?php echo $row->refno; ?><a style="float: right" href="<?php echo site_url('obatch_controller/delete_batch'); ?>?trans_guid=<?php echo $row->trans_guid;?>" onclick="return check()" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg') ?>"></a>
    </td>
    <td class="cTD" style="text-align:center;"><?php echo $row->location_to ?></td>
    <td class="cTD" style="text-align:center;"><?php  echo $row->remark?></td>
    <td class="cTD" style="text-align:center;"><?php  echo $row->created_by?></td>
    <td class="cTD" style="text-align:center;"><?php  echo $row->created_at?></td>
  </tr>
  <?php
      }
  ?> 
</tbody>
</table>
</div>
<p>&nbsp;</p>
</body>
</html>