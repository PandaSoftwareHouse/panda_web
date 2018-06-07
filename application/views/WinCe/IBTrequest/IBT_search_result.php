<html>
<body>
 <div class="container">
   <table width="200" border="0">
  <tr>
    <td width="120"><h5><b>IBT REQUEST</b></h5></td>
    <td width="20"><a href="<?php echo site_url('IBT_controller/main'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<table width="200" border="0">
    <tr>
        <td width="110">
            <form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('IBT_controller/search_result'); ?>">
         <label>Search By</label><br>   
         <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="supname"  id="autofocus" required autofocus onblur="this.focus()" />     
            </form>
        </td>
    </tr>
    
</table>
<table width="200" border="0" class="cTable">
   <thead>
          <tr>
              <td class="cTD" colspan="2"><b>Branch Name</b></td>
          </tr>
   </thead>
      <?php                      
          if($branchname->num_rows() != 0)
          {
              foreach ($branchname->result() as $row)
              {  
      ?>             
    <tbody>
          <tr>
              <td  class="cTD"><?php echo $row->dname; ?></td>
              <td style="text-align:center"  class="cTD">
                  <a id="btn" value="add" name="add" class="btn_primary" href="<?php echo site_url('IBT_controller/add_trans')?>?supcode=<?php echo $row->CODE; ?>&supname=<?php echo $row->NAME; ?>">+</a>
              </td>
                    <input type="hidden" name="brchcode" value="<?php echo $row->CODE; ?>"/>
                    <input type="hidden" name="brchname" value="<?php echo $row->NAME; ?>"/>                 
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
                  <td colspan="5" style="text-align:center;"  class="cTD">No Supplier.</td>
                  </tr>
              </tbody>
              <?php
                                            
              }
      ?>
  </table>
  </div>
