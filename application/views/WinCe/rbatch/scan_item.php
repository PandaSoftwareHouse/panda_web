<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER (IN)</b></h5>
    <small><?php echo $_SESSION['refno'] ?></small>
    </td>
    <td width="20"><a href="<?php echo site_url('rbatch_controller/itemlist?trans_guid='.$_SESSION['trans_guid']) ?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>    
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('rbatch_controller/post_refno_c'); ?>">
<label>Scan Batch Refno</label><br>                     
<input type="text" class="form-control" style="background-color: #E6FFF2" placeholder="Scan Batch Refno" name="refno" id="autofocus"/>
<br>
<h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                        
</form>
</div>
<p>&nbsp;</p>
</body>
</html>        