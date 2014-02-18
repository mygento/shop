<?php

$this->startSetup();

$this->run("
DROP TABLE IF EXISTS {$this->getTable('virtrans/virtrans')};
CREATE TABLE {$this->getTable('virtrans/virtrans')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `min` varchar(255) NOT NULL,
  `nacl` varchar(255) NOT NULL,
  `level1` varchar(255) NOT NULL,
  `level2` varchar(255) NOT NULL,
  `level3` varchar(255) NOT NULL,
  `level4` varchar(255) NOT NULL,
  `level5` varchar(255) NOT NULL,
  `level6` varchar(255) NOT NULL,
  `trans` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$this->run("
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('1', 'Абакан', '4250', '250', '110', '110', '110', '110', '110', '110', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('2', 'Анадырь', '5000', '0', '155', '155', '150', '150', '150', '150', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('3', 'Анапа', '2800', '400', '30', '30', '30', '25', '25', '25', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('4', 'Архангельск', '2900', '400', '32', '32', '30', '30', '30', '30', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('5', 'Астрахань', '3450', '450', '55', '55', '55', '55', '55', '55', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('6', 'Барнаул', '3300', '400', '60', '60', '60', '55', '55', '55', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('7', 'Белоярский', '4150', '150', '100', '100', '100', '100', '100', '100', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('8', 'Благовещенск', '5650', '150', '130', '130', '130', '130', '130', '130', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('9', 'Братск', '5150', '150', '120', '120', '120', '120', '120', '120', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('10', 'Владивосток', '3500', '0', '80', '80', '75', '75', '75', '75', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('11', 'Владикавказ', '4700', '700', '75', '75', '75', '75', '75', '75', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('12', 'Волгоград', '4200', '700', '60', '60', '60', '60', '60', '60', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('13', 'Воронеж', '2200', '0', '40', '40', '50', '50', '60', '60', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('14', 'Геленджик', '3300', '400', '30', '30', '30', '30', '28', '28', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('15', 'Екатеринбург', '3100', '400', '40', '40', '38', '38', '34', '34', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('16', 'Ижевск', '4150', '150', '75', '75', '75', '75', '75', '75', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('17', 'Иркутск', '3600', '400', '70', '70', '70', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('18', 'Казань', '2300', '0', '40', '40', '40', '40', '40', '40', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('19', 'Калининград', '2900', '400', '43', '40', '37', '37', '33', '33', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('20', 'Кемерово', '4700', '700', '85', '85', '85', '85', '85', '85', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('21', 'Когалым', '3700', '400', '70', '70', '70', '70', '70', '70', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('22', 'Котлас', '3000', '100', '50', '50', '50', '50', '50', '50', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('23', 'Комсомольск на Амуре', '4150', '150', '90', '90', '90', '90', '90', '90', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('24', 'Краснодар', '3000', '400', '35', '35', '32', '32', '30', '30', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('25', 'Красноярск', '3500', '400', '60', '60', '55', '55', '53', '53', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('26', 'Курск', '3150', '150', '65', '65', '65', '65', '65', '65', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('27', 'Магадан', '5000', '0', '155', '155', '150', '150', '150', '150', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('28', 'Магнитогорск', '3400', '400', '60', '60', '60', '60', '60', '60', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('29', 'Махачкала', '3150', '150', '70', '70', '70', '70', '70', '70', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('30', 'Мин. воды', '3400', '400', '50', '50', '50', '50', '50', '50', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('31', 'Мирный', '4700', '700', '100', '100', '100', '100', '100', '100', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('32', 'Москва', '2200', '0', '24', '24', '20', '20', '20', '20', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('33', 'Мурманск', '3100', '400', '45', '40', '40', '35', '35', '32', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('34', 'Надым', '3000', '0', '65', '65', '65', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('35', 'Нальчик', '3650', '150', '75', '75', '75', '75', '75', '75', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('36', 'Нарьян-Мар', '3300', '100', '68', '68', '68', '68', '68', '68', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('37', 'Нижневартовск', '3400', '400', '55', '55', '50', '50', '50', '45', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('38', 'Нижнекамск', '4150', '150', '70', '70', '70', '70', '70', '', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('39', 'Нижний Новгород', '4000', '700', '58', '58', '58', '58', '58', '58', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('40', 'Новокузнецк', '4700', '700', '80', '80', '80', '80', '80', '80', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('41', 'Новосибирск', '4200', '700', '65', '65', '65', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('42', 'Новый Уренгой', '3900', '400', '65', '65', '65', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('43', 'Норильск', '4700', '400', '80', '80', '80', '80', '80', '80', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('44', 'Ноябрьск', '3650', '150', '85', '85', '85', '85', '85', '85', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('45', 'Нягань', '4150', '150', '120', '120', '120', '120', '120', '120', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('46', 'Омск', '3400', '400', '50', '50', '50', '50', '50', '50', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('47', 'Оренбург', '2200', '0', '45', '45', '45', '45', '45', '45', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('48', 'Петропавловск-Камчатский', '4500', '0', '120', '120', '115', '115', '110', '110', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('49', 'Пермь', '2800', '400', '30', '30', '28', '28', '25', '25', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('50', 'Пенза', '1750', '0', '35', '35', '35', '35', '35', '35', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('51', 'Ростов-на-Дону', '3000', '400', '36', '31', '30', '30', '25', '25', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('52', 'Салехард', '3000', '0', '65', '65', '65', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('53', 'Самара', '2900', '400', '32', '32', '28', '28', '25', '25', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('54', 'Саратов', '4150', '150', '110', '110', '110', '110', '110', '110', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('55', 'Советский', '3650', '150', '80', '80', '80', '80', '80', '80', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('56', 'Сочи', '3400', '400', '36', '36', '36', '36', '36', '30', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('57', 'Ставрополь', '3650', '150', '70', '70', '70', '70', '70', '70', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('58', 'Сургут', '3400', '400', '55', '55', '55', '55', '55', '55', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('59', 'Сыктывкар', '3400', '400', '65', '65', '65', '65', '65', '65', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('60', 'Томск', '4700', '700', '70', '70', '70', '70', '70', '70', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('61', 'Тюмень', '3100', '400', '40', '40', '40', '40', '40', '40', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('62', 'Улан-Удэ', '4700', '700', '90', '90', '90', '90', '90', '90', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('63', 'Ульяновск', '3150', '150', '60', '60', '60', '60', '60', '60', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('64', 'Усинск', '3200', '100', '80', '80', '80', '80', '80', '80', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('65', 'Уфа', '3100', '400', '35', '35', '33', '33', '30', '30', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('66', 'Ухта', '3900', '400', '110', '110', '110', '110', '110', '110', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('67', 'Хабаровск', '3500', '0', '80', '80', '75', '75', '75', '70', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('68', 'Ханты-Мансийск', '3650', '150', '80', '80', '80', '80', '80', '80', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('69', 'Чебоксары', '3650', '150', '80', '80', '80', '80', '80', '80', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('70', 'Челябинск', '3100', '400', '40', '40', '36', '36', '32', '32', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('71', 'Чита', '5700', '700', '110', '110', '110', '110', '110', '110', '500');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('72', 'Южно-Сахалинск', '4000', '0', '110', '110', '110', '100', '100', '100', '0');
INSERT INTO {$this->getTable('virtrans/virtrans')}` VALUES ('73', 'Якутск', '5000', '500', '135', '135', '135', '155', '155', '155', '0');
    ");

$this->endSetup();