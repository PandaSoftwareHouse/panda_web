<?php 
'session_start()' 
?>
<style>

#poDetails, #promoDetails {
  display: none;
}


b .font {
    font-size: 90px;
}

@media screen and (max-width: 768px) {
  
  p,input,div,span,h4 {
    font-size: 90%;
  }
  h1 {
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  }
  h3 {
    font-size: 20px;  
  }
  input {
    font-size: 16px;
  }
   font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  p {
    font-size: 12px;
  }
  td {
    font-size: 16px;
  }
}

</style>

<script type="text/javascript">

$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});

</script>
<!--onload Init-->
<body onload="check_quantity()">
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('dcpick_controller/scan_item_error')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>dc mobile pick<br>
                         <small><b><?php echo $dc_refno?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-lg-12">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/item_entry_add')?>" onsubmit="trigger_input()">
                        <div class="form-group">
                        <table>
                          <?php 

                          $db_qty = $this->db->query("SELECT qty_mobile*packsize as qty_mobile FROM dc_req_child where child_guid = '".$_SESSION['dc_child_guid']."' ")->row('qty_mobile');

                          foreach($check_related_item->result() as $row)
                          {
                            ?>
                            <tr><td><b>Description: </b></td><td><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></td></tr>
                            <tr><td><b>Barcode : </b></td><td><?php foreach($check_bar->result() as $cb) 
                                            { 
                                              if($row->itemcode == $cb->itemcode) 
                                                  { 
                                                     echo $cb->barcode ; echo '<br>';
                                                  } 
                                            } ?></td></tr>
                            <tr><td><b>P/Size: </b><?php echo $row->packsize;?> </td><td>
                            <b>UM: </b><?php echo $row->um?></td></tr>
                            <tr><td><b>SinglePack QOH: </b></td><td><?php foreach($QOH->result() as $qoh) { 
                                            echo '&nbsp'; echo $qoh->SinglePackQOH; }?> </td></tr>
                            <tr><td><b>Size Req Info:</b></td><td> <?php echo $row->sizeinfo?></td> </tr>
                            <tr><td><b>Mobile Qty Info: </b></td><td><?php echo $row->check_qty?> </td></tr>
                            <input id="itemcode" value="<?php echo $row->itemcode?>" name="itemcode[]" type="hidden">
                            <input value="<?php echo htmlentities(convert_to_chinese($row->description, "UTF-8", "GB-18030"));?>" name="description[]" type="hidden">
                            <input value="<?php echo $row->packsize?>" name="packsize[]" type="hidden" id="packsize">
                            <input value="<?php echo $row->um?>" name="um[]" type="hidden">
                            <input value="<?php echo $row->sizeinfo?>" name="sizeinfo[]" type="hidden">
                            <input value="<?php echo $_SESSION['dc_smallqty']; ?>" name="dc_smallqty" id="dc_smallqty" type="hidden">
                            <input value="<?php echo $db_qty; ?>" name="db_qty" id="db_qty" type="hidden">
                            <?php 
                          }

                              if( $_SESSION['soldbyweight'] == 0)
                                { 
                            ?>
                            <tr><td><b> Qty: </b></td><td><input class="form-control to_qty" type="number" step="any" autofocus onfocus="this.select()" value="<?php echo $_SESSION['decode_qty']?>" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" id="input" onkeyup="check_quantity()"/> </td></tr>
                            <?php } 
                                else { ?>
                            <tr><td><b> Qty: </b></td><td><input class="form-control to_qty"  type="number" step="any" autofocus onfocus="this.select()" value="<?php echo $_SESSION['decode_qty']?>" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" id="input" onkeyup="check_quantity()"/></td></tr>
                            <?php } ?>

                            <tr><td>&ensp;</td></tr>
                            <tr><td><b id="reason_title" style="display: none;"> Reason: </b></td>
                              <td id="reason_box" style="display: none;">
                                <select class="form-control" style="width:300px;" name="reason_input" id="reason_input">
                                  <option hidden selected value> -- Select reason -- </option>

                                  <?php foreach($set_master_code->result() as $row)
                                  { ?>

                                    <option value="<?php echo $row->CODE_DESC; ?>"><?php echo $row->CODE_DESC; ?></option>

                                  <?php } ?>

                                </select>
                              </td>
                            </tr>
      
                            <input type="hidden" name="qty_input_actual" id="input_actual">
                            
                        </div>
                             <tr><td><button value="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button></td></tr>

                    </form>
                    </table>
                </div>
            </div>
                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>

    <script type="text/javascript">
      
      function trigger_input()
      {

      var actual = document.getElementById('input').value;
      document.getElementById('input_actual').value = actual;
      }
    </script>

    <script type="text/javascript">
      function check_quantity()
      {
        var db_qty = $('#db_qty').val();//21

        var qty_pick = $('#input').val();
        var packsize = $('#packsize').val();
        var sum_min = parseFloat(qty_pick) * parseFloat(packsize); //10

        var total = parseFloat(sum_min) + parseFloat(db_qty);

        var dc_smallqty = $('#dc_smallqty').val();

        if(dc_smallqty != total)
        {
          document.getElementById('reason_box').style.display = 'block';
          document.getElementById('reason_title').style.display = 'block';
          document.getElementById('reason_input').required = true;
        }
        else
        {
          document.getElementById('reason_box').style.display = 'none';
          document.getElementById('reason_title').style.display = 'none';
          document.getElementById('reason_input').required = false;
        }
      }

    </script>

