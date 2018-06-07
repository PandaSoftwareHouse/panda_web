<html>
<body>
  <div class="container"> 

   <table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Purchase Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('PO_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<table width="200" border="0">
    <tr>
        <td width="100">
            <form role="form" method="POST" action="<?php echo site_url('PO_controller/search_result');?>">
         <label>Search By</label>   
         <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="supname"  id="autofocus" required autofocus  />     
            </form>
        </td>
        <td width="100">
            <h6 style="float:right"><b>Total Records:</b><?php echo $supname->num_rows();?></h6>
        </td>
    </tr>
    
</table>
<table width="200" class="cTable">
    <thead>
        <tr>
            <th class="cTD">Sup Name</th>
            <th class="cTD" style="text-align:center">Add</th>
        </tr>
    </thead>
    <?php                       
      if($supname->num_rows() != 0)
      {
        foreach ($supname->result() as $row)
        {  
    ?>        
    <tbody>
      <tr>
        <td class="cTD"><?php echo $row->dname; ?></td>
        <td style="text-align:center" class="cTD">
            <a href="<?php echo site_url('PO_controller/add_trans')?>?supcode=<?php echo $row->CODE; ?>&supname=<?php echo $row->NAME; ?>" class="btn_info">+</a>
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
        <td colspan="2" style="text-align:center;" class="cTD">No Supplier.</td>
          </tr>
        </tbody>
    <?php
      }
    ?>
</table>
</div>
</body>
</html>