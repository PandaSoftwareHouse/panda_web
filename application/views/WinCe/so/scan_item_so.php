<html>
<body  onload="autofocus()">
<table width="220" border="0">
  <tr>
    <td width="150"><h5><b>Sales Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('SO_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

                              <form  role="form" method="POST" action="<?php echo site_url('SO_controller/scan_itemresult'); ?>">
                       
                          <?php
                          $acc_code = $this->session->userdata('acc_code');
                          $web_guid = $this->session->userdata('web_guid');
                          //$acc_name = $this->session->userdata('acc_name');
                           // echo $_SESSION['web_guid'] ;

                          ?>
                          <input value="<?php echo $web_guid?>" name="web_guid" type="hidden">
                          <!--input value="<?php echo $acc_code?>" name="acc_code" type="hidden">
                          <input value="<?php echo $acc_name?>" name="acc_name" type="hidden">
                            
                            <input type="text" class="form-control" placeholder="Scan Item" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/-->

                           <input type="text" style="background-color: #e6fff2" id="autofocus" class="form-control input-md" placeholder="Scan Item" name="barcode" id="autofocus" required autofocus onfocus="this.select()"/>   
                        
                    </form>
</body>
</html>