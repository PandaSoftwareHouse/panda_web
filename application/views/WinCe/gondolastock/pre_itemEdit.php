<html>
<body>
<div class="container">

  <table width="200" border="0">
  <tr>
    <td width="130"><h5><b>Gondola Stock Item Edit</b></h5></td>
    <td width="20"><a href="<?php echo site_url('gondolastock_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['binID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>       
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>    
<form role="form" method="POST" id="myForm" action="<?php echo site_url('gondolastock_controller/pre_itemSave')?>">
<p>                      

<b>Loc: </b><?php echo $this->session->userdata('locBin')?><br>
<b>BinID: </b><?php echo $this->session->userdata('binID')?><br>
<b>Description: </b><?php echo $BarDesc?><br>
<b>Barcode: </b><?php echo $barcode?><br>
<b>Itemcode: </b><?php echo $Itemcode?><br>
<input type="hidden" value="<?php echo $Itemcode ?>" name="Itemcode">
<input type="hidden" value="<?php echo $barcode ?>" name="Barcode">

</p>                            

<?php
    foreach($itemEdit->result() as $row)
    {
        $_SESSION['Qty'] = $row->Qty;
?> 

<input type="hidden" value="<?php echo $row->Qty?>" name="qty">
<input type="hidden" value="<?php echo $row->Barcode?>" name="Barcode">
<input type="hidden" value="<?php echo $row->TRANS_GUID?>" name="TRANS_GUID">
                                    
<?php
  }      
?>
                                
<h5 ><b>Qty</b></h5>

<input type="number" 
  <?php
  foreach($itemEdit->result() as $row)
  {
    ?> value="<?php echo $row->Qty?>"
    <?php 
  }
  ?>  
 style="text-align:center;width:80px;" min="0" max="100000" disabled class="form control" />&nbsp;&nbsp;&nbsp;&nbsp; <b style="font-size:28px">+</b>
                              
<input autofocus required type="number" value="0" onfocus="this.select()" class="form control" name="qty_add" style="text-align:center;width:80px;" max="100000"/>
                                
<h4 style="color: red;"><b><?php echo $this->session->userdata('warning') <> '' ? $this->session->userdata('warning') : ''; ?></b></h4>

<input type="submit" name="submit" class="btn_success" value="SAVE">                      
                                
</form>

<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                          
<table class="cTable">
      <thead>

          <tr>
              <td class="cTD" style="text-align:center;"><b>Item exist in Bin ID</b></td>
              <td class="cTD" style="text-align:center;"><b>Qty</b></td>
          </tr>
      </thead>
      <?php
                               
          if($check_gondolastock->num_rows() != 0)
          {
              foreach ($check_gondolastock->result() as $row)
              {  
      ?>        
      <tbody>
          <tr>
              <td class="cTD" style="text-align:center;"><?php echo $row->bin_id; ?></td>
              <td class="cTD" style="text-align:center;">
                   <?php echo $row->g_qty; ?></a>
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
                  <td class="cTD" colspan="5" style="text-align:center;">No Records Found</td>
                  </tr>
              </tbody>
              <?php
                                            
              }
      ?>
</table>
