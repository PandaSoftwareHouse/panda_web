<html>
<body>
<div class="container">
<table width="200" border="0">
      <tr>
        <td><h5><b>SUBMISSION LIST<b></h5></td>
        <td width="28"><a href="<?php echo site_url('submitdoc_controller/transaction')?>"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></td>
        <td width="28"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
        <p><b>User ID :</b><?php echo $_SESSION['userid']?> <br>
         <a href='<?php echo site_url('submitdoc_controller/menu')?>?guid=<?php echo $_REQUEST['guid']?>' class="btn_primary">+</a>
        </p>
        <table width="200" class="cTable">
            <thead>
                <tr>
                  <td class="cTD">Ref No</td>
                  <td class="cTD">Supplier</td>
                  <td class="cTD">Doc Type</td>
                  <td class="cTD">Total Inc Tax</td>
                  <td class="cTD">Create_at</td>
                  <td class="cTD">Create_by</td>
                  <td class="cTD">Print</td>
                </tr>
            </thead>    

                  <?php
                       if($result->num_rows() != 0)
                          {
                             foreach ($result->result() as $row)
                          {  
                  ?>        

            <tbody>
                <tr align="center">
                  <td class="cTD">
                      <?php echo $row->trans_refno; ?>
                          <a href="<?php echo site_url('submitdoc_controller/delete_child')?>?guid_c=<?php echo $row->sl_guid_c?>&trans_refno=<?php echo $row->trans_refno?>&sl_guid=<?php echo $row->sl_guid?>" style="float:right" onclick="return check();"><center><img src="<?php echo base_url('assets/icons/garbage.jpg');?>"></center></a>
                  </td>
                  
                  <td class="cTD"><?php echo $row->name; ?></td>
                  <td class="cTD"><?php echo $row->doc_type; ?></td>
                  <td class="cTD"><?php echo $row->total_include_tax; ?></td>
                  <td class="cTD"><?php echo $row->created_at; ?></td>
                  <td class="cTD"><?php echo $row->created_by; ?></td>
                  <td class="cTD">
                      <?php
                        if($row->send_print == '1')

                                            {
                                                ?>
                                                <img src="<?php echo base_url('assets/icons/checked.jpg');?>">
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <img src="<?php echo base_url('assets/icons/cancel.jpg');?>">
                                                <?php
                                            }
                                        ?>
                                        </td>
                                        
                                    </tr></td>
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
                                            <td class="cTD" colspan="7"><center>No Record Found</center></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }
                                ?>

        </table>
</div>        
</body>
</html>

