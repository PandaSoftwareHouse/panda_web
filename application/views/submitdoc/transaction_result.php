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
    font-size: 12px;
  }
}

</style>

<script type="text/javascript">

function check()
{
    var answer=confirm("Confirm want to delete record ?");
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

                        <a href="<?php echo site_url('submitdoc_controller/transaction')?>" style="float:right">
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
                    <!-- <?php echo var_dump($_SESSION); ?> -->

                    <a href='<?php echo site_url('submitdoc_controller/menu')?>?guid=<?php echo $_REQUEST['guid']?>'>
                    <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                    <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD DOC</b></button></a>
                    <br><br>
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
                                        <td><b>Supplier</b></td>
                                        <td><b>Doc Type</b></td>
                                        <td><b>Total IncTax</b></td>
                                        <td><b>created_at</b></td>
                                        <td><b>created_by</b></td>
                                        <!-- <td><b>Print</b></td> -->
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
                                        <td class="big"><?php echo $row->trans_refno; ?>
                                        <a href="<?php echo site_url('submitdoc_controller/delete_child')?>?guid_c=<?php echo $row->sl_guid_c?>&trans_refno=<?php echo $row->trans_refno?>&sl_guid=<?php echo $row->sl_guid?>" class="btn btn-xs btn-danger" style="float:right" onclick="return check();"><span class="glyphicon glyphicon-trash"></span></a></td>
                                        <td class="big"><?php echo $row->name; ?></td>
                                        <td class="big"><?php echo $row->doc_type; ?></td>
                                        <td class="big"><?php echo $row->total_include_tax; ?></td>
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
                                            <td colspan="7" style="text-align:center;">No Record Found</td>
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