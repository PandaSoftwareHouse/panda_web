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
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

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

                        <a href="<?php echo site_url('IBT_controller/main')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                        <font>ibt request
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('IBT_controller/search_result'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <!--<input type="hidden" value="<?php echo $_REQUEST['guid']?>" class="form-control" placeholder="Item Barcode" name="guid" id="textarea" autofocus/>-->
                            <input type="text" class="form-control" placeholder="Search by" name="branchname" id="textarea" required autofocus onblur="this.focus()"/>
                            
                            </span>
                        </div>
                    </form><br>
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
                                        <td><b>Branch Name</b></td>
                                        <!--<td style="text-align:center"><b>Add</b></td>-->
                                    </tr>
                                </thead>
                                <?php
                                    
                                    if($branchname->num_rows() != 0)
                                    {
                                        foreach ($branchname->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                    <form class="form-inline" role="form" method="POST" id="myForm" 
                                        action="<?php echo site_url('IBT_controller/add_trans')?>">
                                        <td class="big"><?php echo $row->dname; ?>
                                        <input type="hidden" name="code" value="<?php echo $row->CODE; ?>"/>
                                        <button value="add" name="add" type="submit" class="btn btn-primary btn-sm" 
                                        style="margin-left: 0px;width:70px;margin-right:8px;float:right">
                                        <b>ADD</b></button></td>
                                        <input type="hidden" name="brchcode" value="<?php echo $row->CODE; ?>"/>
                                        <input type="hidden" name="brchname" value="<?php echo $row->NAME; ?>"/>

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
                                            <td colspan="5" style="text-align:center;">No Record Found.</td>
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