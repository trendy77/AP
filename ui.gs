

function onInstall(e){
start();onOpen();
}

function onOpen() {
 SpreadsheetApp.getUi().createMenu('TrenDupChk')
 .addItem('runDupe on MASTERTP', 'fileIterateTP').addItem('runDupe on MASTER', 'fileIterate').addItem('numberLeft', 'numberL')
 .addItem('checkTags', 'checkTags').addItem('sendNext Row', 'gsendLine').addItem('get Rows', 'getLines')
 .addItem('allKeys', 'allKeys').addItem('allTrigs', 'menuItem2').addItem('sendEsp', 'menuItem4').addItem('sendXml', 'menuItem6')
  .addToUi();
}
  
// Returns true if the cell where cellData was read from is empty.
// Arguments:
//   - cellData: string
function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}