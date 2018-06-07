<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Goods Return</b></h5>
   </td>
    <td width="20"><a href="<?php echo site_url('greturn_controller/dn_list'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<h6>Debit Note List <b><?php echo $edit_mode?></b></h6>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greturn_controller/dn_item_edit_update')?>">
  <p><h4><b><?php echo $description?></b></h4></p>

   <table width="220" border="0">
    <tr>
      <td>Qty :
      <input type="number" class="form-control" value="<?php echo $qty?>" max="9999" style="text-align:center;width:80px;background-color:#ffff99" name="qty" 
  <?php
    if($edit_mode == 'delete')
    {
      ?>
      disabled
      <?php
    } 
    ?>
      /></td>
      <td><b><?php echo $edit_mode?><br>
      <?php echo $barcode?></b></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p><b>Supplier</b><br>
    <select name="supplier" id="supplier" style="background-color:#D8FFB0" class="form-control">
      <option selected="select" default><?php echo $last_supplier?></option>
      <?php
       foreach($sup_name->result() as $row)
      {
          ?>
      <option><?php echo $row->supplier;?></option>
          <?php
      }
      ?>
    </select>
  </p>
  <p><b>Reason</b><br>
    <select name="reason" id="reason" style="background-color:#ccf5ff" class="form-control">
   <option selected="select" default><?php echo $last_reason?></option>
     <?php
     foreach($reason->result() as $row)
     {
         ?>
     <option><?php echo $row->code_desc;?></option>
         <?php
     }
     ?>
    </select>
  </p>
   <input type="hidden" name="itemcode" value="<?php echo $itemcode?>">
   <input type="hidden" name="item_guid" value="<?php echo $_REQUEST['item_guid']?>">
   <p>
   <input type="submit" name="submit" value="SAVE" class="btn_success">

   </p>
</form>
</div>
</body>
</html>
