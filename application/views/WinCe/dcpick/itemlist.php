<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DC MOBILE PICK</b></h5></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><h5><b>Request No :</b> <?php echo $_REQUEST['dc_refno']?></h5></p>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<table width="200" class="cTable">
  <tr align="center">
    <td class="cTD">Description</td>
    <td class="cTD">Qty</td>
    <td class="cTD">Qty Mobile</td>
  </tr>
  <?php
      foreach ($result->result() as $row)
      {
          ?>
  <tr>
    <td class="cTD"><?php echo $row->description; ?></td>
    <td class="cTD"><center><?php echo $row->qty; ?></center></td>
    <td class="cTD"><center><?php echo $row->qty_mobile; ?></center></td>
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
