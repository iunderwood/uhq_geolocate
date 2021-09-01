<?php

/*
Create an array which maps the ISO 3166 country code to its official short name.

Base information from: http://www.iso.org/iso/english_country_names_and_code_elements
*/

if (!isset($xoopsConfig)) {
    global $xoopsConfig;
}

xoops_loadLanguage('geo', 'uhqgeolocate');

// Define Array, ordered by country code

$_UHQGEO_CC = [];

$_UHQGEO_CC['AD'] = _UHQGEO_CC_AD;    // Andorra
$_UHQGEO_CC['AE'] = _UHQGEO_CC_AE;    // United Arab Emirates
$_UHQGEO_CC['AF'] = _UHQGEO_CC_AF;    // Afghanistan
$_UHQGEO_CC['AG'] = _UHQGEO_CC_AG;    // Antigua and Barbuda
$_UHQGEO_CC['AI'] = _UHQGEO_CC_AI;    // Anguilla
$_UHQGEO_CC['AL'] = _UHQGEO_CC_AL;    // Albania
$_UHQGEO_CC['AM'] = _UHQGEO_CC_AM;    // Armenia
$_UHQGEO_CC['AN'] = _UHQGEO_CC_AN;    // Netherlands Antilles
$_UHQGEO_CC['AO'] = _UHQGEO_CC_AO;    // Angola
$_UHQGEO_CC['AQ'] = _UHQGEO_CC_AQ;    // Antarctica
$_UHQGEO_CC['AR'] = _UHQGEO_CC_AR;    // Argentina
$_UHQGEO_CC['AS'] = _UHQGEO_CC_AS;    // American Samoa
$_UHQGEO_CC['AT'] = _UHQGEO_CC_AT;    // Austria
$_UHQGEO_CC['AU'] = _UHQGEO_CC_AU;    // Austrailia
$_UHQGEO_CC['AW'] = _UHQGEO_CC_AW;    // Aruba
$_UHQGEO_CC['AX'] = _UHQGEO_CC_AX;    // Aland Islands
$_UHQGEO_CC['AZ'] = _UHQGEO_CC_AZ;    // Azerbaijan

$_UHQGEO_CC['BA'] = _UHQGEO_CC_BA;    // Bosnia and Herzegovina
$_UHQGEO_CC['BB'] = _UHQGEO_CC_BB;    // Barbados
$_UHQGEO_CC['BD'] = _UHQGEO_CC_BD;    // Bangladesh
$_UHQGEO_CC['BE'] = _UHQGEO_CC_BE;    // Belgium
$_UHQGEO_CC['BF'] = _UHQGEO_CC_BF;    // Burkina Faso
$_UHQGEO_CC['BG'] = _UHQGEO_CC_BG;    // Bulgaria
$_UHQGEO_CC['BH'] = _UHQGEO_CC_BH;    // Bahrain
$_UHQGEO_CC['BI'] = _UHQGEO_CC_BI;    // Burundi
$_UHQGEO_CC['BJ'] = _UHQGEO_CC_BJ;    // Benin
$_UHQGEO_CC['BL'] = _UHQGEO_CC_BL;    // Saint Barthelemy
$_UHQGEO_CC['BM'] = _UHQGEO_CC_BM;    // Bermuda
$_UHQGEO_CC['BN'] = _UHQGEO_CC_BN;    // Brunei Darussalam
$_UHQGEO_CC['BO'] = _UHQGEO_CC_BO;    // Bolivia
$_UHQGEO_CC['BR'] = _UHQGEO_CC_BR;    // Brazil
$_UHQGEO_CC['BS'] = _UHQGEO_CC_BS;    // Bahamas
$_UHQGEO_CC['BT'] = _UHQGEO_CC_BT;    // Bhutan
$_UHQGEO_CC['BV'] = _UHQGEO_CC_BV;    // Bouvet Island
$_UHQGEO_CC['BW'] = _UHQGEO_CC_BW;    // Botswana
$_UHQGEO_CC['BY'] = _UHQGEO_CC_BY;    // Belarus
$_UHQGEO_CC['BZ'] = _UHQGEO_CC_BZ;    // Belize

