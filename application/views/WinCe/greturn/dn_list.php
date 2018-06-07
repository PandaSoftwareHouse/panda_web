<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GOOD RETURN</b></h5></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><a href="<?php echo site_url('greturn_controller/dn_add')?>" class="btn_primary">+ ADD TRANS</a></p>


<table width="200" class="cTable">
<thead>
  <tr align="center">
    <td class="cTD">Supplier Code</td>
    <td class="cTD">Supplier Name</td>
  </tr>
</thead>  
  <?php                      
      if($dn_list->num_rows() != 0)
      {
          foreach ($dn_list->result() as $row)
          {  
  ?>   
  <tr>
    <td class="cTD"><?php echo $row->sup_code; ?></td>
    <td class="cTD"><a href="<?php echo site_url('greturn_controller/dn_item_list')?>?sup_code=<?php echo $row->sup_code;?>"><?php echo $row->sup_name; ?></a></td>
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
