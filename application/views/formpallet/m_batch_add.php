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
                        
                        <a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>form pallet
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
                            action="<?php echo site_url('formpallet_controller/m_batch_add_save'); ?>">

                            <h4><b>Add <small>Batch/Pallet/Trolley</small></h4></b></h4>

                            <input name="MaxBatch_Id" disabled value="<?php echo $MaxBatch_Id?>" style="background-color:#ffff99;text-align: center;width:40px;font-size: 14px "/>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

                            <h4><b>Method: </b>
                            <select name="method_name" class="form-control" style="background-color:#80ff80;width: 120px"  >
                                <?php
                                foreach($method_name->result() as $row)
                                {
                                    ?>
                                <option><?php echo $row->method_name;?></option>
                                    <?php
                                }
                                ?>
                                
                            </select></h4>
                            <h4><b>Bin ID: </b>
                            <input type="text" autofocus onfocus="this.select()" class="form-control" name="bin_ID" style="background-color:#ffff99;width: 120px" value="0"></h4>

                            <button name="add2" type="submit" class="btn btn-success btn-xs"  title="" value="Login">
                            <b>SAVE</b>
                            </button>

                            </form><br>
                            <div style="overflow-x:auto;">
                            
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