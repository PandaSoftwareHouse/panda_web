<body onload="document.refresh();">
<div class ="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>SKU INFO </b></h5></td>
    <td width="20"><a href="<?php echo site_url('Pchecker_controller/scan_result')?>?barcode=<?php echo $_SESSION['barcode']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form  role="form" method="POST" id="myForm" action="<?php 
                    if($_SESSION['show_cost'] == '1') 
                      {
                        echo site_url('PcheckerCost_controller/scan_result');
                        }
                        else
                        {
                          echo site_url('pchecker_controller/scan_result');
                          } ?>">
  <p>
    <label>Scan Barcode<br>
    </label>
    <input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="autofocus">
  </p>
</form>
<div class="panel-heading"><b>Item Details</b></div>
    <div class="panel-body">
<?php //echo var_dump($_SESSION);?>
<?php foreach($item_details as $p)
  {
?>
<h5><b class="font"><?php echo convert_to_chinese($p['Description'], "UTF-8", "GB-18030"); ?></b></h5>
<table border="0" style="width:250px;">
  <tr><td style="width:80px">Item Code :</td><td><b><?php echo $p['itemcode']; ?></b></td></tr>
  <tr><td style="width:80px">Barcode :</td><td><b><?php echo $p['Barcode']; ?></b></td></tr>
  <tr class="<?php echo $_SESSION['encode']?>"><td style="width:80px">Scan Barcode :</td><td><b><?php echo $_SESSION['encode_barcode']; ?></b></td></tr>
  <tr><td style="width:80px">Tax Code Purchase:</td><td><b><?php echo $p['tax_code_purchase']; ?></b></td></tr>
  <tr><td style="width:80px">Tax Code Supply :</td><td><b><?php echo $p['tax_code_supply']; ?></b></td></tr>
  <tr><td style="width:80px">Item Type :</td><td><b><?php echo $p['itemtype']; ?></td></tr>
  <tr class="<?php echo $_SESSION['encode']?>"><td style="width:80px">Weight / Amount :</td><td><b><?php echo $_SESSION['get_weight']; ?> <?php echo  $p['um']; ?> / RM <?php echo number_format($_SESSION['get_weight']*$p['sellingprice'],2); ?></td></tr>
  <tr><td style="width:80px">Selling Price (inc tax) :</td><td><b>RM <?php echo $p['price_include_tax']; ?></b></td></tr>
  <tr><td style="width:80px">Selling Price (exc tax) :</td><td><b>RM <?php echo $p['sellingprice']; ?></b></td></tr>
</table>

<?php if ($_SESSION['show_cost'] == '1') { ?>
<table border="0" style="width:180px;">
  <tr><td style="width:80px">Average Cost :</td><td><b>RM <?php echo $p['averagecost']; ?></b> <b style="color: blue;"> <?php echo $p['avg_profit']; ?></b></td></tr>
  <tr><td style="width:80px">Last Cost :</td><td><b>RM <?php echo $p["lastcost"]; ?></b> <b style="color: blue;"> <?php echo $p["last_profit"]; ?></b></td></tr>
  <tr><td style="width:80px">Listed Cost :</td><td><b>RM <?php echo $p["stdcost"]; ?></b> <b style="color: blue;"> <?php echo $p["std_profit"]; ?></b></td></tr>
  <tr><td style="width:80px">FIFO Cost :</td><td><b>RM <?php echo $p["fifocost"]; ?></b> <b style="color: blue;"><?php echo $p["fifo_profit"]; ?></b></td></tr>
</table>
<?php } ?>

<?php
  }
?>
<br>
<?php foreach($item_qoh as $i): ?>

<table border="0" style="width:180px;">
  <tr><td style="width:80px">All P/S QOH :</td><td><b><?php echo $i["qoh"]; ?></b></td></tr>
</table>   
<?php endforeach;?>
<br>
<br>
<?php foreach($item_qoh_c as $k): ?>

<table border="0" style="width:180px;" class="cTable">
  <tr><td style="width:80px">Min. Date :</td><td><b><?php echo $k["min_date"]; ?></b></td></tr>
  <tr><td style="width:80px">Max. Date :</td><td><b><?php echo $k["max_date"]; ?></b></td></tr>
  <tr><td style="width:80px">ADS :</td><td><b><?php echo $k["ads"]; ?></b></td></tr>
  <tr><td style="width:80px">AWS :</td><td><b><?php echo $k["aws"]; ?></b></td></tr>
  <tr><td style="width:80px">AMS :</td><td><b><?php echo $k["ams"]; ?></b></td></tr>
  <tr><td style="width:80px">DOH :</td><td><b><?php echo $k["doh"]; ?></b></td></tr>
