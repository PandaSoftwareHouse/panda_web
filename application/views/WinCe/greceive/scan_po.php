<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/po_list')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/scan_po_result'); ?>">
  <label for="scan_itemcode">Scan PO No</label>
  <input type="text" class="form-control" placeholder="Scan PO No" name="po_no" id="autofocus" style="background-color: #e6fff2" required autofocus onblur="this.focus()"/>
</form>
<br>
<h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<p>&nbsp;</p>
</div>
</body>
</html>

