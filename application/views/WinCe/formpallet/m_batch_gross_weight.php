<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>   
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/goods_pallet_weight_update'); ?>">
<h4><b>Pallet ID :</b>
    <?php foreach($result->result() as $row)
    {
      echo $row->batch_id;
      $_SESSION['goods_pallet_weight'] = $row->goods_pallet_weight;
    }
    ?><br><small>Gross Weight (kg)</small></h4>
    <input  type="text" name="goods_pallet_weight" id="autofocus" class="form-control" style="width:170px;background-color:#ffff99" value="<?php echo $_SESSION['goods_pallet_weight']?>" onfocus="this.select()" autofocus>
    <br>
    <input type="submit" name="submit" value="DONE" class="btn_success">

    </form>

</div>
<p>&nbsp;</p>
</body>
</html>