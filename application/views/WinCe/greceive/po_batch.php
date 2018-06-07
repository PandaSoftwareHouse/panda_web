<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/po_list')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
  <?php
      if($postButton == '1')
        {
    ?>
<a href="<?php echo site_url('greceive_controller/po_post_grn_scan?get_refno='.$grn_id)?>" class="btn_default"><small>POST DOCUMENT</small></a>

   <?php
        }
    ?>
<br>    
<small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>)</small></p>
<table width="250">
<tr>
<td><br><a href='<?php echo site_url('greceive_controller/batch_check_pay_by_invoice')?>' class="btn_primary">+ <small>ADD BATCH</small></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('greceive_controller/po_print')?>?grn_guid=<?php echo $_REQUEST['grn_guid']?>&print_type=batch_list" class="btn_default"><img src="<?php echo base_url('assets/icons/printgrda.jpg'); ?>"><small> GRDA LIST </small></a><br><br>
</td>
</tr>
</table>
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</p>

<?php
  foreach ($result->result() as $row)
    { 
?>

<table class="cTable">
  <thead>
      <tr>
          <th class="cTd">Pallet<br>&nbsp<br>&nbsp</th>
          <th class="cTd">Goods.kg<br>Pallet.kg<br>&nbsp</th>
          <th class="cTd">Gross<br>Q.var<br>W.var</th>
          <th class="cTd">Net<br>&nbsp<br>&nbsp</th>
          <th class="cTd">kg/qty<br>kg.TraceQty<br>Tolerance</th>
          <th class="cTd">Qty<br>TraceQty<br>&nbsp</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th class="cTD" rowspan="3" style="text-align: center">
        <b style="font-size: 32px"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->batch_id; ?></a></b>
          <br><br>
          <label>Printed</label>&nbsp<input type="checkbox" disabled
          <?php
            if($row->send_print == '1')
            {
          ?>
                checked
          <?php
            } 
          ?>>
        <br>
        <a href="<?php echo site_url('greceive_controller/po_print')?>?batch_guid=<?php echo $row->batch_guid?>&print_type=batch_only&grn_guid=<?php echo $_REQUEST['grn_guid']?>"><img src="<?php echo base_url('assets/icons/print.jpg'); ?>"></a>
    </th>
    <td class="cTD"><?php echo $row->goods_weight?></td>
    <td class="cTD"><a href="<?php echo site_url('greceive_controller/batch_gross_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->goods_pallet_weight?></a></td>
    <td class="cTD"><?php echo $row->goods_weight_net?></td>
    <td class="cTD"><?php echo $row->goods_weight_perqty?></td>
    <td class="cTD"><?php echo $row->pallet_qty?></td>
  </tr>
    <tr>
      <td class="cTD"><a href="<?php echo site_url('greceive_controller/batch_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->pallet_weight?></a></td>
      <td class="cTD" style="color:red "><?php echo $row->goods_pallet_variance?></td>
      <td class="cTD"></td>
      <td class="cTD" style="color:red "><?php echo $row->goods_weight_traceqty?></td>
      <td class="cTD" style="color:red "><?php echo $row->trace_qty_sum?></td>
    </tr>
    <tr>
      <td class="cTD"></td>
      <td class="cTD" style="color:red "><?php echo $row->Weight_Variance?></td>
      <td class="cTD"></td>
      <td class="cTD"><?php echo $row->PurTolerance_Std_Minus?></td>
      <td class="cTD"></td>
    </tr>
    </tbody>

</table>
<p>&nbsp;</p>
<?php
      }
?>
</div>

</body>
</html>