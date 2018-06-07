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
                        
                        <a href="<?php echo site_url('dnbatch_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>DN BATCH &nbsp&nbsp  <a href="<?php echo site_url('Dnbatch_controller/print_job')?>" style="color: grey"><i class="fa fa-print fa-lg" ></i></a>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>

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

                        <a href="<?php echo site_url('Dnbatch_controller/scan_item'); ?>">
                        <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ITEM</b></button></a>

                         &nbsp&nbsp&nbsp
                            <input value="<?php echo $_SESSION['batch_no']?>" name="batch_no" type="hidden">
                            
                        <br><br>
                        <h5><?php echo $_SESSION['batch_no'] ?></h5>
                        <h5><?php echo $_SESSION['sup_name'] ?></h5>
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                    <?php // echo var_dump($_SESSION) ?>
                                      <th>Description</th>
                                      <th style="text-align:center;">Qty</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td>
                                                <?php if($row->scan_type == 'BATCH') { ;?> 
                                                    <a href="<?php echo site_url('Dnbatch_controller/scan_log')?>?batch_no=<?php echo $_SESSION['batch_no'] ?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?> <i class="fa fa-th-list" style="color:#4380B8"></i></a>
                                                
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('Dnbatch_controller/scan_itemresult')?>?dbnote_c_guid=<?php echo $row->dbnote_c_guid; ?>&dbnote_guid=<?php echo $row->dbnote_guid; ?>"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?></a>

                                                      <a style="float:right" href="<?php echo site_url('Dnbatch_controller/delete_item'); ?>?dbnote_c_guid=<?php echo $row->dbnote_c_guid; ?>&dbnote_guid=<?php echo $row->dbnote_guid;?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a>
                                                <?php } ?>
                                              </td>
                                              
                                              <td style="text-align:center;"><?php echo $row->qty ?></td>

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