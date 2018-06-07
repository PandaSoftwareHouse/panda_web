USE `backend_warehouse`;
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='module_menu' AND `column_name` = 'parent_sequence')<> 1, "ALTER TABLE backend_warehouse.`module_menu` 
    ADD COLUMN `parent_sequence` INT(11)   NOT NULL AFTER `Sequence`", "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='module_menu' AND column_name = 'module_name' AND character_maximum_length = '30')<> 1, 
"ALTER TABLE backend_warehouse.`module_menu` 
    CHANGE `module_name` `module_name` VARCHAR(30)  COLLATE latin1_swedish_ci NULL AFTER `parent_name`", 
    "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='set_user_group_webmodule' AND column_name = 'module_name' AND character_maximum_length = '30')<> 1, 
"ALTER TABLE backend_warehouse.`set_user_group_webmodule` 
    CHANGE `module_name` `module_name` VARCHAR(30)  COLLATE latin1_swedish_ci NULL AFTER `user_group_guid`", 
    "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='module_menu' AND column_name = 'parent_name')<> 1, "ALTER TABLE backend_warehouse.`module_menu` 
    ADD COLUMN `parent_name` VARCHAR(25)  COLLATE latin1_swedish_ci NULL AFTER `parent_sequence` , 
    CHANGE `module_name` `module_name` VARCHAR(30)  COLLATE latin1_swedish_ci NULL AFTER `parent_name` , 
    CHANGE `module_link` `module_link` VARCHAR(100)  COLLATE latin1_swedish_ci NULL AFTER `module_name` , 
    CHANGE `hide_menu` `hide_menu` SMALLINT(6)   NULL DEFAULT 0 AFTER `module_link` , 
    ADD KEY `parent_sequence`(`parent_sequence`) , 
    DROP KEY `PRIMARY`, ADD PRIMARY KEY(`Sequence`,`parent_sequence`)", "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`module_menu` WHERE parent_name IS NULL AND hide_menu = '0' )> '0',
"UPDATE backend_warehouse.`module_menu` SET hide_menu = '1' WHERE parent_name IS NULL","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`module_menu` WHERE parent_name IS NULL)> '0',
"UPDATE backend_warehouse.`module_menu` SET sequence = sequence*-1 WHERE parent_name IS NULL and sequence > 0
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
 
