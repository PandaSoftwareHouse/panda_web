<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER(IN)</b></h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>          
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href="<?php echo site_url('rbatch_controller/trans_location'); ?>" class="btn_primary">+ ADD DOC </a>
<!-- <br>
<h5>Location: <b><?php echo $_SESSION['location'] ?></b></h5> -->
<table class="cTable">
<thead>
  <tr>
    <th class="cTD">Refno</th>
    <th class="cTD" style="text-align:center;">Location To</th>
    <th class="cTD" style="text-align:center;">Remark</th>
    <th class="cTD" style="text-align:center;">Created By</th>
    <th class="cTD" style="text-align:center;">Created At</th>
  </tr>
</thead>
<tbody>
<?php
    foreach ($result->result() as $row)
    {
?>
<tr>
  <td class="cTD">
  <a href="<?php echo site_url('rbatch_controller/itemlist')?>?trans_guid=<?php echo $row->trans_guid;?>"><?php echo $row->refno; ?></a>
  </td>
  <td class="cTD" style="text-align:center;"><?php echo $row->location_to ?></td>
  <td class="cTD" style="text-align:center;"><?php echo $row->remark ?></td>
  <td class="cTD" style="text-align:center;"><?php echo $row->created_by ?></td>
  <td class="cTD" style="text-align:center;"><?php echo $row->created_at ?></td>
</tr>
<?php
    }
?> 

</tbody>
</table>

</div>
<p>&nbsp;</p>
</body>
</html>