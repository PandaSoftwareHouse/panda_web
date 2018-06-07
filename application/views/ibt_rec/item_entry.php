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
   font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  p {
    font-size: 12px;
  }
}

</style>

<script type="text/javascript">
$(document).ready( function() {
  $('#id').click( function( event_details ) {
    $(this).select();
  });
});

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
                        
                        <a href="<?php echo site_url('ibt_rec_controller/barcode_scan')?>?guid=<?php echo $_SESSION['trans_guid']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>GRN BY IBT<br>
                        <small><b><?php echo $ibt_details->row('rec_status')?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                  <?php
                  if($this->session->userdata('message') )
                  {
                     echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                  }
                  ?>
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('ibt_rec_controller/item_entry_update')?>?itemcode=<?php echo $_REQUEST['itemcode']?>">
                        <div class="form-group">
                            <h5>Order: <b><?php echo $ibt_details->row('Qty_Actual')?></b>&nbsp&nbsp
                           Balance: <b><?php echo $ibt_details->row('Qty_Varience')?></b></h5>
                              
                                <h4>Description: <b><?php echo convert_to_chinese($ibt_details->row('Description'), "UTF-8", "GB-18030"); ?>&nbsp&nbsp&nbsp&nbsp<?php echo $ibt_details->row('line')?></b></h4>
                                <h4>Barcode: <b><?php echo $ibt_details->row('Barcode');?></b></h4>

                                <div class="row">
                                  <div class="col-md-5 col-xs-3 form-group">
                                    <h5 ><b>IBT Qty</b></h5>
                                    <input disabled value="<?php echo $ibt_details->row('Qty_Actual')?>" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" type="number" step="any" />
                                     <input type="hidden" name="actual_qty" value="<?php echo $ibt_details->row('Qty_Actual')?>">
                                  </div>

                                  <div class="col-md-6 col-xs-6 form-group">
                                    <h5><b>Rec Qty</b></h5>
                                    <input autofocus value="<?php echo $ibt_details->row('Qty_Received')?>" name="rec_qty" type="number" step="any" style="text-align:center;width:80px;background-color:#80ff80" onfocus="this.select()" />
                                  </div>
                                </div>
                            
                                <br>
                                <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" style="background-color:#00b359;"><b>SAVE</b></button>

                                <h5><b>Expired Date</b></h5>
                                <input type="date" class="form-control" value="<?php echo $ibt_details->row('expiry_date')?>" style="width: 220px" name="expiry_date">

                                <h5><b>Reason</b></h5>
                                <select id="reason" name="reason" class="form-control" style="width: 220px;background-color:#ccf5ff"  >
                                  <?php echo $reason?>
                                <?php
                                if($reason <> '')
                                {
                                  ?>
                                  <option selected data-default style="display: none; " ><?php echo $reason?></option>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <option value="" disabled selected>Select Reason:</option>
                                  <?php
                                }
                                ?>
                                
                                <?php
                                foreach($set_master_code->result() as $row)
                                {
                                    ?>
                                <option value="<?php echo $row->CODE_DESC;?>"><?php echo $row->CODE_DESC;?></option>
                                    <?php
                                }
                                ?>
                                
                                </select>
                                <br>
                        </div><br><br><br><br>
                                  
                    </form>

                </div>
            </div>

            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                                         
                              
                                
                            </div>
                          </div>
                    
                    </div>

            </div>
                        

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>

    
    <!-- <script type="text/javascript">
      function fun()
      {
       var ddl = document.getElementById("reason");
       var selectedValue = ddl.options[ddl.selectedIndex].value;
          if (selectedValue == "selectreason")
         {
          alert("Please select a Reason");
          return false;
         }
      }
    </script> -->