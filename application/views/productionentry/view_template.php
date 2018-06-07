<?php 
'session_start()' 
?>
<style>

#poDetails, #promoDetails {
  display: none;
}


b .font {
    font-size: 90px;
}

td {
  font-size:12px;
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
  h3 {
    font-size: 20px;  
  }
  h6,td.big {
    font-size: 10px;
  }
  td.big {
    font-size: 12px;
  }
  font{
    font-size: 16px;
  }
  h1.page-head-line{
    font-size: 25px;
  }
  input[type="number"] {
    width: 45px;
  }
}

</style>

<script type="text/javascript">

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);

function check()
{
    var answer=confirm("Confirm want to delete item ?");
    return answer;
}

</script>
<!--onload Init-->
<body>
    <div id="wrapper">
        
        <div id="page-inner">
        <div class="fixed">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="page-head-line">
                        <a href="<?php echo site_url('logout_c/logout')?>" style="float:right">
                        <i class="fa fa-sign-out" style="color:#4380B8"></i></a>
                        
                        <a href="<?php echo site_url('main_controller/home')?>" style="float:right">
                        <i class="fa fa-home" style="color:#4380B8;margin-right:20px"></i></a>
                        
                          <?php if($button_name == 'Submit')
                          { ?>

                            <a href="<?php echo site_url('Productionentry_controller/select_template')?>" style="float:right" >

                          <?php }
                          else
                          { ?>

                            <a href="<?php echo site_url('Productionentry_controller/template')?>" style="float:right" >

                          <?php } ?>

                        <i class="fa fa-arrow-left" style="color:#4380B8;margin-right:20px"></i></a>
                        <font><?php echo $title; ?>
                        <br><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small>
                        </font>
                    
                    </h1>
                        <!--<h1 class="page-subhead-line"></h1>-->
                </div>
            </div>
        </div>

        <?php
        if($this->session->userdata('message'))
        {
           echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; 
        }
        ?>

        <?php if($button_name == 'Update')
        { ?>

          <div style="float:right;">
            <a href="<?php echo site_url('Productionentry_controller/post_template'); ?>?guid=<?php echo $guid; ?>"> <button type="button" title="Post" id="post" class="btn btn-default btn-sm" style="background-color:#4380B8;color:white;" onclick="return confirm('Are you sure want to post this item?')" onSubmit="window.location.reload()"><span style="color:white;"></span><b> Post</b></button></a>
          </div>
          <br><br>

        <?php }; ?>

          <div style="float:right;">
            <button name="submit" class="btn btn-primary btn-xs" onclick="checkfield()"><?php echo $button_name; ?></button>
          </div>
          <br>

          <!-- /.box-header -->
          <div class="row">
          <div class="col-md-12">
          <div class="box-body">
            <form class="form-group" role="form" method="POST" id="myForm1" action="<?php echo site_url('Productionentry_controller/submit_template'); ?>?guid=<?php echo $guid; ?>">
            <div style="overflow-x:auto;">
            <div class="form-group col-md-3">
              <input type="hidden" name="method" value="<?php echo $method; ?>" />
                <label style="font-size:12px;">Location</label>
                <select id="location" name="location" class="form-control" >
                  <!-- <option disabled selected value> -- Select location -- </option> -->
                  <option value=""></option>
                  <?php foreach($location->result() as $row) 
                      { 
                  ?>
                      <option value="<?php echo $row->code ?>" 
                          <?php if($main->row('location') ==  $row->code) 
                              { 
                                echo "selected"; 
                              }
                              else { 
                                echo '' ;
                              }; 
                          ?>  
                        ><?php echo $row->code; echo " - "; echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?>
                          
                      </option>

                 <?php 

                      } 

                  ?>
                </select>

               
              </div>
            <table class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Item Code</th>
                <!-- <th style="width:100px">Description</th> -->
                <th>Description</th>
                <!-- <th style="width:120px">Unit Measurement</th> -->
                <th style="width:85px">Preset Quantity</th>
                <th style="width:85px">Batch</th>
                <th style="width:85px">Expected Quantity</th>
                <th style="width:85px">Actual Quantity</th>
                <th style="width:85px">Variance</th>
                <th style="width:200px">Reason</th>
              </tr>
              </thead>
              <tbody>

                <?php foreach($set_template_c->result() as $row)
                { ?>

                <tr class="test">
                  <td><?php echo $row->itemcode; ?></td>
                  <td><?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030"); ?></td>
                  <!-- <td><?php echo $row->um; ?></td> -->
                  <!-- <td><?php echo $row->preset_qty; ?></td> -->
                  

                  <input type="hidden" value="<?php echo $row->trans_guid_c; ?>" name="tgc[]" />

                  <td><input type="number" name="presetqty[]" placeholder="0" value="<?php echo $row->preset_qty; ?>" class="form-control input-sm presetqty" min="0" readonly /></td>

                  <td><input type="number" name="batch[]" step="0.01" id="myTextInput" 

                    <?php if(isset($edit) == 'done')
                    { 
                      echo "value= $row->batch";
                    }
                    else
                    {
                      echo "value='0'";
                    } ?> class="form-control input-sm batch" min="0" onClick="this.select();" onkeyup="IsEmpty();" />
                  </td>

                  <td><input type="number" name="expectedqty[]" placeholder="0" 

                    <?php if(isset($edit) == 'done')
                    { 
                      echo "value= $row->expected_qty";
                    }
                    else
                    {
                      echo "value=''";
                    } ?> class="form-control input-sm expectedqty" min="0" readonly></td>

                  <td><input type="number" name="quantity[]" step="0.01" 

                    <?php if(isset($edit) == 'done')
                    { 
                      echo "value= $row->actual_qty";
                    }
                    else
                    {
                      echo "value='0'";
                    } ?> class="form-control input-sm quantity" min="0" required onkeyup="IsEmpty()" /></td>

                  <td><input type="number" name="variance[]" placeholder="0" 

                    <?php if(isset($edit) == 'done')
                    { 
                      echo "value= $row->variance";
                    }
                    else
                    {
                      echo "value=''";
                    } ?> class="form-control input-sm variance" min="0" readonly /></td>
                  <td>
                    <select name="reason[]" class="form-control input-sm" style="width:300px">

                      <?php if(isset($row->reason))
                      { ?>

                        <option selected data-default style="display: none; " ><?php echo $row->reason?></option>

                      <?php }
                      else
                      { ?>

                        <option selected data-default style="display: none; " ></option>

                      <?php } 
                      foreach($set_master_code->result() as $row)
                      { ?>

                        <option value="<?php echo $row->CODE_DESC; ?>"><?php echo $row->CODE_DESC; ?></option>

                      <?php } ?>

                    </select>
                  </td>

                </tr>
                
                <?php } ?>
               
              </tbody>
                
            </table>
            </div>
           
            <!-- <input type="submit" name="submit" value="<?php echo $button_name; ?>" class="btn btn-primary btn-xs" style="float:right;" /> -->

            </form>

            <button name="submit" class="btn btn-primary btn-xs" style="float:right;" onclick="checkfield()"><?php echo $button_name; ?></button>

        </div>
        </div>
        </div>
        <!-- /.box -->

