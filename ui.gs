function reset(){
// FIRST DELETE ALL RESPONESE FROM SERVER....
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
  var newSH = overview.getSheetByName("LIVE");
  var uptoSpot = newSH.getRange(2,21,8,newSH.getMaxColumns())
    uptoSpot.clearContent(); 

  // RESET THE COUNTERS...
  var winLoss = newSH.getRange(2,18,8,3);
    winLoss.clearContent(); 
  
  // SET UP2SPOTS BACK
 newSH.getRange("B12").setValue('21');
}   
  

function onInstall(e){
start();onOpen();
}

function onOpen() {
 SpreadsheetApp.getUi().createMenu('TrenDupChk')
 .addItem('iterate on MASTERTP', 'fileIterateTP').addItem('iterate on MASTER', 'fileIterate').addItem('start', 'start')
 .addItem('checkTags', 'checkTags').addItem('get Next Row', 'getLine').addItem('get Rows', 'getLines')
 .addItem('dupLIVEcheck', 'dupLIVEcheck').addItem('send line', 'sendLine').addItem('reset', 'reset')// .addItem('sendXml', 'sendLine')
  .addToUi();
}
  
// Returns true if the cell where cellData was read from is empty.
// Arguments:
//   - cellData: string
function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}