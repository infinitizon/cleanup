ALTER TABLE `PARTY_` 
ADD COLUMN `ISPHONEPROCESSED_` TINYINT(1) NULL DEFAULT 0 AFTER `PHOTO_ID`;

ALTER TABLE `PARTY_` 
ADD COLUMN `ISVALIDPHONENUMBER_` TINYINT(1) NULL DEFAULT 0 AFTER `ISPHONEPROCESSED_`;


ALTER TABLE `GEOGRAPHICBOUNDARY_` 
ADD COLUMN `COUNTRYPHONECODE_` VARCHAR(45) NULL AFTER `GEOCODE_`;


ALTER TABLE `ACCOUNT_` 
ADD COLUMN `LEGACYACCOUNTNUMBER_` VARCHAR(255) NULL AFTER `TREASURYBILLNUMBER_`;


ALTER TABLE `GEOGRAPHICBOUNDARY_` 
CHANGE COLUMN `COUNTRYPHONECODE_` `COUNTRYCALLINGCODE_` VARCHAR(45) NULL DEFAULT NULL ,
ADD COLUMN `LOCALECODE_` VARCHAR(45) NULL AFTER `COUNTRYCALLINGCODE_`;

ALTER TABLE `PARTYROLE_` 
ADD COLUMN `LEGACYNUMBER_` VARCHAR(45) NULL AFTER `CUSTOMERID_`;

ALTER TABLE `GEOGRAPHICBOUNDARY_` 
ADD COLUMN `IBROKERMAPPING_` VARCHAR(45) NULL AFTER `COUNTY_COUNTYCITIES_ID`;


