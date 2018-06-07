<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20">
    <a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/batch_add_save'); ?>">
  <h5><b>Add <small>Batch/Pallet/Trolley</small></b></h5>
  <p>
    <input name="MaxBatch_Id" class="form-control" disabled value="<?php echo $MaxBatch_Id?>" style="background-color:#ffff99;text-align: center;width:40px;font-size: 14px "/>
          </p>

<input name="add2" type="submit" class="btn_success" id="add2" value="SAVE">
<h5><b>Method</b></h5>
  <select name="method_name" class="form-control" style="background-color:#80ff80;width: 120px"  >
    <?php
      foreach($method_name->result() as $row)
      {
    ?>
    <option><?php echo $row->method_name;?></option>
    <?php
                                }
                                ?>
  </select>

</form>
</div>
<p>&nbsp;</p>
</body>
</html>

