<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - By Pallet </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/scan_binIDBatch'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_pre_controller/pre_batch_itemSave'); ?>">
 <?php 
    foreach($result->result() as $row)
    {
  ?>
  <p>Bin ID : <?php echo $_SESSION['bin_ID']?> (<?php echo $row->Location?>)</p>
    
  <label>Scan Pallet Barcode</label><br>
<input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/>
  <input value="<?php echo $row->Location?>" type="hidden" name="locBin">
  <input value="<?php echo $_SESSION['bin_ID']?>" type="hidden" name="binID">
<?php
    }
?>
 </form>
 <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>