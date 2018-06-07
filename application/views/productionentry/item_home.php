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
                        
                        <a href="<?php echo site_url('production_entry_controller/index')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px;"></i></a>

                        <font>Production Entry
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
             <div class="row">
                        <div class="col-md-12">

                        <a href="<?php echo site_url('production_entry_controller/add_item'); ?>">
                        <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> Add Refno</b></button></a>

                            <br><br>
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                             
                            <div style="overflow-x:auto;">
                            <!-- <h6 style="float:right"><b>Total Records:</b><?php echo $po_list->num_rows();?></h6> -->
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                        <th>Refno</th>
                                        <th>Created By</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <?php
                                    foreach ($production_batch->result() as $row)
                                    {  
                                    ?>

                                        <tr>
                                            <td class="big"><?php echo $row->refno; ?>
                                              <a href="<?php echo site_url('production_entry_controller/edit_main')?>?guid=<?php echo $row->trans_guid;?>&refno=<?php echo $row->refno;?>"><button value="edit" name="edit" type="submit" class="btn btn-info btn-xs" 
                                                style=""><b>EDIT</b></button></a>
                                            </td>
                                            <td class="big"><?php echo $row->created_by; ?><br>
                                            <?php echo $row->created_at?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                              
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