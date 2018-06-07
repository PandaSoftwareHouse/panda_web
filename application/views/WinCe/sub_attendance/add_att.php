<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Add Attendance</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form method="POST" action="<?php echo site_url('sub_attendance_controller/insert')?>">

    <h4>Supplier:<br></h4>
    
    <?php if ($code == 'Others') 
    { ?>
        <input type="text" class="form-control" name="supplier" value="" required/>
        <input type='hidden' name="code" value="Others">
    <?php }
    else
    { ?>
        <input type="text" class="form-control" name="supplier" value="<?php echo $supp?>" readonly/>
        <input type='hidden' name="code" value="<?php echo $code ?>">
    <?php } ?>
    <br>
    <br>
    <h4>Reference No.:<br></h4>
    <input type="text" class="form-control" name="refno" placeholder="Ref No." required>
    <!-- <span class="help-block"><?php echo form_error('refno'); ?> -->
    <br>
    <h4>Total Amount Include GST:<br></h4>
    <input type="number" class="form-control" name="Amount" placeholder="Amount(RM)" min="0" step="0.01" required>
    <br>
    <h4>Total GST:<br></h4>
    <input type="number" class="form-control" name="gst" placeholder="GST(RM)" min="0" step="0.01" required>
    <br>
    <h4>Remark:<br></h4>
    <textarea name="remark" class="form-control" rows="4" cols="50" placeholder="Add remark" pattern="any"></textarea>
    <br><br>
    <input type="submit" value="Submit" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
</form> 
<p>&nbsp;</p>
</body>
</html>