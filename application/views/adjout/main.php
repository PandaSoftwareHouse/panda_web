<?php 
'session_start()' 
?>
<style>

@media screen and (max-width: 768px) {
  p,input,div,h4 {
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
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                      
                        <font>adjust out <?php if($_SESSION['aotype'] == 'DP') { echo '- Disposal';}; if($_SESSION['aotype'] == 'OU') { echo '- Own Use';}; ?>
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font>
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

                            <a href="<?php echo site_url('adjout_controller/add_remarks')?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD TRANS</b></button></a>

                        </br>
                       <br>
                            
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>Reason</th>
                                      <th style="text-align:center;">Amount</th>
                                      <th style="text-align:center;">Remarks</th>
                                      <th style="text-align:center;">Created by</th>
                                      <th style="text-align:center;">Created at</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                   // echo  var_dump($_SESSION);
                                        foreach ($result->result() as $row)
                                        {
                                            $_SESSION['remarks'] = $row->remarks;
                                            $_SESSION['bill_amt'] = $row->bill_amt;
                                            ?>
                                            <tr>
                                              <td><a href="<?php echo site_url('adjout_controller/itemlist')?>?web_guid=<?php echo $row->web_guid?>&remarks=<?php echo $row->remarks ?>&bill_amt=<?php echo $row->bill_amt?>"><?php echo $row->reason; ?></a></td>
                                              <td style="text-align:center;"><?php echo round($row->bill_amt,2) ?></td>
                                              <td style="text-align:center;"><?php echo $row->remarks; ?></td>
                                              <td style="text-align:center;"><?php echo $row->created_by; ?></td>
                                              <td style="text-align:center;"><?php echo $row->created_at; ?></td>
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