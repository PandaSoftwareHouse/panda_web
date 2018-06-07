<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>DC MOBILE PICK</b></h5>
        <small><b><?php echo $dc_refno?></b></small></font> 
    </td>
    <td width="20"><a href="<?php echo site_url('dcpick_controller/scan_item_error')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/item_entry_add')?>">
  <table class="cTable">
    <thead>
        <tr>
            <td class="cTD" style="text-align:center;"><b>Description</b></td>
            <td class="cTD" style="text-align:center;"><b>Barcode</b></td>
            <td class="cTD" style="text-align:center;"><b>P/S</b></td>
            <td class="cTD" style="text-align:center;"><b>UOM</b></td>
            <td class="cTD" style="text-align:center;"><b>Size Req Info</b></td>
            <td class="cTD" style="text-align:center;"><b>Qty Input Info</b></td>
            <td class="cTD" style="text-align:center;"><b>Qty Input</b></td>
            <td class="cTD" style="text-align:center;"><b>Single Pack QOH</b></td>
         </tr>
    </thead>
  <?php
                               
      if($check_related_item->num_rows() != 0)
      {
          foreach ($check_related_item->result() as $row)
          {  
  ?>        
  <tbody>
      <tr>
        <?php if($row->itemcode == $_SESSION['dc_itemcode'])
          { 
        ?>
          <td class="cTD"  style="text-align:left;"><b style="color:red ;font-weight:bold; font-size: 25px">*</b> &nbsp <?php echo $row->description; ?></td>
        <?php 
          } 
            else 
          { 
        ?>
          <td class="cTD" style="text-align:left;"><?php echo $row->description; ?></td>
        <?php 
          } 
        ?>
          <td class="cTD" style="text-align:left;">
            <?php foreach($check_bar->result() as $cb) 
              { 
                if($row->itemcode == $cb->itemcode) 
                    { 
                      echo '('; echo $cb->barcode ; echo ')'; echo '<br>'; 
                    } 
              } 
              ?>
          </td>
          <td class="cTD" style="text-align:left;"><?php echo $row->packsize; ?></td>
          <td class="cTD" style="text-align:left;"><?php echo $row->um; ?></td>
          <td class="cTD" style="text-align:center;"><?php echo $row->sizeinfo; ?></td>
          <td class="cTD" style="text-align:center;"><?php echo $row->check_qty; ?></td>
          <?php if($_SESSION['soldbyweight'] == 0)
            { ?>
          <td class="cTD" style="text-align:left;"><input type="number" class="form-control" step="1" autofocus onfocus="this.select()" value="0" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /></td>
          <?php }
          else
            { ?>
          <td class="cTD" style="text-align:left;"><input type="number" class="form-control" step="any" value="0" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /></td>
          <?php } ?>
          <td class="cTD" style="text-align:center;">
            <?php foreach($QOH->result() as $qoh) { 
              echo $qoh->SinglePackQOH;
              }?>
          </td>


                                <input id="itemcode" value="<?php echo $row->itemcode?>" name="itemcode[]" type="hidden">
                                <input value="<?php echo $row->description?>" name="description[]" type="hidden">
                                <input value="<?php echo $row->packsize?>" name="packsize[]" type="hidden">
                                <input value="<?php echo $row->um?>" name="um[]" type="hidden">
                                <input value="<?php echo $row->sizeinfo?>" name="sizeinfo[]" type="hidden">
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
<h4><b style="color:red ;font-weight:bold; font-size: 25px">*</b> Indicates item is in document : <?php echo $_SESSION['dc_refno'] ?> </h4>
<input type="submit" name="submit" value="SAVE" class="btn_success">
</form>
<p> &nbsp;</p>
	</div>	
</body>
</html>
