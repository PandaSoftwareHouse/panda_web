<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panda Retail System</title>
</head>

<body>
<div class="container">
    <table width="200" border="0">
      <tr>
         <td width="120"><h5><b>IBT REQUEST</b></h5></td>
        <td width="20"><a href="<?php echo site_url('IBT_controller/main')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
           <form role="form" method="POST" id="myForm" action="<?php echo site_url('IBT_controller/add_trans'); ?>">
            <h4>IBT FROM : </h4>
            <select name="frombranch" class="form-control">
              <?php 
                foreach ($supplier->result()  as $row)
                  {
                      ?>
                          <?php if($row->dname == $selected )
                            { 
                              echo 'selected'; 
                            } 
                            else 
                            { 
                              echo '';
                            }  
                          ?>
                      <option><?php echo $row->dname;?></option>
                      <?php
                  }
              ?>
            </select>
            <br>
            <h4>IBT TO : </h4>
              <select name="tobranch" class="form-control">
              <?php 
                  foreach ($supplier->result()  as $row)
                      {
                          ?>
                          <option><?php echo $row->dname;?></option>
                          <?php
                      }
                  ?>
              </select><br>
              <?php
                  if($this->session->userdata('message') )
                  {
                     echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                  }
                  ?>
        <input type="submit" name="ssave" class="btn_success" value="SAVE">
       </form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>