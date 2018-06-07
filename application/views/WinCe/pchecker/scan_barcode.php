<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Price Checker</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form  role="form" method="POST" id="myForm" action="<?php 
                    if($_SESSION['show_cost'] == '1') 
                      {
                        echo site_url('PcheckerCost_controller/scan_result');
                        }
                        else
                        {
                          echo site_url('pchecker_controller/scan_result');
                          } ?>">
  <p>
    <label>Scan Barcode<br>
    </label>
    <input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="autofocus">
  </p>
</form>
<h4 style="color: red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<p>&nbsp;</p>
</div>
</body>
</html>