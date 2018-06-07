<?php 
'session_start()' 
?>
<script>

    function myFunction() {
         window.print();
       }

</script>

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

  td.big{
    font-size: 8px;
  }
}

</style>

<script type="text/javascript">




</script>
<!--onload Init-->
<body onload="myFunction()">
    <div id="wrapper">
        
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">

                      <h1 class="page-head-line">
                      <!--<small>
                        <p>Print By: <?php echo $_SESSION["username"] ?></p>
                      </small>
                        <small><span id="date_time"></span>
                        <script type="text/javascript">window.onload = date_time('date_time');</script></small>
                        -->
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

                            <table class="table table-striped table-bordered table-hover" style="width:100">
                                <thead>
                                    <tr>
                                        <td><b>Item Code</b></td>
                                        <td><b>Item Link</b></td>
                                        <td><b>Description</b></td>                                    
                                        <td style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td style="text-align:center;"><b>Bulk<br> Qty</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td class="big"><?php echo $_REQUEST['Itemcode']; ?></td>
                                      <td class="big"><?php echo $_REQUEST['Itemlink']; ?></td>
                                      <td><?php echo convert_to_chinese($_REQUEST['Description'], "UTF-8", "GB-18030"); ?></td>
                                      <td style="text-align:center;"><?php echo $_REQUEST['Qoh']; ?></td>
                                      <td style="text-align:center;"><?php echo $_REQUEST['qty_request']; ?></td>
                                      <td style="text-align:center;"><?php echo $_REQUEST['BulkQty']; ?></td>
                                    </tr>
                                </tbody>
                                </table>
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