</table>                                
                                      
<?php endforeach;?>
    </div>



<div class="panel-heading"><b>Promotion</b></div>
    <div class="panel-body">
      <table class="cTable">
        <thead>
            <tr>
                <td class="cTD" ><b>REF NO</b></td>
                <td class="cTD" ><b>Date From</b></td>
                <td class="cTD" ><b>Date To</b></td>
                <td class="cTD" ><b>Outlet</b></td>
                <td class="cTD" ><b>Card Type</b></td>
                <td class="cTD" ><b>Price (Before Discount)</b></td>
                <td class="cTD" ><b>Discount</b></td>
                <td class="cTD" ><b>Price Net</b></td>
                <td class="cTD" ><b>Promo Type</b></td>
            </tr>
        </thead>
        <tbody>
          <?php if($item_promo)
            {
              foreach($item_promo as $j):
          ?>
          <tr>
            <td class="cTD"><?php echo $j["refno"]; ?></td>
            <td class="cTD"><?php echo $j["datefrom"]; ?></td>                                        
            <td class="cTD"><?php echo $j["dateto"]; ?></td>                                        
            <td class="cTD"><?php echo $j["loc_group"]; ?></td>
            <td class="cTD"><?php echo $j["cardtype"]; ?></td>
            <td class="cTD"><?php echo $j["price_target"]; ?></td>                                        
            <td class="cTD"><?php echo $j["discount"]; ?></td>                                        
            <td class="cTD"><?php echo $j["price_net"]; ?></td>
            <td class="cTD"><?php echo $j["promo_type"]; ?></td>                                          
          </tr>
            <?php 
              endforeach;
              }
              else
              {           
            ?>
            <tr>
              <td class="cTD" colspan="9" style="text-align:center;">No Data Found</td>
            </tr>
              <?php
                }
              ?>  
        </tbody>
      </table>
    </div>
<?php if ($_SESSION['show_cost'] == '1') { ?>
<div class="panel-heading"><b>Purchase Details</b></div>    
  <div class="panel-body">

  <h5><b>PURCHASE ORDER  :</b></h5>
                                    
  <table class="cTable">
  <thead>
      <tr>
          <td class="cTD"><b>REF NO</b></td>
          <td class="cTD"><b>Supplier Code</b></td>
          <td class="cTD"><b>PO Date</b></td>
          <td class="cTD"><b>Quantity</b></td>
          <td class="cTD"><b>Deliver Date</b></td>
          <td class="cTD"><b>Expiry Date</b></td>
      </tr>
  </thead>
  <tbody>
  <?php if($po_details)
  {
    foreach($po_details as $m): ?>
  <tr>
    <td class="cTD"><?php echo $m["refno"]; ?></td>                                
    <td class="cTD"><?php echo $m["supcode"]; ?></td>     
    <td class="cTD"><?php echo $m["podate"]; ?></td>
    <td class="cTD"><?php echo $m["qty_order"]; ?></td>
    <td class="cTD"><?php echo $m["deliverdate"]; ?></td>
    <td class="cTD"><?php echo $m["expiry_date"]; ?></td>
  </tr> 
  <?php
  endforeach;
    }
  else
    {
  ?>
    <tr>
      <td class="cTD" colspan="6" style="text-align:center;">No Data Found</td>
    </tr>
  <?php
    }
  ?>
</tbody>
</table>

<h5><b>GOOD RECEIVED  :</b></h5>
<table class="cTable">
<thead>
    <tr>
        <td class="cTD"><b>REF NO</b></td>
        <td class="cTD"><b>Supplier Code</b></td>
        <td class="cTD"><b>GR Date</b></td>
        <td class="cTD"><b>Quantity Recieved</b></td>
        <td class="cTD"><b>Net Unit Price</b></td>
    </tr>
</thead>

<tbody>

<?php if($gr_details)
{
  foreach($gr_details as $j): ?>

    <tr>
      <td class="cTD"><?php echo $j["refno"]; ?></td>                                          
      <td class="cTD"><?php echo $j["supcode"]; ?></td>
      <td class="cTD"><?php echo $j["grdate"]; ?></td>                                          
      <td class="cTD"><?php echo $j["qty_received"]; ?></td>                                          
      <td class="cTD"><?php echo $j["netunitprice"]; ?></td>
    </tr>
                                     
<?php 
endforeach;
}
else
{
?>
      <tr>
        <td colspan="6" class="cTD" style="text-align:center;">No Data Found</td>
    </tr>
<?php
}
?>

</tbody>
</table>
    
</div>
<?php } ?>

