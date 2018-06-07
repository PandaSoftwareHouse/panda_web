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

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by ibt &nbsp
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small><br></font>


                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">

                        <a href="<?php echo site_url('ibt_rec_controller/scan_ibt'); ?>">
                        <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD TRANS</b></button></a>

                            <br><br>
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="overflow-x:auto;">
                           
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>RefNo</th>
                                        <th>From</th>
                                        <th>Created By</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($query->result() as $row)
                                    {  
                                    ?>
                                        <tr>
                                            <td class="big"><?php echo $row->RefNo; ?></td>
                                            <td class="big"><a href="<?php echo site_url('ibt_rec_controller/barcode_scan')?>?guid=<?php echo $row->TRANS_GUID?>&RefNo=<?php echo $row->RefNo?>"><?php echo $row->sname; ?></a></td>
                                            <td class="big"><?php echo $row->CREATED_BY; ?><br>
                                            <?php echo $row->CREATED_AT?></td>
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