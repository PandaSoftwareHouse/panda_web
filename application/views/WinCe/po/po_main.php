<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>Purchase Order</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href="<?php echo site_url('PO_controller/search_sup');?>" class="btn_primary">+ ADD SUPPLIER</a><br><br><b>Total Records:</b><?php echo $po->num_rows();?>

    <table width="220" class="cTable" align="center">
        <thead>
            <tr>
                <th class="cTD">S/Code</th>
                <th class="cTD">S/Name</th>
                <th class="cTD"><center>Bill Amt</center></th>
                <th class="cTD"><center>Crt By</center></th>
                <th class="cTD"><center>Date</center></th>
            </tr>
        </thead>
        <tbody>
          <?php
                 foreach ($po->result() as $row)
                    {
          ?>
                    <tr>
                        <td class="cTD"><?php echo $row->acc_code; ?></td>
                        <td class="cTD"><a href="<?php echo site_url('PO_controller/item_in_po')?>?web_guid=<?php echo $row->web_guid; ?>&acc_code=<?php echo $row->acc_code ;?>"><?php echo $row->acc_name; ?></a></td>
                        <td style="text-align:center;" class="cTD"><?php echo $row->bill_amt_format; ?></td>
                        <td style="text-align:center;" class="cTD"><?php echo $row->created_by; ?></td>
                        <td style="text-align:center;" class="cTD"><?php echo $row->created_at; ?></td>
                    </tr>
          <?php
                    }
          ?> 

        </tbody>
    </table>
 </div>
</body>
</html>