/* check module menu
start PURCHASE  */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '11' AND parent_sequence = '10' )<>1, "
REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('11','10','Purchase','Goods Receive by PO','greceive_controller/po_list','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '12' AND parent_sequence = '10')<>1, "
REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('12','10','Purchase','Stock Return by Batch','Dnbatch_controller/main','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '13' AND parent_sequence = '10')<>1, "
REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('13','10','Purchase','Stock Return Assignment','greturn_controller/dn_list','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '14' AND parent_sequence = '10')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('14','10','Purchase','PO By Vendor','PO_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '15' AND parent_sequence = '10')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('15','10','Purchase','PO By Batch','Simplepo_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start SALES */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '21' AND parent_sequence = '20')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('21','20','Sales','SO By Customer','SO_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '22' AND parent_sequence = '20')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('22','20','Sales','SO By Batch','Simpleso_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '23' AND parent_sequence = '20')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('23','20','Sales','SI Stock Picking','Sipick_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
/* start IBT/ICT */
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '31' AND parent_sequence = '30')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('31','30','IBT/ICT','IBT/ICT Stock Request','IBT_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '32' AND parent_sequence = '30')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('32','30','IBT/ICT','IBT/ICT Stock Picking','dcpick_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
/* start STOCKTAKE */
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '41' AND parent_sequence = '40')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('41','40','Stocktake','Stock Cycle Count','stktake_online_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '42' AND parent_sequence = '40')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('42','40','Stocktake','Stock Take','stktake_controller/scan_userID','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '43' AND parent_sequence = '40')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('43','40','Stocktake','Stock Take - Prelisting','stktake_pre_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start INVENTORY */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '51' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('51','50','Inventory','Stock Adjust In','adjin_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '52' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('52','50','Inventory','Stock Adjust Out','adjout_controller/main?type=AO','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '53' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('53','50','Inventory','Stock Disposal','adjout_controller/main?type=DP','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '54' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('54','50','Inventory','Stock Adjustment - Own Use','adjout_controller/main?type=OU','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '55' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('55','50','Inventory','Backroom Stock Request','Pandarequest_controller/view_transaction','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '56' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('56','50','Inventory','Backroom Stock Pick','Pandarequest_controller/stock_view_transaction','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
/*  start Pallet Management */
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '61' AND parent_sequence = '60')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('61','60','Pallet Management','Form Pallet','formpallet_controller','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '62' AND parent_sequence = '60')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('62','60','Pallet Management','Loc Transfer Out','Obatch_controller/main','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '63' AND parent_sequence = '60')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('63','60','Pallet Management','Loc Transfer Received','Rbatch_controller/main','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start Others */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '71' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('71','70','Others','Sku Info Without Cost','Pchecker_controller/scan_barcode','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '72' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('72','70','Others','SKU Info With Cost','PcheckerCost_controller/scan_barcode','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '73' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('73','70','Others','Print Shelf Label','shelveLabel_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '74' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('74','70','Others','Doc Submission','Submitdoc_controller','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '75' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('75','70','Others','Planogram','planogram_controller/scan_binID','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '76' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('76','70','Others','Gondola SKU Info','gondolastock_controller/main','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '77' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('77','70','Others','Min Max Setup','Minmax_controller/view_transaction','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '78' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('78','70','Others','Mobile POS','Mpos_controller/main','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '79' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('79','70','Others','Supplier Doc Registration','Sub_attendance_controller/main','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '80' AND parent_sequence = '70' AND module_link = 'Productionentry_controller')=1, "
DELETE FROM backend_warehouse.module_menu WHERE sequence = '80' AND parent_sequence = '70' AND module_link = 'Productionentry_controller' 
", "REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('57','50','Inventory','Production Entry','Productionentry_controller','0')
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '57' AND parent_sequence = '50')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('57','50','Inventory','Production Entry','Productionentry_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '82' AND parent_sequence = '80')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('82','80','Setup','Athorise High Shrink Item','#','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '82' AND parent_sequence = '80')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('58','30','IBT/ICT','IBT/ICT Receive','IBT_rec_controller/pending_list','1')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* UPDATE backend_warehouse.`module_menu` SET sequence = sequence*-1 WHERE parent_name IS NULL
 create user_log in stocktake */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_stktake' AND table_name='user_log')<> '1', "CREATE TABLE backend_stktake.`user_log` (
  `log_guid` varchar(32) NOT NULL,
  `trans_guid` varchar(32) NOT NULL,
  `barcode` varchar(30) NOT NULL,
  `bin_id` varchar(20) NOT NULL,
  `itemcode` varchar(30) NOT NULL,
  `bar_desc` varchar(60) DEFAULT NULL,
  `itemlink` varchar(30) DEFAULT NULL,
  `qty_from` double DEFAULT '0',
  `qty_to` double DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`log_guid`),
  KEY `trans_guid` (`trans_guid`),
  KEY `itemcode` (`itemcode`),
  KEY `barcode` (`barcode`),
  KEY `bin_id` (`bin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse sl_main */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='sl_main')<>1,"CREATE TABLE backend_warehouse.`sl_main` (
  `sl_guid` varchar(32) NOT NULL,
  `refno` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `send_print` smallint(6) DEFAULT '0',
  `print_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sl_guid`),
  KEY `created_at` (`created_at`),
  KEY `created_by` (`created_by`),
  KEY `module_desc` (`refno`),
  KEY `location` (`location`),
  KEY `send` (`send_print`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse sl_child */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='sl_child')<>1,"CREATE TABLE backend_warehouse.`sl_child` (
  `sl_guid_c` varchar(32) NOT NULL,
  `sl_guid` varchar(32) DEFAULT NULL,
  `trans_refno` varchar(20) DEFAULT NULL,
  `location` varchar(6) DEFAULT NULL,
  `doc_type` varchar(20) DEFAULT NULL,
  `doc_no` varchar(20) DEFAULT NULL,
  `inv_no` varchar(20) DEFAULT NULL,
  `doc_date` varchar(20) DEFAULT NULL,
  `grdate` varchar(20) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `total` double DEFAULT '0',
  `gst_tax_sum` double DEFAULT '0',
  `total_include_tax` double DEFAULT '0',
  `issuestamp` datetime DEFAULT NULL,
  `postdatetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `send_print` varchar(6) DEFAULT '0',
  PRIMARY KEY (`sl_guid_c`),
  KEY `web_guid` (`sl_guid`),
  KEY `itemcode` (`trans_refno`),
  KEY `created_at` (`created_at`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse sl_menu */
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='sl_menu')<>1,"CREATE TABLE backend_warehouse.`sl_menu` (
  `Sequence` INT(11) NOT NULL DEFAULT '0',
  `module_name` VARCHAR(128) DEFAULT NULL,
  `module_link` VARCHAR(100) DEFAULT NULL,
  `hide_menu` SMALLINT(6) DEFAULT '0',
  PRIMARY KEY (`Sequence`)
) ENGINE=MYISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse production_batch*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='production_batch')<>1,"CREATE TABLE backend_warehouse.`production_batch` (
  `trans_guid` varchar(32) NOT NULL,
  `refno` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `locgroup` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `docdate` date DEFAULT NULL,
  `docno` varchar(20) DEFAULT NULL,
  `cross_refno` varchar(32) DEFAULT NULL,
  `posted` smallint(6) DEFAULT '0',
  `posted_at` datetime DEFAULT NULL,
  `posted_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trans_guid`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse production_batch_c */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='production_batch_c')<>1,"CREATE TABLE backend_warehouse.`production_batch_c` (
  `trans_guid_c` varchar(32) NOT NULL,
  `trans_guid` varchar(32) DEFAULT NULL,
  `itemcode` varchar(20) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `um` varchar(20) DEFAULT NULL,
  `preset_qty` double(10,2) DEFAULT '0.00',
  `batch` double(10,2) DEFAULT '0.00',
  `expected_qty` double(10,2) DEFAULT '0.00',
  `actual_qty` double(10,2) DEFAULT '0.00',
  `variance` double(10,2) DEFAULT '0.00',
  `reason` varchar(32) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trans_guid_c`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse set_template */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='set_template')<>1,"CREATE TABLE backend_warehouse.`set_template` (
  `trans_guid` varchar(32) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `isactive` smallint(6) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trans_guid`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
 
/*  create warehouse set_template_c*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='set_template_c')<>1,"CREATE TABLE backend_warehouse.`set_template_c` (
  `trans_guid_c` varchar(32) NOT NULL,
  `trans_guid` varchar(32) DEFAULT NULL,
  `itemcode` varchar(20) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `um` varchar(20) DEFAULT NULL,
  `preset_qty` double(10,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trans_guid_c`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/*  insert record if new */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '10')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('10','GRN / GRDA','scanbarcode?type=GRN_or_GRDA','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '20')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('20','Purchase Return DN/CN & Purchase Amt DN/CN','scanbarcode?type=DN_or_CN','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '30')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('30','Sales Invoice','scanbarcode?type=SI','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '40')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('40','Sales Invoice CN/DN & Sales Amt DN/CN','scanbarcode?type=SIDN_or_SICN','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '50')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('50','Display Incentive','scanbarcode?type=DI','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.sl_menu WHERE sequence = '60')<>1, "
replace INTO backend_warehouse.`sl_menu` (`Sequence`, `module_name`, `module_link`, `hide_menu`) VALUES('60','Promo Claim Invoice','scanbarcode?type=PCI','0')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
 
 
/* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('arrive_earlier_po'))<>1,"ALTER TABLE backend.xsetup
ADD  `arrive_earlier_po` smallint(6) DEFAULT '1'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/*  create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('grn_by_weight_direct_post_grn'))<>1,"ALTER TABLE backend.xsetup
ADD  `grn_by_weight_direct_post_grn` smallint(6) DEFAULT '1'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* create warehouse gondola_stock */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='gondola_stock')<>1,"CREATE TABLE backend_warehouse.`gondola_stock` (
  `TRANS_GUID` varchar(32) NOT NULL,
  `BIN_ID` varchar(15) NOT NULL,
  `Itemcode` varchar(30) NOT NULL,
  `Itemlink` varchar(30) DEFAULT NULL,
  `Barcode` varchar(30) DEFAULT NULL,
  `Description` varchar(60) DEFAULT NULL,
  `Packsize` double DEFAULT '0',
  `Qty` double DEFAULT '0',
  `UM` varchar(5) DEFAULT NULL,
  `costmargin` smallint(6) DEFAULT '0',
  `costmarginvalue` double DEFAULT '0',
  `SoldByWeight` smallint(6) DEFAULT '0',
  `WeightFactor` double DEFAULT '0',
  `WeightPrice` double DEFAULT '0',
  `Consign` smallint(6) DEFAULT '0',
  `DEPT` varchar(30) DEFAULT NULL,
  `SUBDEPT` varchar(30) DEFAULT NULL,
  `CATEGORY` varchar(30) DEFAULT NULL,
  `Averagecost` double DEFAULT '0',
  `LastCost` double DEFAULT '0',
  `CREATED_AT` datetime DEFAULT NULL,
  `CREATED_BY` varchar(30) DEFAULT NULL,
  `UPDATED_AT` datetime DEFAULT NULL,
  `UPDATED_BY` varchar(30) DEFAULT NULL,
  `exported` smallint(6) DEFAULT '0',
  `exported_at` datetime DEFAULT NULL,
  `exported_by` varchar(20) DEFAULT NULL,
  `exported_refno` varchar(32) DEFAULT NULL,
  `send_print` smallint(6) DEFAULT '0',
  `batch_barcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`TRANS_GUID`,`BIN_ID`,`Itemcode`),
  KEY `Itemcode` (`Itemcode`),
  KEY `Barcode` (`Barcode`),
  KEY `Description` (`Description`),
  KEY `DEPT` (`DEPT`),
  KEY `SUBDEPT` (`SUBDEPT`),
  KEY `BIN_ID` (`BIN_ID`),
  KEY `exported` (`exported`),
  KEY `exported_refno` (`exported_refno`),
  KEY `send_print` (`send_print`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create  warehouse gondola_stock_batch */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='gondola_stock_batch')<>1,"CREATE TABLE backend_warehouse.`gondola_stock_batch` (
  `TRANS_GUID` varchar(32) NOT NULL,
  `BIN_ID` varchar(20) DEFAULT NULL,
  `BATCH_BARCODE` varchar(30) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT NULL,
  `CREATED_BY` varchar(30) DEFAULT NULL,
  `UPDATED_AT` datetime DEFAULT NULL,
  `UPDATED_BY` varchar(30) DEFAULT NULL,
  `exported` smallint(6) DEFAULT '0',
  `exported_at` datetime DEFAULT NULL,
  `exported_by` varchar(20) DEFAULT NULL,
  `exported_refno` varchar(32) DEFAULT NULL,
  `send_print` smallint(6) DEFAULT '0',
  `temp` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`TRANS_GUID`),
  KEY `BIN_ID` (`BIN_ID`),
  KEY `BATCH_BARCODE` (`BATCH_BARCODE`),
  KEY `exported` (`exported`),
  KEY `send_print` (`send_print`),
  KEY `CREATED_AT` (`CREATED_AT`),
  KEY `temp` (`temp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* warehouse stock_request */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='stock_request')<>1,"CREATE TABLE backend_warehouse.`stock_request` (
  `Trans_ID` varchar(32) NOT NULL,
  `Trans_Date` date DEFAULT NULL,
  `Created_By` varchar(15) DEFAULT NULL,
  `DocDate` datetime DEFAULT NULL,
  `Send_print` smallint(2) DEFAULT '0',
  PRIMARY KEY (`Trans_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* warehouse  stock_request_item */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='stock_request_item')<>1,"CREATE TABLE backend_warehouse.`stock_request_item` (
  `Trans_ID` varchar(32) NOT NULL,
  `Bin_ID` varchar(32) DEFAULT NULL,
  `DocDate` datetime DEFAULT NULL,
  `Itemcode` varchar(20) NOT NULL DEFAULT '',
  `Itemlink` varchar(30) NOT NULL DEFAULT '',
  `Description` varchar(50) DEFAULT NULL,
  `Qoh` double(10,2) DEFAULT '0.00',
  `Send_print` smallint(6) DEFAULT '0',
  `qty_request` double DEFAULT '0',
  `qty_pick` double DEFAULT '0',
  `qty_balance` double DEFAULT '0',
  PRIMARY KEY (`Trans_ID`,`Itemcode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
 
/* should we add this reason */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='web_trans'
AND column_name IN ('reason'))<>1,"ALTER TABLE backend.web_trans
ADD  `reason` VARCHAR(32) DEFAULT NULL","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* should we add this ibt_from */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='web_trans'
AND column_name IN ('ibt_from'))<>1,"ALTER TABLE backend.web_trans
ADD  `ibt_from` VARCHAR(32) DEFAULT NULL","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* add the table for minmax */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='set_min_max')<>1,"CREATE TABLE backend_warehouse.`set_min_max` (
  `loc_group` varchar(20) NOT NULL,
  `bin_id` varchar(20) NOT NULL,
  `itemcode` varchar(30) NOT NULL,
  `set_min` double DEFAULT NULL,
  `set_max` double DEFAULT NULL,
  PRIMARY KEY (`loc_group`,`bin_id`,`itemcode`),
  UNIQUE KEY `ZZ` (`loc_group`,`bin_id`,`itemcode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create attendance db */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='attendance')<>1,"CREATE TABLE backend_warehouse.`attendance` (
  `web_guid` varchar(32) NOT NULL,
  `Code` varchar(10) DEFAULT NULL,
  `Suppliers` varchar(100) NOT NULL,
  `RefNo` varchar(20) NOT NULL,
  `Amount` double(10,2) NOT NULL DEFAULT '0.00',
  `GST` double(10,2) DEFAULT '0.00',
  `Remark` text,
  `Created_by` varchar(20) NOT NULL,
  `Created_at` datetime NOT NULL,
  `Updated_by` varchar(20) NOT NULL,
  `Updated_at` datetime NOT NULL,
  PRIMARY KEY (`web_guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* should we add this GST */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='attendance'
AND column_name = 'GST')<>1,"ALTER TABLE backend_warehouse.attendance
ADD  `GST` double(10,2) DEFAULT '0.00'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create attendance userlog */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='attendance_user_log')<>1,"CREATE TABLE backend_warehouse.`attendance_user_log` (
  `trans_guid` varchar(32) NOT NULL,
  `module` varchar(32) DEFAULT NULL,
  `field` varchar(32) DEFAULT NULL,
  `value_guid` varchar(32) DEFAULT NULL,
  `value_from` varchar(60) DEFAULT NULL,
  `value_to` varchar(60) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`trans_guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create the new user setup for grnbyweight
 SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
 WHERE table_schema='backend_warehouse' AND table_name='set_user_group_setting')<>1,"CREATE TABLE backend_warehouse.`set_user_group_setting` (
   `user_group_guid` varchar(32) NOT NULL,
   `show_cost` binary(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1
 ","select * from backend.acc_code limit 1")
PREPARE query_result FROM @sqlscript
 EXECUTE query_result  */
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE module_name = 'Goods Receive by Batch' AND sequence = '12' )='1',
"REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('12','10','Purchase','Stock Return by Batch','Dnbatch_controller/main','0')"
,"select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE module_name = 'Goods Receive by Batch')='1', "
UPDATE backend_warehouse.set_user_group_webmodule set module_name = 'Stock Return by Batch' WHERE module_name = 'Goods Receive by Batch')
", "select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '79' AND parent_name = 'Attendance')='1', "
REPLACE INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) VALUES('79','70','Others','Supplier Doc Registration','Sub_attendance_controller/main','1')
", "select now() as time
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE module_name = 'Attendance')=1, "
UPDATE backend_warehouse.set_user_group_webmodule set module_name = 'Supplier Doc Registration' WHERE module_name = 'Attendance')
", "select now() as time ");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start set_sysrun item production entry */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_sysrun WHERE run_type = 'ITEM')<>1, "
replace INTO backend_warehouse.`set_sysrun` (`run_type`, `run_code`, `run_year`, `run_month`, `run_day`, `run_date`,`run_currentno`, `run_digit`) 
VALUES('ITEM','IT','2010','1','1','2017-11-13', '0', '4')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
/* create web_propose_pricechange */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend' AND table_name='web_propose_pricechange')<>1,
"CREATE TABLE backend.`web_propose_pricechange` (
  `itemcode` varchar(30) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `current_price_inc_tax` double(10,2) DEFAULT '0.00',
  `current_price_exc_tax` double(10,2) DEFAULT '0.00',
  `propose_price_inc_tax` double(10,2) DEFAULT '0.00',
  `propose_price_exc_tax` double(10,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(30) DEFAULT NULL,
  KEY `itemcode` (`itemcode`,`barcode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* for existing client with production_batch but no locgroup */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='production_batch'
AND column_name IN ('locgroup'))<>1,"ALTER TABLE backend_warehouse.production_batch
ADD  `locgroup` VARCHAR(32) DEFAULT NULL","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
UPDATE backend_warehouse.`production_batch`  AS a
INNER JOIN backend.location AS b
ON a.location = b.code
SET a.locgroup = b.`LocGroup`
WHERE a.locgroup IS NULL AND a.posted = '0';
 
/* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('decode_receiving_barcode'))<>1,"ALTER TABLE backend.xsetup
ADD  `decode_receiving_barcode` smallint(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/*  create warehouse d_grn_batch_item_c */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='d_grn_batch_item_c')<>1,"
CREATE TABLE backend_warehouse.d_grn_batch_item_c (
  `item_guid` varchar(32) DEFAULT NULL,
  `batch_guid` varchar(32) DEFAULT NULL,
  `item_guid_c` varchar(32) NOT NULL,
  `lineno` int(11) DEFAULT '0',
  `scan_itemcode` varchar(30) DEFAULT NULL,
  `scan_description` varchar(80) DEFAULT NULL,
  `scan_itemlink` varchar(30) DEFAULT NULL,
  `scan_packsize` double DEFAULT '0',
  `scan_weight` double(10,4) DEFAULT '0.0000',
  `scan_as_itemcode` smallint(6) DEFAULT '0',
  `qty_rec` double DEFAULT '0',
  `scan_weight_total` double(10,4) DEFAULT '0.0000',
  `posum_guid` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `qty_diff_is_foc` smallint(6) DEFAULT '0',
  `scan_barcode` varchar(30) DEFAULT NULL,
  `qty_do` double DEFAULT '0',
  `qty_diff` double DEFAULT '0',
  `stock_update` smallint(6) DEFAULT '0',
  `stock_update_at` datetime DEFAULT NULL,
  `stock_update_by` varchar(20) DEFAULT NULL,
  KEY `NewIndex1` (`lineno`),
  KEY `scan_itemcode` (`scan_itemcode`),
  KEY `batch_guid` (`batch_guid`),
  KEY `stock_update` (`stock_update`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('amt_exc_tax'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `amt_exc_tax` double(14,2) DEFAULT '0.00' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('amt_inc_tax'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `amt_inc_tax` double(14,2) DEFAULT '0.00' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('gst_tax'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `gst_tax` double(14,2) DEFAULT '0.00' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('rounding_adj'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `rounding_adj` double(14,2) DEFAULT '0.00' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.web_trans  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='web_trans'
AND column_name IN ('amt_exc_tax'))<>1,"ALTER TABLE backend.web_trans
ADD  `amt_exc_tax` double(14,2) DEFAULT '0.00'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.web_trans  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='web_trans'
AND column_name IN ('gst_amt'))<>1,"ALTER TABLE backend.web_trans
ADD  `gst_amt` double(14,2) DEFAULT '0.00'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.web_trans  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='web_trans'
AND column_name IN ('amt_inc_tax'))<>1,"ALTER TABLE backend.web_trans
ADD  `amt_inc_tax` double(14,2) DEFAULT '0.00'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('inv_date'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `inv_date` date DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.d_grn  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='d_grn'
AND column_name IN ('received_date'))<>1,"ALTER TABLE backend_warehouse.d_grn
ADD  `received_date` date DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.set_parameter  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='set_parameter'
AND column_name IN ('file_path'))<>1,"ALTER TABLE backend_warehouse.set_parameter
ADD  `file_path` text DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.set_parameter  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='set_parameter'
AND column_name IN ('destination_path'))<>1,"ALTER TABLE backend_warehouse.set_parameter
ADD  `destination_path` text DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.set_parameter  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='set_parameter'
AND column_name IN ('script_datetime'))<>1,"ALTER TABLE backend_warehouse.set_parameter
ADD  `script_datetime` datetime DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* add new field at backend_warehouse.set_parameter  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='set_parameter'
AND column_name IN ('updated_at'))<>1,"ALTER TABLE backend_warehouse.set_parameter
ADD  `updated_at` datetime DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* check if table exist set_user_group_webmodule */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='set_user_group_webmodule')<>1,"
CREATE TABLE backend_warehouse.`set_user_group_webmodule` (
  `webmodule_guid` varchar(32) NOT NULL,
  `user_group_guid` varchar(32) DEFAULT NULL,
  `module_name` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`webmodule_guid`),
  KEY `user_group_guid` (`user_group_guid`),
  KEY `module_name` (`module_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create grnbyweight hide inv detail xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('grn_by_weight_hide_inv_detail'))<>1,"ALTER TABLE backend.xsetup
ADD  `grn_by_weight_hide_inv_detail` smallint(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start set_user_group_web_module */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule 
WHERE user_group_guid = 'panda' AND module_name = 'IBT/ICT Receive')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` 
(`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) 
VALUES('1BABF1F21CF611E8B439441CA8AB9000','panda','IBT/ICT Receive','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* start set_user_group_web_module */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Backroom Stock Pick')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E1B3A04911E7AA76A2134C73170F','panda','Backroom Stock Pick','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Backroom Stock Request')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E282A04911E7AA76A2134C73170F','panda','Backroom Stock Request','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Doc Submission')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E2AEA04911E7AA76A2134C73170F','panda','Doc Submission','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Form Pallet')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E2C4A04911E7AA76A2134C73170F','panda','Form Pallet','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Gondola SKU Info')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E2D9A04911E7AA76A2134C73170F','panda','Gondola SKU Info','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Return by Batch')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E2EEA04911E7AA76A2134C73170F','panda','Stock Return by Batch','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Goods Receive by PO')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E303A04911E7AA76A2134C73170F','panda','Goods Receive by PO','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'IBT/ICT Stock Picking')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E318A04911E7AA76A2134C73170F','panda','IBT/ICT Stock Picking','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'IBT/ICT Stock Request')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E32EA04911E7AA76A2134C73170F','panda','IBT/ICT Stock Request','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Loc Transfer Out')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E344A04911E7AA76A2134C73170F','panda','Loc Transfer Out','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Loc Transfer Received')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E35AA04911E7AA76A2134C73170F','panda','Loc Transfer Received','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Min Max Setup')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E370A04911E7AA76A2134C73170F','panda','Min Max Setup','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Mobile POS')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E386A04911E7AA76A2134C73170F','panda','Mobile POS','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Planogram')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E39EA04911E7AA76A2134C73170F','panda','Planogram','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'PO By Batch')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E3B6A04911E7AA76A2134C73170F','panda','PO By Batch','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'PO By Vendor')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E3CEA04911E7AA76A2134C73170F','panda','PO By Vendor','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Print Shelf Label')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E3E7A04911E7AA76A2134C73170F','panda','Print Shelf Label','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'SI Stock Picking')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E3FFA04911E7AA76A2134C73170F','panda','SI Stock Picking','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'SKU Info With Cost')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E418A04911E7AA76A2134C73170F','panda','SKU Info With Cost','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'SKU Info Without Cost')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E433A04911E7AA76A2134C73170F','panda','SKU Info Without Cost','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'SO By Batch')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E44EA04911E7AA76A2134C73170F','panda','SO By Batch','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'SO By Customer')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E468A04911E7AA76A2134C73170F','panda','SO By Customer','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Adjust In')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E484A04911E7AA76A2134C73170F','panda','Stock Adjust In','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Adjust Out')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E49FA04911E7AA76A2134C73170F','panda','Stock Adjust Out','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Adjustment - Own Use')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E4BBA04911E7AA76A2134C73170F','panda','Stock Adjustment - Own Use','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Cycle Count')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E4D8A04911E7AA76A2134C73170F','panda','Stock Cycle Count','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Disposal')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E4F4A04911E7AA76A2134C73170F','panda','Stock Disposal','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Return Assignment')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E528A04911E7AA76A2134C73170F','panda','Stock Return Assignment','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Take')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E547A04911E7AA76A2134C73170F','panda','Stock Take','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Stock Take - Prelisting')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E566A04911E7AA76A2134C73170F','panda','Stock Take - Prelisting','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Supplier Doc Registration')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E576A04911E7AA76A2134C73170F','panda','Supplier Doc Registration','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Production Entry')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E4FFA04911E7AA76A2134C73170F','panda','Production Entry','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_user_group_webmodule WHERE user_group_guid = 'panda' AND module_name = 'Backroom Stock Pick')<>1, "
REPLACE INTO backend_warehouse.`set_user_group_webmodule` (`webmodule_guid`, `user_group_guid`, `module_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('9A78E1B3A04911E7AA76A2134C73170F','panda','Backroom Stock Pick','2017-09-23 18:26:04','panda','2017-09-23 18:26:04','panda')
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Goods Receive' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Goods Receive by PO' WHERE module_name = 'Goods Receive' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Adjust-Out / Disposal' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Stock Adjust Out' WHERE module_name = 'Adjust-Out / Disposal' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Purchase Order' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'PO By Vendor' WHERE module_name = 'Purchase Order' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'SKU Info' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Sku Info Without Cost' WHERE module_name = 'SKU Info' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Stock Request' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Backroom Stock Request' WHERE module_name = 'Stock Request' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'SKU Info Cost' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'SKU Info With Cost' WHERE module_name = 'SKU Info Cost' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Stock Take (Prelisting)' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Stock Take - Prelisting' WHERE module_name = 'Stock Take (Prelisting)' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Goods Return' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Stock Return Assignment' WHERE module_name = 'Goods Return' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Shelf Label' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Print Shelf Label' WHERE module_name = 'Shelf Label' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'DC Pick' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'IBT/ICT Stock Picking' WHERE module_name = 'DC Pick' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'SI Pick' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'SI Stock Picking' WHERE module_name = 'SI Pick' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`module_menu` WHERE module_name = 'Stock Take' AND parent_name IS NULL
)> '0',
"UPDATE backend_warehouse.`module_menu` SET module_name = 'Stock Take-old' WHERE module_name = 'Stock Take' AND parent_name IS NULL
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Stock Take (Cycle Count)' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Stock Cycle Count' WHERE module_name = 'Stock Take (Cycle Count)' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Adjust-In' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'Stock Adjust In' WHERE module_name = 'Adjust-In' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`set_user_group_webmodule` WHERE module_name = 'Sales Order' AND user_group_guid <> 'panda'
)> '0',
"UPDATE backend_warehouse.`set_user_group_webmodule` SET module_name = 'SO By Customer' WHERE module_name = 'Sales Order' AND user_group_guid <> 'panda'
","select now() as time");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* setting for first time if set_parameter auto take from dropbox to update grnbyweight */
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_parameter WHERE file_path IS NOT NULL AND destination_path IS NOT NULL) <> 1, "
UPDATE backend_warehouse.set_parameter SET  file_path = '/media/data/Dropbox/panda_clients/web modules/panda_web_updated_file/' , destination_path = '/var/www/html/grnbyweight/application/'
", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* create batch_scan_log backend_warehouse */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='d_batch_scan_log')<>1,"CREATE TABLE backend_warehouse.`d_batch_scan_log` (
  `item_guid` varchar(32) NOT NULL,
  `scan_guid` varchar(32) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `refno` varchar(32) DEFAULT NULL,
  `lineno` int(11) DEFAULT '0',
  `scan_barcode` varchar(30) DEFAULT NULL,
  `scan_itemcode` varchar(30) DEFAULT NULL,
  `scan_description` varchar(80) DEFAULT NULL,
  `scan_itemlink` varchar(30) DEFAULT NULL,
  `scan_packsize` double DEFAULT '0',
  `scan_weight` double(10,4) DEFAULT '0.0000',
  `scan_as_itemcode` smallint(6) DEFAULT '0',
  `scan_qty` double DEFAULT '0',
  `scan_weight_total` double(10,4) DEFAULT '0.0000',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`scan_guid`),
  KEY `NewIndex1` (`lineno`),
  KEY `scan_itemcode` (`scan_itemcode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('check_high_shrink'))<>1,"ALTER TABLE backend.xsetup
ADD  `check_high_shrink` smallint(6) DEFAULT '0' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* create warehouse xestup */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('check_dcpick_looseitem'))<>1,"ALTER TABLE backend.xsetup
ADD  `check_dcpick_looseitem` smallint(6) DEFAULT '1' ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* alter stock request item */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend_warehouse' AND table_name='stock_request_item'
AND column_name IN ('Bin_ID'))<>1,"ALTER TABLE backend_warehouse.stock_request_item
ADD  `Bin_ID` VARCHAR(32) DEFAULT NULL ","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* create set_barcode_parameter */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='set_barcode_parameter')<>1,
"CREATE TABLE backend_warehouse.`set_barcode_parameter` (
  `guid` varchar(32) NOT NULL,
  `type_code` varchar(15) DEFAULT NULL,
  `type_desc` varchar(30) DEFAULT NULL,
  `bar_start` int(11) DEFAULT '1',
  `bar_count` int(11) DEFAULT '7',
  `packsize_start` int(11) DEFAULT '0',
  `packsize_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`guid`)
)ENGINE=InnoDB DEFAULT CHARSET=latin1", "select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_barcode_parameter WHERE type_desc = '14 Digit Barcode')<>1, "
replace INTO backend_warehouse.`set_barcode_parameter` (`guid`, `type_code`, `type_desc`, `bar_start`, `bar_count`, `packsize_start`, `packsize_count`, `created_at`, `created_by`, `updated_at`, `updated_by`) 
VALUES('CABCC9A3DA5D11E7B07DCACCA0BBCAC3','14','14 Digit Barcode','3','8','11','4','2017-12-06 16:15:48','panda faizul','2017-12-06 16:16:01','panda faizul')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.set_barcode_parameter WHERE type_desc = '15 Digit Barcode')<>1, "
replace INTO backend_warehouse.`set_barcode_parameter` (`guid`, `type_code`, `type_desc`, `bar_start`, `bar_count`, `packsize_start`, `packsize_count`, `created_at`, `created_by`, `updated_at`, `updated_by`) 
VALUES('D14FED75DA5D11E7B07DCACCA0BBCAC3','15','15 Digit Barcode','3','9','12','4','2017-12-06 16:15:48','panda faizul','2017-12-06 16:16:01','panda faizul')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* hugh 2018-01-27 alter module_name */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.columns
WHERE table_schema='backend_warehouse' AND table_name='module_menu' AND column_name = 'module_name' AND character_maximum_length = '30')<> 1, 
"ALTER TABLE backend_warehouse.`module_menu` 
    CHANGE `module_name` `module_name` VARCHAR(30)  COLLATE latin1_swedish_ci NULL AFTER `parent_name`", 
    "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.`module_menu`
