<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><a href="<?php echo site_url('dnbatch_controller/scan_supplier'); ?>" class="btn_primary">+ ADD SUPPLIER</a></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('Dnbatch_controller/search_refno'); ?>">
  <p>
    <label for="textfield">Search Batch No</label>
    <br>
    <input type="text" name="batch_no" class="form-control input-md" id="autofocus" style="background-color: #e6fff2" required autofocus >
  </p>
  <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
  <table width="200" class="cTable">
  <thead>
    <tr>
      <td class="cTD">Refno</td>
      <td class="cTD">Supplier</td>
      <td class="cTD"><center>Action</center></td>
    </tr>
  </thead>  
     <?php
         foreach ($result->result() as $row)
         {
     ?>
    <tr>
      <td class="cTD"><a href="<?php echo site_url('dnbatch_controller/itemlist')?>?batch_no=<?php echo $row->batch_no;?>"><?php echo $row->batch_no; ?></td>
      <td class="cTD"><?php echo $row->sup_name ?></td>
      <td class="cTD"><center><a href="<?php echo site_url('dnbatch_controller/delete_batch'); ?>?dbnote_guid=<?php echo $row->dbnote_guid;?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>" ></a></center></td>
    </tr>
      <?php
        }
      ?> 
  </table>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

