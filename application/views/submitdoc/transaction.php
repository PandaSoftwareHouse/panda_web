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
  .big{
    font-size: 14px;
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

                        <a href="<?php echo site_url('submitdoc_controller')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font>Submission list
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                      
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                <p><b>User ID :</b><?php echo $_SESSION['userid']?></p>

                    <a href='<?php echo site_url('submitdoc_controller/insertMain')?>'>
                    <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                    <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD TRANS</b></button></a>
                    <br>
                    <br>
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>

            
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                          <div class="col-md-12">
                            <div style="overflow-x:auto;">
                              <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td><b>Ref No</b></td>
                                        <td><b>created_at</b></td>
                                        <td><b>created_by</b></td>
                                        <!-- <td style="text-align: center;"><b>Print</b></td> -->
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
                                        <td class="big"><a href="<?php echo site_url('submitdoc_controller/transaction_result')?>?guid=<?php echo $row->sl_guid?>"><?php echo $row->refno; ?>
                                       <!--  <a href="<?php echo site_url('submitdoc_controller/send_print')?>?guid=<?php echo $row->sl_guid?>&refno=<?php echo $row->refno?>"
                                        class="btn btn-default btn-xs" style="float:right;" 
                                        <?php
                                        if($row->send_print == '1')
                                        {
                                        ?>
                                            disabled 
                                        <?php
                                        }
                                        ?>>PRINT</a> -->
                                        </td>
                                        <td class="big"><?php echo $row->created_at; ?></td>
                                        <td class="big"><?php echo $row->created_by; ?></td>
                                        <!-- <td style="text-align: center;">
                                        <?php
                                        if($row->send_print == '1')

                                            {
                                                ?>
                                                <span class="glyphicon">&#xe013;</span>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span class="glyphicon">&#xe014;</span>
                                                <?php
                                            }
                                        ?>
                                        </td> -->
                                        
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
                    
                    </div>

            </div>      

                
   
        </div>
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>