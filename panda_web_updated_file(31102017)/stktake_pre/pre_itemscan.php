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
  h6{
    font-size: 10px;
  }
  font{
    font-size: 16px;
  }
  td.big{
    font-size: 12px;
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

                        <?php
                        if(isset($back))
                        {
                          ?>
                          <a href="<?php echo site_url('stktake_pre_controller/scan_binID')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                          <?php
                        }
                        else
                        {
                          ?>
                          <a href="<?php echo site_url('stktake_pre_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>" style="float:right">
                          <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                          <?php
                        }
                        ?>
                        
                         

                         <font>Stock take - prelisting</font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_pre_controller/pre_itemEdit'); ?>">
                        <div class="form-group">
                          <?php 
                            foreach($result->result() as $row)
                            {
                              ?>
                            <h5><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?> (<?php echo $row->Location?>)</h5>
                            
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode" 
                            id="textarea" required autofocus />
                            
                            </span>
                            <input value="<?php echo $row->Location?>" type="hidden" name="locBin">
                            <input value="<?php echo $_SESSION['bin_ID']?>" type="hidden" name="binID">
                            <?php
                            }
                            ?>
                            <h5><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h5>
                        </div>
                        

                    </form><br>
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                              <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;"><b>Qty</b></td>
                                        <td><b>Barcode</b></td>
                                        <td><b>Description</b></td>
                                    </tr>
                                </thead>
                                <?php
                                    
                                    if($last_scan->num_rows() != 0)
                                    {
                                        foreach ($last_scan->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        <td class="big" style="text-align:center;"><?php echo $row->Qty; ?></td>
                                        <td class="big"><?php echo $row->Barcode; ?></td>
                                        <td class="big"><?php echo $row->Description; ?></td>
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
                                            <td colspan="5" style="text-align:center;">No Record Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>
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