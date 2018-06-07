<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>ADJUST OUT <?php if($_SESSION['aotype'] == 'DP') { echo '- Disposal';}; if($_SESSION['aotype'] == 'OU') { echo '- Own Use';}; ?></b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('adjout_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a>
    </td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('adjout_controller/add_process'); ?>">
<label for="remarks">Reason :</label><br>
  <select name="reason" class="form-control" required style="background-color:#ccf5ff"  >
    <?php
      foreach($reason->result() as $row)
      {
    ?>
      <option><?php echo $row->code_desc;?></option>
    <?php
      }
    ?>                   
  </select>

  <label for="remarks">Remarks :</label><br>
  <textarea cols="2" rows="5" name="remarks" style="background-color: #e6fff2" class="form-control input-md" ></textarea>

  <button value="save" name="save" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

