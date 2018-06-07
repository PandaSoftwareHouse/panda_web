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
    var answer=confirm("Confirm want to save?");
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
                        
                        <a href="<?php echo site_url('planogram_controller/binID_list')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" style="float:right" >
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
                    action="<?php echo site_url('planogram_controller/row_add_save'); ?>">
                            <h5><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?></h5>
                           
                                <div style="float:left">
                                    <h5 >Row No</h5>
                                    <input type="number" step="any" value="<?php echo $row_no?>" style="text-align:center;width:80px;background-color:#ffff99" name="row_no" onfocus="this.select()" autofocus/>

                                    <h5 >Depth</h5>
                                    <input type="number" step="any" value="" style="text-align:center;width:80px;background-color:#ffff99" name="row_d" />
                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <h5>Width</h5>
                                    <input type="number" step="any" value="" style="text-align:center;width:80px;background-color:#ffff99" name="row_w" />

                                    <h5>Height</h5>
                                    <input type="number" step="any" value="" style="text-align:center;width:80px;background-color:#ffff99" name="row_h" />
                                </div>
                                <br><br><br><br><br><br>
                                <input type="hidden" name="row_guid" value="<?php echo $row_guid?>">
                                <button value="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
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