<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - By Pallet </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><a href="<?php echo site_url('stktake_pre_controller/scan_binIDBatch'); ?>" class="btn_primary">+ SCAN BIN ID</a></p>
<p> <?php
    foreach($result->result() as $row)
    {
    ?>
    <h4><a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemlist')?>?bin_ID=<?php echo $row->BIN_ID?>" style="color:black">
    <b><?php echo $row->BIN_ID; ?></b></a></h4>
    <?php
    }
    ?>
  </p>

</div>
</body>
</html>
