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
    font-size: 10px;
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

                        <font>grn by po
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
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
                            <form class="form-inline" role="form" method="POST" id="myForm" 
                            action="<?php echo site_url('greceive_controller/scan_po'); ?>">
                            
                            <button name="add2" type="submit" class="btn btn-default btn-xs" style="font-size:12px;background-color:#4380B8" title="" value="Login">
                            <i class="fa fa-plus-circle" style="font-size:25px;color:white"></i>
                            </button>

                            </form><br>
                            <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                    <?php echo var_dump($_SESSION) ?>
                                        <th>Pallet</th>
                                        <th>Goods.kg / Pallet.kg</th>
                                        <th>Q.Var / W.Var</th>
                                        <th style="text-align:center;">ACTION</th>
                                    </tr>
                                </thead>
                                <?php
                                    
                                    if($po_list->num_rows() != 0)
                                    {
                                        foreach ($po_list->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        <td class="big"><?php echo $row->po_no; ?></td>
                                        <td><?php echo $row->created_by; ?></td>
                                        <td class="big"><?php echo $row->s_name; ?></td>
                                    <form class="form-inline" role="form" method="POST" id="myForm" 
                                    action="<?php echo site_url('greceive_controller/action')?>">
                                        <td style="text-align:center;">
                                        <button value="edit" name="edit" type="submit" class="btn btn-default btn-sm" 
                                        style="margin-left: 0px;background-color:#00b359;width:70px;margin-right:8px"><b>EDIT</b></button>
                                        <input type="hidden" name="po_no" value="<?php echo $row->po_no; ?>"/>
                                        <button value="add" name="add" type="submit" class="btn btn-default btn-sm" 
                                        style="margin-left: 0px;background-color:#66ccff;width:70px;margin-right:8px"><b>ADD</b></button>
                                        </td>
                                    </form>
                                    </tr>
                                </tbody>
                                <?php
                                        }
                                    }   
                                        else
                                        {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="5" style="text-align:center;">No Record Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>
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