WHERE module_name = 'Stock Adjustment - Own Us' )<> 0, 
"update backend_warehouse.module_menu set module_name = 'Stock Adjustment - Own Use' where module_name = 'Stock Adjustment - Own Us'", 
    "select * from backend.acc_code limit 1" );
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* Create table dc_pick_rec*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend' AND table_name='dc_pick_rec')<> '1', 
"CREATE TABLE backend.`dc_pick_rec` (
  `TRANS_GUID` varchar(32) NOT NULL DEFAULT '',
  `RefNo` varchar(15) DEFAULT NULL,
  `DocDate` date DEFAULT NULL,
  `DeliverDate` date DEFAULT NULL,
  `post_status` smallint(6) DEFAULT '0',
  `post_by` varchar(30) DEFAULT NULL,
  `post_at` datetime DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT NULL,
  `CREATED_BY` varchar(30) DEFAULT NULL,
  `UPDATED_AT` datetime DEFAULT NULL,
  `UPDATED_BY` varchar(30) DEFAULT NULL,
  `hq_update` smallint(6) DEFAULT '0',
  `link_guid` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`TRANS_GUID`),
  UNIQUE KEY `RefNo` (`RefNo`),
  KEY `DocDate` (`DocDate`),
  KEY `post_status` (`post_status`),
  KEY `DeliverDate` (`DeliverDate`),
  KEY `hq_update` (`hq_update`),
  KEY `CREATED_AT` (`CREATED_AT`),
  KEY `post_at` (`post_at`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='1 = Used %, 0 = Used $'
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* Create table dc_pick_rec_c*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend' AND table_name='dc_pick_rec_c')<> '1', 
"CREATE TABLE backend.`dc_pick_rec_c` (
  `CHILD_GUID` varchar(32) NOT NULL DEFAULT '',
  `TRANS_GUID` varchar(32) DEFAULT NULL,
  `line` int(11) DEFAULT '0',
  `Itemcode` varchar(20) DEFAULT NULL,
  `Qty_Received` double DEFAULT '0',
  `Qty_Varience` double DEFAULT '0',
  `Barcode` varchar(30) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT NULL,
  `CREATED_BY` varchar(30) DEFAULT NULL,
  `UPDATED_AT` datetime DEFAULT NULL,
  `UPDATED_BY` varchar(30) DEFAULT NULL,
  `remark` text,
  `reason` varchar(60) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `scan_flag` smallint(6) DEFAULT NULL,
  `link_guid_c` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`CHILD_GUID`),
  KEY `TRANS_GUID` (`TRANS_GUID`),
  KEY `Itemcode` (`Itemcode`),
  KEY `Barcode` (`Barcode`),
  KEY `reason` (`reason`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* xsetup grnbyweight send print  hugh 2018-03-15*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('grnbyweight_send_print'))<>1,"ALTER TABLE backend.xsetup
