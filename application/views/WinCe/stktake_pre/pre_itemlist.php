<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - Prelisting </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/scan_binID'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
  <?php
    foreach($result->result() as $row)
    {
        $_SESSION['locBin'] = $row->Location;
                                    
    }
  ?>
  <a href="<?php echo site_url('stktake_pre_controller/pre_itemscan'); ?>?locBin=<?php echo $_SESSION['locBin']?>" class="btn_primary">+ SCAN ITEM</a>
</p>

<p>Bin ID : <?php echo $_SESSION['bin_ID']?></p>
<table width="200" border="0">
  <tr>
  
    <td>
    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
    </td>
    <td align="right">
    <a href="<?php echo site_url('stktake_pre_controller/pre_itemPrint')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/print.jpg');?>">
    </a>
    </td>
  
  </tr>
  <tr>
    <td align="center" class="cTD"><strong>Qty</strong></td>
    <td class="cTD"><strong>Description</strong></td>
  </tr>

    <?php
                               
      if($itemlist->num_rows() != 0)
      {
        foreach ($itemlist->result() as $row)
        {  
    ?>          

  <tr>
    <td class="cTD"><center><?php echo $row->Qty; ?></center></td>
    <td class="cTD">
      <a href="<?php echo site_url('stktake_pre_controller/pre_itemEdit')?>?Barcode=<?php echo $row->Barcode?>&TRANS_GUID=<?php echo $row->TRANS_GUID ?>&binID=<?php echo $row->BIN_ID?>&locBin=<?php echo $_SESSION['locBin']?>"><?php echo $row->Description; ?>
      </a>
      <input type="hidden" name="item_guid" value="<?php echo $row->TRANS_GUID; ?>"/>
      <a style="float:right" href="<?php echo site_url('stktake_pre_controller/pre_itemDelete')?>?TRANS_GUID=<?php echo $row->TRANS_GUID?>"onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>">
      </a>
    </td>
  </tr>
   <?php
      }
        }   
      else
        {
    ?>
        <tr>
         <td colspan="3" style="text-align:center;">No Record Found</td>
        </tr>
    <?php                                       
      }
    ?>
</table>
</div>
</body>
</html>