<html>
<body>
<div class="container">
<form role="form" method="post" action="<?php echo site_url('main_controller/login_form'); ?>">

  <table width="200" border="0">
  <tr>
    <td colspan="2"><h6 align="center"><b>Panda Retail System </b></h6></td>
  </tr>
    <tr>
      <td rowspan="2">
      <img src="<?php echo base_url('assets/img/panda.jpg');?>" width="65" height="85">
      </td>
      <td style="padding: 2px">
      <label>Username</label>
        <input name="username" type="text" id="autofocus" class="form-control" size="18" placeholder="Username" style="background-color: #e6fff2;width: 120px" autofocus>
        <?php echo form_error('username') ?></td>
    </tr>
    <tr>
      <td style="padding: 2px">
        <label>Password</label>
        <input name="userpass" type="password" class="form-control" size="18" placeholder="Password" style="background-color: #e6fff2">
        <?php echo form_error('userpass') ?></td>
    </tr>
    <tr>
      <td><span style="padding: 2px">
        <input type="submit" name="submit" id="submit" value="LOGIN" class="btn_login">
      </span></td>
      <td style="padding: 2px"><select name="location" class="form-control" style="background-color:#e6fff2">
        <?php
                    foreach($location->result() as $row)
                        {
                            ?>
        <option selected><?php echo $row->sublocation; ?></option>
        <?php
                        }
                            ?>
      </select>
        <br>
        <?php echo form_error('location'); ?></td>
    </tr>
    <tr>
      <td colspan="2" style="padding: 2px">
      <center>
      <small><?php echo 'Current PHP version: ' . phpversion();?></small>  
      <small>&copy; Panda Software House Sdn. Bhd.</small></center></td>
    </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
</form>
</div>  
</body>
</html>