$_UHQGEO_CC['CA'] = _UHQGEO_CC_CA;    // Canada
$_UHQGEO_CC['CC'] = _UHQGEO_CC_CC;    // Cocos (Keeling) Islands
$_UHQGEO_CC['CD'] = _UHQGEO_CC_CD;    // Congo
$_UHQGEO_CC['CF'] = _UHQGEO_CC_CF;    // Central African Republic
$_UHQGEO_CC['CH'] = _UHQGEO_CC_CH;    // Switzerland
$_UHQGEO_CC['CI'] = _UHQGEO_CC_CI;    // Cote D'Ivoire
$_UHQGEO_CC['CK'] = _UHQGEO_CC_CK;    // Cook Islands
$_UHQGEO_CC['CL'] = _UHQGEO_CC_CL;    // Chile
$_UHQGEO_CC['CM'] = _UHQGEO_CC_CM;    // Cameroon
$_UHQGEO_CC['CN'] = _UHQGEO_CC_CN;    // China
$_UHQGEO_CC['CO'] = _UHQGEO_CC_CO;    // Colombia
$_UHQGEO_CC['CR'] = _UHQGEO_CC_CR;    // Costa Rica
$_UHQGEO_CC['CU'] = _UHQGEO_CC_CU;    // Cuba
$_UHQGEO_CC['CV'] = _UHQGEO_CC_CV;    // Cape Verde
$_UHQGEO_CC['CX'] = _UHQGEO_CC_CX;    // Christmas Island
$_UHQGEO_CC['CY'] = _UHQGEO_CC_CY;    // Cypress
$_UHQGEO_CC['CZ'] = _UHQGEO_CC_CZ;    // Czech Republic

$_UHQGEO_CC['DE'] = _UHQGEO_CC_DE;    // Germany
$_UHQGEO_CC['DJ'] = _UHQGEO_CC_DJ;    // Djibouti
$_UHQGEO_CC['DK'] = _UHQGEO_CC_DK;    // Denmark
$_UHQGEO_CC['DM'] = _UHQGEO_CC_DM;    // Dominica
$_UHQGEO_CC['DO'] = _UHQGEO_CC_DO;    // Dominican Republic
$_UHQGEO_CC['DZ'] = _UHQGEO_CC_DZ;    // Algeria

$_UHQGEO_CC['EC'] = _UHQGEO_CC_EC;    // Ecuador
$_UHQGEO_CC['EE'] = _UHQGEO_CC_EE;    // Estonia
$_UHQGEO_CC['EG'] = _UHQGEO_CC_EG;    // Egypt
$_UHQGEO_CC['EH'] = _UHQGEO_CC_EH;    // Western Sahara
$_UHQGEO_CC['ER'] = _UHQGEO_CC_ER;    // Eritrea
$_UHQGEO_CC['ES'] = _UHQGEO_CC_ES;    // Spain
$_UHQGEO_CC['ET'] = _UHQGEO_CC_ET;    // Ethiopia

$_UHQGEO_CC['FI'] = _UHQGEO_CC_FI;    // Finland
$_UHQGEO_CC['FJ'] = _UHQGEO_CC_FJ;    // Fiji
$_UHQGEO_CC['FK'] = _UHQGEO_CC_FK;    // Falkland Islands (Malvinas)
$_UHQGEO_CC['FM'] = _UHQGEO_CC_FM;    // Micronesia
$_UHQGEO_CC['FO'] = _UHQGEO_CC_FO;    // Faroe Islands
$_UHQGEO_CC['FR'] = _UHQGEO_CC_FR;    // France

