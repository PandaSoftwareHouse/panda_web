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
                        
                        <a href="<?php echo site_url('obatch_controller/main') ?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        
                        <font>Batch Transfer Out
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                       
                        
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('obatch_controller/create_batch'); ?>">
                        <div class="form-group">
                             <label>Location To :</label><br>
                                 <select name="locationto" class="form-control" style="width: 120px">
                                    <?php
                                     foreach($slocation->result() as $row)
                                       {
                                           ?>
                                           <option><?php echo $row->sublocation;?></option>
                                           <?php
                                       }
                                       ?> 
                                 </select>
                                 <br>
                              <label>Remarks</label> <br>
                              <input type="text" class="form-control" name="remarks" id="textarea" value="<?php foreach($remarks->result() as $row)
                               { 
                                echo $row->remark;
                                 } 
                                 ?>" />
                              <input name = "trans_guid" value = "<?php echo $trans_guid; ?>" type="hidden" />
                              <br>
                              <button value="view" name="view" type="submit" class="btn btn-success btn-xs" style=""><b>SAVE</b></button>
                        </div>
                    </form>
                    
                    <br>
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