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
  h6,td.big {
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
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <!-- <a href="<?php echo site_url('main_controller/home')?>" style="float:right" >
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a> -->
                        <font>Production Entry
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

          <?php if($this->session->flashdata('msg')): ?>
          <strong><center><?php echo $this->session->flashdata('msg'); ?></center></strong>
          <?php endif; ?>
          <?php if($this->session->userdata('message'))
          {
             echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
          } ?>

        <div style="float:right;">
          <a href="<?php echo site_url('Productionentry_controller/setup'); ?>"> <button type="button" title="Post" id="post" class="btn btn-default btn-sm" style="background-color:#f2f2f2;"><span style="color:white;"></span><b> Setup</b></button></a>
          <!-- <button title="Post" id="post" type="button" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white" data-toggle="modal" data-name="" data-oriname="" ><span style="color:white"></span><b> Post</b></button> -->
        </div>
        <br>

              <center>
              <br>
              <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
                  
                    <form class="form-inline" role="form" method="POST" action="<?php echo site_url('Productionentry_controller/item'); ?>">
                      <input type="submit" value="ITEM" class="btn btn-block btn-primary btn-lg" />
                    </form>
                  
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
                  
                    <form class="form-inline" role="form" method="POST" id="TemplateForm" action="<?php echo site_url('Productionentry_controller/template'); ?>">
                      <input type="submit" value="TEMPLATE" class="btn btn-block btn-success btn-lg" />
                    </form>
                 
                </div>
              </div>
              <br> 
              </center>      
          </div>
            
