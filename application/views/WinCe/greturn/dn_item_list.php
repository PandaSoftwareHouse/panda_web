<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GOOD RETURN</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greturn_controller/dn_list')?>" style="float:right" ><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>


<table width="200" class="cTable">
<thead>
  <tr align="center">
    <td class="cTD">QTY</td>
    <td class="cTD">Barcode</td>
    <td class="cTD">Name</td>
    <td class="cTD">Delete</td>
  </tr>
</thead>  
  <?php
                                    
                                    if($result->num_rows() != 0)
                                    {
                                        foreach ($result->result() as $row)
                                        {  
                                ?>    
  <tr>
    <td class="cTD"><?php echo $row->qty; ?></td>
    <td class="cTD"><?php echo $row->scan_barcode; ?><b style="float:right">P/S: <?php echo $row->packsize; ?></b></td>
    <td class="cTD">
    <a href="<?php echo site_url('greturn_controller/dn_item_edit')?>?item_guid=<?php echo $row->item_guid; ?>&edit_mode=edit&sup_code=<?php echo $_REQUEST['sup_code']?>"><?php echo $row->description; ?></a>
    </td>
    
    <td class="cTD"><center>
    <a href="<?php echo site_url('greturn_controller/delete_item')?>?item_guid=<?php echo $row->item_guid; ?>&sup_code=<?php echo $_REQUEST['sup_code']?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></a></center>
    </td>
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
