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
    font-size: 14px;
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
                        
                        <a href="<?php echo site_url('stktake_pre_controller/pre_batch_itemlist')?>?bin_ID=<?php echo $_SESSION['bin_ID'] ?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Prelisting by Pallet - View Item
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 

                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>

            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    
                        <div class="form-group">
                        </div>
                </div>
            </div>

                <!-- ROW  -->
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            
                            <div style="overflow-x:auto;">
                                <h5><b>Bin ID :</b> <?php echo $_SESSION['bin_ID']?> &nbsp</h5>
                    

                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;"><b>Qty</b></td>
                                        <td><b>Description</b></td>
                                        <!-- <td style="text-align:center;"><b>Delete</b></td> -->
                                    </tr>
                                </thead>
                                <?php
                                    
                                    if($result->num_rows() != 0)
                                    {
                                        foreach ($result->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        <td class="big" style="text-align:center;"><?php echo $row->qty_rec; ?></td>
                                        <td class="big"><?php echo convert_to_chinese($row->po_description, "UTF-8", "GB-18030"); ?></td>
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