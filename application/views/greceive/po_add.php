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
                        
                        <a href="<?php echo $back ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>grn by po</font>
                        <small><b><?php echo $method?></b></small>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">
                        <div class="form-group">

                        <h5><b>PO No: </b><?php echo $po_no?></h5>
                        <h5><b>Supplier Name: </b><?php echo $sname?></h5>
                        <br>
                        <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="float:left">
                                <p><b>D/O No: (max digit = 20)</b>
                                    <br>
                                <input autofocus onfocus="this.select()" onkeyup="autopopulate()" maxlength="20" id="do_no" type="text" name="do_no" style="width:170px;background-color:#ffff99" required
                                value="<?php echo $do_no  ?>"
                                /></p>
                                                    
                                            
                                <p><b>Invoice No: (= D/O No. if Blank)</b><br>
                                <input type="text" id="inv_no" name="inv_no" maxlength="20" style="width:170px;background-color:#80ff80"  onfocus="this.select()"
                                value="<?php echo $inv_no  ?>"
                                /></p>

                                <?php if($grn_by_weight_hide_inv_detail == '0') { ?>
                                <p><b>Invoice Date: </b><br>

                                 <input type="date" name="inv_date" style="width:170px; background-color:#80ff80" 
                                  <?php
                                  if($po_details->num_rows() > 0)
                                  {
                                    foreach($po_details->result() as $row)
                                    {
                                        ?>
                                        <?php  if($row->inv_date == '') { ?>
                                         value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
                                         <?php } else { ?>
                                         value="<?php echo $row->inv_date; ?>"
                                         <?php } ?>
                                      <?php
                                    }
                                  }
                                  else
                                  {
                                  ?>
                                    value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
                                  <?php 
                                  } 
                                ?>
                                max="<?php echo $max_invoice_date; ?>"/> 



                                <!-- <input type="date" name="inv_date" style="width:170px;background-color:#80ff80" 
                                <?php
                                    foreach($po_details->result() as $row)
                                    {
                                        ?>
                                        value="<?php echo $row->inv_date?>"
                                <?php 
                                    } ?>
                                /></p> -->

                                <p><b>Receiving Date: </b><br>
                                <input type="date" name="received_date" style="width:170px; background-color:#C0C0C0" 
                                  <?php
                                  if($po_details->num_rows() > 0)
                                  {
                                    foreach($po_details->result() as $row)
                                    {
                                        ?>
                                        <?php  if($row->received_date == '') { ?>
                                         value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
                                         <?php } else { ?>
                                         value="<?php echo $row->received_date; ?>"
                                         <?php } ?>
                                      <?php
                                    }
                                  }
                                  else
                                  {
                                  ?>
                                    value="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>"
                                  <?php 
                                  } 
                                ?>
                                min="<?php echo $this->db->query("SELECT date_format(now(), '%Y-%m-%d') as  masaskrg")->row('masaskrg'); ?>" max="<?php echo $max_received_date ?>"/></p>

                                <p><b>Amount Exclude Tax:</b><br>
                                <input type="number" step="any" name="amt_exc_tax" style="width:170px;background-color:white;text-align: right"  max="100000" onfocus="this.select()" value="<?php echo $amt_exc_tax  ?>"
                                /></p>

                                <p><b>Tax Amount:</b><br>
                                <input type="number" step="any" name="gst_tax" style="width:170px;background-color:white;text-align: right" max="100000" onfocus="this.select()" value="<?php echo  $gst_tax  ?>"
                                /></p>

                                <p><b>Rounding Adj Amount:</b><br>
                                <input type="number" step="any" name="rounding_adj" style="width:170px;background-color:white;text-align: right" max="100000" onfocus="this.select()" value="<?php echo  $rounding_adj  ?>"
                                /></p>

                                <p><b>Amount Include Tax:</b><br>
                                <input type="number" step="any" name="amt_inc_tax" style="width:170px;background-color:white;text-align: right"  max="100000" 
                                  onfocus="this.select()"
                                  value="<?php echo  $amt_inc_tax  ?>"
                                /></p>
                              <?php } ?>
                                <br><br>
                                            
                               
                            </div>
                                    
                        </div>
                    </form>
                     <button value="go" name="go" type="submit" class="btn btn-success btn-xs" 
                                style="" 
                                onclick="$('#myForm').submit()">
                                <b>SAVE</b></button>
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
<script type="text/javascript">

  $(document).ready(function() {
    var input = document.getElementById('do_no');
      input.focus();
      input.select();
  });

  inputs = $("input");
  $(inputs).keypress(function(e){
      if (e.keyCode == 13){
        inputs[inputs.index(this)+1].focus();
        inputs[inputs.index(this)+1].select();
      }
  });

</script>
<script>
function autopopulate() {
    var x = document.getElementById("do_no").value;
    document.getElementById("inv_no").value =  x;
}
</script>

