<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>DC MOBILE PICK</b></h5></td>
    <td width="20"><a href="<?php echo site_url('dcpick_controller')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>

<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
 <form role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/scan_item_result'); ?>">

	<p><h5><b>Request No :</b><a target="_blank" href="<?php echo site_url('dcpick_controller/itemlist') ?>?dc_trans_guid=<?php echo $dc_trans_guid?>&dc_refno=<?php echo $dc_refno?>"> <?php echo $dc_refno?></a></h5>
    </p>
    <p><h5><b>Location To :</b><?php echo $dc_locto?></h5></p>
          <label>Item Barcode</label><br>
          <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="barcode" id="autofocus" required autofocus /><!-- onblur="this.focus()" -->
          <p><h5><b>Total Records : </b><?php echo $count?></h5></p>
          <input type="hidden" name="dc_trans_guid" value="<?php echo $dc_trans_guid?>">     
</form>
	<p> <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4> </p>
  <br><br>

  <table width="200" class="cTable">
    <tr align="center">
      <td class="cTD">No</td>
      <td class="cTD">Itemcode</td>
      <td class="cTD">Description</td>
      <td class="cTD">Qty</td>
      <td class="cTD">Qty Mobile</td>
      <td class="cTD">Reason</td>
    </tr>
    <?php
        foreach ($result->result() as $row)
        {
            ?>
    <tr>
      <td class="cTD"><?php echo $row->line; ?> </td>
      <td class="cTD"><?php echo $row->Itemcode; ?> </td>
      <td class="cTD">
        <?php
          if($row->scan_type == 'BATCH')
          {
              ?>
              <a href="<?php echo site_url('Main_controller/scan_log')?>?type=<?php echo $row->type?>&item_guid=<?php echo $row->item_guid?>&dc_child_guid=<?php echo $row->CHILD_GUID?>"><?php echo $row->description; echo '&nbsp'?></a>
              <?php
          }
          else
          {
              ?>
              <?php echo $row->description; ?>
              <?php
          }
          ?>
        <!-- <?php echo $row->description; ?> -->
      </td>
      <td class="cTD"><center><?php echo $row->qty; ?></center></td>
      <td class="cTD"><center><?php echo $row->qty_mobile; ?></center></td>
      <td class="cTD"><?php echo $row->reason; ?></td>
    </tr>
    <?php
          }
      ?> 
</table>
</div>
<p>&nbsp;</p>	
</body>
</html>
