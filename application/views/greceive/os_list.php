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
  p,input,div,h4 {
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

                        <a href="<?php echo site_url('greceive_controller/po_list')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>GRN BY PO
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
                            
                        <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('greceive_controller/outstanding_po'); ?>">
                              
                               <h6>Expected Delivery Date : <input class="form-control" type="date" name= "selected_date" value="<?php echo $selected_date ?>"> </h6>
                              <button type="submit" class="form-control" > Submit</button> 
                        </br>
                        </form>

                            <div style="overflow-x:auto;">
                                <h6 style="float:left"><a href="<?php echo site_url('greceive_controller/outstanding_po')?>?localdate=1">Show All</a></h6>
                                <h6 style="float:right"><b>Total Records:</b><?php echo $ospo->num_rows();?></h6>
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                
                                <thead>
                                    <tr>
                                        <th>Refno</th>
                                        <th>PO Date</th>
                                        <th style="text-align:center;">Supplier</th>
                                   <!--      <th>Created by</th>
                                        <th style="text-align:center;">Date</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        foreach ($ospo->result() as $row)
                                        {  
                                ?>        
                                
                                    <tr>
                                        <td class="big">
                                            <a href="<?php echo site_url('greceive_controller/outstanding_po_child_detail')?>?refno=<?php echo $row->refno?>&localdate=<?php echo $_SESSION['localdate'] ?>"><?php echo $row->refno; ?></a>
                                        </td>
                                        <td class="big"><?php echo $row->podate; ?></a></td>
                                        
                                        <td class="big"><?php echo $row->sname; ?></td>
                                    </tr>
                                
                                <?php
                                        }
                                ?>
                            </tbody>
                            </table>
                            </div>
                        </div>
                        <?php // echo var_dump($_SESSION) ?>
                    </div>
                        <!-- /. ROW  -->
                </div>

            </div>
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>