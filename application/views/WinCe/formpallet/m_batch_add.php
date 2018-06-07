<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg') ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>  
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>          
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/m_batch_add_save'); ?>">
<h4><b>Add <small>Batch/Pallet/Trolley</small></h4></b></h4>
<input name="MaxBatch_Id" disabled value="<?php echo $MaxBatch_Id?>" class="form-control input-md" style="background-color:#ffff99;text-align: center;width:40px;font-size: 14px "/>
   
    <h4><b>Method: </b>
        <select name="method_name" class="form-control input-md" style="background-color:#80ff80;width: 120px"  >
            <?php
            foreach($method_name->result() as $row)
            {
                ?>
            <option><?php echo $row->method_name;?></option>
                 <?php
            }
            ?>
                                
        </select></h4>
    <h4><b>Bin ID: </b>
    <input type="text" autofocus onfocus="this.select()" value="0" class="form-control" name="bin_ID" style="background-color:#ffff99;width: 120px"></h4>
    <br>
    <input type="submit" name="add2" class="btn_success" value="SAVE">
    </form>
</div>
<p>&nbsp;</p>
</body>
</html>