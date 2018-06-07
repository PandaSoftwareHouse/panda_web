<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b><?php echo $module ?></b></h5></td>
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

  <table width="200" border="0" class="cTable">
    <tr>
      <td><b>Barcode: </b><?php echo $row->barcode;?>&nbsp;</td>
      <td>&nbsp;<b>P/Size:</b><?php echo $row->packsize;?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Desc: </b><?php echo $row->description?></td>
      </tr>
    <tr>
      <td colspan="2"><b>Selling Price: </b><?php echo $row->sellingprice?>
        <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
        <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
        <input value="<?php echo $row->packsize?>" name="packsize" type="hidden">
        <input value="<?php echo $row->description?>" name="description" type="hidden">
        <input value="<?php echo $row->sellingprice?>" name="sellingprice" type="hidden"></td>
    </tr>
    <tr>
      <td colspan="2"><?php
      }
    foreach($itemQOH->result() as $row)
      {
  ?>
&nbsp;&nbsp;<b>QOH: </b><?php echo $row->SinglePackQOH?>
<input value="<?php echo $row->SinglePackQOH?>" name="SinglePackQOH" type="hidden">
<?php
      }
    ?>
</p></td>
    </tr>
    </table>
  <table width="164" border="0">
    <tr>
    <td width="58">Qty</td>
    <td width="11">&nbsp;</td>
    <td width="73">Order Qty</td>
  </tr>
  <tr>
    <td>
    <input type="number" class="form-control" name="qty" style="text-align:center;background-color: #e6fff2;width: 60px" min="0" max="100000" disabled 
        <?php if($_SESSION['get_weight'] == '' ) 
          {
            foreach ($itemQty -> result() as $row)
          {
        ?> 
        value="<?php echo $row->qty?>"/>
    <input type="hidden" name="defaultqty" value="<?php echo $row->qty?>"
        <?php 
          }
          }
          else
          {
        ?>
        value=" ">
    <input type="hidden" name="defaultqty" value="0">
        <?php 
          } 
        ?>

    </td>
    <td><center><b>+</b></center></td>
    <td>
      <?php if($_SESSION['get_weight'] == '' )
        if(isset($_SESSION['decode_qty']))
        {
          ?>
          <input autofocus required type="number" value="<?php echo $_SESSION['decode_qty']?>" onfocus="this.select()" step="any" name="iqty" style="text-align:center;background-color: #e6fff2;width:60px;" />
          <?php
        }
        else
        {
      ?>
      <input autofocus required value="0" onfocus="this.select()" id="autofocus" type="decimal" class="form-control" name="iqty" style="text-align:center;background-color: #e6fff2;width: 60px" />
      <?php 
        }
        else 
        {
      ?>
      <input disabled type="decimal" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" style="text-align:center;background-color: #e6fff2;" />
      <input hidden type="decimal" value="<?php echo $_SESSION['get_weight'] ?>" name="iqty" style="text-align:center;background-color: #e6fff2;" />
      <?php 
        }
      ?>

    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Remarks</td>
  </tr>
  <tr>
    <td>
    <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid"></td>
    <td>&nbsp;</td>
    <td rowspan="2">
      <textarea name="remark" cols="10" class="form-control" rows="3" style="background-color: #e6fff2;"></textarea></td>
  </tr>
  <tr>
    <td>
    <input type="submit" name="button" id="button" class="btn_success" value="SAVE">
</td>
    <td>&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

