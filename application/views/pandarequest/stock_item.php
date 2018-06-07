<?php 
'session_start()' 
?>

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

}

</style>

<style type="text/css" media="print">
#dontprint
{ display: none; }

#printonly
{display: block;}


</style>

<script type="text/javascript">

        function myFunction() {
          window.print();
        }
        
        function myfunvtion(){
          var coloumn = cell.attr('class'),
          id =cell.closet ('tr'),attr('id'),
          cellwidth = cell.css('width'),
          prevContent = cell.text(),
          form = '<form action="javascript: this.prevDefault"><input type="text" name="newValue"
          size="4" value="'+prevContent+'" /><input type="hidden" name>'

          cell.html(form).find('input[type=text]')
          .focus()
          .css('width', cellwidth);

          cell.on('click', function() {return false;});
        }
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
                            <input style="display:none;"type"hidden" name="guid" value="<?php echo $row->Trans_ID?>">
                            <input name="Itemcode[]" value="<?php echo $row->Itemcode?>">
                          </div>
                            <?php
                          }
                        ?>
                        
                        <a id="dontprint" href="<?php echo site_url('pandarequest_controller/stock_view_transaction')?>" ><i class="fa fa-arrow-left" style="font-size:32px;color:#4380B8"></i></a>

                        <a id="dontprint" href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="font-size:32px;color:#4380B8"></i></a>
                        
                        <a id="dontprint" href="<?php echo site_url('main_controller/homemenu')?>" style="float:right">
                        <i id="dontprint" class="fa fa-home" style="font-size:32px;color:#4380B8;margin-right:20px"></i></a>

                        
                        <a id="dontprint" href='' style="float:right" target="_blank" >
                        <button type="submit" name="print" value="print" class="btn btn-default btn-sm" style="float:right;margin-right:20px;background-color:#00b359">
                        <i id="dontprint" class="glyphicon glyphicon-print" style="font-size:12px;color:black;margin-right:8px"></i><b>PRINT</b></button></a>
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
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Link</b></td>
                                        <td><b>Description</b></td>                                    
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Carton<br> Qty</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Pick</b></td>
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
                                      <td class="big"><?php echo $row->Itemcode; ?></td>
                                      <td class="big"><?php echo $row->Itemlink; ?></td>
                                      <td><?php echo convert_to_chinese($row->Description, "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $row->Qoh; ?></td>
                                      <td style="text-align:center;"><?php echo $row->qty_request; ?></td>
                                      <td style="text-align:center;">
                                      <?php echo round($row->qty_request / $row->BulkQty, 2) ?> ctn @ 
                                      <?php echo round($row->qty_request / $row->BulkQty, 0) ?> ctn
                                      <?php echo round(fmod($row->qty_request, $row->BulkQty), 0) ?> unit</td>
                                      <!--SELECT CONCAT(FORMAT((qty_request-(qty_request MOD bulkty)) / bulkty,0),
                                      ' ctn ', qty_request MOD bulkty,' unit') AS ctnqty-->

                                      <input type="hidden" name="qty_request1" value="<?php echo $row->qty_request; ?>"/>
                                      <input type="hidden" name="BulkQty1" value="<?php echo $row->BulkQty; ?>"/>

                                      <form class="form-inline" role="form" method="POST" id="myForm" 
                                      action="<?php echo site_url('pandarequest_controller/add_qty_pick')?>">
                                      
                                      <td style="text-align:center;width:80px">
                                        <input id="required" class="big" type="number" name="qty_pick[]" value="" 
                                        style="text-align:center;width:70px;"></td>

                                      <td style="text-align:center;"><?php echo $row->qty_balance; ?></td>
                                    </tr>
                                </tbody>

                                    <input type="hidden" name="Itemcode[]" value="<?php echo $row->Itemcode; ?>"/>
                                    <input type="hidden" name="Trans_ID[]" value="<?php echo $row->Trans_ID; ?>"/>
                                    <input type="hidden" name="qty_request[]" value="<?php echo $row->qty_request; ?>"/>
                                    <input type="hidden" name="qty_balance[]" value="<?php echo $row->qty_balance; ?>"/>

                                <?php
                                    }
                                }
                                else
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="8" style="text-align:center;">No Item Found</td>
                                            </tr>
                                        </tbody>
                                        <?php       
                                        }
                                ?>
                                </table>
                                </div>
                                <button value="go" name="go" type="submit" class="btn btn-default btn-sm" 
                                style="margin-left: 0px;background-color:#00b359;width:70px;margin-right:8px" 
                                onclick="return check()">
                                <a href=<?php echo site_url('pending_submit_c/viewdata'); ?> style="color:black;text-decoration:none"><b>SUBMIT</b></a></button>

                              </form>
                              
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