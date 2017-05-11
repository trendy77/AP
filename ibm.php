<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Updating worksheets</title>
    <style>
    body {
      font-family: Verdana;      
    }
    table, td {
      border: 1px solid black;
      vertical-align: top;
    }
    </style>    
  </head>
  <body>
    <?php
    // load Zend Gdata libraries
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
 
    // set credentials for ClientLogin authentication
    $user = "trendypublishingau@gmail.com";
    $pass = "Joker999";
 
    try {
      // connect to API
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);
 
      // get worksheet entry
      $query = new Zend_Gdata_Spreadsheets_DocumentQuery();
      $query->setSpreadsheetKey('ssid');
      $query->setWorksheetId('wsid');
      $wsEntry = $service->getWorksheetEntry($query);
      $title = new Zend_Gdata_App_Extension_Title('Feb 2012');
      $wsEntry->setTitle($title);
 
      // update entry
      $entryResult = $service->updateEntry($wsEntry, 
        $wsEntry->getLink('edit')->getHref());
      echo 'The ID of the updated worksheet entry is: ' . $entryResult->id;
 
    } catch (Exception $e) {
      die('ERROR: ' . $e->getMessage());
    }
    ?>
 
  </body>
<html>