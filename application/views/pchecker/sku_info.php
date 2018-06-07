<?php 
'session_start()' 
?>
<style>

tr td {
  width:200px;
  font-size:16px;
}

b.font {
  font-size:25px;
}

b {
  font-size:16px;
}

span.prices {
  font-size: 16px;
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
  b.font {
    font-size: 15px;  
  }
  b {
    font-size: 12px;
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
  td {
    font-size: 5px;
  }
  a.tab-head {
    font-size: 11px;
  }
  span.prices {
    font-size: 12px;
  }
  th {
    font-size:10px;
  }

}

</style>

<script type="text/javascript">

</script>
<!--onload Init
onload="window.location.reload() "-->
<body onload="document.refresh();">
    <div id="wrapper">
        
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        <?php 
                        if ($_SESSION['show_cost'] == '1')
                          {
                        ?>
                        <a href="<?php echo site_url('PcheckerCost_controller/scan_result')?>?barcode=<?php echo $_SESSION['barcode']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <?php 
                          } 
                          else 
                          { 
                        ?>
                        <a href="<?php echo site_url('Pchecker_controller/scan_result')?>?barcode=<?php echo $_SESSION['barcode']?>" style="float:right">
                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <?php 
                          } 
                        ?>
                        <font>SKU INFO
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></font>
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>      
                <!--1-->

                
            
              <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                      <form class="form-inline" role="form" method="POST" id="myForm" action="<?php 
                    if($_SESSION['show_cost'] == '1') 
                      {
                        echo site_url('PcheckerCost_controller/scan_result');
                        }
                        else
                        {
                          echo site_url('pchecker_controller/scan_result');
                          } ?>">
                        <div class="form-group">
                            <span class="input-group-btn">
                            <!--<input type="hidden" value="<?php echo $_REQUEST['guid']?>" class="form-control" placeholder="Item Barcode" name="guid" id="textarea" autofocus/>-->
                            <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode" id="textarea" required autofocus /><!-- onblur="this.focus()" -->
                            
                            </span>
                        </div>
                    </form><!-- <br class="break" /> -->
                    <h4 style="color: red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                    <h4 style="color: green"><?php echo $this->session->userdata('message_success') <> '' ? $this->session->userdata('message_success') : ''; ?></h4>
                      <?php // echo var_dump($_SESSION) ?>
                        <div class="tabbable" id="tabs-577039">
                            <ul class="nav nav-tabs">
                                <li class="<?php echo $active_itemdetails?>">
                                    <a class="tab-head" href="#panel-360876" data-toggle="tab">Item Details</a>
                                </li>
                                <li >
                                    <a class="tab-head" href="#panel-107683" data-toggle="tab">Promotion</a>
                                </li>
                                <?php if ($_SESSION['show_cost'] == '1')
                                        {
                                      ?>
                                <li >
                                    <a class="tab-head" href="#panel-purchase_details" data-toggle="tab">Purchase Details</a>
                                </li>

                                <?php }  ?>
                                <li >
                                    <a class="tab-head" href="#panel-itemlink" data-toggle="tab">Item Link</a>
                                </li>
                                <li class="<?php echo $active_propose_price?>">
                                    <a class="tab-head" href="#panel-purposeprice" data-toggle="tab">Propose Price</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?php echo $active_itemdetails?>" id="panel-360876">
                                    <br>
                                    <?php foreach($item_details as $p)
                                    {
                                      ?>
                                      <b class="font"><?php echo convert_to_chinese($p['Description'], "UTF-8", "GB-18030"); ?></b>
                                      
                                      <table>
                                      <font style="display:inline-block;margin-right:9px">
                                      
                                      <tr>
                                        <td>
                                        <b>Item Code :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['itemcode']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Barcode :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['Barcode']; ?></b>
                                        </td>
                                      </tr>
                                      <tr class="<?php echo $_SESSION['encode']?>">
                                        <td>
                                        <b>Scan Barcode :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $_SESSION['encode_barcode']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Tax Code :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_purchase']; ?> / <?php echo $p['tax_code_supply']; ?></b>
                                        </td>
                                      </tr>
                                      <!-- <tr>
                                        <td>
                                        <b>Tax Code Purchase:</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_purchase']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Tax Code Supply :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_supply']; ?></b>
                                        </td>
                                      </tr> -->
                                      <tr>
                                        <td>
                                        <b>Item Type :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['itemtype']; ?></b>
                                        </td>
                                      </tr>
                                      <tr class="<?php echo $_SESSION['encode']?>">
                                        <td>
                                        <b>Weight / Amount :</b>
                                        </td>
                                        <td>
                                        <?php echo $_SESSION['get_weight']; ?>&nbsp<?php echo  $p['um']; ?> / <b> RM </b><span class="prices"><?php echo number_format($_SESSION['get_weight']*$p['sellingprice'],2); ?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Price inc tax:</b>
                                        </td>
                                        <td>
                                        <b> RM </b><span class="prices"><?php echo $p['price_include_tax']; ?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Price exc tax:</b>
                                        </td>
                                        <td>
                                        <b> RM </b><span class="prices"><?php echo $p['sellingprice']; ?></span>
                                        </td>
                                      </tr>
                                      </font>
                                      </table>

                                      <table>
                                      <font style="display:inline-block;margin-right:9px">
                                      <!-- <tr>
                                        <td style="width:220px;font-size:16px">
                                        <b>Selling Price <br> (inc tax) :</b>
                                        </td>
                                        <td style="width:150px;">
                                        <b> RM </b><span class="prices"><?php echo $p['price_include_tax']; ?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:220px;font-size:16px">
                                        <b>Selling Price <br> (exc tax) :</b>
                                        </td>
                                        <td style="width:150px;">
                                        <b> RM </b><span class="prices"><?php echo $p['sellingprice']; ?></span>
                                        </td>
                                      </tr> -->
                                      <?php 
                                        if ($_SESSION['show_cost'] == '1')
                                        {
                                      ?>
                                      <tr>
                                        <td>
                                        <b>Average Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p['averagecost']; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p['avg_profit']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Last Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["lastcost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["last_profit"]; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Listed Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["stdcost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["std_profit"]; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>FIFO Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["fifocost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["fifo_profit"]; ?></b>
                                        </td>
                                      </tr>

                                      <?php }
                                       ?>
                                      </font>
                                      </table>
                                      <?php
                                    }
                                    
                                    ?>

                                    <?php foreach($item_qoh as $i): ?>
                                    <table>
                                      <font style="display:inline-block;margin-right:9px">
                                      <tr>
                                      <td>
                                      <b>All P/S QOH :</b>
                                      </td>
                                      <td>
                                      <b><?php echo $i["qoh"]; ?></b>
                                      </td>
                                      </tr>
                                      </font>
                                    </table>
                                    <?php endforeach;?>

                                    <?php foreach($item_qoh_c as $k): ?>
                                      <table>
                                        <font style="display:inline-block;margin-right:9px">
                                        <tr>
                                        <td>
                                        <b>Min. Date :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["min_date"]; ?></b>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>Max. Date :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["max_date"]; ?></b>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>ADS :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["ads"]; ?></b>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>AWS :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["aws"]; ?></b>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>AMS :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["ams"]; ?></b>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>DOH :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $k["doh"]; ?></b>
                                        </td>
                                        </tr>
                                        </font>
                                      </table>
                                    <?php endforeach;?>


                                </div>
                                
                                <div class="tab-pane " id="panel-107683">
                                  <br class="break" />
                                  <div style="overflow-x:auto;" >
                                  
                                    <table class="table table-striped table-bordered table-hover" style="width:100">
                                    <thead>
                                        <tr>
                                            <td ><b>REF NO</b></td>
                                            <td ><b>Date From</b></td>
                                            <td ><b>Date To</b></td>
                                            <td ><b>Outlet</b></td>
                                            <td ><b>Card Type</b></td>
                                            <td ><b>Price (Before Discount)</b></td>
                                            <td ><b>Discount</b></td>
                                            <td ><b>Price Net</b></td>
                                            <td ><b>Promo Type</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($item_promo)
                                    {
                                     foreach($item_promo as $j): ?>
                                        <tr>
                                  
                                          <td><?php echo $j["refno"]; ?></td>

                                          <td><?php echo $j["datefrom"]; ?></td>
                                        
                                          <td><?php echo $j["dateto"]; ?></td>
                                        
                                          <td><?php echo $j["loc_group"]; ?></td>

                                          <td><?php echo $j["cardtype"]; ?></td>

                                          <td><?php echo $j["price_target"]; ?></td>
                                        
                                          <td><?php echo $j["discount"]; ?></td>
                                        
                                          <td><?php echo $j["price_net"]; ?></td>

                                          <td><?php echo $j["promo_type"]; ?></td>
                                          
                                        </tr>

                                    <?php 
                                    endforeach;
                                    }
                                    else
                                    {
                                    ?>

                                        <tr>
                                            <td colspan="9" style="text-align:center;">No Data Found</td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                    </tbody>
                                    </table>
                                  </div> 
                                </div>

                                <?php  if ($_SESSION['show_cost'] == '1')
                                        {
                                      ?>
                                <div class="tab-pane" id="panel-purchase_details">
                                <br class="break" />
                                <h4><b>PURCHASE ORDER  :</b></h4>
                                    <div style="overflow-x:auto;" >
                                    <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td><b>REF NO</b></td>
                                            <td><b>Supplier Code</b></td>
                                            <td><b>PO Date</b></td>
                                            <td><b>Quantity</b></td>
                                            <td><b>Deliver Date</b></td>
                                            <td><b>Expiry Date</b></td>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    <?php if($po_details)
                                    {
                                     foreach($po_details as $m): ?>

                                        <tr>
                                          <td><?php echo $m["refno"]; ?></td>
                                        
                                          <td><?php echo $m["supcode"]; ?></td>
                                            
                                          <td><?php echo $m["podate"]; ?></td>
                                        
                                          <td><?php echo $m["qty_order"]; ?></td>
                                        
                                          <td><?php echo $m["deliverdate"]; ?></td>

                                          <td><?php echo $m["expiry_date"]; ?></td>
                                        </tr> 
                                    
                                       
                                    <?php
                                    endforeach;
                                    }
                                    else
                                    {
                                    ?>
                                         <tr>
                                            <td colspan="6" style="text-align:center;">No Data Found</td>
                                        </tr>


                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                    </table>

                                    </div>

                                     <h4><b>GOOD RECEIVED  :</b></h4>

                                    <div style="overflow-x:auto;" >
                                    <table class="table table-striped table-bordered table-hover">
                                      <thead>
                                          <tr>
                                              <td><b>REF NO</b></td>
                                              <td><b>Supplier Code</b></td>
                                              <td><b>GR Date</b></td>
                                              <td><b>Quantity Recieved</b></td>
                                              <td><b>Net Unit Price</b></td>
                                          </tr>
                                      </thead>

                                      <tbody>

                                      <?php if($gr_details)
                                      {
                                       foreach($gr_details as $j): ?>

                                          <tr>
                                            <td><?php echo $j["refno"]; ?></td>
                                          
                                            <td><?php echo $j["supcode"]; ?></td>

                                            <td><?php echo $j["grdate"]; ?></td>
                                          
                                            <td><?php echo $j["qty_received"]; ?></td>
                                          
                                            <td><?php echo $j["netunitprice"]; ?></td>
                                          </tr>
                                     
                                      <?php 
                                      endforeach;
                                      }
                                      else
                                      {
                                      ?>
                                           <tr>
                                              <td colspan="6" style="text-align:center;">No Data Found</td>
                                          </tr>


                                      <?php
                                      }
                                      ?>

                                      </tbody>
                                    </table>
                                    </div>

                                </div>

                                <?php } ?>

                                <div class="tab-pane" id="panel-itemlink">
                                  <br class="break" />

                                    <div style="overflow-x:auto;" >
                                     <table id="myTable" class="tablesorter table table-striped table-bordered table-hovers">
                                        <thead style="cursor:s-resize">
                                          <tr>
                                        
                                            <th style="text-align:center;">Item Code</th>
                                            <th style="text-align:center;">Price</th>
                                            <th style="text-align:center;">Pack Size</th>
                                            <th style="text-align:center;">QOH</th>
                                            <th style="text-align:center;">Total QOH</th>
                                            <th style="text-align:center;">Description</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                              foreach ($itemlink->result() as $row)
                                              {
                                                  ?>
                                                  <tr>
                                                    <td style="text-align:center;font-size: 12px"><?php echo $row->itemcode; ?></td>
                                                    <td style="text-align:center;font-size: 12px"><?php echo $row->sellingprice; ?></td>
                                                    <td style="text-align:center;font-size: 12px"><?php echo $row->packsize; ?></td>
                                                    <td style="text-align:center;font-size: 12px"><?php echo $row->onhandqty; ?></td>
                                                    <td style="text-align:center;font-size: 12px"><?php echo $row->psqoh; ?></td>
                                                    <td style="text-align:center;font-size: 12px"><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                                                  </tr>
                                                  <?php
                                              }
                                          ?> 
                                        </tbody>
                                      </table>
                                    </div>

                                </div>

                                <div class="tab-pane <?php echo $active_propose_price?>" id="panel-purposeprice">

                                  <br>
                                  <b class="font"><?php echo convert_to_chinese($p['Description'], "UTF-8", "GB-18030"); ?></b>
                                      <br class="break" />
                                      <table>
                                      <font style="display:inline-block;margin-right:9px">
                                      
                                      <tr>
                                        <td>
                                        <b>Item Code :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['itemcode']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Barcode :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['Barcode']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Tax Code :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_purchase']; ?> / <?php echo $p['tax_code_supply']; ?></b>
                                        </td>
                                      </tr>
                                      <!-- <tr>
                                        <td>
                                        <b>Tax Code Purchase:</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_purchase']; ?></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Tax Code Supply :</b>
                                        </td>
                                        <td>
                                        <b><?php echo $p['tax_code_supply']; ?></b>
                                        </td>
                                      </tr> -->
                                      </font>
                                      </table>

                                    <table >
                                      <?php
                                      if($_SESSION['show_cost'] == '1')
                                      {
                                        ?>
                                        <form action="<?php echo site_url('PcheckerCost_controller/save_propose_price')?>?propose_price=1" method="POST">
                                        <?php
                                      }
                                      else
                                      {
                                        ?>
                                        <form action="<?php echo site_url('Pchecker_controller/save_propose_price')?>?propose_price=1" method="POST">
                                        <?php
                                      }
                                      ?>
                                      
                                      <font style="display:inline-block;margin-right:9px">
                                      <th></th>
                                      <th style="color: blue">Current</th>
                                      <th style="color: blue">Propose</th>
                                      <th style="color: blue"></th>
                                      <th style="color: blue"></th>
                                      <tr>
                                        <td style="width:220px;font-size:16px">
                                        <b>Selling Price <br>(inc tax) :</b>
                                        </td>
                                        <td style="width:150px;">
                                        <b> RM </b><span class="prices"><?php echo $p['price_include_tax']; ?></span>
                                        </td>
                                        <!-- <td style="width:150px;">
                                        </td> -->
                                        <td style="width:150px;">
                                          <input style="width:80px;" type="number" step="any" id="inctax1" onchange="SetTaxInc(this)" name="price_include_tax" class="form-control" >
                                          <input type="hidden"  name="ori_price_include_tax" class="form-control" value="<?php echo $p['price_include_tax']; ?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:220px;font-size:16px">
                                        <b>Selling Price <br> (exc tax) :</b>
                                        </td>
                                        <td style="width:150px;">
                                        <b> RM </b><span class="prices"><?php echo $p['sellingprice']; ?></span>
                                        </td>
                                        <!-- <td style="width:150px;">
                                        </td> -->
                                        <td style="width:150px;">
                                          <input style="width:80px;" type="number" id="exctax1" onchange="SetExcInc(this)" name="price_exc_tax" step="any" class="form-control" >
                                          <input type="hidden"  name="ori_price_exc_tax" class="form-control" value="<?php echo $p['sellingprice']; ?>">
                                        </td>
                                      </tr>
                                      <?php 
                                        if ($_SESSION['show_cost'] == '1')
                                        {
                                      ?>
                                      <tr>
                                        <td>
                                        <b>Average Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p['averagecost']; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p['avg_profit']; ?></b>
                                        </td>
                                        
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Last Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["lastcost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["last_profit"]; ?></b>
                                        </td>
                                        
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>Listed Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["stdcost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["std_profit"]; ?></b>
                                        </td>
                                        
                                      </tr>
                                      <tr>
                                        <td>
                                        <b>FIFO Cost :</b>
                                        </td>
                                        <td style="width:150px;font-size:16px">
                                        <b> RM </b><?php echo $p["fifocost"]; ?>
                                        </td>
                                        <td>
                                        <b><?php echo $p["fifo_profit"]; ?></b>
                                        </td>
                                        
                                      </tr>

                                      <?php }
                                       ?>
                                      </font>
                                      
                                    </table>
                                    <br>
                                    <button style="float: right" value="go" name="go" type="submit" class="btn btn-success btn-xs">
                                            <b>SAVE</b></a></button>
                                          </form>
                                </div>

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


    <script>
    function SetTaxInc() {
      var v1 = document.getElementById("inctax1").value;
      var tax = v1 * (6/100).toFixed(2);
      var inctax = parseFloat(v1) - parseFloat(tax);
        document.getElementById("exctax1").value  = inctax.toFixed(2);
    }
    </script>

    <script>
    function SetExcInc() {
      var v1 = document.getElementById("exctax1").value;
      var tax = v1 * (6/100).toFixed(2);
      var inctax = parseFloat(v1) + parseFloat(tax);
        document.getElementById("inctax1").value  = inctax.toFixed(2);
    }
    </script>