<html>
<body>
<div class="container">
      <table width="200" border="0">
      <tr>
        <td width="150">
        <h5><b>SUBMISSION LIST<b></h5>
        <small><b>Scan <?php echo $title?></b></small>
        </td>
        <td width="28"><a href="<?php echo site_url('submitdoc_controller/menu')?>?guid=<?php echo $_REQUEST['sl_guid']?>"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
        <td width="28"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">
    <p><b>User ID :</b><?php echo $_SESSION['userid']?></p>
    <label>Scan Transaction Barcode</label><br>
    <input type="text" name="barcode" style="background-color: #e6fff2" class="form-control input-md" id="autofocus" placeholder="Scan User_ID" autofocus>
</form>
<br>
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : '';?>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>

