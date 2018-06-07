<html>
<body>
<div class="container">
    <table width="200" border="0">
      <tr>
        <td width="120"><h5><b>IBT REQUEST </b></h5></td>
        <td width="20"><a href="<?php echo site_url('main_controller/home')?>"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a>
        </td>
        <td width="5">&nbsp;</td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a>
        </td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
    <p><a href="<?php echo site_url('IBT_controller/search_branch');?>" class="btn_primary">+ ADD SUPPLIER</a>
     <br><b>Total Records:</b><?php echo $IBT->num_rows();?></p>
    <table width="200" class="cTable" >
    <thead>
      <tr align="center">
        <td class="cTD">Branch Code</td>
        <td class="cTD">Branch Name</td>
        <td class="cTD">Bill Amt</td>
        <td class="cTD">Create by</td>
        <td class="cTD">Date</td>
      </tr>
    </thead>
      <tbody>
        <?php
          foreach ($IBT->result() as $row)
           {  
        ?>                               
          <tr align="center">
            <td class="cTD"><?php echo $row->acc_code; ?></td>
            <td class="cTD"><a href="<?php echo site_url('IBT_controller/item_in_IBT')?>?web_guid=<?php echo $row->web_guid; ?>"><?php echo $row->acc_name; ?></a></td>
            <td class="cTD"><?php echo $row->bill_amt; ?></td>
            <td class="cTD"><?php echo $row->created_by; ?></td>
            <td class="cTD"><?php echo $row->created_at; ?></td>
          </tr>

          <?php
            }
          ?>  
      </tbody>
    </table>
<p>&nbsp;</p>    
</div>
</body>
</html>
