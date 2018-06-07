<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="130"><h5><b>Gondola Stock</b></h5></td>
    <td width="20"><a href="<?php echo site_url('gondolastock_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('gondolastock_controller/pre_itemEdit'); ?>">

<?php 
  foreach($result->result() as $row)
    {
?>
<h5><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?> (<?php echo $row->Location?>)</h5>
<label>Scan Barcode</label><br>                             
<input type="text" class="form-control" style="background-color: #e6fff2" placeholder="Scan Barcode" name="barcode"/>
<input value="<?php echo $row->Location?>" type="hidden" name="locBin">
<input value="<?php echo $_SESSION['bin_ID']?>" type="hidden" name="binID">

<?php
  }
?>
              
<h5><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>

</form>

<br>

<table class="cTable">
    <thead>
        <tr>
            <td class="cTD" style="text-align:center;"><b>Qty</b></td>
            <td class="cTD"><b>Barcode</b></td>
            <td class="cTD"><b>Description</b></td>
        </tr>
    </thead>
    <?php
                                    
        if($last_scan->num_rows() != 0)
        {
            foreach ($last_scan->result() as $row)
            {  
    ?>        
    <tbody>
        <tr>
            <td class="cTD" style="text-align:center;"><?php echo $row->Qty; ?></td>
            <td class="cTD"><?php echo $row->Barcode; ?></td>
            <td class="cTD"><?php echo $row->Description; ?></td>
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

</div>
<p>&nbsp;</p>
</body>
</html>