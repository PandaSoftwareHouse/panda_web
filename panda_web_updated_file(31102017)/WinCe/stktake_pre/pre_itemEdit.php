<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - Item Edit </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['binID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_pre_controller/pre_itemSave')?>">
<p>
<b>Loc: </b><?php echo $this->session->userdata('locBin')?>&nbsp
<b>BinID: </b><?php echo $this->session->userdata('binID')?><br>
<b>Description: </b><?php echo $BarDesc?><br>
<b>Barcode: </b><?php echo $barcode?><br>
<b>Itemcode: </b><?php echo $Itemcode?></p>
<input type="hidden" value="<?php echo $Itemcode ?>" name="Itemcode">
<input type="hidden" value="<?php echo $barcode ?>" name="Barcode">
  <?php                      
      foreach($itemEdit->result() as $row)
    {
        $_SESSION['Qty'] = $row->Qty;
  ?> 
    <input type="hidden" value="<?php echo $row->Qty?>" name="qty">
    <input type="hidden" value="<?php echo $row->Barcode?>" name="Barcode">
    <input type="hidden" value="<?php echo $row->TRANS_GUID?>" name="TRANS_GUID">
  <?php
    }      
  ?>

<p><b>Qty:</b></p>
  <table width="200" border="0">
    <tr>
      <td>
      <label for="qty1">&nbsp;</label>
        <input type="number" 
          <?php
          foreach($itemEdit->result() as $row)
          {
            ?> value="<?php echo $row->Qty?>"
            <?php 
          }
          ?>  style="text-align:center;background-color: #e6fff2;width: 80px" class="form-control" min="0" max="100000" disabled step="any">
      </td>
      <td><center><b>+</b></center></td>
      <td><center><label for="qty">&nbsp;</label>
        <input type="number" name="qty_add" value="0" onfocus="this.select()" id="autofocus" class="form-control" style="text-align:center;background-color: #e6fff2;width: 80px" max="100000" step="any"></center></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      </tr>
    <tr>
      <td><input type="submit" name="submit" value="SAVE" class="btn_success"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>