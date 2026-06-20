-- noinspection SqlNoDataSourceInspectionForFile
-- noinspection SqlDialectInspectionForFile
INSERT IGNORE INTO `#__rsform_component_types` (`ComponentTypeId`, `ComponentTypeName`) VALUES
(600, 'switch'),
(602, 'rating'),
(603, 'advtextarea'),
(604, 'colorpicker'),
(605, 'selectize'),
(606, 'advcheckbox'),
(607, 'advradio'),
(608, 'datedropper'),
(609, 'timedropper'),
(610, 'datepicker');

DELETE FROM `#__rsform_component_type_fields` WHERE ComponentTypeId IN (600, 602, 603, 604, 605, 606, 607, 608, 609, 610) ;

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(600, 'NAME', 'textbox', '', '', 1),
(600, 'CAPTION', 'textbox', '', '', 2),
(600, 'ITEMS', 'hiddenparam', '0\r\n\1', '', 11),
(600, 'SWITCHSTATE', 'select', 'ON\r\nOFF', '', 4),
(600, 'OFFVALUE', 'textbox', '0', '', 4),
(600, 'ONVALUE', 'textbox', '1', '', 5),
(600, 'ONPRICE', 'textbox', '1', '', 6),
(600, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 6),
(600, 'DESCRIPTION', 'textarea', '', '', 7),
(600, 'COMPONENTTYPE', 'hidden', '600', '', 8),
(600, 'REQUIRED', 'select', 'NO\r\nYES', '', 9),
(600, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 10);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(602, 'NAME', 'textbox', '', '', 1),
(602, 'CAPTION', 'textbox', '', '', 2),
(602, 'NUMBERSTARS', 'textbox', '5', 'numeric', 3),
(602, 'RATINGTYPE', 'select', 'singlecolor\r\nmulticolor', '{"case":{"singlecolor":{"show":["FILLCOLOR"],"hide":["STARTCOLOR", "ENDCOLOR"]},"multicolor":{"show":["STARTCOLOR", "ENDCOLOR"],"hide":["FILLCOLOR"]}}}', 4),
(602, 'BASECOLOR', 'color', '#808080', '', 5),
(602, 'FILLCOLOR', 'color', '#F39C12', '', 6),
(602, 'STARTCOLOR', 'color', '#F39C12', '', 7),
(602, 'ENDCOLOR', 'color', '#FF0000', '', 8),
(602, 'HALFSTAR', 'select', 'NO\r\nYES', '', 9),
(602, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 9),
(602, 'DESCRIPTION', 'textarea', '', '', 10),
(602, 'COMPONENTTYPE', 'hidden', '602', '', 11),
(602, 'REQUIRED', 'select', 'NO\r\nYES', '', 12),
(602, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 13);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(603, 'NAME', 'textbox', '', '', 1),
(603, 'CAPTION', 'textbox', '', '', 2),
(603, 'REQUIRED', 'select', 'NO\r\nYES', '', 3),
(603, 'COLS', 'textbox', '50', 'numeric', 4),
(603, 'ROWS', 'textbox', '5', 'numeric', 5),
(603, 'MAXWIDTH', 'textbox', '0', 'numeric', 6),
(603, 'MAXHEIGHT', 'textbox', '0', 'numeric', 7),
(603, 'VALIDATIONRULE', 'select', '//<code>\r\nreturn RSFormProHelper::getValidationRules();\r\n//</code>', '', 6),
(603, 'VALIDATIONMULTIPLE', 'selectmultiple', '//<code>\r\nreturn RSFormProHelper::getValidationRules(false, true);\r\n//</code>', '', 6),
(603, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 7),
(603, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 8),
(603, 'DEFAULTVALUE', 'textarea', '', '', 9),
(603, 'DESCRIPTION', 'textarea', '', '', 10),
(603, 'COMPONENTTYPE', 'hidden', '603', '', 10),
(603, 'PLACEHOLDER', 'textbox', '', '', 10),
(603, 'VALIDATIONEXTRA', 'textbox', '', '', 6);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(604, 'NAME', 'textbox', '', '', 1),
(604, 'CAPTION', 'textbox', '', '', 2),
(604, 'REQUIRED', 'select', 'NO\r\nYES', '', 3),
(604, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 4),
(604, 'COMPONENTTYPE', 'hidden', '604', '', 5),
(604, 'DEFAULTVALUE', 'textarea', '#FFFFFF', '', 6),
(604, 'SHOWCOLORINPUT', 'select', 'NO\r\nYES', '', 9),
(604, 'DESCRIPTION', 'textarea', '', '', 7),
(604, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 8);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(605, 'NAME', 'textbox', '', '', 1),
(605, 'CAPTION', 'textbox', '', '', 2),
(605, 'RSFPA_THEME', 'select', 'legacy\r\nstandard\r\nbootstrap2\r\nbootstrap3', '', 3),
(605, 'MULTIPLE', 'select', 'NO\r\nYES', '{"case":{"YES":{"show":["NUMBERITEMS"],"hide":[]},"NO":{"show":[],"hide":["NUMBERITEMS"]}}}', 4),
(605, 'NUMBERITEMS', 'textbox', '3', 'numeric', 5),
(605, 'ITEMS', 'textarea', '', '', 6),
(605, 'PLACEHOLDER', 'textbox', '', '', 8),
(605, 'REQUIRED', 'select', 'NO\r\nYES', '', 7),
(605, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 8),
(605, 'DESCRIPTION', 'textarea', '', '', 9),
(605, 'COMPONENTTYPE', 'hidden', '605', '', 10),
(605, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 11);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(606, 'NAME', 'textbox', '', '', 1),
(606, 'CAPTION', 'textbox', '', '', 2),
(606, 'ITEMS', 'textarea', '', '', 3),
(606, 'FLOW', 'select', 'HORIZONTAL\r\nVERTICAL\r\nVERTICAL2COLUMNS\r\nVERTICAL3COlUMNS\r\nVERTICAL4COLUMNS\r\nVERTICAL6COLUMNS', '', 4),
(606, 'MAXSELECTIONS', 'textbox', '0', '', 5),
(606, 'REQUIRED', 'select', 'NO\r\nYES', '{"case":{"YES":{"show":["VALIDATIONMESSAGE"],"hide":[]},"NO":{"show":[],"hide":["VALIDATIONMESSAGE"]}}}', 5),
(606, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 6),
(606, 'DESCRIPTION', 'textarea', '', '', 7),
(606, 'COMPONENTTYPE', 'hidden', '606', '', 8),
(606, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 9);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(607, 'NAME', 'textbox', '', '', 1),
(607, 'CAPTION', 'textbox', '', '', 2),
(607, 'ITEMS', 'textarea', '', '', 3),
(607, 'FLOW', 'select', 'HORIZONTAL\r\nVERTICAL\r\nVERTICAL2COLUMNS\r\nVERTICAL3COlUMNS\r\nVERTICAL4COLUMNS\r\nVERTICAL6COLUMNS', '', 4),
(607, 'REQUIRED', 'select', 'NO\r\nYES', '{"case":{"YES":{"show":["VALIDATIONMESSAGE"],"hide":[]},"NO":{"show":[],"hide":["VALIDATIONMESSAGE"]}}}', 5),
(607, 'ADDITIONALATTRIBUTES', 'textarea', '', '', 6),
(607, 'DESCRIPTION', 'textarea', '', '', 6),
(607, 'COMPONENTTYPE', 'hidden', '607', '', 7),
(607, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '', 8);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(608, 'NAME', 'textbox', '', '', 1),
(608, 'CAPTION', 'textbox', '', '', 2),
(608, 'INIT_ANIMATION', 'select', 'fadein\r\nbounce\r\ndropdown', '', 3),
(608, 'DATE_FORMAT', 'textbox', 'm-d-Y', '', 4),
(608, 'DEFAULTVALUE', 'textarea', '', '', 5),
(608, 'FORCE_DATE', 'select', 'disabled\r\nfrom\r\nto', '',  6),
(608, 'MINYEAR', 'textbox', '1970', 'numeric',  7),
(608, 'MAXYEAR', 'textbox', '', 'numeric',  8),
(608, 'YEARSRANGE', 'textbox', '10', 'numeric',  9),
(608, 'DROPPRIMARYCOLOR', 'color', '#01CEFF', '',  10),
(608, 'DROPTEXTCOLOR', 'color', '#333333', '',  11),
(608, 'DROPBACKGROUNDCOLOR', 'color', '#FFFFFF', '',  12),
(608, 'DROPBORDER', 'textbox', '1px solid #08C', '',  13),
(608, 'DROPBORDERRADIUS', 'textbox', '8', 'numeric',  14),
(608, 'DROPSHADOW', 'textbox', '0 0 10px 0 rgba(0, 136, 204, 0.45)', '',  15),
(608, 'DROPWIDTH', 'textbox', '124', 'numeric',  16),
(608, 'ADDITIONALATTRIBUTES', 'textarea', '', '',  17),
(608, 'DESCRIPTION', 'textarea', '', '',  18),
(608, 'COMPONENTTYPE', 'hidden', '608', '',  19),
(608, 'REQUIRED', 'select', 'NO\r\nYES', '',  20),
(608, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '',  21);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(609, 'NAME', 'textbox', '', '', 1),
(609, 'CAPTION', 'textbox', '', '', 2),
(609, 'MERIDIANS', 'select', 'NO\r\nYES', '', 4),
(609, 'TIME_FORMAT', 'textbox', 'hh:mm A', '', 5),
(609, 'TIME_INIT_ANIMATION', 'select', 'fadein\r\nbounce\r\ndropdown', '',  7),
(609, 'SETCURRENTTIME', 'select', 'NO\r\nYES', '',  8),
(609, 'PRIMARYCOLOR', 'color', '#1977CC', '',  9),
(609, 'TEXTCOLOR', 'color', '#555555', '',  10),
(609, 'BACKGROUNDCOLOR', 'color', '#FFFFFF', '',  11),
(609, 'BORDERCOLOR', 'color', '#1977CC', '',  12),
(609, 'ADDITIONALATTRIBUTES', 'textarea', '', '',  13),
(609, 'DEFAULTVALUE', 'textarea', '', '', 14),
(609, 'COMPONENTTYPE', 'hidden', '609', '',  15),
(609, 'REQUIRED', 'select', 'NO\r\nYES', '',  16),
(609, 'DESCRIPTION', 'textarea', '', '',  17),
(609, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '',  18);

