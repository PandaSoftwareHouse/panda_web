<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panda Retail System</title>
</head>

<body>
<div class="container">
    <table width="200" border="0">
      <tr>
         <td width="120"><h5><b>PLANOGRAM</b></h5></td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
       <form role="form" method="POST" id="myForm" action="<?php echo site_url('planogram_controller/binID_list'); ?>">
          <label for="textfield">Scan Bin ID</label><br>
          <input type="text" name="bin_ID" id="bin_ID" style="background-color: #e6fff2" class="form-control input-md" >
       </form>
       <br> 
       <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->
       userdata('message') : ''; ?></h4>
</div>
</body>
</html>