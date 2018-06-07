<html>
<body>
<div class="container">
    <table width="200" border="0">
      <tr>
        <td width="120"><h4><b>Sales Order</b></h4></td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
    <a href="<?php echo site_url('SO_controller/search_supcus');?>" class="btn_primary">+ ADD SUPPLIER</a><br><br><b>Total Records:</b><?php echo $so->num_rows();?>
 <table width="220" class="cTable">
        <thead>
            <tr align="center">
                <td class="cTD"><p>Sup Code</p></td>
                <td class="cTD"><p>Sup Name</p></td>
                <td class="cTD"><p>Bill Amt</p></td>
                <td class="cTD"><p>Crt By</p></td>
                <td class="cTD"><p>Date</p></td>
            </tr>
        </thead>
        <tbody>
          <?php
                 foreach ($so->result() as $row)
                    {
          ?>
                    <tr align="center">
                        <td class="cTD"><?php echo $row->acc_code; ?></td>
                        <td class="cTD"><a href="<?php echo site_url('SO_controller/item_in_so')?>?web_guid=<?php echo $row->web_guid; ?>"><?php echo $row->acc_name; ?></a></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->bill_amt; ?></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->created_by; ?></td>
                        <td class="cTD" style="text-align:center;"><?php echo $row->created_at; ?></td>
                    </tr>
          <?php
                    }
          ?> 

        </tbody>
    </table>
    
</div>
</body>
</html>