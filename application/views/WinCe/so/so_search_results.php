<html>
<body>
   <div class="container">
   <table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Sales Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('SO_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<table width="220" border="0">
    <tr>
        <td width="110">
            <form role="form" method="POST" action="<?php echo site_url('SO_controller/search_result');?>">
         <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="supname"  id="autofocus" required autofocus onblur="this.focus()" />     
            </form>
        </td>
        <td width="110">
            <h6 style="float:right"><b>Total Records:</b><?php echo $supname->num_rows();?></h6>
        </td>
    </tr>
    
</table>
<table width="220" class="cTable">
  <thead>
      <tr>
          <th class="cTD">Sup Name</th>
          <th class="cTD" style="text-align:center">Add</th>
                                        <!--<td style="text-align:center"><b>Add</b></td>-->
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
        <td class="cTD" style="text-align:center">
            <a id="btn" class="btn" href="<?php echo site_url('SO_controller/add_trans')?>?supcode=<?php echo $row->CODE; ?>&supname=<?php echo $row->NAME; ?>">+</a>
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
                <td class="cTD" colspan="2" style="text-align:center;">No Supplier.</td>
                </tr>
            </tbody>
            <?php
                                            
            }
    ?>
</table>
</div>
</body>
</html>