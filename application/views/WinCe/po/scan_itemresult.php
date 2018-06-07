<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Purchase Order</b></h5></td>
    <td width="20"><a onclick="history.go(-1); return false;" href="<?php echo site_url('general_scan_controller/scan_item')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('general_scan_controller/add_qty'); ?>">

  <?php 
    foreach($itemresult->result() as $row)
    {
  ?>
<p>
<b>Barcode: </b><?php echo $row->barcode;?><br>
<b>P/Size: </b><?php echo $row->packsize;?><br>
<b>Desc: </b><?php echo $row->description?><br>
<b>Selling Price: </b><?php echo $row->sellingprice?><br>

<input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
<input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
<input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
<input value="<?php echo $row->description?>" name="description" type="hidden">
<input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">
<input value="<?php echo $row->soldbyweight?>" name="soldbyweight" type="hidden">

<?php
    }
      foreach($itemQOH->result() as $row)
        {
  ?>
<b>QOH: </b><?php echo $row->SinglePackQOH?>
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
      <input type="number" step="any" name="qty" style="text-align:center;width:80px;background-color: #e6fff2;" min="0" max="100000" disabled class="form-control"
      <?php   
      if($_SESSION['get_weight'] == '' ) 
      {
          foreach ($itemQty -> result() as $row)
          {
      ?> 
      value="<?php echo $row->qty?>"/>
       <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
      <?php 
          }
        }
        else
          {
      ?>
      value=" "/>
    <input type="hidden" name="defaultqty" value="0">
    <?php 
          } 
    ?>

    </td>
    <td><center><b>+</b></center></td>
    <td>
    <input autofocus required type="number" value="0" id="autofocus" onfocus="this.select()" class="form-control" name="iqty" size="5" style="text-align:center;background-color: #e6fff2" max="100000"/>
    </td>
  </tr>
  <tr>
    <td>Foc Qty</td>
    <td>&nbsp;</td>
    <td>Remarks</td>
  </tr>
  <tr>
    <td>
    <input type="number" step="any" size="5" class="form-control" name="foc_qty" style="text-align:center;width:80px;background-color: #e6fff2;" max="100000"/>
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

</div>
<p>&nbsp;</p>
</body>
</html>