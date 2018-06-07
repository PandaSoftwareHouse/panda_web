<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b><?php echo $module ?></b></h5></td>
    <td width="20"> <a onclick="history.go(-1); return false;"  href="<?php echo site_url('general_scan_controller/scan_item')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>">
    </a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('general_scan_controller/update_qty'); ?>">

  <?php 
    foreach($itemresult->result() as $row)
    {
  ?>
  <b>Barcode: </b><?php echo $row->barcode;?><br>
  <b>P/Size:</b><?php echo $row->packsize;?><br>
  <b>Desc: </b><?php echo $row->description?><br>
  <b>Selling Price: </b><?php echo $row->sellingprice?>
 <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
 <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
 <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
 <input value="<?php echo $row->description?>" name="description" type="hidden">
 <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">
  <?php
      }
    foreach($itemQOH->result() as $row)
      {
  ?>                         
    &nbsp;&nbsp;<br><b>QOH: </b><?php echo $row->SinglePackQOH?>
<input value="<?php echo $row->SinglePackQOH?>" name="SinglePackQOH" type="hidden">
    <?php
      }
    ?>
</p>
<table width="200" border="0">
  <tr>
    <td width="58">
      <label>Qty</label><br>
      <input type="number" name="qty" class="form-control" style="text-align:center;background-color: #e6fff2;width: 60px" min="0" max="100000" disabled 
        <?php 
          foreach ($itemQty -> result() as $row)
            {
        ?> 
      value="<?php echo $row->qty?>"/>
      <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
      <?php 
            }
        ?>
      
      </td>
    
    <td width="51"><center><h4><b>+</b></h4></center></td>
    
    <td width="77"><label>Input Qty</label><br>
      <input autofocus required type="decimal" id="autofocus" value="0" onfocus="this.select()" class="form-control" name="iqty" style="text-align:center;background-color: #e6fff2;width: 80px"  max="100000"/>
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="2">
      <label for="textarea">Remarks</label><br>
      <textarea name="remark" cols="10" rows="3" class="form-control" style="background-color: #e6fff2;"></textarea></center></td>
  </tr>
  <tr>
    <td>
    <input value="<?php echo $this->session->userdata('web_c_guid'); ?>" type="hidden" name="web_c_guid">  
    <input type="submit" name="button" id="button" class="btn_success" value="SAVE"></td>
    <td>&nbsp;</td>
    </tr>
</table>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

