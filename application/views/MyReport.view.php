<?php
    
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\Areachart;
    use \koolreport\widgets\google\ColumnChart;
    use \koolreport\widgets\google\PieChart;
?>
<html>
    <script>
            function myFunction() 
            {
                window.print();
            }

    </script>
    <style>
        .color 
        {
            background-color:#b3ffcc;
            text-align:center;
        }
        .col-color
        {
            background-color:#ffe0b3;
        }
        .tfcolor
        {
            background-color:#e6ffee;
        }

    </style>
    <head>
        <title>Supplier Doc Registration</title>
    </head>
    <body>
        <!-- <div class='row kreport-title'> -->
        <h3><center><strong>Supplier Doc Registration</strong></center></h3>
        <!-- </div> -->
        <hr>
    <div class="container-fluid">
        <!-- <b>
            <?php echo $company; ?> 
        </b> -->
        <button onclick="myFunction()" class="button button4" style="float:right;background-color: #e7e7e7; color: black;">Print</button>
    </div>
    <br>
        
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <center>
        <?php 
            Table::create(array(
                "dataStore"=>$this->dataStore('attendance'),
                "columns"=>array(
                    /*"product"=>array(
                        "label"=>"Product Name"*/
                    ),
                    /*"sale_amount"=>array(
                        "type"=>"number",
                        "label"=>"Sale Amount",
                        "prefix"=>"$"
                    )*/
                
                "cssClass"=>array(
                    "table"=>"table table-bordered"
                )
            ));
        ?>  
        </center>
        </div>
    </div>
</div>

    </body>
</html>