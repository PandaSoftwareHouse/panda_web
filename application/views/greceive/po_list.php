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
    var answer=confirm("Confirm want to cancel item ?");
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

                        <font>grn by po &nbsp
                          <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small><br>
                          <?php 
                            // remark: if they already can direct post grn, no need like this post GR with ID already.. wee yit and new user all say confusing 2018-03-21
                            if($grn_by_weight_direct_post_grn == '0')
                            {
                          ?>
                           <a href="<?php echo site_url('greceive_controller/po_post_grn')?>" ><button class="btn btn-default btn-sm" style=""><b>POST by GR ID</b></button></a>
                           <?php 
                              } 
                            ?> 

                          <a href="<?php echo site_url('greceive_controller/search_gr')?>" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-search fa-lg"></i>Search GRN</b></button></a> 

                          <a href="<?php echo site_url('greceive_controller/outstanding_po')?>?localdate=<?php echo date('Y-m-d'); ?>" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-list fa-lg"></i> Outstanding PO</b></button></a>

                          <a href="<?php echo site_url('greceive_controller/posted_doc')?>?localdate=<?php echo date('Y-m-d'); ?>" ><button class="btn btn-default btn-sm" style=""><b><i class="fa fa-clipboard fa-lg"></i> Posted Doc</b></button></a>

                        </font>


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

                        <a href="<?php echo site_url('greceive_controller/scan_po'); ?>">
                        <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                        <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD PO</b></button></a>

                            <br><br>
                            <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="overflow-x:auto;">
                            <!-- <h6 style="float:right"><b>Total Records:</b><?php echo $po_list->num_rows();?></h6> -->
                            <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>PO No</th>
                                        <th>Supplier Name</th>
                                        <th>Created By</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($po_list->result() as $row)
                                    {  
                                    ?>
                                        <tr>
                                            <td class="big"><?php echo $row->po_no; ?>
                                              <a href="<?php echo site_url('greceive_controller/po_edit')?>?po_no=<?php echo $row->po_no;?>&sname=<?php echo $row->s_name;?>&grn_guid=<?php echo $row->grn_guid?>"><button value="edit" name="edit" type="submit" class="btn btn-info btn-xs" 
                                                style=""><b>EDIT</b></button></a>
                                            </td>
                                            <td class="big"><a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $row->grn_guid?>&po_no=<?php echo $row->po_no?>&sname=<?php echo $row->s_name;?>&scode=<?php echo $row->scode;?>&doc_posted=0"><?php echo $row->s_name; ?></a>
                                              
                                              <a href="<?php echo site_url('greceive_controller/cancel_po')?>?grn_guid=<?php echo $row->grn_guid?>" class="btn btn-warning btn-xs" onclick="return check()" style="float: right" >CANCEL</a>
                                            </td>
                                            <td class="big"><?php echo $row->created_by; ?><br>
                                            <?php echo $row->created_at?></td>
                                        
                                            <!-- <td style="text-align:center;">
                                                <a href="<?php echo site_url('greceive_controller/po_edit')?>?po_no=<?php echo $row->po_no;?>&sname=<?php echo $row->s_name;?>&grn_guid=<?php echo $row->grn_guid?>"><button value="edit" name="edit" type="submit" class="btn btn-info btn-xs" 
                                                style=""><b>EDIT</b></button></a>
                                                
                                                 <input type="hidden" name="po_no" value="<?php echo $row->po_no; ?>"/> 
                                                <a href="<?php echo site_url('greceive_controller/po_delete')?>?grn_guid=<?php echo $row->grn_guid?>"><button value="edit" name="edit" type="submit" class="btn btn-danger btn-xs" 
                                                style="" onclick="return check()"><b>DELETE</b></button></a> 
                                            </td> -->
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