///// finds all spreadsheets in GDrive....

function fileInterateTP(){
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); var newSH = overview.getSheetByName("MASTERTP");
newSH.clearContents();
var files = DriveApp.searchFiles('mimeType = "' + MimeType.GOOGLE_SHEETS + '"'); 
  while (files.hasNext()) {
   var spreadsheet = SpreadsheetApp.open(files.next());
checkItTP(spreadsheet);
}
}

function checkItTP(spreadsheet){
var ssid= spreadsheet.getId(); var nam= spreadsheet.getName();var url= spreadsheet.getUrl();
 var lil = ([nam,ssid,url]);
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); var newSH = overview.getSheetByName("MASTERTP");
newSH.appendRow(lil);
  return;
 }
  
function feedrTP(){
 var t1 = new Date();
 //// how many sheets to run DUPECHECK on??
      var numRw = 4;
       //////
var overview = SpreadsheetApp.getActiveSpreadsheet();
  var livesh = overview.getSheetByName("MASTERTP");	
  var uptoSpot = livesh.getRange('H1');
  var uptoFig = uptoSpot.getValue(); var nextUp = uptoFig++; uptoSpot.setValue(uptoFig);
     if ((!uptoFig) || (uptoFig ==1)){         // at the end of the sheet list...
           uptoFig = 2;
           }
// get sheet ID... from H1.    
    var sheetTarg = livesh.getRange(uptoFig,2,numRw,1).getValues();  
    for (v in sheetTarg){
       
      // do dupe check ...
      var diff = filedupCheck(sheetTarg[v]); 
          var formattedDate = new Date();
          var formattedTime = Utilities.formatDate(new Date(), "GMT+11","HH:mm:ss");
          var preDiff = livesh.getRange(uptoFig,3,1,1).getValue();
          var totDiff = preDiff + diff;
          var vals = [[diff,totDiff, formattedDate,formattedTime]];
          livesh.getRange(uptoFig,3,1,4).setValues(vals);
         }
var t2 = new Date();
timeReport(t1,t2);
}

function filedupCheck(sheetTarg){
  Logger.log(sheetTarg);var t4=new Date();
  var spreadsheet = SpreadsheetApp.openById(sheetTarg);
    var ssid = spreadsheet.getId();    var url = spreadsheet.getUrl();
 var sheet = spreadsheet.getSheetByName("Sheet1");
  var name = spreadsheet.getName();
 if (sheet== null){
 return;
 } else {
 var data = sheet.getDataRange().getValues();           
   var newData = new Array();       
   var diff = 0;           
   for(i in data){
     var row = data[i];    
     var duplicate = false;                
    for(j in newData){                            
  if(row[0] == newData[j][0] || row[2] == newData[j][2]){
  duplicate = true;
      }
    }
    if(!duplicate){
      newData.push(row);
      }
    }  
    sheet.clearContents();  
    sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
    diff = (data.length-newData.length);
  var t5=new Date();
   Logger.log('found ' +diff + 'in ');
   timeReport(t4,t5);
return diff;
 }
}
