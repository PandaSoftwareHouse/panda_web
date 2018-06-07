<html>
<body>
<div class="container">
<table width="200" border="0">
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


<form role="form" method="POST" action="<?php echo site_url('SO_controller/search_result');?>">
      		<label>Search By</label>
          <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="supname" id="autofocus" required autofocus onblur="this.focus()"/>     
</form>
</div>
</body>
</html>
