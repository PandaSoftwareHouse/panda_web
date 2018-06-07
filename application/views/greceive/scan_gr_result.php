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

                        <font>grn by po
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                        <!-- <small><b><?php echo $method?></b></small> -->
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
                        <?php
                        if($grmain_detail->num_rows() > 1)
                        {
                            ?>
                            <table class="tablesorter table table-striped table-bordered table-hovers">
                                  <thead style="cursor:s-resize">
                                    <tr>
                                      <th>PO No</th>
                                        <th>PO Date</th>
                                        <th>Received At</th>
                                        <th>Convert GRN At</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($grmain_detail->result() as $row)
                                    {  
                                    ?>
                                        <tr>
                                            <td class="big"><a href="<?php echo site_url('greceive_controller/search_gr_result')?>?po_no=<?php echo $row->po_no?>&gr_no=<?php echo $row->RefNo?>"><?php echo $row->po_no; ?></a></td>
                                            <td class="big"><?php echo $row->inv_no; ?></td>
                                            <td class="big"><?php echo $row->received_date; ?></td>
                                            <td class="big"><?php echo $row->convert_grn_at; ?><br>
                                            <?php echo $row->convert_grn_by?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                                </table>
                            <?php
                        }
                        else
                        {
                            ?>
                            <h5><b>GR No: </b><?php echo $grmain_detail->row('RefNo'); ?></h5>
                            <h5><b>Supplier Name: </b><?php echo $grmain_detail->row('Name')?></h5>
                            <br>
                            <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                                <div style="float:left">
                                    <p><b>D/O No: (max digit = 20) </b>
                                        <br>
                                    <input autofocus onfocus="this.select()" type="text" name="do_no" style="width:170px;background-color:#ffff99" required  maxlength="20"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo $row->do_no?>"
                                            <?php
                                        }
                                    ?>
                                    /></p>
                                                        
                                                
                                    <p><b>Invoice No: (= D/O No. if Blank)</b><br>
                                    <input type="text" name="inv_no" style="width:170px;background-color:#80ff80"  onfocus="this.select()"  maxlength="20"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo $row->inv_no?>"
                                            <?php
                                        }
                                    ?>
                                    /></p>

                                    <?php if($grn_by_weight_hide_inv_detail == '0') { ?>
                                    <p><b>Invoice Date: </b><br>
                                    <input type="date" name="inv_date" style="width:170px;background-color:#80ff80" value="<?php echo $row->inv_date ?>"
                                    <?php 
                                    ?>
                                    /></p>

                                    <p><b>Receiving Date: </b><br>
                                    <input type="date" name="received_date" style="width:170px;background-color:#C0C0C0" value="<?php echo $row->received_date ?>"
                                    <?php 
                                    ?>
                                    /></p>

                                    <p><b>Amount Exclude Tax:</b><br>
                                    <input type="number" step="any" name="amt_exc_tax" style="width:170px;background-color:white;text-align: right"  max="100000" onfocus="this.select()"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo  $row->amt_exc_tax  ?>"
                                            <?php
                                        }
                                    ?>
                                    /></p>

                                    <p><b>Tax Amount:</b><br>
                                    <input type="number" step="any" name="gst_tax" style="width:170px;background-color:white;text-align: right" max="100000" onfocus="this.select()"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo  $row->gst_tax  ?>"
                                            <?php
                                        }
                                    ?>
                                    /></p>

                                    <p><b>Rounding Adj Amount:</b><br>
                                    <input type="number" step="any" name="rounding_adj" style="width:170px;background-color:white;text-align: right" max="100000" onfocus="this.select()"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo  $row->rounding_adj  ?>"
                                            <?php
                                        }
                                    ?>
                                    /></p>

                                    <p><b>Amount Include Tax:</b><br>
                                    <input type="number" step="any" name="amt_inc_tax" style="width:170px;background-color:white;text-align: right"  max="100000"  onfocus="this.select()"
                                    <?php
                                        foreach($grmain_detail->result() as $row)
                                        {
                                            ?>
                                            value="<?php echo  $row->amt_inc_tax  ?>"
                                            <?php
                                        }
                                    ?>
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
                            <?php
                        }
                        ?>
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