<?php

use \koolreport\processes\ColumnMeta;
use \koolreport\processes\DateTimeFormat;
use \koolreport\processes\RemoveColumn;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\OnlyColumn;
use \koolreport\processes\CopyColumn;
use \koolreport\processes\ColumnsSort;
use \koolreport\processes\Group;
use \koolreport\processes\AggregatedColumn;

require APPPATH."/libraries/koolreport/autoload.php";
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\clients\Bootstrap;
    function settings()  //databases setting
    {
        return array(
            "assets"=>array(
                "path"=>"../../assets",
                "url"=> base_url('assets'),
                /*"url"=>"http://localhost/panda_web/assets",*/
            ),
            "dataSources"=>array(
                "a"=>array(  //connect to database 1
                    "connectionString"=>"mysql:host=localhost;dbname=backend_warehouse",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                )
            )
        );
    }

    function setup()  //data processing
    {
        $this->src('a')  //get data source from database 1
        ->query("SELECT CODE, Suppliers, RefNo AS `Reference No`, Amount, GST, Remark, Created_at AS `Created At`,Created_by AS `Created By`, Updated_at AS `Updated At`, Updated_by AS `Updated By` FROM backend_warehouse.attendance; ")
        /*->params(array(
            '@EDateTo'=>$this->params["dateto"],
            '@EDateFrom'=>$this->params["datefrom"],
            '@ECode1'=>$this->params["level1"]))*/
        ->pipe($this->dataStore("attendance"));
    }

}