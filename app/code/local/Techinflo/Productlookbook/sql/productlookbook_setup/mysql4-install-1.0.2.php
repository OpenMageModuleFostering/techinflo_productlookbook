<?php
/*
 * @category     Techinflo
 * @package     Techinflo LookBook
 * @author      <Techinflo Team>
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('productlookbook')};
CREATE TABLE {$this->getTable('productlookbook')} (
  `productlookbook_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `hotspots` text NOT NULL default '',
  `position` smallint(5) unsigned NOT NULL,
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`productlookbook_id`),
  KEY `IDX_LOOKBOOK_LOOKBOOK_ID` (`productlookbook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->setConfigData('productlookbook/general/hotspot_icon/','default/hotspot-icon.png');

$installer->endSetup(); 