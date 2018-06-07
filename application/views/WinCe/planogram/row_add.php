<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>PLANOGRAM</b></h5></td>
    <td width="20"><a href="<?php echo site_url('planogram_controller/binID_list')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><h5><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?></h5></p>
<form  role="form" method="POST" id="myForm" action="<?php echo site_url('planogram_controller/row_add_save'); ?>">
  <table width="200" border="0">
    <tr>
      <td>Row No</td>
      <td>Width</td>
    </tr>
    <tr>
      <td>
      <input type="number" class="form-control" id="autofocus" value="<?php echo $row_no?>" style="text-align:center;background-color:#ffff99;width: 80px" name="row_no" onfocus="this.select()" />
      </td>
      
      <td>
      <input type="number" value="" class="form-control" size="10" style="text-align:center;background-color:#ffff99;width: 80px"" name="row_w" />
      </td>
    </tr>

    <tr>
      <td>Depth</td>
      <td>Height</td>
    </tr>
    <tr>
      <td>
      <input type="number" value="" class="form-control" size="10" style="text-align:center;background-color:#ffff99;width: 80px"" name="row_d" />
      </td>

      <td>
      <input type="number" value="" class="form-control" size="10" style="text-align:center;background-color:#ffff99;width: 80px"" name="row_h" />
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="hidden" name="row_guid" value="<?php echo $row_guid?>"></td>
    </tr>
  </table>
  <input type="submit" name="submit" value="SAVE" class="btn_success">

</form>
</div>
<p>&nbsp;</p>
</body>
</html>