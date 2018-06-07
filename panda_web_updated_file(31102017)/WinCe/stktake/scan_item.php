<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_controller/scan_binID?user_ID='.$_SESSION['user_ID'])?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_controller/scan_item_result'); ?>">
<?php
  if ($_SESSION['user_ID'] != '')
  {
    $user_ID = $_SESSION['user_ID'];
    $bin_ID = $_SESSION['bin_ID'];
    $_SESSION['get_weight'] = '';
    $_SESSION['get_price'] = '';
  }
  else
  {
    $user_ID = $_REQUEST['user_ID'];
    $bin_ID = $_REQUEST['bin_ID'];
    $_SESSION['get_weight'] = '';
    $_SESSION['get_price'] = '';
  }
?>
<table width="200" border="0">
  <tr>
    <td><b>User ID :</b><?php echo $user_ID?></td>
    <td rowspan="2">
    <a href="<?php echo site_url('stktake_controller/send_print'); ?>" style="color: grey">
    <img src="<?php echo base_url('assets/icons/print.jpg');?>"></a>
    <?php 
      { 
        echo $_SESSION['printinfo'] ;
      }
    ?>
    </td>
  </tr>
  <tr>
    <td><b>Bin ID :</b><?php echo $bin_ID?></td>
    </tr>
  <tr>
    <td><b>Location :</b><?php echo $_SESSION['sublocation'];?></td>
  </tr>    
</table>
  <p>
    <label>Scan Barcode<br>
    </label>
    <input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="textarea" required autofocus onblur="this.focus()"/>
    <br>
  </p>
   <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>