INSERT IGNORE INTO `#__rsform_component_type_fields` (`ComponentTypeId`, `FieldName`, `FieldType`, `FieldValues`, `Properties`, `Ordering`) VALUES
(610, 'NAME', 'textbox', '', '', 1),
(610, 'CAPTION', 'textbox', '', '', 2),
(610, 'DEFAULTVALUE', 'textarea', '', '', 3),
(610, 'DESCRIPTION', 'textarea', '', '',  4),
(610, 'REQUIRED', 'select', 'NO\r\nYES', '',  5),
(610, 'VALIDATIONCALENDAR', 'select', '//<code>\r\nreturn RSFormProHelper::getOtherCalendars(610);\r\n//</code>', '{"case":{"":{"show":[],"hide":["VALIDATIONCALENDAROFFSET"]}},"indexcase":{"min":{"show":["VALIDATIONCALENDAROFFSET"],"hide":[]},"max":{"show":["VALIDATIONCALENDAROFFSET"],"hide":[]}}}',  6),
(610, 'VALIDATIONCALENDAROFFSET', 'textbox', '1', 'numeric', 7),
(610, 'VALIDATIONDATE', 'select', 'YES\r\nNO', '', 8),
(610, 'VALIDATIONMESSAGE', 'textarea', 'INVALIDINPUT', '',  9),
(610, 'DATE_FORMAT_PICKER', 'textbox', 'm/d/Y', '', 10),
(610, 'MINDATE', 'textarea', '', '', 11),
(610, 'MAXDATE', 'textarea', '', '', 12),
(610, 'SELECTYEARS', 'select', 'NO\r\nYES', '', 13),
(610, 'SELECTMONTHS', 'select', 'NO\r\nYES', '', 14),
(610, 'FIRSTDAYOFWEEK', 'select', 'day0\r\nday1', '', 15),
(610, 'WEEKDAYFORMAT', 'select', 'FULL\r\nSHORT', '', 16),
(610, 'MONTHSFORMAT', 'select', 'FULL\r\nSHORT', '', 17),
(610, 'READONLY', 'select', 'NO\r\nYES', '', 18),
(610, 'DISABLEALL', 'select', 'NO\r\nYES', '{"case":{"YES":{"show":[],"hide":["DAYSOFWEEKDISABLED"]},"NO":{"show":["DAYSOFWEEKDISABLED"],"hide":[]}}}', 19),
(610, 'DAYSOFWEEKDISABLED', 'textbox', '', '', 20),
(610, 'DISABLEEXCEPTIONS', 'textarea', '', '', 21),
(610, 'ADDITIONALATTRIBUTES', 'textarea', '', '',  22),
(610, 'COMPONENTTYPE', 'hidden', '610', '',  23);