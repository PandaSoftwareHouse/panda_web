<html>
<body onload="autofocus()">

<table width="220" border="0">
  <tr>
    <td width="150"><h5><b>Sales Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('SO_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('SO_controller/add_qty'); ?>">

<?php 
    foreach($itemresult->result() as $row)
      {
        ?>
<table width="220" border="0">
<tr>
    <td width="100"><b>Barcode: </b><?php echo $row->barcode;?></td>
    <td width="100"><b>P/Size: </b><?php echo $row->packsize;?></td>
</tr>
<tr>
<td colspan="2"><br><b>Desc: </b><?php echo $row->description?></td>
</tr>
<tr>
<td><b>Selling Price: </b><?php echo $row->sellingprice?></td>

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
                              <td><br><b>QOH: </b><?php echo $row->SinglePackQOH?></h5></td>
                              
                              <input value="<?php echo $row->SinglePackQOH?>" name="SinglePackQOH" type="hidden">
                             <?php
                            }
                            ?>


</tr>
</table>

  <table width="200" border="0">
    <tr align="center">
      <td>
          <label>Qty</label>
            <input type="number" name="qty" size="10" style="text-align:center;width:80px;" 
                                    min="0" max="100000" disabled>
                                    <?php 
                                     foreach ($itemQty -> result() as $row)
                                    {
                                    ?> 
                                    value="<?php echo $row->qty?>"/>
                                    <input type="hidden" name="defaultqty" value="
                                    <?php echo $row->qty?>">
                                    <?php 
                                     }
                                     ?>

      </td>
      <td><b>+</b></td>
      <td><label>Order Qty</label>
      <input type="text" size="10" style="background-color: #e6fff2" name="iqty" id="autofocus" required value="0" onfocus="this.select()" autofocus/></td>
    </tr>
    <tr align="center">
      <td><label>FOC Qty</label>
      <input type="text" size="10" name="foc_qty" id="foc_qty" style="background-color: #e6fff2" /></td>
      <td>&nbsp;</td>
      <td><br><br><label for="remark">Remarks</label>
        <br />
<textarea name="remark" id="remark" cols="10" rows="3" style="background-color: #e6fff2"></textarea></td>
    </tr>
    <input value="<?php echo $this->session->userdata('web_guid'); ?>" type="hidden" name="web_guid"> 
    <tr>
      <td><input type="submit" name="submit" value="SAVE" class="btn_success"></td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  </form>

  </body>
  </html>