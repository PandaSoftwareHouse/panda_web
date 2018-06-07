<html>
<body>
<div class="container">
     <table width="200" border="0">
      <tr>
         <td width="120"><h5><b>IBT REQUEST<b></h5></td>
        <td width="20"><a href="<?php echo site_url('IBT_controller/main')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
    <p>
        <?php
          foreach ($header->result() as $row)
            {  
        ?>  
          <h4><b><?php echo $row->acc_name; ?></b></h4>
          <h5><b>Cost:</b>$<?php echo $row->bill_amt; ?></h5>
          <h5><b>Total Records : </b><?php echo $count; ?></h5><br>
        <?php
           }
        ?>   

    </p>

  <p>
  <a href="<?php echo site_url('general_scan_controller/scan_item'); ?>?web_guid=<?php echo  $row->web_guid?>&acc_code=<?php echo $row->acc_code?>" class="btn_primary">+ ADD ITEM</a>
    </p>

    <table width="200" class="cTable">
      <thead>
        <tr align="center">
          <td class="cTD">No</td>
          <td class="cTD">Item Code</td>
          <td class="cTD">Item Name</td>
          <td class="cTD">Price</td>
          <td class="cTD">Quantity</td> 
          <td class="cTD">Action</td>
        </tr>
     </thead> 
      <?php                             
        if($item->num_rows() != 0)
        {
            $count = 0;
            foreach ($item->result() as $row)
        {  $count++;
      ?>      
     <tbody>
        <tr align="center">
          <td class="cTD"><?php echo $count; ?></td>
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
          <!-- <a href="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>"><?php echo $row->description; ?></a> -->
          </td>
          <td class="cTD">$ <?php echo $row->price; ?></td>
          <td class="cTD"><?php echo $row->qty; ?></td>
          <td class="cTD">
          <a href="<?php echo site_url('ibt_controller/delete_item'); ?>?web_c_guid=<?php echo $row->web_c_guid ;?>&web_guid=<?php echo $row->web_guid ;?>" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()">
          <img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a></td>
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
          <td colspan="7" style="text-align:center;">No Item</td>
        </tr>
     </tbody>
        <?php                                   
          }
    ?>   

  </table>
    
</div>
</body>
</html>
