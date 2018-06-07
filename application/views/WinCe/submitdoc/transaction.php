<html>
<body>
<div class="container">
  <table width="200" border="0">
      <tr>
        <td width="150"><h5><b>SUBMISSION LIST<b></h5></td>
        <td width="20"><a href="<?php echo site_url('logout_c/logout')?>"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></td>
      </tr>
    </table>
    <p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
        <p><b>User ID :</b><?php echo $_SESSION['userid']?></p>
        <p>
        <a href='<?php echo site_url('submitdoc_controller/insertMain')?>' class="btn_primary">+</a>
        </p>
        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        <br>
        <table width="200" class="cTable" >
          <thead>
                <tr>
                  <td class="cTD">Ref No</td>
                  <td class="cTD">Create_at</td>
                  <td class="cTD">Create_by</td>
                  <!-- <td>Print</td> -->
                </tr>
          </thead>

            <?php
                                      
              if($result->num_rows() != 0)
              foreach ($result->result() as $row)
              {  
            ?>        

          <tbody>   
              <tr align="center">
                <td class="cTD">
                <a href="<?php echo site_url('submitdoc_controller/transaction_result')?>?guid=<?php echo $row->sl_guid?>"><?php echo $row->refno; ?>
               <!--    <?php 
                    if($row->send_print == '1')
                    {
                    ?>
                        <!-- <button disabled class="dbtnprint">
                        <a href="<?php echo site_url('submitdoc_controller/send_print')?>?guid=<?php echo $row->sl_guid?>&refno=<?php echo $row->refno?>">Print</a>
                        </button> 

                  <?php
                    }
                    else
                    {
                      ?>
                        <a href="<?php echo site_url('submitdoc_controller/send_print')?>?guid=<?php echo $row->sl_guid?>&refno=<?php echo $row->refno?>" class="btnprint" style="float:right;">Print</a>
                      <?php
                    }
                  ?> -->

                </td>
                <td class="cTD"><?php echo $row->created_at; ?></td>
                <td class="cTD"><?php echo $row->created_by; ?></td>
              <!--   <td>
                  <?php
                     if($row->send_print == '1')
                        {
                  ?>
                      <center><img src="<?php echo base_url('assets/icons/checked.jpg');?>"></center>
                      <?php
                          }
                    else
                          {
                      ?>
                        <center><img src="<?php echo base_url('assets/icons/cancel.jpg');?>"></center>
                      <?php
                         }
                    ?>
                </td> -->
              </tr>
          </tbody> 

           <?php
                }   
                 else
                  {
                  ?>
          <tbody>
               <tr>
                  <td colspan="3" class="cTD">No Record Found</td>
                   </tr>
          </tbody>
          <?php
              }
          ?>
        </table>
</div>
</body>
</html>