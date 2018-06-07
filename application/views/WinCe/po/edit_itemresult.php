<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>Purchase Order</b></h5></td>
    <td width="20"><a onclick="history.go(-1); return false;" href="<?php echo site_url('general_scan_controller/scan_item')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('general_scan_controller/update_qty'); ?>">
    
    <p>
      <?php 
        foreach($itemresult->result() as $row)
        {
    ?>
    </p>
    <p><b>Barcode :</b><?php echo $row->barcode;?>&nbsp;&nbsp;<b>P/Size :</b><?php echo $row->packsize;?><br>
      <b>Desc :</b><?php echo $row->description?><br>
      <b>S/Price: </b><?php echo $row->sellingprice?>
      <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
      <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
      <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
      <input value="<?php echo $row->description?>" name="description" type="hidden">
      <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">&nbsp;&nbsp;<?php 
    if($_SESSION['web_c_guid'] == '')
    {
      $web_c_guid = $_REQUEST['web_c_guid'];
    }
    else
    {
      $web_c_guid = $_SESSION['web_c_guid'];
    }
    ?>
      <input value="<?php echo $web_c_guid?>" name="web_c_guid" type="hidden">
      <input value="<?php echo $row->acc_code?>" name="acc_code" type="hidden">
      
      <?php
        }
          foreach($itemQOH->result() as $row)
        {
      ?><b>QOH :</b><?php echo $row->SinglePackQOH?>
       <input value="<?php echo $row->SinglePackQOH?>" name="SinglePackQOH" type="hidden">
      <?php
          }
      ?>
    </p>
    <table width="164" border="0">
      <tr>
    <td width="58">Qty</td>
    <td width="11">&nbsp;</td>
    <td width="73">Order Qty</td>
  </tr>
  <tr>
    <td>
       <input type="number" name="qty" class="form-control" style="text-align:center;background-color: #e6fff2" size="5" min="0" max="100000" disabled  
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
    <td><center><b>+</b></center></td>
    <td>
    <input autofocus required type="number" id="autofocus" value="0" onfocus="this.select()" class="form-control" name="iqty" size="5" style="text-align:center;background-color: #e6fff2" max="100000"/>
    </td>
  </tr>
  <tr>
    <td>Foc Qty</td>
    <td>&nbsp;</td>
    <td>Remarks</td>
  </tr>
  <tr>
    <td>
    <input type="number" name="foc_qty" class="form-control" size="5" style="text-align:center;background-color: #e6fff2" max="100000"/>
    </td>
    <td>&nbsp;</td>
    <td rowspan="2">
      <textarea name="textarea" name="remark" class="form-control" cols="10" rows="3" style="text-align:center;background-color: #e6fff2"></textarea></td>
     <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid">  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><input type="submit" name="submit" value="SAVE" class="btn_success"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</div>
</body>

