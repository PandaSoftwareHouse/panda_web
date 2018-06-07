<?php 
'session_start()' 
?>
<style>

@media screen and (max-width: 768px) {
  p,input,div,span,h4 {
    font-size: 7px;
  }
  h1,h3{
    font-size: 20px;  
  }
  h4 {
    font-size: 18px;  
  } 
  h6,td.big {
    font-size: 10px;
  }
  td{
    font-size: 12px
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

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

function check()
{
    var answer=confirm("Confirm want to delete item ?");
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
                        
                        <a href="<?php echo site_url('rbatch_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Batch Transfer (In) <br><small><?php echo $_SESSION['refno'] ?></small> 
                        &nbsp&nbsp<a href="<?php echo site_url('rbatch_controller/scan_batch'); ?>" ><button name="post" type="submit" class="btn btn-default btn-xs" 
                            style="font-size:12px;" title="post" value="Login">
                           <b>POST</b></button></a>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>  </font>

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12"> 
                          <a href="<?php echo site_url('rbatch_controller/scan_item') ?>" ><button name="scan" type="submit" class="btn btn-default btn-xs" 
                            style="font-size:12px;background-color:#228b22" title="scan" value="Login">
                            <i class="fa fa-check" style="font-size:25px;color:white"></i>
                            </button></a>&nbsp&nbsp&nbsp
                            <input value="<?php echo $_SESSION['refno']?>" name="refno" type="hidden">
                            
                        <br><br>
                        <h5><!-- Location: <b><?php echo $_SESSION['location'] ?></b>&nbsp&nbsp --> T:<?php echo $count ?></h5>
                        
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                    <?php // echo var_dump($_SESSION) ?>
                                      <th>Batch Barcode</th>
                                      <th style="text-align:center;">Weight Variance</th>
                                      <th style="text-align:center;">Verified Variance</th>
                                      <th style="text-align:center;">Created by</th>
                                      <th style="text-align:center;">Created at</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td><?php echo $row->batch_barcode; ?></td>
                                              <td style="text-align:center;"><?php echo $row->pick_weight_variance ?></td>
                                              <td  style="text-align:center; color:red"><?php echo $row->varified_weight_variance ?></td>
                                              <td><?php echo $row->created_by; ?></td>
                                              <td><?php echo $row->created_at; ?></td>


                                            </tr>
                                            <?php
                                        }
                                    ?> 
                                  </tbody>
                                </table>
                            </div>
                            
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