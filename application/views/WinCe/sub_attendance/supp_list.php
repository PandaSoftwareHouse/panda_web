<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Supplier List</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form method='POST' action="<?php echo site_url('sub_attendance_controller/proceed_supp')?>">
    <select class="form-control" name="supplier">
    <option value="Others">Others</option>

    <?php foreach ($supp_array->result() as $row) { ?>

    <option value="<?php echo $row->code?>"><?php echo $row->code, " ==> " , $row->Name?></option>

    <?php } ?>
    
    </select>
    <br>
    <input type="submit" value='Submit' class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
</form>
<!-- <p>Name is not in the list?<a href="<?php echo site_url('sub_attendance_controller/add_supp')?>"> CLICK HERE</a></p> -->
</div>
<p>&nbsp;</p>
</body>
</html>