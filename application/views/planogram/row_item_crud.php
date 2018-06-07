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
  td.big {
    font-size: 10px;
  }
  font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  input{
    font-size: 14px
  }
}

</style>

<script type="text/javascript">

$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});

function check()
{
    var answer=confirm("Confirm want to delete?");
    return answer;
}

</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">

                         <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('planogram_controller/row_item_scan')?>?row_guid=<?php echo $_SESSION['row_guid']?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>Planogram
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>
        <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('planogram_controller/rack_row_item_crud_save'); ?>">
                            <h5><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?>&nbsp&nbsp<b><?php echo $_SESSION['row_no']?></b><!-- <?php echo var_dump($_SESSION)?> -->
                            <?php
                            if($deletebutton == '1')
                            {
                                ?>
                                <a style="float:right;" href="<?php echo site_url('planogram_controller/rack_row_item_delete')?>" class="btn btn-xs btn-danger" onclick="return check()"><span class="glyphicon glyphicon-trash"></span> 
                                </a>
                                <?php
                            }
                            ?>
                            
                            </h5>
                            <h5> <?php echo $itemcode?>&nbsp&nbsp<?php echo $barcode?>
                            <br><br><b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?></b></h5>
                           
                                <div style="float:left">

                                    <h5 >Qty</h5>
                                    <input type="number" step="any" value="<?php echo $Qty ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Qty" autofocus onfocus="this.select()"/>

                                    <h5 >Width</h5>
                                    <input type="number" step="any" value="<?php echo $Width ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Width" />

                                    <h5 >Height</h5>
                                    <input type="number" step="any" value="<?php echo $Height ?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Height" />
                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <h5>Max Stackable</h5>
                                    <input type="number" step="any" value="<?php echo $MaxStackable?>" style="text-align:center;width:80px;background-color:#66FFCC" name="MaxStackable" />

                                    <h5>Depth</h5>
                                    <input type="number" step="any" value="<?php echo $Depth?>" style="text-align:center;width:80px;background-color:#66FFCC" name="Depth" />
                                    <br><br>

                                    <input type="hidden" name="row_guid" value="<?php ?>">
                                    <button value="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;float: right"><b>SAVE</b></button>
                                </div>
                                <br>
                                
                    </form>

                                
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                        </br>
                            
                        </div>

                    </div>
                        <!-- /. ROW  -->
                </div>

            </div>
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>