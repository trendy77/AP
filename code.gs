//  fileInterate ---> checkIt   //   CheckDups ?? filedupcheck

///// finds all spreadsheets in GDrive....
function fileInterate(){
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); var newSH = overview.getSheetByName("MASTER");
newSH.clearContents();
var files = DriveApp.searchFiles('mimeType = "' + MimeType.GOOGLE_SHEETS + '"'); 
  while (files.hasNext()) {
   var spreadsheet = SpreadsheetApp.open(files.next());
checkIt(spreadsheet);
}
} 


function checkDups(){
var overview = SpreadsheetApp.getActiveSpreadsheet(); 
var newSH = overview.getSheetByName("MASTER");
var uptoSpot = newSH.getRange('H1');
  var uptoFig = uptoSpot.getValue(); 
  var sheetTarg = newSH.getRange(uptoFig,2,1).getValues(); 
   uptoSpot.setValue(nextUp+1);
   for (z in sheetTarg){
     if (isCellEmpty(sheetTarg[z])){
   uptoFig == 2;
   return;
       } else {
  var diff = filedupCheck(sheetTarg[z]);
      }
    }
 }

// Returns true if the cell where cellData was read from is empty.
// Arguments:
//   - cellData: string
function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}


// finds number remaining posts and updates sheet
function numL(ssid){
 var ss = SpreadsheetApp.openById(ssid);
var gov2s = ss.getSheetByName("Sheet1");var leftE = gov2s.getLastRow(); 
 //var gov1s = ss.getSheetByName("Sheet3");var rows = gov1s.getMaxRows();
return left;
}


 function checkTags(ssid){
 var tagged = 0;var notTagged = 0;
 var ss=SpreadsheetApp.openById(ssid);
   var sheet = ss.getSheetByName("Sheet1");
  var selection=sheet.getRange('H1').setValue('tags');
 SpreadsheetApp.flush();
 var numm =sheet.getLastRow-1;
 var rows=sheet.getRange(2,8,numm,1).getValues();
    for (var row=1; row < sheet.getLastRow-1; row++) { 
      if (cell.isBlank()) {
        notTagged++;
            }
    }
    tagged = (numm-notTagged);  
    Logger.log('tagged'+tagged+'notTagged'+notTagged);
    return tagged;
}


