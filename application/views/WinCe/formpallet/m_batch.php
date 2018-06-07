<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>MANUAL PALLET CREATION</b></h5>
    </td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>   
<a href="<?php echo site_url('formpallet_controller/m_post_stock')?>" class="btn_default"><b><small>POST BATCH</b></small></a>
<br><br>
<p> 
<a href='<?php echo site_url('formpallet_controller/m_batch_add'); ?>' class="btn_primary">+ ADD BATCH</a>
<br>
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</p>                            
<?php
foreach ($result->result() as $row)
    { 
?>
<table class="cTable">
<thead>
    <tr>
        <th class="cTD">Pallet<br>&nbsp;<br>&nbsp;</th>
        <th class="cTD">Goods.kg<br>Pallet.kg<br>&nbsp;</th>
        <th class="cTD">Gross<br>Q.var<br>W.var</th>
        <th class="cTD">Net<br>&nbsp;<br>&nbsp;</th>
        <th class="cTD">kg/qty<br>kg.TraceQty<br>Tolerance</th>
        <th class="cTD">Qty<br>TraceQty<br>&nbsp;</th>
    </tr>
</thead>
<tbody>
    <tr>
    <td class="cTD" rowspan="3" style="text-align: center">
    <b style="font-size: 32px"><a href="<?php echo site_url('formpallet_controller/m_batch_entry')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->batch_id; ?></a></b>
<br><br>
<label>Printed</label>&nbsp;<input type="checkbox" disabled
        <?php
        if($row->send_print == '1')
        {
            ?>
            checked
            <?php
        } 
        ?>>
        <br>
        <a href="<?php echo site_url('formpallet_controller/m_po_print')?>?batch_guid=<?php echo $row->batch_guid?>&print_type=batch_only"><img src="<?php echo base_url('assets/icons/print.jpg');?>"></a>
    </td>
    <td class="cTD"><?php echo $row->goods_weight?></td>
    <td class="cTD"><a href="<?php echo site_url('formpallet_controller/m_batch_gross_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->goods_pallet_weight?></a></td>
    <td class="cTD"><?php echo $row->goods_weight_net?></td>
    <td class="cTD"><?php echo $row->goods_weight_perqty?></td>
    <td class="cTD"><?php echo $row->pallet_qty?></td>
    </tr>
    <tr>
    <td class="cTD"><a href="<?php echo site_url('formpallet_controller/m_batch_weight')?>?batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->pallet_weight?></a></td>
    <td class="cTD" style="color:red "><?php echo $row->goods_pallet_variance?></td>
    <td class="cTD"></td>
    <td class="cTD" style="color:red "><?php echo $row->goods_weight_traceqty?></td>
    <td class="cTD" style="color:red "><?php echo $row->trace_qty_sum?></td>
    </tr>
    <tr>
    <td class="cTD" colspan='2' style="color:red "><?php echo $row->batch_barcode?></td>
                                    <!-- <td class="cTD" style="color:red "><?php echo $row->Weight_Variance?></td> -->
    <td class="cTD"></td>
    <td class="cTD"><?php echo $row->PurTolerance_Std_Minus?></td>
    <td class="cTD"></td>
    </tr>
</tbody></table></div>
<?php
    }
?> 
</div>
<p>&nbsp;</p>
</body>
</html>                        