ADD  `grnbyweight_send_print` smallint(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* panda platform for auto print module */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables 
WHERE table_schema='panda_platform') = 0,"CREATE DATABASE panda_platform","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='panda_platform' AND table_name='trans')<> '1', 
"CREATE TABLE panda_platform.`trans` (
  `trans_guid` varchar(32) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `web_guid` varchar(32) NOT NULL,
  `refno` varchar(40) NOT NULL,
  `location` varchar(20) NOT NULL,
  `do_no` varchar(20) DEFAULT NULL,
  `inv_no` varchar(20) DEFAULT NULL,
  `po_date` varchar(20) DEFAULT NULL,
  `po_no` varchar(20) DEFAULT NULL,
  `scode` varchar(20) DEFAULT NULL,
  `s_name` varchar(80) DEFAULT NULL,
  `reason` varchar(80) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `sync_in` smallint(6) DEFAULT '0',
  `sync_in_datetime` datetime DEFAULT NULL,
  `sync_out` smallint(6) DEFAULT '0',
  `sync_out_datetime` datetime DEFAULT NULL,
  `printed` smallint(6) DEFAULT '0',
  `printed_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`type`,`web_guid`,`refno`,`location`),
  KEY `trans_guid` (`trans_guid`),
  KEY `type` (`type`),
  KEY `refno` (`refno`),
  KEY `po_date` (`po_date`),
  KEY `scode` (`scode`),
  KEY `reason` (`reason`),
  KEY `printed` (`printed`),
  KEY `web_guid` (`web_guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='panda_platform' AND table_name='trans_c')<> '1', 
