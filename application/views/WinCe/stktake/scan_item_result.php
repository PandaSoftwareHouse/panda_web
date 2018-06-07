<html>
<body>
<div class="container">
<table width="200" border="0" style="margin-bottom: -20px;">
  <tr>
    <td width="120">
    <h5><b>Stock Take </b></h5></td>
    <td width="20"><a onclick="history.go(-1)" href="<?php echo site_url('Stktake_controller/scan_item')?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('Stktake_controller/add_qty'); ?>">
 <?php 
    foreach($item->result() as $row)
    {
 ?>
<p ><b>Barcode: </b><?php echo $row->barcode;?>&nbsp;&nbsp;<b>P/Size:</b><?php echo $row->packsize;?>
<br>
  <b>Desc: </b><?php echo $row->description?>
  <b>Selling Price: </b><?php echo $row->sellingprice?>
</p>
  <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
  <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
  <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
  <input value="<?php echo $row->description?>" name="description" type="hidden">
  <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden">
  <input value="<?php echo $row->itemlink?>" name="itemlink" type="hidden">
  
  <?php
      }
  ?>
<table width="200" border="0">
    <tr>
      <td><label for="textfield">Qty</label></td>
      <td><center>
      </center></td>
      <td><label for="textfield2">Qty Input</label></td>
    </tr>
    <tr>
      <td>
      <input type="number" name="qty" style="text-align:center;background-color: #e6fff2;" class="form-control" size="1" min="0" max="100000" step="any" disabled 
          <?php 
              foreach ($itemQty -> result() as $row)
            {
          ?> 
          value="<?php echo $row->qty?>">
          <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>">
          <?php 
            }
          ?>
      </td>
      <td>+</td>
      <td><center>
        <?php 
          if($_SESSION['get_weight'] == '' ) 
            {
        ?>
      <input autofocus required type="decimal" value="0" onfocus="this.select()" class="form-control" id="autofocus" name="iqty" style="text-align:center;background-color: #e6fff2;" size="10" max="100000" step="any">
        <?php 
            }
          else 
            {
        ?>
      <input autofocus onclick="this.focus();this.select()" required  type="decimal" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" style="text-align:center;">
        <?php 
            }
        ?>
      </center></td>
    </tr>
  </table>
    <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid"> 
  <br>
  <?php 
    foreach ($detail -> result() as $row)
      { 
        echo $row->detail;}
  ?> <br>
  <h5>Location : <?php echo $_SESSION['bin_location']; ?></h5>
  <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
  <input type="submit" name="submit" value="SAVE" class="btn_success">
  </button>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>