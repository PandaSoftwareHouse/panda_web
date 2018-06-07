<html>
<body>
<div class="container">
    <table width="200" border="0">
      <tr>
        <td width="150"><h5><b>SUBMISSION LIST<b></h5></td>
        <td width="20"><a href="<?php echo site_url('submitdoc_controller/transaction_result')?>?guid=<?php echo $_REQUEST['guid']?>"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
          <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    <h5>Scan Option :</h5>
                    <br>
                    <?php
                    $i = 0;
                    foreach($result->result() as $row)
                    {
                      ?>
                     <h5><b><?php echo ++$i ?>.</b> <a href="<?php echo $row->module_link?>&sl_guid=<?php echo $_REQUEST['guid']?>"><?php echo $row->module_name?></a></h5>
                      <?php
                    }
                    ?>
</div>                    
</body>
</html>