"CREATE TABLE panda_platform.`trans_c` (
  `trans_guid_c` varchar(32) DEFAULT NULL,
  `trans_guid` varchar(32) NOT NULL,
  `type` varchar(30) NOT NULL,
  `web_guid` varchar(32) NOT NULL,
  `web_c_guid` varchar(32) NOT NULL,
  `refno` varchar(40) NOT NULL,
  `itemcode` varchar(32) NOT NULL,
  `description` varchar(60) NOT NULL,
  `barcode` varchar(30) NOT NULL,
  `qty` double DEFAULT NULL,
  `reason` varchar(80) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `sync_in` smallint(6) DEFAULT '0',
  `sync_in_datetime` datetime DEFAULT NULL,
  `sync_out` smallint(6) DEFAULT '0',
  `sync_out_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`trans_guid`,`type`,`web_guid`,`web_c_guid`,`refno`,`itemcode`,`description`,`barcode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1
","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='supcus'
AND column_name IN ('mobile_po'))<>1,"ALTER TABLE backend.supcus
ADD  `mobile_po` smallint(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('allow_change_receiving_date'))<>1,"ALTER TABLE backend.xsetup
ADD  `allow_change_receiving_date` smallint(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 
 
/*create auto grn_mobile_po */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='supcus'
AND column_name IN ('auto_grn_mobile_po'))<>1,"ALTER TABLE backend.supcus
ADD auto_grn_mobile_po SMALLINT(6) DEFAULT '0'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 


SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='panda_platform' AND table_name='trans'
AND column_name IN ('status'))<>1,"ALTER TABLE panda_platform.trans
ADD status varchar(32) DEFAULT ''","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 

/* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('allow_chinese_character'))<>1,"ALTER TABLE backend.xsetup
ADD  `allow_chinese_character` smallint(6) DEFAULT '1'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
 /* create warehouse xestup  */
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.COLUMNS
WHERE table_schema='backend' AND table_name='xsetup'
AND column_name IN ('requery_after_insert'))<>1,"ALTER TABLE backend.xsetup
ADD  `requery_after_insert` smallint(6) DEFAULT '1'","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;

/* add price tag verifier menu*/
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '83' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('83','70','Others','Price Tag Verifier','price_tag_verifier_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;


/*create table price tag verifier*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_stktake' AND table_name='price_tag_verifier')<> '1', 
"CREATE TABLE backend_stktake.`price_tag_verifier` (
  `shelf_guid` varchar(32) NOT NULL,
  `Bin_Code` varchar(15) NOT NULL,
  `itemcode` varchar(30) NOT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `LabelPrice` double DEFAULT '0',
  `SystemPrice` double DEFAULT '0',
  `articleno` varchar(20) DEFAULT NULL,
  `Remark` varchar(50) DEFAULT NULL,
  `scanned_barcode` varchar(30) DEFAULT NULL,
  `actual_barcode` varchar(30) DEFAULT NULL,
  `Print_now` smallint(6) DEFAULT '0',
  `Label_Format` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `PackSize` double DEFAULT '1',
  `Size` varchar(30) DEFAULT '',
  PRIMARY KEY (`shelf_guid`,`Bin_Code`,`itemcode`),
  KEY `barcode` (`actual_barcode`),
  KEY `Print_now` (`Print_now`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 

/*reprint module*/
SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.module_menu WHERE sequence = '84' AND parent_sequence = '70')<>1, "
replace INTO backend_warehouse.`module_menu` (`Sequence`, `parent_sequence`, `parent_name`, `module_name`, `module_link`, `hide_menu`) 
VALUES('84','70','Others','Reprint Module','Reprint_controller','0')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;

