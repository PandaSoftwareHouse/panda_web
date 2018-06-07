<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - Prelisting </b></h5></td>
    
    <?php
      if(isset($back))
      {
    ?>
  <td width="20"><a href="<?php echo site_url('stktake_pre_controller/scan_binID')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    
   <?php
      }
      else
      {
   ?>

    <td width="20"><a href="<?php echo site_url('stktake_pre_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    
       <?php
          }
       ?>

    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_pre_controller/pre_itemEdit'); ?>">
<?php 
  foreach($result->result() as $row)
  {
?>

<p><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?> (<?php echo $row->Location?>) </p>

<label>Scan Barcode</label><br>
<input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="autofocus" required autofocus />

<input value="<?php echo $row->Location?>" type="hidden" name="locBin">
<input value="<?php echo $_SESSION['bin_ID']?>" type="hidden" name="binID">

<?php
  }
?><br>
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
</form>
<table width="200" class="cTable">
<thead>
  <tr>
    <td class="cTD" align="center">Qty</td>
    <td class="cTD">Barcode</td>
    <td class="cTD">Description</td>
  </tr>
</thead>
<?php
                                    
    if($last_scan->num_rows() != 0)
    {
      foreach ($last_scan->result() as $row)
        {  
?>

  <tr>
    <td class="cTD"><?php echo $row->Qty; ?></td>
    <td class="cTD"><?php echo $row->Barcode; ?></td>
    <td class="cTD"><?php echo $row->Description; ?></td>
  </tr>

  <?php
        }
    }   
    else
    {
  ?>
    <tr>
    <td colspan="3" style="text-align:center;" class="cTD">No Record Found</td>
    </tr>
  <?php
    }
  ?>

</table>
</div>
</body>
</html>