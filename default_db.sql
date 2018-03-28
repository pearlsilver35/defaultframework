/*
MySQL Data Transfer
Source Host: localhost
Source Database: default_db
Target Host: localhost
Target Database: default_db
Date: 7/21/2017 10:59:01 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for gendata
-- ----------------------------
DROP TABLE IF EXISTS `gendata`;
CREATE TABLE `gendata` (
  `table_name` varchar(30) default NULL,
  `table_id` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `itemid` bigint(200) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `categoryid` int(100) NOT NULL,
  `subcategoryid` int(100) NOT NULL,
  `initial_stockvalue` int(100) default NULL,
  `stockvalue` int(100) default '1000',
  `price` double(10,0) NOT NULL,
  `discount` decimal(10,2) NOT NULL default '0.00',
  `hit` int(100) NOT NULL default '0',
  `thumbnail` varchar(100) default NULL,
  `thumbnail1` varchar(100) default NULL,
  `thumbnail2` varchar(100) default NULL,
  `del_status` int(1) default '0',
  `review` int(1) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`itemid`),
  KEY `subcategoryid` (`subcategoryid`),
  KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menu_id` varchar(5) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(60) default '',
  `parent_id` varchar(5) default '#',
  `parent_id2` varchar(5) NOT NULL default ' ',
  `menu_level` char(1) default '0',
  `created` datetime NOT NULL,
  `menu_order` int(3) NOT NULL default '0',
  PRIMARY KEY  (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for menugroup
-- ----------------------------
DROP TABLE IF EXISTS `menugroup`;
CREATE TABLE `menugroup` (
  `role_id` varchar(5) NOT NULL,
  `menu_id` varchar(5) NOT NULL,
  PRIMARY KEY  (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for parameter
-- ----------------------------
DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
  `parameter_name` varchar(60) default NULL,
  `parameter_value` varchar(100) default NULL,
  `parameter_flag` enum('0','1') default '1',
  `parameter_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` varchar(5) NOT NULL default '',
  `role_name` varchar(60) default NULL,
  `role_enabled` char(1) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for states
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `state` char(20) NOT NULL,
  `capital` char(20) default NULL,
  PRIMARY KEY  (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 4096 kB; InnoDB free: 736256 kB';

-- ----------------------------
-- Table structure for userdata
-- ----------------------------
DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata` (
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` varchar(20) NOT NULL,
  `role_name` varchar(30) default NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `passchg_logon` char(1) NOT NULL,
  `pass_expire` varchar(1) default NULL,
  `pass_dateexpire` date default NULL,
  `pass_change` char(1) default NULL,
  `user_disabled` char(1) NOT NULL,
  `user_locked` char(1) NOT NULL,
  `day_1` char(1) NOT NULL,
  `day_2` char(1) NOT NULL,
  `day_3` char(1) NOT NULL,
  `day_4` char(1) NOT NULL,
  `day_5` char(1) NOT NULL,
  `day_6` char(1) NOT NULL,
  `day_7` char(1) NOT NULL,
  `pin_missed` int(2) NOT NULL default '0',
  `last_used` datetime default NULL,
  `modified` datetime default NULL,
  `hint_question` varchar(100) default NULL,
  `hint_answer` varchar(100) default NULL,
  `override_wh` char(1) default NULL,
  `extend_wh` varchar(17) default NULL,
  `branch_code` varchar(50) default NULL,
  `trans_limit` double(20,2) default '0.00',
  `created` datetime default NULL,
  `posted_user` varchar(100) default NULL,
  `last_used_passwords` varchar(250) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='InnoDB free: 11264 kB; InnoDB free: 11264 kB; InnoDB free: 1';

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `gendata` VALUES ('CART', '32');
INSERT INTO `gendata` VALUES ('CUSID', '18');
INSERT INTO `gendata` VALUES ('ORDER', '28');
INSERT INTO `gendata` VALUES ('IDD', '83');
INSERT INTO `gendata` VALUES ('TRN', '25');
INSERT INTO `gendata` VALUES ('SVCCAT', '11');
INSERT INTO `gendata` VALUES ('menu', '18');
INSERT INTO `items` VALUES ('1', 'Fageli Exclusive Facials', 'Revives, Restores & Rejuvenates damaged skin caused by harse chemical creams, sun burn, bacterial, cream reaction. Clears pimples and wrinkle. Removes dead skin cells and re-generate new skin cells around the facial walls and there by prevents aging and smoothens the facial skin. Moisturizes and improves skin elasticity and collagen production ', '1', '0', null, '1000', '8000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('2', 'Fageli Organic Facials', 'Removes blemishes, clears dirty and oil from the face. Colour booster and gives youthful skin, tones the skin, clears black head and white heads (Vitamins and Freash Fruit)', '1', '0', null, '1000', '7000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('3', 'Fageli Rountine Facials', 'Deep cleans the facial skin. Brightens and Improves the Overall appearance of the face', '1', '0', null, '1000', '5000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('4', 'Acne/Extraction Facials', '', '1', '0', null, '1000', '6000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('5', 'Fageli 21 Karat Gold Facials', 'Repels malenoma, contains a deep moisturizing factor, Lavender Extract, Hamomile extract and 21 Karat Gold Powder which infiltrates the skin base in order to immediately display skin moistness and brightness. Condition the facial skin, Adds collagen to the facial skin, improves skin texture. Age-Defying, Allargy, Clears Dark Spots, gives a perfect glowing and smooth face', '1', '0', null, '1000', '12000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('6', 'Fageli Silver Crystal Facials', 'Contains the Collagen Good for Firming the facial skin, Remove skin watt and help to reduce the growth of skin watt on the face. Moisturizes, brightens, & Smoothens the facial skin, keeps the face free from blemishes and roughness', '1', '0', null, '1000', '11000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('7', 'Fageli Casmara Vitamin Vegetables Facials', 'Deep treatment to the facial skin and gives a brighter, glowing and younger looking skin, destroys bacterial, blemishes, skin problems, improves dull looking skin, Prevents accumulation of dead skin cells on the face', '1', '0', null, '1000', '12000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('8', 'Fageli High Frequency Facial Treatment', 'It has healing benefit on the facial skin. It improves darck circle around the eyes, it reduces puffy eyes and puffy cheek. It relieves stress and fatique and relaxes the facial nerves. It clears wrinkles and fine0line. It rejuvenates the skin', '1', '0', null, '1000', '10000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('9', 'Fageli Face Lift Massage Therapy', 'Through the increase in blood circulation it instantly gives the face a visible lift and firm. It regenerates new skin cells, clears fine lines, alleviates stress and relaxes the soul and mind. Gives a younger smoother and refereshed skin instantly.', '1', '0', null, '1000', '6000', '0.00', '0', 'http://fagelispa.com/img/facial.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('10', 'Articulation Massage', '', '2', '0', null, '1000', '10000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('11', 'Island Massage (Lomi Lomi)', '', '2', '0', null, '1000', '12000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('12', 'Sweddish Massage', '', '2', '0', null, '1000', '8000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('13', 'Aromatherapy Massage', '', '2', '0', null, '1000', '7000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('14', 'Deep Tissue Massage', '', '2', '0', null, '1000', '6000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('15', 'Indian Head Massage', '', '2', '0', null, '1000', '1500', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('16', 'Hot Stone Massage', '', '2', '0', null, '1000', '3000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('17', 'Articulation Leg and Hand Massage', '', '2', '0', null, '1000', '4000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('18', 'Articulation Neck and Face Massage', '', '2', '0', null, '1000', '3000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('19', 'Steam Bath', '', '2', '0', null, '1000', '2000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('20', 'Exra 20 Min Massage', '', '2', '0', null, '1000', '2000', '0.00', '0', 'http://fagelispa.com/img/b1.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('21', 'Bikini Line Waxing', '', '3', '0', null, '1000', '2000', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('22', 'Full Bikini Waxing', '', '3', '0', null, '1000', '3000', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('23', 'Eyebrow Waxing', '', '3', '0', null, '1000', '1000', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('24', 'Armbit waxing', '', '3', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('25', 'Leg Waxing', '', '3', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('26', 'Hand Waxing', '', '3', '0', null, null, '2500', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('27', 'Around the jaw Waxing', '', '3', '0', null, null, '2500', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('28', 'Jaw Waxing', '', '3', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('29', 'Full Body Waxing', '', '3', '0', null, null, '10000', '0.00', '0', 'http://fagelispa.com/img/wax.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('30', 'Breast Enlargement', 'We offers breast enlargement services at Fageli beauty world. we can make those flat breast to become bigger and more attractive in just few seconds.\r\nOur breast enlargement therapy has no side effects and easily affordable and readily available 247.', '4', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/enl.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('31', 'Hip Enlargement', '', '4', '0', null, null, '30000', '0.00', '0', 'http://fagelispa.com/img/enl.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('32', 'Breast Firm and Lift', '', '4', '0', null, null, '60000', '0.00', '0', 'http://fagelispa.com/img/enl.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('33', 'Penis Enlargement', '', '4', '0', null, null, '10000', '0.00', '0', '', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('34', 'Stretch Mark Therapy', '', '4', '0', null, null, '35000', '0.00', '0', 'http://fagelispa.com/img/enl.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('35', 'Tommy Blast', '', '4', '0', null, null, '42000', '0.00', '0', 'http://fagelispa.com/img/enl.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('36', 'Machine Detox Therapy', '', '5', '0', null, null, '3500', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('37', 'Powder Detox Therapy', '', '5', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('38', 'Disk Foot Treatment/Pedicure', '', '5', '0', null, null, '4000', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('39', 'Pedicure', '', '5', '0', null, null, '2500', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('40', 'Manicure', '', '5', '0', null, null, '1000', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('41', 'Body Analyzer', '', '5', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('42', 'Skin Test', '', '5', '0', null, null, '1000', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('43', 'Semi Permanent (Christian eye Brow)', '', '5', '0', null, null, '7000', '0.00', '0', 'http://fagelispa.com/img/det.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('44', 'Foot Treatment', '', '6', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('45', 'Palm Treatment', '', '6', '0', null, null, '1000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('46', 'Foot/Palm Treatment', '', '6', '0', null, null, '2000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('47', 'Back Treatment', '', '6', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('48', 'Buttocks Treatment', '', '6', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('49', 'Teet Whitening', '', '6', '0', null, null, '3500', '0.00', '0', 'http://fagelispa.com/img/teeth.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('50', 'Teet Whitening Powder', '', '6', '0', null, null, '5000', '0.00', '0', 'http://fagelispa.com/img/teeth.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('51', 'Make Over Treatment', '', '6', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('52', 'Eyebrow Twizing Treatment', '', '6', '0', null, null, '1000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('53', 'Eyebrow Shaping (Razor)', '', '6', '0', null, null, '500', '0.00', '0', 'http://fagelispa.com/img/eye.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('54', 'Eyebrow Threading ', '', '6', '0', null, null, '1500', '0.00', '0', 'http://fagelispa.com/img/eye.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('55', 'Full Face Threading', '', '6', '0', null, null, '3000', '0.00', '0', 'http://fagelispa.com/img/eye.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('56', 'Fageli Morocam Hammam (Basic)', 'Peels of dead skin cells from the skin and the skin comes out fresh and new like a new born baby skin. Makes the skin healthy and skin can now respond very well to any cream, soap or medication. (Moracan Soap/Herbs/Mud) Done every 29 days', '7', '0', null, null, '8000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('57', 'Fageli Morocan Hammam (Sucular)', 'Peels of Dead skin cells from the skins. Makes the skin healthy. Gives the skin a smooth and fresh looking skin like a new born baby skin. Tones and brightens the complexion. Plus firmings and tightennings the intimate path. (Morocan Soap/Herbs/Firming Herbs) Done every 29 days', '7', '0', null, null, '10000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('58', 'Fageli Body Polishing/Whitening', 'Clears Dead Cells from the skin, regenerate new skin cells, Stimulate collagen Production, Smoothen the skin, removes dark spot, brighteness stretch marks, facilitate the skin to respond quick to lightening creams, removes dark knuckles and tones the skin', '7', '0', null, null, '8000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('59', 'Fageli Salt/Sugar Body Treatment', 'Clears dead cells from the skin, removes rough and flarky skin. Removes impurity from the skin such as exzema, rashes, allergy, blemishes. Smothens and brightens the complexion, firms the skin. Stimulates collagen production and smoothens the skin', '7', '0', null, null, '7000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `items` VALUES ('60', 'Natural Body Peel/Bleaching Treatment', 'Clear impurity, brightens dull skin, removes dark complexion and gives a lighter and fairer complexion. Removes dark spot and knuckles. Gives spotless skin. Nourishes, softens, Moisturizes and keeps the skin healthy', '7', '0', null, null, '10000', '0.00', '0', 'http://fagelispa.com/img/ski.jpg', null, null, '0', null, '2015-09-11 20:12:15');
INSERT INTO `menu` VALUES ('001', 'Setups', '#', '#', '', '0', '2009-10-27 16:00:00', '1');
INSERT INTO `menu` VALUES ('002', 'Edit', '#', '#', '', '0', '2011-08-28 18:43:05', '5');
INSERT INTO `menu` VALUES ('003', 'Resources', 'menu_list.php', '001', '', '1', '2010-02-02 00:00:00', '2');
INSERT INTO `menu` VALUES ('004', 'User List', 'user_list.php', '001', '', '1', '2011-08-28 18:48:34', '7');
INSERT INTO `menu` VALUES ('005', 'Role List', 'role_list.php', '001', '', '1', '2011-08-28 18:49:19', '8');
INSERT INTO `menu` VALUES ('006', 'MenuGroup', 'menugroup.php', '002', '', '1', '2011-09-01 17:29:49', '13');
INSERT INTO `menu` VALUES ('016', 'Service Category List', 'category_list.php', '001', '', '1', '2015-10-21 19:06:48', '0');
INSERT INTO `menu` VALUES ('017', 'Services Item Listss', 'items_list.php', '001', '', '1', '2016-02-11 13:13:38', '0');
INSERT INTO `menu` VALUES ('018', 'Role Menu Assignment', 'role_menu_demo.php', '001', '', '1', '2016-02-22 13:46:19', '0');
INSERT INTO `menugroup` VALUES ('001', '001');
INSERT INTO `menugroup` VALUES ('001', '002');
INSERT INTO `menugroup` VALUES ('001', '003');
INSERT INTO `menugroup` VALUES ('001', '004');
INSERT INTO `menugroup` VALUES ('001', '005');
INSERT INTO `menugroup` VALUES ('001', '006');
INSERT INTO `menugroup` VALUES ('501', '004');
INSERT INTO `menugroup` VALUES ('501', '005');
INSERT INTO `menugroup` VALUES ('501', '006');
INSERT INTO `menugroup` VALUES ('501', '016');
INSERT INTO `menugroup` VALUES ('501', '017');
INSERT INTO `menugroup` VALUES ('501', '018');
INSERT INTO `parameter` VALUES ('VUVVA_MERCHANT', 'ACC-VMCHT0459', '1', 'Merchant ID');
INSERT INTO `parameter` VALUES ('ADMIN_EMAIL', 'gkpuma4all@gmail.com', '1', 'Admin email');
INSERT INTO `parameter` VALUES ('working_hours', '00:00-23:59', '0', 'Allotted working hours of the day');
INSERT INTO `parameter` VALUES ('country_code', '566', '0', 'Default Country');
INSERT INTO `parameter` VALUES ('currency', 'NGN', '0', 'Default Country Currency');
INSERT INTO `parameter` VALUES ('no_of_pin_misses', '5', '0', 'Available number of pin misses allowed');
INSERT INTO `parameter` VALUES ('password_expiry_days', '30', '0', 'Number of days for password expiry');
INSERT INTO `parameter` VALUES ('sex', 'Male', '0', 'sex');
INSERT INTO `parameter` VALUES ('sex', 'Female', '0', 'sex');
INSERT INTO `parameter` VALUES ('sex', 'T.B.A', '0', 'sex');
INSERT INTO `parameter` VALUES ('501', '001', '0', 'SYSTEM ADMIN usercreation previlege');
INSERT INTO `parameter` VALUES ('501', '501', '0', '');
INSERT INTO `parameter` VALUES ('inactivity_time', '5', '1', 'Time to timeout in minutes');
INSERT INTO `role` VALUES ('001', 'Administrator', '1', '2014-11-19 05:08:40');
INSERT INTO `role` VALUES ('501', 'SYSTEM ADMIN', '1', '2012-06-14 18:01:13');
INSERT INTO `states` VALUES ('ABIA', 'Umuahia');
INSERT INTO `states` VALUES ('ADAMAWA', 'Yola');
INSERT INTO `states` VALUES ('AKWA IBOM', 'Uyo');
INSERT INTO `states` VALUES ('ANAMBRA', 'Awka');
INSERT INTO `states` VALUES ('BAUCHI', 'Bauchi');
INSERT INTO `states` VALUES ('BAYELSA', 'Yenagoa');
INSERT INTO `states` VALUES ('BENUE', 'Makurdi');
INSERT INTO `states` VALUES ('BORNO', 'Maiduguri');
INSERT INTO `states` VALUES ('CROSS RIVERS', 'Calabar');
INSERT INTO `states` VALUES ('DELTA', 'Asaba');
INSERT INTO `states` VALUES ('EBONYI', 'Abakaliki');
INSERT INTO `states` VALUES ('EDO', 'Benin City');
INSERT INTO `states` VALUES ('EKITI', 'Ado-Ekiti');
INSERT INTO `states` VALUES ('ENUGU', 'Enugu');
INSERT INTO `states` VALUES ('FCT', 'Abuja');
INSERT INTO `states` VALUES ('GOMBE', 'Gombe');
INSERT INTO `states` VALUES ('IMO', 'Owerri');
INSERT INTO `states` VALUES ('JIGAWA', 'Dutse');
INSERT INTO `states` VALUES ('KADUNA', 'Kaduna');
INSERT INTO `states` VALUES ('KANO', 'Kano');
INSERT INTO `states` VALUES ('KATSINA', 'Katsina');
INSERT INTO `states` VALUES ('KEBBI', 'Birnin Kebbi');
INSERT INTO `states` VALUES ('KOGI', 'Lokoja');
INSERT INTO `states` VALUES ('KWARA', 'Ilorin');
INSERT INTO `states` VALUES ('LAGOS', 'Ikeja');
INSERT INTO `states` VALUES ('NASSARAWA', 'Lafia');
INSERT INTO `states` VALUES ('NIGER', 'Minna');
INSERT INTO `states` VALUES ('OGUN', 'Abeokuta');
INSERT INTO `states` VALUES ('ONDO', 'Akure');
INSERT INTO `states` VALUES ('OSUN', 'Oshogbo');
INSERT INTO `states` VALUES ('OYO', 'Ibadan');
INSERT INTO `states` VALUES ('PLATEAU', 'Jos');
INSERT INTO `states` VALUES ('RIVERS', 'Port Harcourt');
INSERT INTO `states` VALUES ('SOKOTO', 'Sokoto');
INSERT INTO `states` VALUES ('TARABA', 'Jalingo');
INSERT INTO `states` VALUES ('YOBE', 'Damaturu');
INSERT INTO `states` VALUES ('ZAMFARA', 'Gusau');
INSERT INTO `userdata` VALUES ('Amigu', '0xa9b0cdd854dc3b7d', '001', null, 'Amigun ', 'Paul ', 'hhshsh@yahoo.com', '553663773737', '0', null, '2017-09-19', null, '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', null, '2017-07-21 10:58:22', null, null, '0', '', null, '0.00', '2017-07-21 10:58:22', null, null);
INSERT INTO `userdata` VALUES ('Jude', '0x63f5f51503442a9f', '001', null, 'jude', 'Aneke ', 'judeaneke@gmail.com', '09099999999', '0', null, '2020-01-01', null, '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', null, '2017-07-21 10:21:28', null, null, '0', '', null, '0.00', '2017-07-21 10:21:28', null, null);
INSERT INTO `userdata` VALUES ('systemadmin', '0x579fa7e54d27ed44', '001', null, 'System', 'Admin', 'test@domain.com', '07067047227', '0', '', '2020-07-14', '', '0', '0', '1', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '2012-06-14 19:07:50', '2012-06-14 19:07:50', '', '', '', '', null, '2012-06-19 18:35:33', '', '');
