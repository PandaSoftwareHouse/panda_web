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
                        
                        <a href="<?php echo site_url('IBT_rec_controller/pending_list')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po
                        <br><small><b><?php echo $_SESSION['sup_name']?></b> (<?php echo $_SESSION['sup_code']?>) </small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                        <br>
                        <a href="<?php echo site_url('ibt_rec_controller/post?guid='.$_SESSION['trans_guid'])?>" ><button class="btn btn-default btn-sm" style=""><b>POST DOCUMENT</b></button></a>
                    </h1>
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" 
                    action="<?php echo site_url('ibt_rec_controller/barcode_scan_result'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode_scan" id="textarea" required autofocus onblur="this.focus()"/>
                            </span>
                        </div>
                    </form>
                    <br>
                    
                    <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>

                    <!-- <?php
                    if($this->session->userdata('message_update_success'))
                    {
                       echo $this->session->userdata('message_update_success') <> '' ? $this->session->userdata('message_update_success') : ''; 
                    }
                    ?> -->
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
                                      <th>Line</th>
                                      <th>Itemcode</th>
                                      <th>Description</th>
                                      <th>Barcode</th>
                                      <th>Qty Rec</th>
                                      <th>Qty Var</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($rec_list->result() as $row)
                                    {  
                                    ?>
                                    <tr>
                                        <td><?php echo $row->line; ?></td>
                                        <td><?php echo $row->Itemcode; ?></td>
                                        <td><a href="<?php echo site_url('ibt_rec_controller/item_entry')?>?trans_guid=<?php echo $row->TRANS_GUID?>&itemcode=<?php echo $row->Itemcode?>"><?php echo $row->Description; ?></a></td>
                                        <td><?php echo $row->Barcode; ?></td>
                                        <td><?php echo $row->Qty_Received; ?><br>
                                        <td><?php echo $row->Qty_Varience; ?></td>
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