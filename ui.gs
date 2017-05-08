

function onInstall(e){
start();onOpen();
}

function onOpen() {
 SpreadsheetApp.getUi().createMenu('TrenDupChk')
 .addItem('runDupe on MASTERTP', 'fileIterateTP').addItem('runDupe on MASTER', 'fileIterate').addItem('numberLeft', 'numberL')
 .addItem('checkTags', 'checkTags').addItem('sendNext Row', 'getLine')
 .addItem('allKeys', 'allKeys').addItem('allTrigs', 'menuItem2').addItem('sendEsp', 'menuItem4').addItem('sendXml', 'menuItem6')
  .addToUi();
}
  