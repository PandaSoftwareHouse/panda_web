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
                            <?php echo var_dump($_SESSION); ?>
                        <h5><b>GR No: </b><?php echo $grmain_detail->row('RefNo'); ?></h5>
                        <h5><b>Supplier Name: </b><?php echo $grmain_detail->row('Name')?></h5>
                        <br>
                        <h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            <div style="float:left">
                                <p><b>D/O No:</b>
                                    <br>
                                <input autofocus onfocus="this.select()" type="text" name="do_no" style="width:170px;background-color:#ffff99" required
                                <?php
                                    foreach($grmain_detail->result() as $row)
                                    {
                                        ?>
                                        value="<?php echo $row->DONo?>"
                                        <?php
                                    }
                                ?>
                                /></p>
                                                    
                                            
                                <p><b>Invoice No: (= D/O No. if Blank)</b><br>
                                <input type="text" name="inv_no" style="width:170px;background-color:#80ff80"  
                                <?php
                                    foreach($grmain_detail->result() as $row)
                                    {
                                        ?>
                                        value="<?php echo $row->InvNo?>"
                                        <?php
                                    }
                                ?>
                                /></p>

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

                               

                               
                                            
                                <br><br>
                                            
                                <button value="go" name="go" type="submit" class="btn btn-success btn-xs" 
                                style="" 
                                onclick="return check()">
                                <b>SAVE</b></button>
                            </div>
                                    
                        </div>
                    </form><br>
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