$_UHQGEO_CC['GA'] = _UHQGEO_CC_GA;    // Gabon
$_UHQGEO_CC['GB'] = _UHQGEO_CC_GB;    // United Kingdom
$_UHQGEO_CC['GD'] = _UHQGEO_CC_GD;    // Grenada
$_UHQGEO_CC['GF'] = _UHQGEO_CC_GF;    // French Guiana
$_UHQGEO_CC['GG'] = _UHQGEO_CC_GG;    // Guernsey
$_UHQGEO_CC['GH'] = _UHQGEO_CC_GH;    // Ghana
$_UHQGEO_CC['GI'] = _UHQGEO_CC_GI;    // Gibraltar
$_UHQGEO_CC['GL'] = _UHQGEO_CC_GL;    // Greenland
$_UHQGEO_CC['GM'] = _UHQGEO_CC_GM;    // Gambia
$_UHQGEO_CC['GN'] = _UHQGEO_CC_GN;    // Guinea
$_UHQGEO_CC['GP'] = _UHQGEO_CC_GP;    // Guadeloupe
$_UHQGEO_CC['GQ'] = _UHQGEO_CC_GQ;    // Ecquatoria Guinea
$_UHQGEO_CC['GR'] = _UHQGEO_CC_GR;    // Greece
$_UHQGEO_CC['GS'] = _UHQGEO_CC_GS;    // South Georgia and The South Sandwich Islands
$_UHQGEO_CC['GT'] = _UHQGEO_CC_GT;    // Guatemala
$_UHQGEO_CC['GU'] = _UHQGEO_CC_GU;    // Guam
$_UHQGEO_CC['GW'] = _UHQGEO_CC_GW;    // Guinea-Bisseau
$_UHQGEO_CC['GY'] = _UHQGEO_CC_GY;    // Guyana

$_UHQGEO_CC['HK'] = _UHQGEO_CC_HK;    // Hong Kong
$_UHQGEO_CC['HM'] = _UHQGEO_CC_HM;    // Heard Island and McDonald Islands
$_UHQGEO_CC['HN'] = _UHQGEO_CC_HN;    // Honduras
$_UHQGEO_CC['HR'] = _UHQGEO_CC_HR;    // Croatia
$_UHQGEO_CC['HT'] = _UHQGEO_CC_HT;    // Haiti
$_UHQGEO_CC['HU'] = _UHQGEO_CC_HU;    // Hungary

$_UHQGEO_CC['ID'] = _UHQGEO_CC_ID;    // Indonesia
$_UHQGEO_CC['IE'] = _UHQGEO_CC_IE;    // Ireland
$_UHQGEO_CC['IL'] = _UHQGEO_CC_IL;    // Israel
$_UHQGEO_CC['IM'] = _UHQGEO_CC_IM;    // Isle of Man
$_UHQGEO_CC['IN'] = _UHQGEO_CC_IN;    // India
$_UHQGEO_CC['IO'] = _UHQGEO_CC_IO;    // British Indian Ocean Territory
$_UHQGEO_CC['IQ'] = _UHQGEO_CC_IQ;    // Iraq
$_UHQGEO_CC['IR'] = _UHQGEO_CC_IR;    // Iran
$_UHQGEO_CC['IS'] = _UHQGEO_CC_IS;    // Iceland
$_UHQGEO_CC['IT'] = _UHQGEO_CC_IT;    // Italy

$_UHQGEO_CC['JE'] = _UHQGEO_CC_JE;    // Jersey
$_UHQGEO_CC['JM'] = _UHQGEO_CC_JM;    // Jamaica
$_UHQGEO_CC['JO'] = _UHQGEO_CC_JO;    // Jordan
$_UHQGEO_CC['JP'] = _UHQGEO_CC_JP;    // Japan

$_UHQGEO_CC['KE'] = _UHQGEO_CC_KE;    // Kenya
$_UHQGEO_CC['KG'] = _UHQGEO_CC_KG;    // Kyrgyzstan
$_UHQGEO_CC['KH'] = _UHQGEO_CC_KH;    // Cambodia
$_UHQGEO_CC['KI'] = _UHQGEO_CC_KI;    // Kiribati
$_UHQGEO_CC['KN'] = _UHQGEO_CC_KN;    // Saint Kitts and Nevis
$_UHQGEO_CC['KP'] = _UHQGEO_CC_KP;    // North Korea (Korea, Democratic People's Republic of)
$_UHQGEO_CC['KR'] = _UHQGEO_CC_KR;    // South Korea (Korea, Republic of)
$_UHQGEO_CC['KW'] = _UHQGEO_CC_KW;    // Kuwait
$_UHQGEO_CC['KY'] = _UHQGEO_CC_KY;    // Cayman Islands
$_UHQGEO_CC['KZ'] = _UHQGEO_CC_KZ;    // Kazakhstan

