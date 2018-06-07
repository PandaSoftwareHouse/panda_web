<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>STOCK PICK</b><br>
    </h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<br>
<table width="200" class="cTable">
    <thead>
        <tr>
            <td class="cTD">Trans Date</td>
            <td class="cTD">Created By</td>
            <td class="cTD">DocDate</td>
            <td class="cTD" style="text-align:center;"><b>Print</b></td>
        </tr>
    </thead>
    
    <?php
        if($transactions->num_rows() != 0)
        {
            foreach ($transactions->result() as $row)
        {  
    ?>        
    <tbody>
        <tr>
            <td class="cTD"><?php echo $row->Trans_Date; ?></td>
            <td class="cTD"><?php echo $row->Created_By; ?></td>
            <td class="cTD"><?php echo $row->DocDate; ?></td>
            <td class="cTD" style="text-align:center;">
            <a href="<?php echo site_url('pandarequest_controller/stock_view_item')?>?guidpost=<?php echo $row->Trans_ID; ?>" class="btn_info">VIEW</a></td>
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
                <td colspan="4" style="text-align:center;">No Request Transaction</td>
                </tr>
        </tbody>
    <?php
        }
    ?>
</table>
</div>
</body>
</html>