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
                        
                        <a href="<?php echo site_url('IBT_controller/main')?>" style="float:right">
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
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('IBT_controller/add_trans'); ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <h4>IBT FROM : </h4>
                            <select name="frombranch" class="selectpicker form-control" data-live-search="true" required >
                            <!-- <option selected><?php echo $selected;?></option> -->
                             <?php 
                                 foreach ($supplier->result()  as $row)
                                  {
                                    ?>
                                      <?php if($row->dname == $selected )
                                        { 
                                          echo 'selected'; 
                                        } 
                                        else 
                                        { 
                                          echo '';
                                        }  
                                      ?>
                                  <option><?php echo $row->dname;?></option>
                              <?php
                                  }
                                ?>
                            </select>
                            <br>
                            <h4>IBT TO : </h4>
                            <select name="tobranch" class="selectpicker form-control" data-live-search="true" required >
                             <?php 
                                 foreach ($supplier->result()  as $row)
                                     {
                                         ?>
                                         <option><?php echo $row->dname;?></option>
                                         <?php
                                     }
                                 ?>
                            </select>
                            <br><br>
                          
                            </span>
                  <?php
                  if($this->session->userdata('message') )
                  {
                     echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
                  }
                  ?>
                            <button value="save" name="save" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
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