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
  h6,td.big {
    font-size: 10px;
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
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Supplier Doc Registration
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
                    <button type="" target="_blank" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" onclick="location.href = '<?php echo site_url('Sub_attendance_controller/generate_report')?>';" >View Report</button>  
                        <form method="post" action="<?php echo site_url('Sub_attendance_controller/display_date')?>" >
                            <div class="row">
                                <input type="submit" value='Search' class='btn btn-xs btn-primary' style="float:right;font-size: 12px;width: 50px;background-color:#4380B8;color:white" />
                                <span class="glyphicon glyphicon-plus-sign" style="color:white"></span>
                            <div class="col-xs-3" style="float:right;" >
                                <input type="text" class="form-control" name='date' id="datepicker" required style="height:24px;" />
                            </div>  
                            </div> 
                        </form>
                        <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('sub_attendance_controller/add_record'); ?>">
                        <div style="overflow-x:auto;">
                        <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD RECORD</b></button>
                        <h4 style = "color:black"><?php echo $this->session->flashdata('message')?></h4>
                        <!-- <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4> --> 
                        <!-- alternative way -->
                        </div>
                        </form>
                </div>
            </div>         
            <div class="row">
                <div class="col-md-8">
                    <h6 style="float:right"><b>Total Records:</b><?php echo $supp_array->num_rows();?></h6>
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                
                                <thead>
                                    <tr>                               
                                        <th>Created Date</th>
                                        <th>Created Time</th>
                                        <th>Suppliers</th>
                                        <th>Reference No.</th>
                                        <!-- <th>Amount</th> -->
                                        <th>Total Incl GST (RM)</th>
                                        <th>GST (RM)</th>
                                        <th>Remark</th>
                                        <th>Updated Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php  
                                foreach ($supp_array->result() as $row)
                                { ?>        
                        
                                <tr>
                                    <td class="big"><?php echo $row->date; ?></td>
                                    <td class="big"><?php echo $row->time; ?></td>
                                    <td><a href = '<?php echo site_url('sub_attendance_controller/update'); ?>?trans=<?php echo $row->web_guid?>'><?php echo $row->Suppliers; ?></a></td>
                                    <td class="big"><?php echo $row->RefNo; ?></td>
                                    <!-- <td class="big"><?php echo $row->Amount; ?></td> -->
                                    <td style="text-align: right"><?php echo number_format($row->Amount,2)?></td>
                                    <!-- <td class="big"><?php echo $row->GST; ?></td> -->
                                    <td style="text-align: right"><?php echo number_format($row->GST,2)?></td>
                                    <td class="big"><?php echo $row->Remark; ?></td>
                                    <td class="big"><?php echo $row->Updated_at ?></td>
                                </tr>
                                
                                <?php } ?>

                                </tbody>
                            </table>
                </div>
            </div>
        </div>
    </div>
