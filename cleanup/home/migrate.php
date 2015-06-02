<?php
/*
 * Include necessary files
 */
include_once 'core/init.inc.php';
$cust = new Customer($dbo);
$fxns = new Functions($dbo);

$tot_autrole = count($_SESSION['user_dets']['authrole']);
$rand_autrole = rand(0, $tot_autrole-1);
$headers = unserialize (WEBSERVICE_AUTH);
$idRef = "2";
$xml_migrate = '<?xml version="1.0" encoding="UTF-8"?>
                <TRANSACTION currentLocale="' . $_SESSION['user_dets']['locale'][0] . '" currentRole="' . $_SESSION['user_dets']['authrole'][$rand_autrole] . '">
                    <UPDATE entity="OnlineMigration" id="new:-1155484576" parentProperty="">
                        <PROPERTY bidirectional="false" composite="false" path="status" type="OnlineMigrationStatus">
                            <ENTITY idref="2" />
                        </PROPERTY>
                        <PROPERTY bidirectional="false" composite="false" path="type" type="OnlineMigrationType">
                            <ENTITY idref="'.$idRef.'" />
                        </PROPERTY>
                        <PROPERTY path="entryDate" type="Date" value="' . date('m/d/Y') . '" />
                        <PROPERTY path="migrationSourceId" type="String" value="661520471" />
                        <PROPERTY path="locale" type="String" value="' . $_SESSION['user_dets']['locale'][0] . '" />
                    </UPDATE>
                    <ENTITYSPEC name="OnlineMigration">
                        <PROPERTY path="id" />
                    </ENTITYSPEC>
                </TRANSACTION>';
$output = $fxns->_consumeService(WEB_SERVICE_URL, $xml_migrate, $headers);

$query_response = simplexml_load_string($output);
$result = $query_response->xpath('//ERRORS');
print_r($result);