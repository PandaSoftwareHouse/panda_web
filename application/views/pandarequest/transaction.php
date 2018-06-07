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
}

</style>

<script type="text/javascript">

function check()
{
    var answer=confirm("Confirm want to delete item ?");
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

                        <a href="<?php echo site_url('main_controller/homemenu')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>Stock request</font>
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

                            <a href="<?php echo site_url('pandarequest_controller/add_transID'); ?>">
                            <button type="submit" name="save" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white">
                            <span class="glyphicon glyphicon-plus-sign" style="color:white"></span><b> ADD TRANS</b></button></a>

                            <input type="hidden" name="username" value="<?php echo $_SESSION['username']?>" style="text-align:center;width:80px;" max="100000"/>
                             <!--  <?php
                                foreach ($sysrun->result() as $row) 
                                {
                                    ?>
                                    <input type="hidden" name="run_code" value="<?php echo $row->run_code; ?>" />
                                    <input type="hidden" name="run_year" value="<?php echo $row->run_year; ?>" />
                                    <input type="hidden" name="run_month" value="<?php echo $row->run_month; ?>" />
                                    <input type="hidden" name="run_day" value="<?php echo $row->run_day; ?>" />
                                    <input type="hidden" name="run_currentno" value="<?php echo $row->run_currentno; ?>" />
                                    <input type="hidden" name="run_digit" value="<?php echo $row->run_digit; ?>" />
                                    <?php     
                                }
                                ?>   -->
                           <br><br>
                            <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        
                                        <td><b>Trans Date</b></td>
                                        <td><b>Created By</b></td>
                                        <td><b>DocDate</b></td>
                                        <td style="text-align:center;"><b>Print</b></td>
                                    </tr>
                                </thead>
                                <?php
                                    
                                    if($transactions->num_rows() != 0)
                                    {
                                        foreach ($transactions->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        
                                        <td class="big"><?php echo $row->Trans_Date; ?></td>
                                        <td><?php echo $row->Created_By; ?></td>
                                        <td class="big"><?php echo $row->DocDate; ?></td>
                                        <td style="text-align:center;">
                                            <a href="<?php echo site_url('pandarequest_controller/view_bin')?>?guidpost=<?php echo $row->Trans_ID?>"><button value="view" name="view" type="submit" class="btn btn-info btn-xs" ><b>VIEW</b>
                                            </button></a>
                                        </td>
                                    </form>
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
                                            <td colspan="5" style="text-align:center;">No Pending Transaction</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>
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