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
                        <font>sales order
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
                            action="<?php echo site_url('SO_controller/search_supcus'); ?>">
                            
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD SUPPLIER</b></button>

                        </br>
                        </form>

                            <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('SO_controller/item_in_so')?>">
                            <div style="overflow-x:auto;">
                            <h6 style="float:right"><b>Total Records:</b><?php echo $so->num_rows();?></h6>
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                
                                <thead>
                                    <tr>
                                        <th>Sup Code</th>
                                        <th>Sup Name</th>
                                        <th style="text-align:center;">Bill Amt</th>
                                        <th>Created by</th>
                                        <th style="text-align:center;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    
                                        foreach ($so->result() as $row)
                                        {  
                                ?>        
                                
                                    <tr>
                                    
                                        <td class="big"><?php echo $row->acc_code; ?></td>
                                        <td class="big"><a href="<?php echo site_url('SO_controller/item_in_so')?>?web_guid=<?php echo $row->web_guid; ?>"><?php echo $row->acc_name; ?></a>
                                        <input type="hidden" name="web_guid" value="<?php echo $row->web_guid; ?>"/>
                                        <!--<button value="view" name="view" type="submit" class="btn btn-default btn-sm" 
                                        style="margin-left: 0px;background-color:#00b359;width:70px;margin-right:8px;float:right">
                                        <b>VIEW</b></button>--></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->bill_amt; ?></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->created_by; ?></td>
                                        <td class="big"><?php echo $row->created_at; ?></td>
                                    
                                    </tr>
                                
                                <?php
                                        }
                                ?>
                                </tbody>
                            </table>
                            </div>
                        </form>
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