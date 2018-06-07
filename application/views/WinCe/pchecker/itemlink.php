<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Price Checker </b></h5>
    <medium><b>Itemlink</b></medium>
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
    <td class="cTD">Item Link</td>
    <td class="cTD">Item Code</td>
    <td class="cTD">Price</td>
    <td class="cTD">P/Size</td>
    </tr>
</thead>
      <?php
        foreach ($result->result() as $row)
        {
      ?>

  <tr align="center">
    <td class="cTD"><?php echo $row->Itemlink; ?></td>
    <td class="cTD"><?php echo $row->Itemcode; ?></td>
    <td class="cTD"><?php echo $row->SellingPrice; ?></td>
    <td class="cTD"><?php echo $row->PackSize; ?></td>
    </tr>
     <?php
        }
      ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>