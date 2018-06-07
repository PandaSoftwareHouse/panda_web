<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Shelve Label</b></h5>
    <a href="<?php echo site_url('shelveLabel_controller/update_printflag')?>" ">
    <img src="<?php echo base_url('assets/icons/print.jpg'); ?>">
    </a>  
    </td>
    <td width="20"><a href="<?php echo site_url('shelveLabel_controller')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href="<?php echo site_url('shelveLabel_controller/update_printflag')?>" style="color: grey"><img src="<?php echo base_url('assets/icons/print.jpg');?>"></a>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('shelveLabel_controller/barcode_scan_result'); ?>">
<b>Bin ID :</b><?php echo $_SESSION['get_binID']?><br>
      		<label>Scan Barcode</label>
   		  <br>
          <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/>
          <p>  
          <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4></p>     
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
