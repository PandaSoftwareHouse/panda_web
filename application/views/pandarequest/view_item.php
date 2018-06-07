<?php 
'session_start()' 
?>

<script>

    function myFunction() {
         window.print();
       }

</script>

<style type="text/css">

#poDetails, #promoDetails {
  display: none;
}


b .font {
    font-size: 90px;
}

#printonly{
  display:none;
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

  td.big{
    font-size: 8px;
  }
  h1.page-head-line{
    font-size: 25px;
  }

}

</style>

<style type="text/css" media="print">
#dontprint
{ display: none; }

#printonly
{display: block;}

html body{

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
                      <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/sendprint'); ?>">
                      <h1 class="page-head-line">
                        <?php
                          foreach ($view->result() as $row)
                          {
                            ?>
                          <div id="printonly">
                            <!--<small style="font-size:12px;">Request by: <?php echo $row->Created_By?></small></br>
                            <small style="font-size:12px;">Trans ID: <?php echo $row->Trans_ID?></small></br>
                            <small style="font-size:12px;">Trans Date: <?php echo $row->DocDate?></small>-->
                            <input style="display:none;" type="hidden" name="guid" value="<?php echo $row->Trans_ID?>">
                            <input name="Itemcode[]" value="<?php echo $row->Itemcode?>">
                          </div>
                            <?php
                          }
                        ?>

                        <!--<a id="dontprint" href="<?php echo site_url('pandarequest_controller/scanbarcodeview')?>">
                        <i id="dontprint" class="fa fa-plus-circle" style="font-size:32px;color:#4380B8"></i></a>-->

                        <!--<a id="dontprint" href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="font-size:32px;color:#4380B8"></i></a>-->

                        

                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>

                        <a id="dontprint" href="<?php echo site_url('main_controller/homemenu')?>" style="float:right">
                        <i id="dontprint" class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>

                        <a href="<?php echo site_url('pandarequest_controller/view_transaction')?>" style="float:right"><i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px""></i></a>

                        <a id="dontprint" href='' style="float:right" target="_blank" >
                        <button type="submit" name="print" value="print" class="btn btn-default btn-sm" style="float:right;margin-right:20px;background-color:#00b359">
                        <i id="dontprint" class="glyphicon glyphicon-print" style="font-size:12px;color:black;margin-right:8px"></i><b>PRINT</b></button></a>

                        <font>Stock request</font>
                      
                      </form>
                      </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                    </div> 
                </div>

                <!--1-->
                <div class="row">
                    <!--1.1-->
                    <div class="col-md-4">

                    </div>
                </div>

                <!-- ROW  -->
                <div class="row" >

                    <!--REVIEWS &  SLIDESHOW  -->
                    <div class="col-md-8">

                        <div class="row">
                            <div class="col-md-12">
                            <div style="overflow-x:auto;">
                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td><b>Bin_ID</b></td>
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Link</b></td>
                                        <td><b>Description</b></td>                                    
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Carton<br> Qty</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Balance</b></td>
                                    </tr>
                                </thead>
                                <?php
                                if($view->num_rows() != 0)
                                {
                                    foreach ($view->result() as $row)
                                    {
                                ?>   
                                <tbody>
                                    <tr>
                                      <td class="big"><?php echo $row->Bin_ID; ?></td>
                                      <td class="big"><?php echo $row->Itemcode; ?></td>
                                      <td class="big"><?php echo $row->Itemlink; ?></td>
                                      <td><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $row->Qoh; ?></td>
                                      <td style="text-align:center;"><?php echo $row->qty_request; ?></td>
                                      <td style="text-align:center;">
                                      <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
                                      <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
                                      <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
                                      <td style="text-align:center;"><?php echo $row->qty_balance; ?></td>
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
                                            <td colspan="7" style="text-align:center;">No Item Found</td>
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