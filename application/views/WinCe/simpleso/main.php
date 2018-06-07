<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>SIMPLE SO</b><br>
    </h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><a href="<?php echo site_url('simpleso_controller/add_remarks')?>" class="btn_primary">+ ADD TRANS</a></p>
<table width="200" class="cTable">
<thead>
  <tr>
    <td class="cTD">Remaks</td>
    <td class="cTD" style="text-align:center;">Amount</td>
    <td class="cTD" style="text-align:center;">Created By</td>
    <td class="cTD" style="text-align:center;">Created At</td>
  </tr>
</thead>  
  <?php
    foreach ($result->result() as $row)
    {
      $_SESSION['remarks'] = $row->remarks;
      $_SESSION['bill_amt'] = $row->bill_amt;
  ?>
  <tr>
    <td class="cTD">
    <a href="<?php echo site_url('simpleso_controller/itemlist')?>?web_guid=<?php echo $row->web_guid?>&remarks=<?php echo $row->remarks ?>&bill_amt=<?php echo $row->bill_amt?>"><?php echo $row->remarks; ?></a>
    </td>
    <td class="cTD" style="text-align:center;"><?php echo round($row->bill_amt,2) ?></td>
    <td class="cTD" style="text-align:center;"><?php echo $row->created_by; ?></td>
    <td class="cTD" style="text-align:center;"><?php echo $row->created_at; ?></td>
  </tr>
  <?php
    }
  ?> 
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