/*create table reprint module*/
SET @sqlscript = IF((SELECT COUNT(*) FROM information_schema.tables
WHERE table_schema='backend_warehouse' AND table_name='reprint_table')<> '1', 
"CREATE TABLE backend_warehouse.`reprint_table` (
  `print_guid` varchar(32) NOT NULL,
  `module_name` varchar(60) DEFAULT NULL,
  `query` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`print_guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1","select * from backend.acc_code limit 1");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result; 

SET @sqlscript = IF((SELECT COUNT(*) FROM backend_warehouse.reprint_table WHERE module_name = 'Price Change')<>1, "
REPLACE INTO backend_warehouse.`reprint_table` (`print_guid`, `module_name`, `query`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES('665F250F3FA011E8967AA81E8453CCF0','Price Change','SELECT trans_guid, refno, effectivedate as date from backend.price_change_req where print_req = 1 order by effectivedate desc','2018-04-14 13:02:21','HUGH','2018-04-14 13:02:24','HUGH')
", "select * from backend.acc_code limit 1
");
PREPARE query_result FROM @sqlscript;
EXECUTE query_result;
 
/* @@@@@@@@@@@@@@@@@@@@@@@ NO QUERY BELOW THIS END PLEASE @@@@@@@@@@@@@@@@@@@@@@@@*/
SELECT 'END';