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
  input {
    font-size: 16px;
  }
  p {
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
                        
                        <a href="<?php echo site_url('stktake_online_controller/scan_item')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>stock cycle count
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1><!-- <?php echo var_dump($_SESSION)?> -->
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                <h4><b><?php echo convert_to_chinese($description, "UTF-8", "GB-18030");?></b>
                <small>P/size : <?php echo $packsize?></small></h4>
                <h5><b>QOH : </b><?php echo $QOH?> &nbsp&nbsp
                <a href="<?php echo site_url('stktake_online_controller/itemlink_create_insert')?>"><button type="submit" class="btn btn-primary btn-xs" style="float:right">CREATE</button></a></h5>
                <br>
                
                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                              <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th style="text-align:center;">P/Size</th>
                                        <th style="text-align:center;">QOH</th> 
                                        <th >Description</th>
                                        <th style="text-align:center;">Itemcode</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                        foreach ($result_itemlink->result() as $row)
                                        {
                                            ?>
                                            <tr>
                                              <td style="text-align:center;"><?php echo $row->packsize; ?></td>
                                              <td style="text-align:center;"><?php echo $row->OnHandQty; ?></td>
                                              <td><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                                              <td style="text-align:center;"><?php echo $row->itemcode; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    ?> 
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>