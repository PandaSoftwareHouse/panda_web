<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER OUT</b></h5><small><?php echo $_SESSION['refno'] ?></small>&nbsp;<small><?php echo $_SESSION['location'] ?></small></td>
    <td width="5"><a href="<?php echo site_url('obatch_controller/print_job')?>" style="color: grey"><img src="<?php echo base_url('assets/icons/print.jpg') ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('obatch_controller/main')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>    
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
<a href="<?php echo site_url('obatch_controller/scan_item') ?>" class="btn_primary">+ ADD FORM / BATCH</a>
<input value="<?php echo $_SESSION['refno']?>" name="refno" type="hidden">
</p>
<table class="cTable">
  <thead style="cursor:s-resize">
    <tr>                                    
      <th class="cTD">Batch Barcode</th>
      <th class="cTD" style="text-align:center;">Original Weight</th>
      <th class="cTD" style="text-align:center;">Weight Variance</th>
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
    <a href="<?php echo site_url('obatch_controller/scan_itemresult')?>?child_guid=<?php echo $row->child_guid; ?>&trans_guid=<?php echo $row->trans_guid; ?>"><?php echo $row->batch_barcode; ?></a>
    <a style="float:right" href="<?php echo site_url('obatch_controller/delete_item'); ?>?child_guid=<?php echo $row->child_guid; ?>&trans_guid=<?php echo $row->trans_guid;?>" onclick="return check()" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg') ?>"></a>
    </td>
    <td class="cTD" style="text-align:center;"><?php echo $row->goods_pallet_weight ?></td>
    <td class="cTD"  style="text-align:center; color:red"><?php echo $row->pick_weight_variance ?></td>
    <td class="cTD"  style="text-align:center;"><?php echo $row->created_by ?></td>
    <td class="cTD"  style="text-align:center;"><?php echo $row->created_at ?></td>
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