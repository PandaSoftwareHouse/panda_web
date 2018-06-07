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
  p {
    font-size: 12px;
  }
  font{
    font-size: 16px;
  }
}

</style>

<script type="text/javascript">


</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="font-size:32px;color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="font-size:32px;color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('greceive_controller/po_list')?>" >
                        <i class="fa fa-arrow-left" style="font-size:32px;color:#4380B8;margin-right:20px;float:right"></i></a>

                        <font>grn by po
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">

                    <!-- <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/scan_po_result'); ?>"> -->

                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/batch'); ?>">
                    
                        <div class="form-group">
                            <?php
                            $po_no = $this->session->userdata('po_no');
                            ?>
                            <?php
                                    
                                foreach($po_details->result() as $row)
                                {
                                    ?>  
                                        <h5><b>PO No: </b><?php echo $po_no?></h5>
                                        <h5><b>Supplier Name: </b><?php echo $row->s_name?></h5>
                                        <br>
                                        <div style="float:left">
                                            <p><b>DO No:</b></p>
                                            <input type="text" name="row_no" style="width:170px;background-color:#ffff99" 
                                            value="<?php echo $row->do_no?>"/>
                                            <p><b>Invoice No:</b></p>
                                            <input type="text" name="row_w" style="width:170px;background-color:#ffff99" 
                                            value="<?php echo $row->inv_no?>"/>
                                            <br><br>
                                            <button value="go" name="go" type="submit" class="btn btn-default btn-xs" 
                                            style="margin-left: 0px;background-color:#00b359;width:50px;margin-right:8px" 
                                            onclick="return check()">
                                            <b>SAVE</b></a></button>
                                        </div>
                                    <?php
                                }   
                                    
                            ?>
                        </div>
                    </form><br>
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