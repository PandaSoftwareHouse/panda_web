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
<body>
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
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/item_entry_add')?>">
                        <div class="form-group">
                        <table>
                          <?php 
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
                            <input value="<?php echo $row->packsize?>" name="packsize[]" type="hidden">
                            <input value="<?php echo $row->um?>" name="um[]" type="hidden">
                            <input value="<?php echo $row->sizeinfo?>" name="sizeinfo[]" type="hidden">
                            <?php 
                          }
                              if( $_SESSION['soldbyweight'] == 0)
                                { 
                            ?>
                            <tr><td><b> Qty: </b></td><td><input class="form-control" type="number" step="1" autofocus onfocus="this.select()" value="0" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /> </td></tr>
                            <?php } 
                                else { ?>
                            <tr><td><b> Qty: </b></td><td><input class="form-control"  type="number" step="any" autofocus onfocus="this.select()" value="0" max="10000" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /></td></tr>
                            <?php } ?>
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

