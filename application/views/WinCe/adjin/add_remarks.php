<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>ADJUST IN</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('Adjin_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a>
    </td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('adjin_controller/add_process'); ?>">
  <label>Reason</label><br>
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
  <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Remarks" name="remarks" id="autofocus"/>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>

