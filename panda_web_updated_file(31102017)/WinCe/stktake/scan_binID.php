<html>
<head>
<style>

  th,td,h6 {
    font-size: 12px;
  }

  .btn {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0px;
  font-family: Arial;
  color: #ffffff;
  font-size: 12px;
  background: #4380B8;
  padding: 0px 3px 3px 3px;
  border: solid #4380B8 2px;
  text-decoration: none;
}

 table{
   border-collapse: collapse;
 } 
.cTable
{ 
    border: 1px solid black;
    
}
.cTD
{ 
    border: 1px solid black;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panda Retail System</title>
</head>

<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_controller/scan_userID')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_controller/scan_item'); ?>">
      <?php
        $user_ID = $this->session->userdata('user_ID');
      ?>
  <p><b>User ID :</b><?php echo $user_ID?></p>    
  <p>
    <label>Scan Bin ID<br>
    </label>
    <input type="text" style="background-color: #e6fff2" class="form-control input-md" name="bin_ID" id="textarea" required autofocus onblur="this.focus()"/>
    <input type="hidden" class="form-control"  name="user_ID" value="<?php echo $user_ID ?>" />
  </p>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>