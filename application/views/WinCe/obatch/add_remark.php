<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER OUT</b></h5></td>
    <td width="20"><a href="<?php echo site_url('obatch_controller/main') ?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>            
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('obatch_controller/create_batch'); ?>">
<label>Location To :</label><br>
<select name="locationto" class="form-control" style="width: 120px">
  <?php
    foreach($slocation->result() as $row)
      {
          ?>
          <option><?php echo $row->sublocation;?></option>
          <?php
      }
      ?> 
</select>
<br>
  <label>Remarks</label> <br>
  <input type="text" class="form-control" name="remarks" id="autofocus" value="<?php foreach($remarks->result() as $row)
          { 
          echo $row->remark;
   ?>" />
  <input name = "trans_guid" value = "<?php echo $trans_guid; ?>" type="hidden" />
  <br>
  <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
  <input type="submit" name="view" class="btn_success" value="SAVE">
</form>

</div>
<p>&nbsp;</p>
</body>
</html>