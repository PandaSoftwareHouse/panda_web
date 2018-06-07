<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="130"><h5><b>Gondola Stock</b></h5></td>
    <td width="20"><a href="<?php echo site_url('gondolastock_controller/scan_binID')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
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

<a href="<?php echo site_url('gondolastock_controller/pre_itemscan'); ?>?locBin=<?php echo $_SESSION['locBin']?>" class="btn_primary"><b>+ ADD ITEM </b></a>
    
<h5><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?></h5> 
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
<p align="right">

<a href="<?php echo site_url('gondolastock_controller/pre_itemPrint')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" ><img src="<?php echo base_url('assets/icons/print.jpg');?>"></a>                              
</p>
<table class="cTable">
     <thead>
        <tr>
            <td class="cTD" style="text-align:center;"><b>Qty</b></td>
            <td class="cTD"><b>Description</b></td>
        </tr>
    </thead>
    <?php
                               
        if($itemlist->num_rows() != 0)
        {
            foreach ($itemlist->result() as $row)
            {  
     ?>        
    <tbody>
        <tr>
            <td class="cTD" style="text-align:center;"><?php echo $row->Qty; ?></td>
            <td class="cTD">
            <a href="<?php echo site_url('gondolastock_controller/pre_itemEdit')?>?Barcode=<?php echo $row->Barcode?>&TRANS_GUID=<?php echo $row->TRANS_GUID ?>&binID=<?php echo $row->BIN_ID?>&locBin=<?php echo $_SESSION['locBin']?>">
            <?php echo $row->Description; ?></a>

            <a style="float:right" style="" href="<?php echo site_url('gondolastock_controller/pre_itemDelete')?>?TRANS_GUID=<?php echo $row->TRANS_GUID?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>">
            </a>
            </td>
            <input type="hidden" name="item_guid" value="<?php echo $row->TRANS_GUID; ?>"/>
        </tr>
    </tbody>
     <?php
            }
        }   
            else
            {
            ?>
            <tbody>
                <tr>
                <td class="cTD" colspan="5" style="text-align:center;">No Record Found</td>
                </tr>
            </tbody>
            <?php
                                            
            }
    ?>
</table>
