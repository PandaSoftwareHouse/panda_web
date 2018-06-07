<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b></h5>
    <a href="<?php echo site_url('Dnbatch_controller/print_job')?>" style="color: grey"><img src="<?php echo base_url('assets/icons/print.jpg');?>">
    </a></td>
    <td width="20"><a href="<?php echo site_url('dnbatch_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<br>
<p><a href="<?php echo site_url('Dnbatch_controller/scan_item') ?>" class="btn_primary">+ ADD ITEM</a></p>
<p><?php echo $_SESSION['batch_no'] ?><br>
  <?php echo $_SESSION['sup_name'] ?></p>
<table width="200" class="cTable">
<thead>
  <tr>
    <td class="cTD">Description</td>
    <td class="cTD">Qty</td>
  </tr>
</thead>  

  <?php
    foreach ($result->result() as $row)
    {
  ?>
  <tr>
    <td class="cTD">
    <a href="<?php echo site_url('Dnbatch_controller/scan_itemresult')?>?dbnote_c_guid=<?php echo $row->dbnote_c_guid; ?>&dbnote_guid=<?php echo $row->dbnote_guid; ?>"><?php echo $row->description; ?></a>

    <a style="float:right" href="<?php echo site_url('Dnbatch_controller/delete_item'); ?>?dbnote_c_guid=<?php echo $row->dbnote_c_guid; ?>&dbnote_guid=<?php echo $row->dbnote_guid;?>" onclick="return check()" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a>

    </td>
    <td class="cTD"><?php echo $row->qty ?></td>
  </tr>
     <?php
        }
     ?> 
</table>
<input value="<?php echo $_SESSION['batch_no']?>" name="batch_no" type="hidden">
<p>&nbsp;</p>
</div>
</body>
</html>

