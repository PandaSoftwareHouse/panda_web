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
                        
                        <a href="<?php echo site_url('greturn_controller/dn_scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>goods return<br>
                         <small>debit note list <b><?php echo $edit_mode?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greturn_controller/dn_item_fast_add')?>">
                        <div class="form-group">
                                <h4><b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?></b></h4>
                                <div style="float:left">
                                    <h5 >Qty</h5>
                                    <input type="number" step="any" value="<?php echo $qty;?>" style="text-align:center;width:80px;background-color:#ffff99" name="qty" max="9999" onfocus="this.select()" autofocus="" />
                                    <br>
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    
                                    <h5><b><?php echo $dept?></b></h5>
                                </div>
                                <br><br><br>

                                <h5><b>Supplier</b></h5>
                                <select name="supplier" class="form-control" style="width: 220px;background-color:#D8FFB0"  >
                                <?php
                                foreach($sup_name->result() as $row)
                                {
                                    ?>
                                <option><?php echo $row->supplier;?></option>
                                    <?php
                                }
                                ?>
                                </select>

                                <h5><b>Reason</b></h5>
                                <select name="reason" class="form-control" style="width: 220px;background-color:#ccf5ff" >
                                  <option value="" disabled selected>Select Reason</option>
                                <?php
                                foreach($reason->result() as $row)
                                {
                                    ?>
                                <option><?php echo $row->code_desc;?></option>
                                    <?php
                                }
                                ?>
                                </select>
                                <br>
                                <input type="hidden" name="barcode" value="<?php echo $barcode?>">
                                <br>
                                <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>
                                 <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
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