$_UHQGEO_CC['LA'] = _UHQGEO_CC_LA;    // Lao People's Democratic Republic
$_UHQGEO_CC['LB'] = _UHQGEO_CC_LB;    // Lebanon
$_UHQGEO_CC['LC'] = _UHQGEO_CC_LC;    // Saint Lucia
$_UHQGEO_CC['LI'] = _UHQGEO_CC_LI;    // Liechtenstein
$_UHQGEO_CC['LK'] = _UHQGEO_CC_LK;    // Sri Lanka
$_UHQGEO_CC['LR'] = _UHQGEO_CC_LR;    // Liberia
$_UHQGEO_CC['LS'] = _UHQGEO_CC_LS;    // Lesotho
$_UHQGEO_CC['LT'] = _UHQGEO_CC_LT;    // Lithuania
$_UHQGEO_CC['LU'] = _UHQGEO_CC_LU;    // Luxembourg
$_UHQGEO_CC['LV'] = _UHQGEO_CC_LV;    // Latvia
$_UHQGEO_CC['LY'] = _UHQGEO_CC_LY;    // Libya

$_UHQGEO_CC['MA'] = _UHQGEO_CC_MA;    // Morocco
$_UHQGEO_CC['MC'] = _UHQGEO_CC_MC;    // Monaco
$_UHQGEO_CC['MD'] = _UHQGEO_CC_MD;    // Moldova
$_UHQGEO_CC['ME'] = _UHQGEO_CC_ME;    // Montenegro
$_UHQGEO_CC['MF'] = _UHQGEO_CC_MF;    // Saint Martin
$_UHQGEO_CC['MG'] = _UHQGEO_CC_MG;    // Madagascar
$_UHQGEO_CC['MH'] = _UHQGEO_CC_MH;    // Marshall Islands
$_UHQGEO_CC['MK'] = _UHQGEO_CC_MK;    // Macedonia
$_UHQGEO_CC['ML'] = _UHQGEO_CC_ML;    // Mali
$_UHQGEO_CC['MM'] = _UHQGEO_CC_MM;    // Myanmanr
$_UHQGEO_CC['MN'] = _UHQGEO_CC_MN;    // Mongolia
$_UHQGEO_CC['MO'] = _UHQGEO_CC_MO;    // Macao
$_UHQGEO_CC['MP'] = _UHQGEO_CC_MP;    // Northern Mariana Islands
$_UHQGEO_CC['MQ'] = _UHQGEO_CC_MQ;    // Martinique
$_UHQGEO_CC['MR'] = _UHQGEO_CC_MR;    // Mauritania
$_UHQGEO_CC['MS'] = _UHQGEO_CC_MS;    // Montserrat
$_UHQGEO_CC['MT'] = _UHQGEO_CC_MT;    // Malta
$_UHQGEO_CC['MU'] = _UHQGEO_CC_MU;    // Mauritius
$_UHQGEO_CC['MW'] = _UHQGEO_CC_MW;    // Malawi
$_UHQGEO_CC['MV'] = _UHQGEO_CC_MV;    // Maldives
$_UHQGEO_CC['MX'] = _UHQGEO_CC_MX;    // Mexico
$_UHQGEO_CC['MY'] = _UHQGEO_CC_MY;    // Malaysia
$_UHQGEO_CC['MZ'] = _UHQGEO_CC_MZ;    // Mozambique

$_UHQGEO_CC['NA'] = _UHQGEO_CC_NA;    // Namibia
$_UHQGEO_CC['NC'] = _UHQGEO_CC_NC;    // New Caledonia
$_UHQGEO_CC['NE'] = _UHQGEO_CC_NE;    // Niger
$_UHQGEO_CC['NF'] = _UHQGEO_CC_NF;    // Norfolk Island
$_UHQGEO_CC['NG'] = _UHQGEO_CC_NG;    // Nigeria
$_UHQGEO_CC['NI'] = _UHQGEO_CC_NI;    // Nicaragua
$_UHQGEO_CC['NL'] = _UHQGEO_CC_NL;    // Netherlands
$_UHQGEO_CC['NO'] = _UHQGEO_CC_NO;    // Norway
$_UHQGEO_CC['NP'] = _UHQGEO_CC_NP;    // Nepal
$_UHQGEO_CC['NR'] = _UHQGEO_CC_NR;    // Nauru
$_UHQGEO_CC['NU'] = _UHQGEO_CC_NU;    // Niue
$_UHQGEO_CC['NZ'] = _UHQGEO_CC_NZ;    // New Zealand