<script type="text/javascript">

  $(document).ready(function() {
    // if any of the qty or price inputs on the page change
    $(".presetqty, .batch").keyup(function() {
        // find parent TR of the input being changed
        var $row = $(this).closest('tr');

        var a = $row.find(".presetqty").val();
        var b = $row.find(".batch").val();
        var c = $row.find(".quantity").val();
        var r = $row.find(".expectedqty").val(a * b);
        var x = $row.find(".quantity").val(a * b);
        var y = $row.find(".variance").val(r - x);
    });
});

  // declare variable outside of loop
  var total = 0;

  // loop each table row with class .test
  $('.test').each(function() {
      var $row = $(this);
      var value = $row.find('.batch').val() * $row.find('.presetqty').val();
      total = total + value;
  });

  /*$('#gran').val(total);*/

</script>

<script type="text/javascript">

$(document).ready(function() {
    $(".quantity").keyup(function() {
        var grandTotal = 0;
        $("input[name='expectedqty[]']").each(function (index) {
            var expectedqty = $("input[name='expectedqty[]']").eq(index).val();
            var quantity = $("input[name='quantity[]']").eq(index).val();
            var output = parseFloat(expectedqty) - parseFloat(quantity);
            
            if (!isNaN(output)) {
        $("input[name='variance[]']").eq(index).val(output);
        /*grandTotal = parseInt(grandTotal) + parseInt(output);    
              $('#gran').val(grandTotal);*/
            }
        });
    });
});

</script>
<script language="JavaScript" type="text/javascript">
function IsEmpty(){
  if(document.forms['myForm1'].location.value === "")
  {
    alert("Location Cannot Be Empty! Please Select a location");
    return false;
  }
    return true;
}
</script>

<script type="text/javascript">

  $(document).ready(function() {
    var input = document.getElementById('myTextInput');
      input.focus();
      input.select();
  });

  inputs = $("table :input");
  $(inputs).keypress(function(e){
      if (e.keyCode == 13){
        inputs[inputs.index(this)+7].focus();
        inputs[inputs.index(this)+7].select();
      }
  });

</script>

<script type="text/javascript">
  function checkfield() {
    var location = document.getElementById('location').value;

    if(location == null || location == '')
    {
      alert('Please fill in location');
      return false;
    }
    else
    {
      $('#myForm1').submit();
    }
  }
</script>
