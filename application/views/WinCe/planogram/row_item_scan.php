<html>
<body>
<div class="container">
  <table width="200" border="0">
      <tr>
         <td width="120"><h5><b>PLANOGRAM</b></h5></td>
         <td width="20"><a href="<?php echo site_url('planogram_controller/binID_list')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></td>
         <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
       <table width="200" border="0">
         <tr>
           <td><b>Bin ID:</b> <?php echo $bin_ID?><b>&nbsp;&nbsp;<?php echo $row_no?></b></td>
           <td>
           <center>
           
           <a href="<?php echo site_url('planogram_controller/rack_row_item_delete_all')?>?row_guid=<?php echo $_REQUEST['row_guid']?>&bin_ID=<?php echo $bin_ID?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a>
           
           </center>
           </td>
         </tr>
       </table>
       <form role="form" method="POST" id="myForm" action="<?php echo site_url('planogram_controller/row_item_scan_result'); ?>">
          <label>Scan Barcode</label><br>
          <input type="text" name="barcode" id="autofocus"  style="background-color: #e6fff2" class="form-control input-md" >
          <input type="hidden" name="row_guid" value="<?php echo $_REQUEST['row_guid']?>">
  </form>
       <br> 
      <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</div>
</body>
</html>