$_UHQGEO_CC['OM'] = _UHQGEO_CC_OM;    // Oman

$_UHQGEO_CC['PA'] = _UHQGEO_CC_PA;    // Panama
$_UHQGEO_CC['PE'] = _UHQGEO_CC_PE;    // Peru
$_UHQGEO_CC['PF'] = _UHQGEO_CC_PF;    // French Polynesia
$_UHQGEO_CC['PG'] = _UHQGEO_CC_PG;    // Papua New Guinea
$_UHQGEO_CC['PH'] = _UHQGEO_CC_PH;    // Philippines
$_UHQGEO_CC['PK'] = _UHQGEO_CC_PK;    // Pakistan
$_UHQGEO_CC['PL'] = _UHQGEO_CC_PL;    // Poland
$_UHQGEO_CC['PM'] = _UHQGEO_CC_PM;    // Saint Pierre and Miquelon
$_UHQGEO_CC['PN'] = _UHQGEO_CC_PN;    // Pitcairn
$_UHQGEO_CC['PR'] = _UHQGEO_CC_PR;    // Puerto Rico
$_UHQGEO_CC['PS'] = _UHQGEO_CC_PS;    // Palestinian Territory
$_UHQGEO_CC['PT'] = _UHQGEO_CC_PT;    // Portugal
$_UHQGEO_CC['PW'] = _UHQGEO_CC_PW;    // Palau
$_UHQGEO_CC['PY'] = _UHQGEO_CC_PY;    // Paraguay

$_UHQGEO_CC['QA'] = _UHQGEO_CC_QA;    // Qatar

$_UHQGEO_CC['RE'] = _UHQGEO_CC_RE;    // Reunion
$_UHQGEO_CC['RO'] = _UHQGEO_CC_RO;    // Romania
$_UHQGEO_CC['RS'] = _UHQGEO_CC_RS;    // Serbia
$_UHQGEO_CC['RU'] = _UHQGEO_CC_RU;    // Russian Federation
$_UHQGEO_CC['RW'] = _UHQGEO_CC_RW;    // Rwanda

$_UHQGEO_CC['SA'] = _UHQGEO_CC_SA;    // Saudi Arabia
$_UHQGEO_CC['SB'] = _UHQGEO_CC_SB;    // Solomon Islands
$_UHQGEO_CC['SC'] = _UHQGEO_CC_SC;    // Seychelles
$_UHQGEO_CC['SD'] = _UHQGEO_CC_SD;    // Sudan
$_UHQGEO_CC['SE'] = _UHQGEO_CC_SE;    // Sweden
$_UHQGEO_CC['SG'] = _UHQGEO_CC_SG;    // Singapore
$_UHQGEO_CC['SH'] = _UHQGEO_CC_SH;    // Saint Helena
$_UHQGEO_CC['SI'] = _UHQGEO_CC_SI;    // Slovenia
$_UHQGEO_CC['SJ'] = _UHQGEO_CC_SJ;    // Svalbard and Jan Mayen
$_UHQGEO_CC['SK'] = _UHQGEO_CC_SK;    // Slovakia
$_UHQGEO_CC['SL'] = _UHQGEO_CC_SL;    // Sierra Leone
$_UHQGEO_CC['SM'] = _UHQGEO_CC_SM;    // San Marino
$_UHQGEO_CC['SN'] = _UHQGEO_CC_SN;    // Senegal
$_UHQGEO_CC['SO'] = _UHQGEO_CC_SO;    // Somalia
$_UHQGEO_CC['SR'] = _UHQGEO_CC_SR;    // Suriname
$_UHQGEO_CC['ST'] = _UHQGEO_CC_ST;    // Sao Tome and Principe
$_UHQGEO_CC['SV'] = _UHQGEO_CC_SV;    // El Salvador
$_UHQGEO_CC['SY'] = _UHQGEO_CC_SY;    // Syrian Arab Republic
$_UHQGEO_CC['SZ'] = _UHQGEO_CC_SZ;    // Swaziland

