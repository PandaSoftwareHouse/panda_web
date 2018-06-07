<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER (IN)</b></h5><small><?php echo $_SESSION['refno'] ?></small> 
    </td>
    <td width="20"><a href="<?php echo site_url('rbatch_controller/main')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>  
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>  
<a href="<?php echo site_url('rbatch_controller/scan_batch'); ?>" class="btn_default"><small>POST</small></a><br><br>                        
<p><a href="<?php echo site_url('rbatch_controller/scan_item') ?>" class="btn_primary">+ ADD ITEM</a>
 <input value="<?php echo $_SESSION['refno']?>" name="refno" type="hidden">
</p>                      
<!-- <h5>Location: <b><?php echo $_SESSION['location'] ?></b>&nbsp&nbsp T:<?php echo $count ?></h5> -->
                        
<table class="cTable" >
  <thead style="cursor:s-resize">
    <tr>
      <th class="cTD">Batch Barcode</th>
      <th class="cTD" style="text-align:center;">Weight Variance</th>
      <th class="cTD" style="text-align:center;">Verified Variance</th>
      <th class="cTD" style="text-align:center;">Created by</th>
      <th class="cTD" style="text-align:center;">Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($result->result() as $row)
        {
    ?>
    <tr>
      <td class="cTD"><?php echo $row->batch_barcode; ?></td>
      <td class="cTD" style="text-align:center;"><?php echo $row->pick_weight_variance ?></td>
      <td class="cTD" style="text-align:center; color:red"><?php echo $row->varified_weight_variance ?></td>
      <td class="cTD"><?php echo $row->created_by; ?></td>
      <td class="cTD"><?php echo $row->created_at; ?></td>


    </tr>
    <?php
        }
    ?> 
  </tbody>
</table>

</div>
<p>&nbsp;</p>
</body>
</html>