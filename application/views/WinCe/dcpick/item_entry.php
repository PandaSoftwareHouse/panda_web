<html>

<script type="text/javascript">

$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});

/*function check_quantity()
{
  var db_qty = $('#db_qty').val();

  var qty_pick = $('#qty_input').val();
  var packsize = $('#packsize').val();
  var sum_min = parseFloat(qty_pick) * parseFloat(packsize);

  var total = parseFloat(sum_min) + parseFloat(db_qty);

  var dc_smallqty = $('#dc_smallqty').val();

  if(dc_smallqty != total)
  {
    document.getElementById('reason_box').style.display = 'block';
    document.getElementById('reason_title').style.display = 'block';
  }
  else
  {
    document.getElementById('reason_box').style.display = 'none';
    document.getElementById('reason_title').style.display = 'none';
  }
}*/

</script>

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
  <tbody>
     <?php 
      $db_qty = $this->db->query("SELECT qty_mobile*packsize as qty_mobile FROM dc_req_child where child_guid = '".$_SESSION['dc_child_guid']."' ")->row('qty_mobile');

        foreach($check_related_item->result() as $row)
        {
          ?>
          <tr><td class="cTD" style="text-align:center;"><b>Description: </b></td><td class="cTD"  style="text-align:left;"><?php echo $row->description;?></td></tr>
          <tr><td class="cTD" style="text-align:center;"><b>Barcode : </b></td><td class="cTD"  style="text-align:left;"><?php foreach($check_bar->result() as $cb) 
               { 
                 if($row->itemcode == $cb->itemcode) 
                     { 
                        echo $cb->barcode ; echo '<br>';
                     } 
               } ?></td></tr>
        <tr><td class="cTD" style="text-align:center;"><b>P/Size: </b><?php echo $row->packsize;?> </td><td class="cTD"  style="text-align:left;"><b>UM: </b><?php echo $row->um?></td></tr>
        <tr><td class="cTD" style="text-align:center;"><b>SinglePack QOH: </b></td><td class="cTD"  style="text-align:left;"><?php foreach($QOH->result() as $qoh) { 
           echo '&nbsp'; echo $qoh->SinglePackQOH; }?> </td></tr>
        <tr><td class="cTD" style="text-align:center;"><b>Size Req Info:</b></td><td class="cTD"  style="text-align:left;"> <?php echo $row->sizeinfo?></td> </tr>
        <tr><td class="cTD" style="text-align:center;"><b>Mobile Qty Info: </b></td><td class="cTD"  style="text-align:left;"><?php echo $row->check_qty?> </td></tr>
        <input id="itemcode" value="<?php echo $row->itemcode?>" name="itemcode[]" type="hidden">
        <input value="<?php echo $row->description?>" name="description[]" type="hidden">
        <input value="<?php echo $row->packsize?>" id="packsize" name="packsize[]" type="hidden">
        <input value="<?php echo $row->um?>" name="um[]" type="hidden">
        <input value="<?php echo $row->sizeinfo?>" name="sizeinfo[]" type="hidden">
        <input value="<?php echo $_SESSION['dc_smallqty']; ?>" name="dc_smallqty" id="dc_smallqty" type="hidden">
        <input value="<?php echo $db_qty; ?>" name="db_qty" id="db_qty" type="hidden">

        <?php 
           }
           if( $_SESSION['soldbyweight'] == 0)
             { 
         ?>
        <tr><td  class="cTD" style="text-align:center;"><b> Qty: </b></td><td><input class="form-control" type="number" step="1" autofocus onfocus="this.select()" value="<?php echo $_SESSION['decode_qty']?>" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" id="qty_input" onchange="check_quantity()"/> </td></tr>
         <?php } 
             else { ?>
        <tr><td  class="cTD" style="text-align:center;"><b> Qty: </b></td><td><input class="form-control"  type="number" step="any" autofocus onfocus="this.select()" value="<?php echo $_SESSION['decode_qty']?>" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" id="qty_input" onchange="check_quantity()"/></td></tr>
          <?php } ?>

        <tr><td><b id="reason_title" style="display: block;"> Reason: </b></td>
          <td id="reason_box" style="display: block;">
            <select class="form-control" style="width:200px;" name="reason_input" id="reason_input">
              <option hidden selected value> -- Select reason -- </option>
              
              <?php foreach($set_master_code->result() as $row)
              { ?>

                <option value="<?php echo $row->CODE_DESC; ?>"><?php echo $row->CODE_DESC; ?></option>

              <?php } ?>

            </select>
          </td>
        </tr>
  </tbody>

</table>

<input type="submit" name="submit" value="SAVE" class="btn_success">
</form>
<p> &nbsp;</p>
  </div>  
</body>

</html>