$_UHQGEO_CC['TC'] = _UHQGEO_CC_TC;    // Turks and Caicos Islands
$_UHQGEO_CC['TD'] = _UHQGEO_CC_TD;    // Chad
$_UHQGEO_CC['TF'] = _UHQGEO_CC_TF;    // French Southern Territories
$_UHQGEO_CC['TG'] = _UHQGEO_CC_TG;    // Togo
$_UHQGEO_CC['TH'] = _UHQGEO_CC_TH;    // Thailand
$_UHQGEO_CC['TJ'] = _UHQGEO_CC_TJ;    // Tajikistan
$_UHQGEO_CC['TK'] = _UHQGEO_CC_TK;    // Tokelau
$_UHQGEO_CC['TL'] = _UHQGEO_CC_TL;    // Timor-Leste
$_UHQGEO_CC['TM'] = _UHQGEO_CC_TM;    // Turkmenistan
$_UHQGEO_CC['TN'] = _UHQGEO_CC_TN;    // Tunisia
$_UHQGEO_CC['TO'] = _UHQGEO_CC_TO;    // Tonga
$_UHQGEO_CC['TR'] = _UHQGEO_CC_TR;    // Turkey
$_UHQGEO_CC['TT'] = _UHQGEO_CC_TT;    // Trinidad and Tobago
$_UHQGEO_CC['TV'] = _UHQGEO_CC_TV;    // Tuvalu
$_UHQGEO_CC['TW'] = _UHQGEO_CC_TW;    // Taiwan
$_UHQGEO_CC['TZ'] = _UHQGEO_CC_TZ;    // Tanzania

$_UHQGEO_CC['UA'] = _UHQGEO_CC_UA;    // Ukraine
$_UHQGEO_CC['UG'] = _UHQGEO_CC_UG;    // Uganda
$_UHQGEO_CC['UK'] = _UHQGEO_CC_GB;    // United Kingdom - still uses UK in many names
$_UHQGEO_CC['UM'] = _UHQGEO_CC_UM;    // United States Minor Outlying Islands
$_UHQGEO_CC['US'] = _UHQGEO_CC_US;    // United States
$_UHQGEO_CC['UY'] = _UHQGEO_CC_UY;    // Uruguay
$_UHQGEO_CC['UZ'] = _UHQGEO_CC_UZ;    // Uzbekistan

$_UHQGEO_CC['VA'] = _UHQGEO_CC_VA;    // Vatican
$_UHQGEO_CC['VC'] = _UHQGEO_CC_VC;    // Saint Vincent and The Grenadines
$_UHQGEO_CC['VE'] = _UHQGEO_CC_VE;    // Venezuela
$_UHQGEO_CC['VG'] = _UHQGEO_CC_VG;    // Virgin Islands, British
$_UHQGEO_CC['VI'] = _UHQGEO_CC_VI;    // Virgin Islands, U.S>
$_UHQGEO_CC['VN'] = _UHQGEO_CC_VN;    // Vietnam
$_UHQGEO_CC['VU'] = _UHQGEO_CC_VU;    // Vanuatu

$_UHQGEO_CC['WF'] = _UHQGEO_CC_WF;    // Vallis and Futuna
$_UHQGEO_CC['WS'] = _UHQGEO_CC_WS;    // Samoa

$_UHQGEO_CC['YE'] = _UHQGEO_CC_YE;    // Yemen
$_UHQGEO_CC['YT'] = _UHQGEO_CC_YT;    // Mayotte

$_UHQGEO_CC['ZA'] = _UHQGEO_CC_ZA;    // South Africa
$_UHQGEO_CC['ZM'] = _UHQGEO_CC_ZM;    // Zambia
$_UHQGEO_CC['ZW'] = _UHQGEO_CC_ZW;    // Zimbabwe