update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AFG', COUNTRYCALLINGCODE_ = '93', LOCALECODE_ = 'AF ' WHERE NAME_ = 'Afghanistan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ALB', COUNTRYCALLINGCODE_ = '355', LOCALECODE_ = 'AL ' WHERE NAME_ = 'Albania';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DZA', COUNTRYCALLINGCODE_ = '213', LOCALECODE_ = 'DZ ' WHERE NAME_ = 'Algeria';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ASM', COUNTRYCALLINGCODE_ = '1 684', LOCALECODE_ = 'AS ' WHERE NAME_ = 'American Samoa';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AND', COUNTRYCALLINGCODE_ = '376', LOCALECODE_ = 'AD' WHERE NAME_ = 'Andorra';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AGO', COUNTRYCALLINGCODE_ = '244', LOCALECODE_ = 'AO ' WHERE NAME_ = 'Angola';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AIA', COUNTRYCALLINGCODE_ = '1 264', LOCALECODE_ = 'AI ' WHERE NAME_ = 'Anguilla';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ATA', COUNTRYCALLINGCODE_ = '672', LOCALECODE_ = 'AQ ' WHERE NAME_ = 'Antarctica';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ATG', COUNTRYCALLINGCODE_ = '1 268', LOCALECODE_ = 'AG ' WHERE NAME_ = 'Antigua and Barbuda';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ARG', COUNTRYCALLINGCODE_ = '54', LOCALECODE_ = 'AR ' WHERE NAME_ = 'Argentina';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ARM', COUNTRYCALLINGCODE_ = '374', LOCALECODE_ = 'AM ' WHERE NAME_ = 'Armenia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ABW', COUNTRYCALLINGCODE_ = '297', LOCALECODE_ = 'AW ' WHERE NAME_ = 'Aruba';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AUS', COUNTRYCALLINGCODE_ = '61', LOCALECODE_ = 'AU ' WHERE NAME_ = 'Australia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AUT', COUNTRYCALLINGCODE_ = '43', LOCALECODE_ = 'AT ' WHERE NAME_ = 'Austria';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'AZE', COUNTRYCALLINGCODE_ = '994', LOCALECODE_ = 'AZ ' WHERE NAME_ = 'Azerbaijan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BHS', COUNTRYCALLINGCODE_ = '1 242', LOCALECODE_ = 'BS ' WHERE NAME_ = 'Bahamas';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BHR', COUNTRYCALLINGCODE_ = '973', LOCALECODE_ = 'BH ' WHERE NAME_ = 'Bahrain';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BGD', COUNTRYCALLINGCODE_ = '880', LOCALECODE_ = 'BD ' WHERE NAME_ = 'Bangladesh';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BRB', COUNTRYCALLINGCODE_ = '1 246', LOCALECODE_ = 'BB ' WHERE NAME_ = 'Barbados';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BLR', COUNTRYCALLINGCODE_ = '375', LOCALECODE_ = 'BY ' WHERE NAME_ = 'Belarus';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BEL', COUNTRYCALLINGCODE_ = '32', LOCALECODE_ = 'BE ' WHERE NAME_ = 'Belgium';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BLZ', COUNTRYCALLINGCODE_ = '501', LOCALECODE_ = 'BZ ' WHERE NAME_ = 'Belize';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BEN', COUNTRYCALLINGCODE_ = '229', LOCALECODE_ = 'BJ ' WHERE NAME_ = 'Benin';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BMU', COUNTRYCALLINGCODE_ = '1 441', LOCALECODE_ = 'BM ' WHERE NAME_ = 'Bermuda';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BTN', COUNTRYCALLINGCODE_ = '975', LOCALECODE_ = 'BT ' WHERE NAME_ = 'Bhutan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BOL', COUNTRYCALLINGCODE_ = '591', LOCALECODE_ = 'BO ' WHERE NAME_ = 'Bolivia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BIH', COUNTRYCALLINGCODE_ = '387', LOCALECODE_ = 'BA ' WHERE NAME_ = 'Bosnia and Herzegovina';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BWA', COUNTRYCALLINGCODE_ = '267', LOCALECODE_ = 'BW ' WHERE NAME_ = 'Botswana';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BRA', COUNTRYCALLINGCODE_ = '55', LOCALECODE_ = 'BR ' WHERE NAME_ = 'Brazil';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IOT', COUNTRYCALLINGCODE_ = '', LOCALECODE_ = 'IO ' WHERE NAME_ = 'British Indian Ocean Territory';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VGB', COUNTRYCALLINGCODE_ = '1 284', LOCALECODE_ = 'VG ' WHERE NAME_ = 'British Virgin Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BRN', COUNTRYCALLINGCODE_ = '673', LOCALECODE_ = 'BN ' WHERE NAME_ = 'Brunei';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BGR', COUNTRYCALLINGCODE_ = '359', LOCALECODE_ = 'BG ' WHERE NAME_ = 'Bulgaria';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BFA', COUNTRYCALLINGCODE_ = '226', LOCALECODE_ = 'BF ' WHERE NAME_ = 'Burkina Faso';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MMR', COUNTRYCALLINGCODE_ = '95', LOCALECODE_ = 'MM ' WHERE NAME_ = 'Burma (Myanmar)';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BDI', COUNTRYCALLINGCODE_ = '257', LOCALECODE_ = 'BI ' WHERE NAME_ = 'Burundi';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KHM', COUNTRYCALLINGCODE_ = '855', LOCALECODE_ = 'KH ' WHERE NAME_ = 'Cambodia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CMR', COUNTRYCALLINGCODE_ = '237', LOCALECODE_ = 'CM ' WHERE NAME_ = 'Cameroon';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CAN', COUNTRYCALLINGCODE_ = '1', LOCALECODE_ = 'CA ' WHERE NAME_ = 'Canada';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CPV', COUNTRYCALLINGCODE_ = '238', LOCALECODE_ = 'CV ' WHERE NAME_ = 'Cape Verde';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CYM', COUNTRYCALLINGCODE_ = '1 345', LOCALECODE_ = 'KY ' WHERE NAME_ = 'Cayman Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CAF', COUNTRYCALLINGCODE_ = '236', LOCALECODE_ = 'CF ' WHERE NAME_ = 'Central African Republic';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TCD', COUNTRYCALLINGCODE_ = '235', LOCALECODE_ = 'TD ' WHERE NAME_ = 'Chad';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CHL', COUNTRYCALLINGCODE_ = '56', LOCALECODE_ = 'CL ' WHERE NAME_ = 'Chile';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CHN', COUNTRYCALLINGCODE_ = '86', LOCALECODE_ = 'CN ' WHERE NAME_ = 'China';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CXR', COUNTRYCALLINGCODE_ = '61', LOCALECODE_ = 'CX ' WHERE NAME_ = 'Christmas Island';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CCK', COUNTRYCALLINGCODE_ = '61', LOCALECODE_ = 'CC ' WHERE NAME_ = 'Cocos (Keeling) Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'COL', COUNTRYCALLINGCODE_ = '57', LOCALECODE_ = 'CO ' WHERE NAME_ = 'Colombia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'COM', COUNTRYCALLINGCODE_ = '269', LOCALECODE_ = 'KM ' WHERE NAME_ = 'Comoros';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'COK', COUNTRYCALLINGCODE_ = '682', LOCALECODE_ = 'CK ' WHERE NAME_ = 'Cook Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CRC', COUNTRYCALLINGCODE_ = '506', LOCALECODE_ = 'CR ' WHERE NAME_ = 'Costa Rica';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'HRV', COUNTRYCALLINGCODE_ = '385', LOCALECODE_ = 'HR ' WHERE NAME_ = 'Croatia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CUB', COUNTRYCALLINGCODE_ = '53', LOCALECODE_ = 'CU ' WHERE NAME_ = 'Cuba';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CYP', COUNTRYCALLINGCODE_ = '357', LOCALECODE_ = 'CY ' WHERE NAME_ = 'Cyprus';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CZE', COUNTRYCALLINGCODE_ = '420', LOCALECODE_ = 'CZ ' WHERE NAME_ = 'Czech Republic';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'COD', COUNTRYCALLINGCODE_ = '243', LOCALECODE_ = 'CD ' WHERE NAME_ = 'Democratic Republic of the Congo';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DNK', COUNTRYCALLINGCODE_ = '45', LOCALECODE_ = 'DK ' WHERE NAME_ = 'Denmark';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DJI', COUNTRYCALLINGCODE_ = '253', LOCALECODE_ = 'DJ ' WHERE NAME_ = 'Djibouti';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DMA', COUNTRYCALLINGCODE_ = '1 767', LOCALECODE_ = 'DM ' WHERE NAME_ = 'Dominica';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DOM', COUNTRYCALLINGCODE_ = '1 809', LOCALECODE_ = 'DO ' WHERE NAME_ = 'Dominican Republic';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ECU', COUNTRYCALLINGCODE_ = '593', LOCALECODE_ = 'EC ' WHERE NAME_ = 'Ecuador';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'EGY', COUNTRYCALLINGCODE_ = '20', LOCALECODE_ = 'EG ' WHERE NAME_ = 'Egypt';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SLV', COUNTRYCALLINGCODE_ = '503', LOCALECODE_ = 'SV ' WHERE NAME_ = 'El Salvador';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GNQ', COUNTRYCALLINGCODE_ = '240', LOCALECODE_ = 'GQ ' WHERE NAME_ = 'Equatorial Guinea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ERI', COUNTRYCALLINGCODE_ = '291', LOCALECODE_ = 'ER ' WHERE NAME_ = 'Eritrea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'EST', COUNTRYCALLINGCODE_ = '372', LOCALECODE_ = 'EE ' WHERE NAME_ = 'Estonia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ETH', COUNTRYCALLINGCODE_ = '251', LOCALECODE_ = 'ET ' WHERE NAME_ = 'Ethiopia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FLK', COUNTRYCALLINGCODE_ = '500', LOCALECODE_ = 'FK ' WHERE NAME_ = 'Falkland Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FRO', COUNTRYCALLINGCODE_ = '298', LOCALECODE_ = 'FO ' WHERE NAME_ = 'Faroe Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FJI', COUNTRYCALLINGCODE_ = '679', LOCALECODE_ = 'FJ ' WHERE NAME_ = 'Fiji';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FIN', COUNTRYCALLINGCODE_ = '358', LOCALECODE_ = 'FI ' WHERE NAME_ = 'Finland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FRA', COUNTRYCALLINGCODE_ = '33', LOCALECODE_ = 'FR ' WHERE NAME_ = 'France';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PYF', COUNTRYCALLINGCODE_ = '689', LOCALECODE_ = 'PF ' WHERE NAME_ = 'French Polynesia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GAB', COUNTRYCALLINGCODE_ = '241', LOCALECODE_ = 'GA ' WHERE NAME_ = 'Gabon';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GMB', COUNTRYCALLINGCODE_ = '220', LOCALECODE_ = 'GM ' WHERE NAME_ = 'Gambia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GEO', COUNTRYCALLINGCODE_ = '995', LOCALECODE_ = 'GE ' WHERE NAME_ = 'Georgia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'DEU', COUNTRYCALLINGCODE_ = '49', LOCALECODE_ = 'DE ' WHERE NAME_ = 'Germany';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GHA', COUNTRYCALLINGCODE_ = '233', LOCALECODE_ = 'GH ' WHERE NAME_ = 'Ghana';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GIB', COUNTRYCALLINGCODE_ = '350', LOCALECODE_ = 'GI ' WHERE NAME_ = 'Gibraltar';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GRC', COUNTRYCALLINGCODE_ = '30', LOCALECODE_ = 'GR ' WHERE NAME_ = 'Greece';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GRL', COUNTRYCALLINGCODE_ = '299', LOCALECODE_ = 'GL ' WHERE NAME_ = 'Greenland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GRD', COUNTRYCALLINGCODE_ = '1 473', LOCALECODE_ = 'GD ' WHERE NAME_ = 'Grenada';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GUM', COUNTRYCALLINGCODE_ = '1 671', LOCALECODE_ = 'GU ' WHERE NAME_ = 'Guam';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GTM', COUNTRYCALLINGCODE_ = '502', LOCALECODE_ = 'GT ' WHERE NAME_ = 'Guatemala';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GIN', COUNTRYCALLINGCODE_ = '224', LOCALECODE_ = 'GN ' WHERE NAME_ = 'Guinea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GNB', COUNTRYCALLINGCODE_ = '245', LOCALECODE_ = 'GW ' WHERE NAME_ = 'Guinea-Bissau';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GUY', COUNTRYCALLINGCODE_ = '592', LOCALECODE_ = 'GY ' WHERE NAME_ = 'Guyana';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'HTI', COUNTRYCALLINGCODE_ = '509', LOCALECODE_ = 'HT ' WHERE NAME_ = 'Haiti';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VAT', COUNTRYCALLINGCODE_ = '39', LOCALECODE_ = 'VA ' WHERE NAME_ = 'Holy See (Vatican City)';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'HND', COUNTRYCALLINGCODE_ = '504', LOCALECODE_ = 'HN ' WHERE NAME_ = 'Honduras';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'HKG', COUNTRYCALLINGCODE_ = '852', LOCALECODE_ = 'HK ' WHERE NAME_ = 'Hong Kong';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'HUN', COUNTRYCALLINGCODE_ = '36', LOCALECODE_ = 'HU ' WHERE NAME_ = 'Hungary';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IS', COUNTRYCALLINGCODE_ = '354', LOCALECODE_ = 'IS ' WHERE NAME_ = 'Iceland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IND', COUNTRYCALLINGCODE_ = '91', LOCALECODE_ = 'IN ' WHERE NAME_ = 'India';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IDN', COUNTRYCALLINGCODE_ = '62', LOCALECODE_ = 'ID ' WHERE NAME_ = 'Indonesia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IRN', COUNTRYCALLINGCODE_ = '98', LOCALECODE_ = 'IR ' WHERE NAME_ = 'Iran';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IRQ', COUNTRYCALLINGCODE_ = '964', LOCALECODE_ = 'IQ ' WHERE NAME_ = 'Iraq';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IRL', COUNTRYCALLINGCODE_ = '353', LOCALECODE_ = 'IE ' WHERE NAME_ = 'Ireland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'IMN', COUNTRYCALLINGCODE_ = '44', LOCALECODE_ = 'IM ' WHERE NAME_ = 'Isle of Man';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ISR', COUNTRYCALLINGCODE_ = '972', LOCALECODE_ = 'IL ' WHERE NAME_ = 'Israel';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ITA', COUNTRYCALLINGCODE_ = '39', LOCALECODE_ = 'IT ' WHERE NAME_ = 'Italy';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CIV', COUNTRYCALLINGCODE_ = '225', LOCALECODE_ = 'CI ' WHERE NAME_ = 'Ivory Coast';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'JAM', COUNTRYCALLINGCODE_ = '1 876', LOCALECODE_ = 'JM ' WHERE NAME_ = 'Jamaica';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'JPN', COUNTRYCALLINGCODE_ = '81', LOCALECODE_ = 'JP ' WHERE NAME_ = 'Japan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'JEY', COUNTRYCALLINGCODE_ = '', LOCALECODE_ = 'JE ' WHERE NAME_ = 'Jersey';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'JOR', COUNTRYCALLINGCODE_ = '962', LOCALECODE_ = 'JO ' WHERE NAME_ = 'Jordan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KAZ', COUNTRYCALLINGCODE_ = '7', LOCALECODE_ = 'KZ ' WHERE NAME_ = 'Kazakhstan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KEN', COUNTRYCALLINGCODE_ = '254', LOCALECODE_ = 'KE ' WHERE NAME_ = 'Kenya';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KIR', COUNTRYCALLINGCODE_ = '686', LOCALECODE_ = 'KI ' WHERE NAME_ = 'Kiribati';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  '', COUNTRYCALLINGCODE_ = '381', LOCALECODE_ = '' WHERE NAME_ = 'Kosovo';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KWT', COUNTRYCALLINGCODE_ = '965', LOCALECODE_ = 'KW ' WHERE NAME_ = 'Kuwait';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KGZ', COUNTRYCALLINGCODE_ = '996', LOCALECODE_ = 'KG ' WHERE NAME_ = 'Kyrgyzstan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LAO', COUNTRYCALLINGCODE_ = '856', LOCALECODE_ = 'LA ' WHERE NAME_ = 'Laos';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LVA', COUNTRYCALLINGCODE_ = '371', LOCALECODE_ = 'LV ' WHERE NAME_ = 'Latvia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LBN', COUNTRYCALLINGCODE_ = '961', LOCALECODE_ = 'LB ' WHERE NAME_ = 'Lebanon';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LSO', COUNTRYCALLINGCODE_ = '266', LOCALECODE_ = 'LS ' WHERE NAME_ = 'Lesotho';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LBR', COUNTRYCALLINGCODE_ = '231', LOCALECODE_ = 'LR ' WHERE NAME_ = 'Liberia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LBY', COUNTRYCALLINGCODE_ = '218', LOCALECODE_ = 'LY ' WHERE NAME_ = 'Libya';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LIE', COUNTRYCALLINGCODE_ = '423', LOCALECODE_ = 'LI ' WHERE NAME_ = 'Liechtenstein';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LTU', COUNTRYCALLINGCODE_ = '370', LOCALECODE_ = 'LT ' WHERE NAME_ = 'Lithuania';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LUX', COUNTRYCALLINGCODE_ = '352', LOCALECODE_ = 'LU ' WHERE NAME_ = 'Luxembourg';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MAC', COUNTRYCALLINGCODE_ = '853', LOCALECODE_ = 'MO ' WHERE NAME_ = 'Macau';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MKD', COUNTRYCALLINGCODE_ = '389', LOCALECODE_ = 'MK ' WHERE NAME_ = 'Macedonia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MDG', COUNTRYCALLINGCODE_ = '261', LOCALECODE_ = 'MG ' WHERE NAME_ = 'Madagascar';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MWI', COUNTRYCALLINGCODE_ = '265', LOCALECODE_ = 'MW ' WHERE NAME_ = 'Malawi';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MYS', COUNTRYCALLINGCODE_ = '60', LOCALECODE_ = 'MY ' WHERE NAME_ = 'Malaysia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MDV', COUNTRYCALLINGCODE_ = '960', LOCALECODE_ = 'MV ' WHERE NAME_ = 'Maldives';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MLI', COUNTRYCALLINGCODE_ = '223', LOCALECODE_ = 'ML ' WHERE NAME_ = 'Mali';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MLT', COUNTRYCALLINGCODE_ = '356', LOCALECODE_ = 'MT ' WHERE NAME_ = 'Malta';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MHL', COUNTRYCALLINGCODE_ = '692', LOCALECODE_ = 'MH ' WHERE NAME_ = 'Marshall Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MRT', COUNTRYCALLINGCODE_ = '222', LOCALECODE_ = 'MR ' WHERE NAME_ = 'Mauritania';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MUS', COUNTRYCALLINGCODE_ = '230', LOCALECODE_ = 'MU ' WHERE NAME_ = 'Mauritius';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MYT', COUNTRYCALLINGCODE_ = '262', LOCALECODE_ = 'YT ' WHERE NAME_ = 'Mayotte';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MEX', COUNTRYCALLINGCODE_ = '52', LOCALECODE_ = 'MX ' WHERE NAME_ = 'Mexico';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'FSM', COUNTRYCALLINGCODE_ = '691', LOCALECODE_ = 'FM ' WHERE NAME_ = 'Micronesia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MDA', COUNTRYCALLINGCODE_ = '373', LOCALECODE_ = 'MD ' WHERE NAME_ = 'Moldova';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MCO', COUNTRYCALLINGCODE_ = '377', LOCALECODE_ = 'MC ' WHERE NAME_ = 'Monaco';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MNG', COUNTRYCALLINGCODE_ = '976', LOCALECODE_ = 'MN ' WHERE NAME_ = 'Mongolia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MNE', COUNTRYCALLINGCODE_ = '382', LOCALECODE_ = 'ME ' WHERE NAME_ = 'Montenegro';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MSR', COUNTRYCALLINGCODE_ = '1 664', LOCALECODE_ = 'MS ' WHERE NAME_ = 'Montserrat';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MAR', COUNTRYCALLINGCODE_ = '212', LOCALECODE_ = 'MA ' WHERE NAME_ = 'Morocco';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MOZ', COUNTRYCALLINGCODE_ = '258', LOCALECODE_ = 'MZ ' WHERE NAME_ = 'Mozambique';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NAM', COUNTRYCALLINGCODE_ = '264', LOCALECODE_ = 'NA ' WHERE NAME_ = 'Namibia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NRU', COUNTRYCALLINGCODE_ = '674', LOCALECODE_ = 'NR ' WHERE NAME_ = 'Nauru';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NPL', COUNTRYCALLINGCODE_ = '977', LOCALECODE_ = 'NP ' WHERE NAME_ = 'Nepal';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NLD', COUNTRYCALLINGCODE_ = '31', LOCALECODE_ = 'NL ' WHERE NAME_ = 'Netherlands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ANT', COUNTRYCALLINGCODE_ = '599', LOCALECODE_ = 'AN ' WHERE NAME_ = 'Netherlands Antilles';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NCL', COUNTRYCALLINGCODE_ = '687', LOCALECODE_ = 'NC ' WHERE NAME_ = 'New Caledonia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NZL', COUNTRYCALLINGCODE_ = '64', LOCALECODE_ = 'NZ ' WHERE NAME_ = 'New Zealand';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NIC', COUNTRYCALLINGCODE_ = '505', LOCALECODE_ = 'NI ' WHERE NAME_ = 'Nicaragua';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NER', COUNTRYCALLINGCODE_ = '227', LOCALECODE_ = 'NE ' WHERE NAME_ = 'Niger';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NGA', COUNTRYCALLINGCODE_ = '234', LOCALECODE_ = 'NG ' WHERE NAME_ = 'Nigeria';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NIU', COUNTRYCALLINGCODE_ = '683', LOCALECODE_ = 'NU ' WHERE NAME_ = 'Niue';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'K', COUNTRYCALLINGCODE_ = '672', LOCALECODE_ = '' WHERE NAME_ = 'Norfolk Island';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PRK', COUNTRYCALLINGCODE_ = '850', LOCALECODE_ = 'KP ' WHERE NAME_ = 'North Korea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MNP', COUNTRYCALLINGCODE_ = '1 670', LOCALECODE_ = 'MP ' WHERE NAME_ = 'Northern Mariana Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'NOR', COUNTRYCALLINGCODE_ = '47', LOCALECODE_ = 'NO ' WHERE NAME_ = 'Norway';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'OMN', COUNTRYCALLINGCODE_ = '968', LOCALECODE_ = 'OM ' WHERE NAME_ = 'Oman';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PAK', COUNTRYCALLINGCODE_ = '92', LOCALECODE_ = 'PK ' WHERE NAME_ = 'Pakistan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PLW', COUNTRYCALLINGCODE_ = '680', LOCALECODE_ = 'PW ' WHERE NAME_ = 'Palau';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PAN', COUNTRYCALLINGCODE_ = '507', LOCALECODE_ = 'PA ' WHERE NAME_ = 'Panama';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PNG', COUNTRYCALLINGCODE_ = '675', LOCALECODE_ = 'PG ' WHERE NAME_ = 'Papua New Guinea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PRY', COUNTRYCALLINGCODE_ = '595', LOCALECODE_ = 'PY ' WHERE NAME_ = 'Paraguay';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PER', COUNTRYCALLINGCODE_ = '51', LOCALECODE_ = 'PE ' WHERE NAME_ = 'Peru';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PHL', COUNTRYCALLINGCODE_ = '63', LOCALECODE_ = 'PH ' WHERE NAME_ = 'Philippines';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PCN', COUNTRYCALLINGCODE_ = '870', LOCALECODE_ = 'PN ' WHERE NAME_ = 'Pitcairn Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'POL', COUNTRYCALLINGCODE_ = '48', LOCALECODE_ = 'PL ' WHERE NAME_ = 'Poland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PRT', COUNTRYCALLINGCODE_ = '351', LOCALECODE_ = 'PT ' WHERE NAME_ = 'Portugal';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'PRI', COUNTRYCALLINGCODE_ = '1', LOCALECODE_ = 'PR ' WHERE NAME_ = 'Puerto Rico';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'QAT', COUNTRYCALLINGCODE_ = '974', LOCALECODE_ = 'QA ' WHERE NAME_ = 'Qatar';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'COG', COUNTRYCALLINGCODE_ = '242', LOCALECODE_ = 'CG ' WHERE NAME_ = 'Republic of the Congo';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ROU', COUNTRYCALLINGCODE_ = '40', LOCALECODE_ = 'RO ' WHERE NAME_ = 'Romania';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'RUS', COUNTRYCALLINGCODE_ = '7', LOCALECODE_ = 'RU ' WHERE NAME_ = 'Russia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'RWA', COUNTRYCALLINGCODE_ = '250', LOCALECODE_ = 'RW ' WHERE NAME_ = 'Rwanda';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'BLM', COUNTRYCALLINGCODE_ = '590', LOCALECODE_ = 'BL ' WHERE NAME_ = 'Saint Barthelemy';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SHN', COUNTRYCALLINGCODE_ = '290', LOCALECODE_ = 'SH ' WHERE NAME_ = 'Saint Helena';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KNA', COUNTRYCALLINGCODE_ = '1 869', LOCALECODE_ = 'KN ' WHERE NAME_ = 'Saint Kitts and Nevis';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LCA', COUNTRYCALLINGCODE_ = '1 758', LOCALECODE_ = 'LC ' WHERE NAME_ = 'Saint Lucia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'MAF', COUNTRYCALLINGCODE_ = '1 599', LOCALECODE_ = 'MF ' WHERE NAME_ = 'Saint Martin';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SPM', COUNTRYCALLINGCODE_ = '508', LOCALECODE_ = 'PM ' WHERE NAME_ = 'Saint Pierre and Miquelon';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VCT', COUNTRYCALLINGCODE_ = '1 784', LOCALECODE_ = 'VC ' WHERE NAME_ = 'Saint Vincent and the Grenadines';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'WSM', COUNTRYCALLINGCODE_ = '685', LOCALECODE_ = 'WS ' WHERE NAME_ = 'Samoa';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SMR', COUNTRYCALLINGCODE_ = '378', LOCALECODE_ = 'SM ' WHERE NAME_ = 'San Marino';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'STP', COUNTRYCALLINGCODE_ = '239', LOCALECODE_ = 'ST ' WHERE NAME_ = 'Sao Tome and Principe';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SAU', COUNTRYCALLINGCODE_ = '966', LOCALECODE_ = 'SA ' WHERE NAME_ = 'Saudi Arabia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SEN', COUNTRYCALLINGCODE_ = '221', LOCALECODE_ = 'SN ' WHERE NAME_ = 'Senegal';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SRB', COUNTRYCALLINGCODE_ = '381', LOCALECODE_ = 'RS ' WHERE NAME_ = 'Serbia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SYC', COUNTRYCALLINGCODE_ = '248', LOCALECODE_ = 'SC ' WHERE NAME_ = 'Seychelles';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SLE', COUNTRYCALLINGCODE_ = '232', LOCALECODE_ = 'SL ' WHERE NAME_ = 'Sierra Leone';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SGP', COUNTRYCALLINGCODE_ = '65', LOCALECODE_ = 'SG ' WHERE NAME_ = 'Singapore';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SVK', COUNTRYCALLINGCODE_ = '421', LOCALECODE_ = 'SK ' WHERE NAME_ = 'Slovakia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SVN', COUNTRYCALLINGCODE_ = '386', LOCALECODE_ = 'SI ' WHERE NAME_ = 'Slovenia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SLB', COUNTRYCALLINGCODE_ = '677', LOCALECODE_ = 'SB ' WHERE NAME_ = 'Solomon Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SOM', COUNTRYCALLINGCODE_ = '252', LOCALECODE_ = 'SO ' WHERE NAME_ = 'Somalia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ZAF', COUNTRYCALLINGCODE_ = '27', LOCALECODE_ = 'ZA ' WHERE NAME_ = 'South Africa';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'KOR', COUNTRYCALLINGCODE_ = '82', LOCALECODE_ = 'KR ' WHERE NAME_ = 'South Korea';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ESP', COUNTRYCALLINGCODE_ = '34', LOCALECODE_ = 'ES ' WHERE NAME_ = 'Spain';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'LKA', COUNTRYCALLINGCODE_ = '94', LOCALECODE_ = 'LK ' WHERE NAME_ = 'Sri Lanka';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SDN', COUNTRYCALLINGCODE_ = '249', LOCALECODE_ = 'SD ' WHERE NAME_ = 'Sudan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SUR', COUNTRYCALLINGCODE_ = '597', LOCALECODE_ = 'SR ' WHERE NAME_ = 'Suriname';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SJM', COUNTRYCALLINGCODE_ = '', LOCALECODE_ = 'SJ ' WHERE NAME_ = 'Svalbard';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SWZ', COUNTRYCALLINGCODE_ = '268', LOCALECODE_ = 'SZ ' WHERE NAME_ = 'Swaziland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SWE', COUNTRYCALLINGCODE_ = '46', LOCALECODE_ = 'SE ' WHERE NAME_ = 'Sweden';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'CHE', COUNTRYCALLINGCODE_ = '41', LOCALECODE_ = 'CH ' WHERE NAME_ = 'Switzerland';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'SYR', COUNTRYCALLINGCODE_ = '963', LOCALECODE_ = 'SY ' WHERE NAME_ = 'Syria';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TWN', COUNTRYCALLINGCODE_ = '886', LOCALECODE_ = 'TW ' WHERE NAME_ = 'Taiwan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TJK', COUNTRYCALLINGCODE_ = '992', LOCALECODE_ = 'TJ ' WHERE NAME_ = 'Tajikistan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TZA', COUNTRYCALLINGCODE_ = '255', LOCALECODE_ = 'TZ ' WHERE NAME_ = 'Tanzania';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'THA', COUNTRYCALLINGCODE_ = '66', LOCALECODE_ = 'TH ' WHERE NAME_ = 'Thailand';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TLS', COUNTRYCALLINGCODE_ = '670', LOCALECODE_ = 'TL ' WHERE NAME_ = 'Timor-Leste';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TGO', COUNTRYCALLINGCODE_ = '228', LOCALECODE_ = 'TG ' WHERE NAME_ = 'Togo';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TKL', COUNTRYCALLINGCODE_ = '690', LOCALECODE_ = 'TK ' WHERE NAME_ = 'Tokelau';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TON', COUNTRYCALLINGCODE_ = '676', LOCALECODE_ = 'TO ' WHERE NAME_ = 'Tonga';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TTO', COUNTRYCALLINGCODE_ = '1 868', LOCALECODE_ = 'TT ' WHERE NAME_ = 'Trinidad and Tobago';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TUN', COUNTRYCALLINGCODE_ = '216', LOCALECODE_ = 'TN ' WHERE NAME_ = 'Tunisia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TUR', COUNTRYCALLINGCODE_ = '90', LOCALECODE_ = 'TR ' WHERE NAME_ = 'Turkey';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TKM', COUNTRYCALLINGCODE_ = '993', LOCALECODE_ = 'TM ' WHERE NAME_ = 'Turkmenistan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TCA', COUNTRYCALLINGCODE_ = '1 649', LOCALECODE_ = 'TC ' WHERE NAME_ = 'Turks and Caicos Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'TUV', COUNTRYCALLINGCODE_ = '688', LOCALECODE_ = 'TV ' WHERE NAME_ = 'Tuvalu';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'UGA', COUNTRYCALLINGCODE_ = '256', LOCALECODE_ = 'UG ' WHERE NAME_ = 'Uganda';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'UKR', COUNTRYCALLINGCODE_ = '380', LOCALECODE_ = 'UA ' WHERE NAME_ = 'Ukraine';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ARE', COUNTRYCALLINGCODE_ = '971', LOCALECODE_ = 'AE ' WHERE NAME_ = 'United Arab Emirates';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'GBR', COUNTRYCALLINGCODE_ = '44', LOCALECODE_ = 'GB ' WHERE NAME_ = 'United Kingdom';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'USA', COUNTRYCALLINGCODE_ = '1', LOCALECODE_ = 'US ' WHERE NAME_ = 'United States';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'URY', COUNTRYCALLINGCODE_ = '598', LOCALECODE_ = 'UY ' WHERE NAME_ = 'Uruguay';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VIR', COUNTRYCALLINGCODE_ = '1 340', LOCALECODE_ = 'VI ' WHERE NAME_ = 'US Virgin Islands';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'UZB', COUNTRYCALLINGCODE_ = '998', LOCALECODE_ = 'UZ ' WHERE NAME_ = 'Uzbekistan';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VUT', COUNTRYCALLINGCODE_ = '678', LOCALECODE_ = 'VU ' WHERE NAME_ = 'Vanuatu';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VEN', COUNTRYCALLINGCODE_ = '58', LOCALECODE_ = 'VE ' WHERE NAME_ = 'Venezuela';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'VNM', COUNTRYCALLINGCODE_ = '84', LOCALECODE_ = 'VN ' WHERE NAME_ = 'Vietnam';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'WLF', COUNTRYCALLINGCODE_ = '681', LOCALECODE_ = 'WF ' WHERE NAME_ = 'Wallis and Futuna';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  '', COUNTRYCALLINGCODE_ = '970', LOCALECODE_ = '' WHERE NAME_ = 'West Bank';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ESH', COUNTRYCALLINGCODE_ = '', LOCALECODE_ = 'EH ' WHERE NAME_ = 'Western Sahara';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'YEM', COUNTRYCALLINGCODE_ = '967', LOCALECODE_ = 'YE ' WHERE NAME_ = 'Yemen';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ZMB', COUNTRYCALLINGCODE_ = '260', LOCALECODE_ = 'ZM ' WHERE NAME_ = 'Zambia';
update GEOGRAPHICBOUNDARY_ set COUNTRYCODE_ =  'ZWE', COUNTRYCALLINGCODE_ = '263', LOCALECODE_ = 'ZW ' WHERE NAME_ = 'Zimbabwe';

UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='AB' WHERE `GEOGRAPHICBOUNDARY_ID`='655491237';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='AK' WHERE `GEOGRAPHICBOUNDARY_ID`='655491277';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='BA' WHERE `GEOGRAPHICBOUNDARY_ID`='655491332';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='BA' WHERE `GEOGRAPHICBOUNDARY_ID`='655491333';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='BN' WHERE `GEOGRAPHICBOUNDARY_ID`='655491360';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='CR' WHERE `GEOGRAPHICBOUNDARY_ID`='655491413';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='DT' WHERE `GEOGRAPHICBOUNDARY_ID`='655491431';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='ED' WHERE `GEOGRAPHICBOUNDARY_ID`='655491470';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='EK' WHERE `GEOGRAPHICBOUNDARY_ID`='655491487';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='Ek' WHERE `GEOGRAPHICBOUNDARY_ID`='655491739';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='FC' WHERE `GEOGRAPHICBOUNDARY_ID`='655491235';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='IM' WHERE `GEOGRAPHICBOUNDARY_ID`='655491532';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='KG' WHERE `GEOGRAPHICBOUNDARY_ID`='655491714';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='KG' WHERE `GEOGRAPHICBOUNDARY_ID`='655491724';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='LA' WHERE `GEOGRAPHICBOUNDARY_ID`='655491751';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='NG' WHERE `GEOGRAPHICBOUNDARY_ID`='655491787';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='NS' WHERE `GEOGRAPHICBOUNDARY_ID`='655491642';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='NS' WHERE `GEOGRAPHICBOUNDARY_ID`='655491781';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='OD' WHERE `GEOGRAPHICBOUNDARY_ID`='655491834';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='OG' WHERE `GEOGRAPHICBOUNDARY_ID`='655491813';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='OY' WHERE `GEOGRAPHICBOUNDARY_ID`='655491885';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='PL' WHERE `GEOGRAPHICBOUNDARY_ID`='655491918';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='RV' WHERE `GEOGRAPHICBOUNDARY_ID`='655491936';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='KD' WHERE `GEOGRAPHICBOUNDARY_ID`='655491587';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='KW' WHERE `GEOGRAPHICBOUNDARY_ID`='655492011';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='KB' WHERE `GEOGRAPHICBOUNDARY_ID`='655491692';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='EN' WHERE `GEOGRAPHICBOUNDARY_ID`='655491503';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='AN' WHERE `GEOGRAPHICBOUNDARY_ID`='655491309';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='AD' WHERE `GEOGRAPHICBOUNDARY_ID`='655491255';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='TR' WHERE `GEOGRAPHICBOUNDARY_ID`='655491983';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='SO' WHERE `GEOGRAPHICBOUNDARY_ID`='655491959';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='BO' WHERE `GEOGRAPHICBOUNDARY_ID`='655491385';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='OS' WHERE `GEOGRAPHICBOUNDARY_ID`='655491854';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='JG' WHERE `GEOGRAPHICBOUNDARY_ID`='655491560';


UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='NGA' WHERE `GEOGRAPHICBOUNDARY_ID`='655491234';
UPDATE `GEOGRAPHICBOUNDARY_` SET `IBROKERMAPPING_`='UKD' WHERE `GEOGRAPHICBOUNDARY_ID`='655491119';
UPDATE `GEOGRAPHICBOUNDARY_` SET `NAME_`='United States Of America', `IBROKERMAPPING_`='USA' WHERE `GEOGRAPHICBOUNDARY_ID`='655492034';