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
  h6 {
    font-size: 10px;
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
                        
                        <a href="<?php echo site_url('SO_controller/main')?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>sales order
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('SO_controller/search_result'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <input type="text" class="form-control" placeholder="Search by" name="supname" id="textarea" required autofocus />
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
                            <h6 style="float:right"><b>Total Records:</b><?php echo $supname->num_rows();?></h6>
                              <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                
                                <thead>
                                    <tr>
                                        <td><b>Sup Name</b></td>
                                        <th style="text-align:center">Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($supname->result() as $row)
                                    {  
                                ?>        
                                
                                    <tr>
                                        <td class="big"><?php echo $row->dname; ?></td>
                                        <td style="text-align:center">
                                        <a class="btn btn-xs btn-primary" href="<?php echo site_url('SO_controller/add_trans')?>?supcode=<?php echo $row->CODE; ?>&supname=<?php echo $row->NAME; ?>">
                                            <span class="glyphicon glyphicon-plus"></span> 
                                        </a>
                                        </td>
                                    </tr>
                                
                                <?php
                                    }
                                ?>
                                </tbody>
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