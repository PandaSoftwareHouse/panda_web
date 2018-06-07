<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>PLANOGRAM</b></h5></td>
    <td width="20"><a href="<?php echo site_url('planogram_controller/scan_binID'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><a href="<?php echo site_url('planogram_controller/row_add')?>" class="btn_primary">+ ADD ROW</a><br>
<h5><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?></h5><br>
 <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</p>


<table width="200" class="cTable">
<thead>
  <tr align="center">
    <td class="cTD">Row No</td>
    <td class="cTD">Row Width</td>
    <td class="cTD">Row Depth</td>
    <td class="cTD">Row Height</td>
    <td class="cTD">Row Volume</td>
  </tr>
</thead>  
 <?php
    if($result->num_rows() != 0)
    {
        foreach ($result->result() as $row)
        {  
 ?>        
  <tr align="center">
    <td class="cTD"><b><a style="font-size: 16px" href="<?php echo site_url('planogram_controller/row_item_scan')?>?row_guid=<?php echo $row->row_guid?>"><?php echo $row->row_no; ?></a></b></td>
    <td class="cTD"><?php echo $row->row_w; ?></td>
    <td class="cTD"><?php echo $row->row_d; ?></td>
    <td class="cTD"><?php echo $row->row_h; ?></td>
    <td class="cTD"><?php echo $row->row_volume; ?></td>
  </tr>
   <?php
      }
    }   
    else
    {
    ?>
      <tr>
        <td colspan="5" style="text-align:center;">No Record Found</td>
      </tr>
    <?php                                        
      }
  ?>
</table>
</div>
</body>
</html>
