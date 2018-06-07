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
                        
                        <a href="<?php echo site_url('planogram_controller/scan_binID')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>Planogram
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

                            <a href="<?php echo site_url('planogram_controller/row_add')?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD ROW</b></button></a>

                           
                            <h5><b>Bin ID:</b> <?php echo $_SESSION['bin_ID']?></h5>
                        
                        <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;"><b>Row No</b></td>
                                        <td style="text-align:center;"><b>Row Width</b></td>
                                        <td style="text-align:center;"><b>Row Depth</b></td>
                                        <td style="text-align:center;"><b>Row Height</b></td>
                                        <td style="text-align:center;"><b>Row Volume</b></td>
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
                                    
                                        <td class="big" style="text-align:center;"><!-- <b style="font-size: 32px"> --><a style="font-size: 24px" href="<?php echo site_url('planogram_controller/row_item_scan')?>?row_guid=<?php echo $row->row_guid?>"><?php echo $row->row_no; ?></a></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->row_w; ?></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->row_d; ?></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->row_h; ?></td>
                                        <td class="big" style="text-align:center;"><?php echo $row->row_volume; ?></td>
                                
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