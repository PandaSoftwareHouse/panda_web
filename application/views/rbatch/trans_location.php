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
                        
                        <a href="<?php echo site_url('rbatch_controller/main') ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Batch Transfer (In)<br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                       
                        
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('rbatch_controller/rbatch_trans'); ?>">
                        <div class="form-group">

                            <input type="text" class="form-control" placeholder="Scan Transaction Barcode" name="barcode" id="textarea" required autofocus />

                         </span>
                            <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                        
                            
                        </div>
                    </form>
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                  </thead>
                                  <br>
                                  <tbody>
                               <?php foreach($trans_location->result() as $row)
                               { ?>
                               <tr>
                               <td style="color:green"><b><?php echo $row->batch_barcode; ?></b></td>
                               <td ><b><?php echo $row->created_by; ?></b></td>
                               <td ><b><?php echo $row->created_at; ?></b></td>
                               </tr>
                               <tr>
                               <td><b><?php echo $row->pick_weight_variance; ?></td>
                               <td colspan="2" style="color:red;"><b><?php echo $row->varified_weight_variance; ?></b></td>
                               </tr>

                               <?php 
                                }
                                ?>
                                </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>