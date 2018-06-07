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
    font-size: 12px;
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
                <div class="col-md-12">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('dcpick_controller/item_entry_add')?>">
                        <div class="form-group">
                        <div style="overflow-x:auto;" >
                          <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>

                                    <tr>
                                        <td style="text-align:center;"><b>Description</b></td>
                                        <td style="text-align:center;"><b>Barcode</b></td>
                                        <td style="text-align:center;"><b>P/S</b></td>
                                        <td style="text-align:center;"><b>UOM</b></td>
                                        <td style="text-align:center;"><b>Size Req Info</b></td>
                                        <td style="text-align:center;"><b>Mobile Qty Info</b></td>
                                        <td style="text-align:center;"><b>Qty Input</b></td>
                                        <td style="text-align:center;"><b>Single Pack QOH</b></td>
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
                                      { ?>
                                        <td style="text-align:left;"><b style="color:red ;font-weight:bold; font-size: 25px">*</b> &nbsp <?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                                      <?php } 
                                      else { ?>
                                        <td style="text-align:left;"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                                      <?php } ?>
                                        <td style="text-align:left;">
                                          <?php foreach($check_bar->result() as $cb) 
                                            { 
                                              if($row->itemcode == $cb->itemcode) 
                                                  { 
                                                    echo '('; echo $cb->barcode ; echo ')'; echo '<br>'; 
                                                  } 
                                            } ?>
                                            </td>
                                        <td style="text-align:left;"><?php echo $row->packsize; ?></td>
                                        <td style="text-align:left;"><?php echo $row->um; ?></td>
                                        <td style="text-align:center;"><?php echo $row->sizeinfo; ?></td>
                                        <td style="text-align:center;"><?php echo $row->check_qty; ?></td>
                                          <?php if( $_SESSION['soldbyweight'] == 0)
                                        { ?>
                                        <td style="text-align:left;"><input type="number" step="1" autofocus onfocus="this.select()" value="0" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /></td>
                                        <?php } 
                                        else { ?>
                                        <td style="text-align:left;"><input type="number" step="any" autofocus onfocus="this.select()" value="0" style="text-align:center;width:80px;background-color:#ffff99" name="qty_input[]" /></td>
                                        <?php } ?>
                                        <td style="text-align:center;">
                                          <?php foreach($QOH->result() as $qoh) { 
                                            echo $qoh->SinglePackQOH;
                                            }?>
                                        </td>


                                 <input id="itemcode" value="<?php echo $row->itemcode?>" name="itemcode[]" type="hidden">
                                <input value="<?php echo htmlentities(convert_to_chinese($row->description, "UTF-8", "GB-18030"));?>" name="description[]" type="hidden">
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
                                            <td colspan="5" style="text-align:center;">No Records Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>
                            </table>
                            </div>
                            <h4><b style="color:red ;font-weight:bold; font-size: 25px">*</b> Indicates item is in document : <?php echo $_SESSION['dc_refno'] ?> </h4>

                             <button value="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>

                        </div>
                        <br><br><br><br>
                                  
                    </form>

                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                                         
                              
                                
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>


        <!--  <?php foreach ($check_related_item->result() as $row)
                        {
                          ?>
                            <h4><b><?php echo $row->description?></b>&nbsp&nbsp
                                 <br><b><?php echo $row->iteminfo?></h4>
                                <div style="float:left">
                                    <h5 >Req Qty</h5>
                                    <input disabled type="number" step="any"
                                     value="<?php echo $dc_qty?>" style="text-align:center;width:80px" name=""/>
                                    <br>
                                </div>
                          
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <h5><b>Actual Qty</b></h5>
                                    <input type="number" step="any"
                                     value="<?php echo $dc_qty_mobile ?>" style="text-align:center;width:80px;background-color:#ffff99" name="qty_mobile" onfocus="this.select()" autofocus onblur="this.focus()"
                                     />
                                </div>
                           
                                <br><br><br>
                                <?php
                          }
                            ?>      -->