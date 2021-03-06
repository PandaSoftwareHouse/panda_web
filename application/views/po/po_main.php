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
  td.big {
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

                        <a href="<?php echo site_url('logout_c/clearSession')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>purchase order</font>
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

                            <a href="<?php echo site_url('PO_controller/search_sup'); ?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD SUPPLIER</b></button></a>
                        </br>
                        
                        
                            
                            <div style="overflow-x:auto;">
                              <h6 style="float:right"><b>Total Records:</b><?php echo $po->num_rows();?></h6>
                                <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize;font-size: 10px">
                                    <tr>
                                  
                                      <th>Sup Code</th>
                                        <th>Sup Name</th>
                                        
                                        <th style="text-align:center;">Bill Amt</th>
                                        <th style="text-align:center;">Created by</th>
                                        <th style="text-align:center;">Date</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($po->result() as $row)
                                           //echo var_dump($_SESSION);
                                        {
                                            ?>
                                            <tr>
                                            
                                              <td class="big"><?php echo $row->acc_code; ?></td>
                                              <td class="big"><a href="<?php echo site_url('PO_controller/item_in_po')?>?web_guid=<?php echo $row->web_guid; ?>&acc_code=<?php echo $row->acc_code ;?>"><?php echo $row->acc_name; ?></a></td>
                                              <td class="big" style="text-align:center;"><?php echo $row->bill_amt_format; ?></td>
                                              <td class="big" style="text-align:center;"><?php echo $row->created_by; ?></td>
                                              <td class="big" style="text-align:center;"><?php echo $row->created_at; ?></td>
                                               <td><a href="<?php echo site_url('PO_controller/delete'); ?>?web_guid=<?php echo $row->web_guid ;?>" > 
                                        <button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?')" onSubmit="window.location.reload()"><span class="glyphicon glyphicon-trash"></span></button></a></td> 
                                            </tr>
                                            <?php 
                                        }/* */
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