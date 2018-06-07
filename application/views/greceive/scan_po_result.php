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
  h1.page-head-line{
    font-size: 25px;
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
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('greceive_controller/po_list')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

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
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/scan_po_result'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Scan PO No" name="po_no" id="textarea" required autofocus/>
                            </span>
                            <?php
                            $po_no = $this->session->userdata('po_no');
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
                                         
                              
                                <?php
                                    
                                    foreach($po_details->result() as $row)
                                    {
                                        if($row->Completed =='1')
                                        {
                                        ?>  
                                            <h4><b><?php echo $po_no?>:</b> PO Already Close.</h4>
                                        <?php
                                        }
                                        else if($row->expiry_date < date('Y-m-d'))
                                        {
                                        ?>  
                                            <h4><b><?php echo $po_no?>:</b> PO Already Expired.</h4>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>  
                                            <h4><b>PO No: </b><?php echo $row->RefNo?></h4>
                                            <h4><b>Supplier Name: </b><?php echo $row->SName?></h4>
                                            <br>
                                            <div style="float:left">
                                                <p><b>DO No:</b></p>
                                                <input type="text" name="row_no" style="width:170px;background-color:#ffff99" />
                                                <p><b>Invoice No:</b></p>
                                                <input type="text" name="row_w" style="width:170px;background-color:#ffff99" />
                                                <br><br>
                                                <button value="go" name="go" type="submit" class="btn btn-default btn-sm" 
                                                style="margin-left: 0px;background-color:#00b359;width:70px;margin-right:8px" 
                                                onclick="return check()">
                                                <b>SAVE</b></a></button>
                                            </div>
                                        <?php
                                        }
                                    }   
                                    
                                ?>
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>