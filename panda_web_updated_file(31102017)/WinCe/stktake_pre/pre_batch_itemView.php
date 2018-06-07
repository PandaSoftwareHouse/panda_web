<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>PRELISTING BY PALLET - View Item </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemlist')?>?bin_ID=<?php echo $_SESSION['bin_ID'] ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>

<p>Bin ID :<?php echo $_SESSION['bin_ID']?> </p>
<table width="200" class="cTable">
  <tr>
    <td class="cTD">Qty</td>
    <td class="cTD">Description</td>
  </tr>

<?php
                                    
      if($result->num_rows() != 0)
      {
          foreach ($result->result() as $row)
          {  
  ?>        

  <tr>
    <td class="cTD" style="text-align: center;"><?php echo $row->qty_rec; ?></td>
    <td class="cTD"><?php echo $row->po_description; ?></td>
  </tr>

  <?php
        }
    }   
     else
     {
  ?>  
    <tr>
      <td colspan="2" style="text-align:center;">No Record Found</td>
    </tr>
  <?php                               
     }
  ?>
</table>
</div>
</body>
</html>
