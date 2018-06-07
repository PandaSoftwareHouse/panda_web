<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/barcode_scan')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_entry_update')?>?>">
    <h4><b><?php echo $query_heading->row('description')?><br>
      <br>
      <?php echo $_SESSION['barcode']?>&nbsp&nbsp</b>
      <?php
        if($query_heading->row('grn_by_weight_hide_po_info') == 0 )
          {
      ?>
      
      <b><?php echo $query_heading->row('po_bal')?></b>
      <?php
        } 
      ?>
    </h4>
</form>
<table class="cTable" >
  <thead>
    <tr>
      <th class="cTD">Pack Size</th>
      <th class="cTD">Description</th>
    </tr>
  </thead>
  <?php
    foreach($query_item->result() as $row)
    {
  ?>
  <tbody>
    <tr>
      <td class="cTD"><?php echo $row->packsize?>
        <?php
                                                  if($po_itemcode == $itemcode )
                                                  {
                                                    ?>
        <b style="color:red">**</b>
        <?php
                                                  };
                                                  ?></td>
      <td class="cTD"><a href="<?php echo site_url('greceive_controller/item_entry_add')?>?scan_itemcode=<?php echo $row->itemcode?>"><?php echo $row->description?></a></td>
    </tr>
  </tbody>
  <?php
    }
  ?>
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

