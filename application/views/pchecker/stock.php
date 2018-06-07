<?php 
'session_start()' 
?>
<style>

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

                        <a href="<?php echo site_url('Pchecker_controller/scan_result')?>?barcode=<?php echo $_SESSION['barcode']?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        

                        <font>price checker<br><small><b>stock</b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
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
                                    <tr>
                                      <th style="text-align:center;">Location</th>
                                      <th style="text-align:center;">QOH</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td style="text-align:center;"><?php echo $row->Location; ?></td>
                                              <td style="text-align:center;"><?php echo $row->OnHandQty; ?></td>
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
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>d