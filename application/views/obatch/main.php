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
                        
                        <font>Batch Transfer Out
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                          <br> <a href="<?php echo site_url('obatch_controller/post_scan'); ?>" ><button name="post" type="submit" class="btn btn-default btn-xs" 
                            style="font-size:12px;" title="post" value="Login">
                           <b>POST</b>
                            </button></a>
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

                            <a href="<?php echo site_url('obatch_controller/add_remark'); ?>" >
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD TRANS</b></button></a>

                             <br><br>
 
                            <div style="overflow-x:auto;">
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>Refno</th>
                                      <th style="text-align:center;">Location To</th>
                                      <th style="text-align:center;">Remark</th>
                                      <th style="text-align:center;">Created By</th>
                                      <th style="text-align:center;">Created At</th>
                                      <th style="text-align:center;">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td><a href="<?php echo site_url('obatch_controller/itemlist')?>?trans_guid=<?php echo $row->trans_guid;?>"><?php echo $row->refno; ?><a style="float: right" href="<?php echo site_url('obatch_controller/delete_batch'); ?>?trans_guid=<?php echo $row->trans_guid;?>" > <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a></a>
                                              </td>
                                              <td style="text-align:center;"><?php echo $row->location_to ?>
                                              </td>
                                              <td style="text-align:center;"><?php  echo $row->remark?></td>
                                              <td style="text-align:center;"><?php  echo $row->created_by?></td>
                                              <td style="text-align:center;"><?php  echo $row->created_at?></td>
                                              <td style="text-align: center"><a  href="<?php echo site_url('obatch_controller/add_remark'); ?>?trans_guid=<?php echo $row->trans_guid;?>" > <button  class="btn btn-info btn-xs" style=""><b>EDIT</b></button></a></td>

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