<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20">
    <a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/goods_pallet_weight_update'); ?>">
  <p><h4><b>Pallet ID :</b>
      <?php 
        foreach($result->result() as $row)
        {
          echo $row->batch_id;
          $_SESSION['goods_pallet_weight'] = $row->goods_pallet_weight;
        }
      ?><br>
      <small>Gross Weight (kg)</small></h4>
  </p>
  <p>
     <input  type="text" name="goods_pallet_weight" size="10" class="form-control" id="autofocus" style="background-color:#ffff99;width: 80px;" value="<?php echo $_SESSION['goods_pallet_weight']?>" onfocus="this.select()" autofocus>


  </p>
  <p>
    <input type="submit" name="Done" id="Done" value="DONE" class="btn_success">
  </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>

