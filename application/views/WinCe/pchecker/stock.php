<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Price Checker</b></h5>
    <medium><b>Stock</b></medium>
    </td>
    <td width="20"><a href="<?php echo site_url('Pchecker_controller/scan_result')?>?barcode=<?php echo $_SESSION['barcode']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>&nbsp;</p>
<table width="200" class="cTable">
<thead>
  <tr align="center">
    <td class="cTD">Location</td>
    <td class="cTD">QOH</td>
    </tr>
</thead>
	<?php
  	   foreach ($result->result() as $row)
  		{
    ?>

  <tr align="center">
    <td class="cTD"><?php echo $row->Location; ?></td>
    <td class="cTD">?php echo $row->OnHandQty; ?></td>
    </tr>

   	<?php
         }
    ?>
     
</table>
<p>&nbsp;</p>
</div>
</body>
</html>