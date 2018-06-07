<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Cycle Count </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_online_controller/scan_item')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><b><?php echo $_SESSION['description']?></b> <small>P/size : <?php echo $_SESSION['packsize']?></small><br>
  <b>QOH : </b><?php echo $QOH?> &nbsp;&nbsp;&nbsp; <b>ACT : </b><?php echo $Act?> <br>
  <b>Diff : </b><?php echo $Diff ?>
</p>
<table width="200" class="cTable">
<thead> 
  <tr>
    <td class="cTD">System</td>
    <td class="cTD">Actual</td>
    <td class="cTD">P/S</td>
    <td class="cTD">S/P</td>
    <td class="cTD">Description</td>
    <td class="cTD">Itemcode</td>
  </tr>
</thead>  
   <?php
     foreach ($itemlink->result() as $row)
     {
   ?>
  <tr>
    <td class="cTD"><center><?php echo $row->QTY_CURR; ?></center></td>
    <td class="cTD"><center><?php echo $row->QTY_ACTUAL; ?></center></td>
    <td class="cTD"><center><?php echo $row->PACKSIZE; ?></center></td>
    <td class="cTD"><center><?php echo $row->price_include_tax; ?></center></td>
    <td class="cTD"><a href="<?php echo site_url('stktake_online_controller/item_edit')?>?trans_guid=<?php echo $row->TRANS_GUID?>"><?php echo $row->DESCRIPTION; ?></a></td>
    <td class="cTD"><center><?php echo $row->ITEMCODE; ?></center></td>
  </tr>
   <?php
     }
   ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>