<html>
<body>
<div class="container">
<table width="200" border="0">
      <tr>
        <td width="150"><h5><b>SUBMISSION LIST<b></h5></td>
        <td width="20"><a href="<?php echo site_url('submitdoc_controller/backhome')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
      <p>
      <form role="form" method="POST" id="myForm" action="<?php echo site_url('submitdoc_controller/declare_session'); ?>">
        <label>Scan User ID</label><br>
        <input type="text" name="userid" style="background-color: #e6fff2" class="form-control input-md" id="autofocus" placeholder="Scan User_ID" onsubmit="return required();" autofocus>
        </form>
      </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>