<div class="panel-heading"><b>Item Link</b></div>
    <div class="panel-body">
      <table class="cTable">
        <thead>
            <tr>
                <td class="cTD" ><b>Itemcode</b></td>
                <td class="cTD" ><b>Price</b></td>
                <td class="cTD" ><b>Pack Size</b></td>
                <td class="cTD" ><b>QOH</b></td>
                <td class="cTD" ><b>Total QOH</b></td>
                <td class="cTD" ><b>Description</b></td>
            </tr>
        </thead>
        <tbody>
          <?php
            foreach ($itemlink->result() as $row)
            {
          ?>
          <tr>
            <td class="cTD"><?php echo $row->itemcode; ?></td>
            <td class="cTD"><?php echo $row->sellingprice; ?></td>                                        
            <td class="cTD"><center><?php echo $row->packsize; ?></center></td>
            <td class="cTD"><?php echo $row->onhandqty; ?></td>  
            <td class="cTD"><?php echo $row->psqoh; ?></td>  
            <td class="cTD"><?php echo $row->description; ?></td>                                 
          </tr>
              <?php
                }
              ?>  
        </tbody>
      </table>
    </div>

<div class="panel-heading"><b>Purpose Price</b></div>
    <div class="panel-body">
      <h5><b class="font"><?php echo $p['Description']; ?></b></h5>
  <table border="0" style="width:180px;">
    <tr><td style="width:80px">Item Code :</td><td><b><?php echo $p['itemcode']; ?></b></td></tr>
    <tr><td style="width:80px">Barcode :</td><td><b><?php echo $p['Barcode']; ?></b></td></tr>
    <tr><td style="width:80px">Tax Code Purchase:</td><td><b><?php echo $p['tax_code_purchase']; ?></b></td></tr>
    <tr><td style="width:80px">Tax Code Supply :</td><td><b><?php echo $p['tax_code_supply']; ?></b></td></tr>
  </table>

    <table border="0" style="width:200px;" >
    <?php if($_SESSION['show_cost'] == '1') { ?>
      <form action="<?php echo site_url('PcheckerCost_controller/save_propose_price')?>?propose_price=1" method="POST">
    <?php } else { ?>
      <form action="<?php echo site_url('Pchecker_controller/save_propose_price')?>?propose_price=1" method="POST">
    <?php } ?>
    
    <th></th>
    <th style="color: blue">Current</th>
    <th style="color: blue">Propose</th>
    <th style="color: blue"></th>
    <th style="color: blue"></th>
    <tr>
      <td style="width:120px"><b>Selling Price <br>(inc tax) :</b></td>
      <td style="width:80px"><b> RM </b><?php echo $p['price_include_tax']; ?></td>
      <td><input style="width:80px;" type="number" step="any" id="inctax1" onchange="SetTaxInc(this)" name="price_include_tax" class="form-control" >
        <input type="hidden"  name="ori_price_include_tax" class="form-control" value="<?php echo $p['price_include_tax']; ?>">
      </td>
    </tr>
    <tr>
    <td style="width:80px"><b>Selling Price <br> (exc tax) :</b></td>
    <td style="width:80px"><b> RM </b><span class="prices"><?php echo $p['sellingprice']; ?></span></td>
    <td><input style="width:80px;" type="number" id="exctax1" onchange="SetExcInc(this)" name="price_exc_tax" step="any" class="form-control" >
      <input type="hidden"  name="ori_price_exc_tax" class="form-control" value="<?php echo $p['sellingprice']; ?>">
      </td>
    </tr>
    <?php if ($_SESSION['show_cost'] == '1') { ?>
    <tr>
      <td style="width:120px"><b>Average Cost :</b></td>
      <td style="width:80px"><b> RM </b><?php echo $p['averagecost']; ?></td> 
      <td><b><?php echo $p['avg_profit']; ?></b></td>
    </tr>
    <tr>
      <td style="width:120px"><b>Last Cost :</b></td>
      <td style="width:80px"><b> RM </b><?php echo $p["lastcost"]; ?></td> <td><b><?php echo $p["last_profit"]; ?></b></td>
    </tr>
    <tr>
      <td style="width:120px"><b>Listed Cost :</b></td>
      <td style="width:80px"><b> RM </b><?php echo $p["stdcost"]; ?></td> <td><b><?php echo $p["std_profit"]; ?></b></td>
    </tr>
    <tr>
      <td style="width:120px"><b>FIFO Cost :</b></td>
      <td style="width:80px"><b> RM </b><?php echo $p["fifocost"]; ?></td> <td><b><?php echo $p["fifo_profit"]; ?></b></td>
    </tr>
    <?php } ?>

    <button style="float: right" value="go" name="go" type="submit" class="btn btn-success btn-xs">
     <b>SAVE</b></a></button>
    </form>
    </table>
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