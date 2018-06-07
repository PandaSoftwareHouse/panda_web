<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="130"><h5><b>Sales Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('SO_controller/main')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<?php
    foreach ($header->result() as $row)
    {  
?>  
    <h5><b><?php echo $row->acc_name; ?></b>
    <br>(<?php if($row->Type = 'C') 
    {
      echo $row->tax_code;
    }
    elseif($row->Type = 'S')
    {
    echo $row->poprice_method;
    } 
    ?>)</h5>
    <b>Cost:</b> <?php echo $row->bill_amt_format; ?>                         
        <input value="<?php echo $row->web_guid?>" type="hidden" name="web_guid">
        <input value="<?php echo $row->acc_code ?>" type="hidden" name="acc_code">
        <input value="<?php echo $row->acc_name ?>" type="hidden" name="acc_name">
<?php
    }
?>
<br> 
<a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo $row->web_guid?>&acc_code=<?php echo $row->acc_code?>" class="btn_primary">+ ADD ITEM</a>
<br><br>   
<table width="220" class="cTable">
    <thead>
        <tr align="center">
            <td class="cTD"><b>Item Code</b></td>
            <td class="cTD"><b>Item Name</b></td>
            <td class="cTD"><b>Price</b></td>
            <td class="cTD"><b>Quantity</b></td>
            <td class="cTD"><b>Action</b></td>
        </tr>
    </thead>
    <?php                   
      if($item->num_rows() != 0)
       {
        foreach ($item->result() as $row)
       {  
    ?>        
    <tbody>
        <tr align="center">
          <td class="cTD"><?php echo $row->itemcode; ?></td>
          <td class="cTD">
          <?php
            if($row->scan_type == 'BATCH')
          {
          ?>
            <a href="<?php echo site_url('Main_controller/scan_log'); ?>?type=<?php echo $row->module_desc ;?>&item_guid=<?php echo $row->item_guid ;?>&web_c_guid=<?php echo $row->web_c_guid?>"><?php echo $row->description; echo '&nbsp'?><img src="<?php echo base_url('assets/icons/batch.jpg');?>"></a>
          <?php
          }
          else
          {
          ?>
            <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>"><?php echo $row->description; ?>
          <?php
          }
          ?>
          </td>
          <td class="cTD">$ <?php echo $row->price; ?></td>
          <td class="cTD"><?php echo $row->qty; ?></td>
          <td class="cTD">
          <a href="<?php echo site_url('SO_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a>
          </td>
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
      <td class="cTD" colspan="5" style="text-align:center;">No Item</td>
    </tr>
    </tbody>
        <?php 
          }
        ?>
</table>
</div>
<p>&nbsp;</p>
</body>
</html>