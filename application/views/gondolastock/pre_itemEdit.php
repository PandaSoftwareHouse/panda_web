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
   font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  p {
    font-size: 12px;
  }
    td {
    font-size: 12px;
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
                        
                        <a href="<?php echo site_url('gondolastock_controller/pre_itemlist')?>?bin_ID=<?php echo $_SESSION['binID']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>

                         <font>Gondola Stock Item edit
                         <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font> 
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      


                <!--1-->
            <div class="row">
                    <!--1.1-->
                <div class="col-md-4">
                    <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('gondolastock_controller/pre_itemSave')?>">
                        <div class="form-group">
                            <h5><b>Loc: </b><?php echo $this->session->userdata('locBin')?>&nbsp
                           <b>BinID: </b><?php echo $this->session->userdata('binID')?></h5>
                              
                                        <h5><b>Description: </b><?php echo convert_to_chinese($BarDesc, "UTF-8", "GB-18030");?></h5>
                                        <h5><b>Barcode: </b><?php echo $barcode?></h5>
                                        <h5><b>Itemcode: </b><?php echo $Itemcode?></h5>
                                        <input type="hidden" value="<?php echo $Itemcode ?>" name="Itemcode">
                                        <input type="hidden" value="<?php echo $barcode ?>" name="Barcode">
                            <?php
                                 // echo var_dump($_SESSION);
                                foreach($itemEdit->result() as $row)
                                {
                                    $_SESSION['Qty'] = $row->Qty;
                                    ?> 

                                    <input type="hidden" value="<?php echo $row->Qty?>" name="qty">
                                    <input type="hidden" value="<?php echo $row->Barcode?>" name="Barcode">
                                    <input type="hidden" value="<?php echo $row->TRANS_GUID?>" name="TRANS_GUID">
                                    
                                    <?php
                                }      
                            ?>
                                <div style="float:left">
                                    <h5 ><b>Qty</b></h5>
                                    <input type="number" 
                                    <?php
                                    foreach($itemEdit->result() as $row)
                                    {
                                      ?> value="<?php echo $row->Qty?>"
                                      <?php 
                                    }
                                    ?>  style="text-align:center;width:80px;" 
                                    min="0" max="100000" disabled />&nbsp&nbsp&nbsp&nbsp <b style="font-size:28px">+</b>
                                    
                                    <br>
                                    <!-- <h5><b>FOC Qty</b></h5>
                                    <input type="number" required name="foc_qty" style="text-align:center;width:80px;" max="100000"/> -->
                                </div>
                                
                                <div style="float:left;margin-left:12px">
                                    <h5><b>&nbsp</b></h5>
                                    <input autofocus required value="0" onfocus="this.select()" type="number" name="qty_add" style="text-align:center;width:80px;" max="100000"/>
                                    <!-- <h5><b>Remarks</b></h5>
                                    <textarea rows="2" name="remark" cols="35" ></textarea> -->
                                </div>
                                
                                   
                        </div><br><br><br>
                        <h4 style="color: red;"><b><?php echo $this->session->userdata('warning') <> '' ? $this->session->userdata('warning') : ''; ?></b></h4>
                        
                                  <button value="submit" name="submit" type="submit" class="btn btn-success btn-xs" 
                                  style="background-color:#00b359;">
                                  <b>SAVE</b></button>
                    </form>

                </div>
            </div>
            <br>
            <div class="row" >

                    <!--REVIEWS &  SLIDESHOW-->
                    <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                              <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                          <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>

                                    <tr>
                                        <td style="text-align:center;"><b>Item exist in Bin ID</b></td>
                                        <td style="text-align:center;"><b>Qty</b></td>
                                    </tr>
                                </thead>
                                <?php
                               
                                    if($check_gondolastock->num_rows() != 0)
                                    {
                                        foreach ($check_gondolastock->result() as $row)
                                        {  
                                ?>        
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $row->bin_id; ?></td>
                                        <td style="text-align:center;">
                                            <?php echo $row->g_qty; ?></a>
                                        </td>
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
                                            <td colspan="5" style="text-align:center;">No Records Found</td>
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
            <!-- /. PAGE INNER  -->
        <!--</div>-->
        <!-- /. PAGE WRAPPER  -->
    </div>




      