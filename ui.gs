

function onInstall(e){
start();onOpen();
}

function onOpen() {
 SpreadsheetApp.getUi().createMenu('TrenDupChk')
 .addItem('runDupe on MASTERTP', 'fileIterateTP').addItem('runDupe on MASTER', 'fileIterate').addItem('start', 'start')
 .addItem('checkTags', 'checkTags').addItem('sendNext Row', 'gsendLine').addItem('get Rows', 'getLines')
 .addItem('dupLIVEcheck', 'dupLIVEcheck').addItem('allTrigs', 'menuItem2').addItem('getLines', 'getLineInfo').addItem('sendXml', 'sendLine')
  .addToUi();
}
  
// Returns true if the cell where cellData was read from is empty.
// Arguments:
//   - cellData: string
function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}