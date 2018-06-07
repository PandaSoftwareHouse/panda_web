<html>
<body>
<div class="container">        
                        
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>STOCK REQUEST</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/scanbarcodeview')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<br>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scanbarcode'); ?>">
<label>Item Barcode</label><br>
<input type="text" placeholder="Item Barcode" class="form-control input-md" name="barcode" style="background-color:#E6fff2" required />
</form>

                            <table width="200" class="cTable">
                                <thead>
                                    <tr>
                                        <td class="cTD"><b>Item Code</b></td>
                                        <td class="cTD"><b>Description</b></td>
                                        <td class="cTD"><b>Item Link</b></td> 
                                        <td class="cTD" style="text-align:center;"><b>Pack<br> Size</b></td>                                        
                                        <td class="cTD" style="text-align:center;"><b>Qty On<br> Hand</b></td>
                                        <td class="cTD" style="text-align:center;"><b>Qty<br> Request</b></td>
                                        <td class="cTD" style="text-align:center;"><b>Bulk<br> Qty</b></td>
                                    </tr>
                                </thead>
                                <?php
                                if($h->num_rows() != 0)
                                {
                                    foreach ($h->result() as $row)
                                    {
                                    $_SESSION['Itemcode'] = $row->Itemcode;
                                    $_SESSION['ItemLink'] = $row->ItemLink;
                                    $_SESSION['Description'] = $row->Description;
                                    $_SESSION['OnHandQty'] = $row->OnHandQty;
                                ?>   
                                <tbody>
                                    <tr>
                                      <td class="cTD"><?php echo $row->Itemcode; ?></td>
                                      <td class="cTD"><?php echo $row->Description; ?></td>
                                      <td class="cTD"><?php echo $row->ItemLink; ?></td>
                                      <td class="cTD" style="text-align:center;"><?php echo $row->PackSize; ?></td>
                                      <td class="cTD" style="text-align:center;"><?php echo round($row->OnHandQty, 2) ; ?></td>
                                <form class="form-inline" role="form" method="POST" id="myForm" 
                                action="<?php echo site_url('pandarequest_controller/add_requestWinCE')?>">
                                      <td class="cTD" style="text-align:center;width:80px">
                                        <input class="form-control input-md" type="number" name="qty_request[]" value="" 
                                        style="text-align:center;width:70px;background-color:#E6fff2"
                                        required></td>

                                    <td class="cTD" style="text-align:center;"><?php echo $row->BulkQty; ?></td>
                                    </tr>
                                </tbody>
                                <input type="hidden" name="PackSize[]" value="<?php echo  $row->PackSize ?>" />
                                <input type="hidden" name="BulkQty[]" value="<?php echo  $row->BulkQty ?>" />
                                <input type="hidden" name="Itemcode[]" value="<?php echo  $row->Itemcode ?>" />
                                <input type="hidden" name="ItemLink[]" value="<?php echo $row->ItemLink ?>" />
                                <input type="hidden" name="Description[]" value="<?php echo $row->Description ?>" />
                                <input type="hidden" name="OnHandQty[]" value="<?php echo $row->OnHandQty; ?>" /> 
                                <?php
                                    }
                                }
                                else
                                    {
                                        ?>
                                        <tbody>
                                            <tr>
                                            <td colspan="7" style="text-align:center;">No Item Found</td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            
                                        }

                                ?>
                                </table>
                                 <?php foreach ($guid->result() as $row)
                                    {
                                    $_SESSION['guid'] = $row->Trans_ID;
                                    } 
                                ?>   
                                    <input type="hidden" name="guid[]" value="<?php echo $_SESSION["guid"] ?>" style="text-align:center;width:80px;" max="100000"/> 

                                    <?php 
                                    foreach ($h1->result() as $row)
                                    {
                                        //$_SESSION['Itemcode1'] = $row->Itemcode;
                                        //$_SESSION['ItemLink1'] = $row->ItemLink;
                                        //$_SESSION['Description1'] = $row->Description;
                                        //$_SESSION['OnHandQty1'] = $row->OnHandQty;
                                    ?>
                                    <input type="hidden" name="Itemcode1" value="<?php echo $row->Itemcode; ?>"/>
                                    <input type="hidden" name="ItemLink1" value="<?php echo $row->ItemLink; ?>"/>
                                    <input type="hidden" name="Description1" value="<?php echo $row->Description; ?>"/>
                                    <input type="hidden" name="OnHandQty1" value="<?php echo $row->OnHandQty; ?>"/>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    foreach ($qty_balance->result() as $row)
                                    {
                                        ?>
                                        <p><b>Qty Balance: <?php echo $row->qty_balance;?></p><br/>
                                        <input type="hidden" name="qty_balance" value="<?php echo $row->qty_balance; ?>"/>
                                        <input type="hidden" name="qty_requested" value="<?php echo $row->qty_request; ?>"/>
                                        <?php
                                    }
                                    ?>
                                    <input type="submit" name="add" class="btn_primary" value="ADD">
                                    &nbsp;&nbsp;
                                    <input type="submit" name="go" class="btn_success1" value="DONE">
                                    
                                </form>

                            </div>
                            <p>&nbsp;</p>
                            </body></html>