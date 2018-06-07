<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - By Pallet </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/scan_binIDBatch'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
  <?php
      foreach($result->result() as $row)
  {
      $_SESSION['locBin'] = $row->Location;
                                    
  }
  ?>
<p>
  <a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemscan'); ?>?locBin=<?php echo $_SESSION['locBin']?>" class="btn_primary">+ SCAN PALLET</a>
</p>

<p>Bin ID : <?php echo $_SESSION['bin_ID']?> <br>
 <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
</p>
<table width="200" class="cTable">
  <tr>
    <td class="cTD" colspan="2">Batch Barcode</td>
    </tr>
     <?php                        
        if($itemlist->num_rows() != 0)
        {
            foreach ($itemlist->result() as $row)
        {  
     ?>        
  <tr>
    <td width="155" class="cTD">
    <a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemView')?>?batch_barcode=<?php echo $row->BATCH_BARCODE ?>"><?php echo $row->BATCH_BARCODE; ?>
    </a>
    </td>
    <td width="29" class="cTD">
    <center>
    <a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemDelete')?>?batch_barcode=<?php echo $row->BATCH_BARCODE?>" onclick="return check()">
    <img src="<?php echo base_url('assets/icons/garbage.jpg');?>">
    </a>
      <input type="hidden" name="item_guid" value="<?php echo $row->TRANS_GUID; ?>"/>
    </center>
    </td>
  </tr>
      <?php
          }
      }   
        else
        {
      ?>
         <tr>
              <td colspan="2" style="text-align:center;" class="cTD">No Record Found</td>
         </tr>
      <?php
        }
      ?>

</table>
</div>
</body>
</html>
