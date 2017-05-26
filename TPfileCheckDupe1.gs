
function fileInterateTP(){
  var t1 = startClock('fileIterate');
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); 
var newSH = overview.getSheetByName("MASTER");
  var files = DriveApp.searchFiles('mimeType = "' + MimeType.GOOGLE_SHEETS + '"'); 

  // FOR ALL DRIVE SPREADSHEETS
  while (files.hasNext()) {
   var spreadsheet = SpreadsheetApp.open(files.next());
      var checkD = spreadsheet.getId();
    // SEE IF IT'S NEW...
   var boo = AUTOcheckItTP(checkD);

      var ssid= spreadsheet.getId(); var nam= spreadsheet.getName();var url= spreadsheet.getUrl();
    
    // IF NEW
      if (boo == 0){

        // THEN DUPECHECK
        var dupe =  AUTOfiledupCheck(spreadsheet); 
        // NUMBER LEFT... 
        
        Logger.log(['new row']);
        var lil = ([nam,ssid,url]);
         newSH.appendRow(lil);
} else if (boo >= 1){

  Logger.log('old row', boo);

  //var dupe =  filedupCheck(spreadsheet); 
  // var left =numL(spreadsheet);
 var lil = ([nam,ssid,url]);
  newSH.getRange(boo,1,1,3).setValues([lil]);
}
      Logger.log('one down');
   timeChk(t1);   
  }
  try {
    newSH.appendRow([formattedDate]);
  } catch(e){
    Logger.log([e.message,e.line]);
  }
stopClk(t1);
}

  // CHECKS IF THE FILE IS IN THE LIST, RETURNS 'T' - line#   OR   0 
function AUTOcheckItTP(spreadsheet){
 var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); var newSH = overview.getSheetByName("MASTER"); 
  var check = newSH.getRange(1, 2, newSH.getMaxRows(), 1).getValues();
for (var t = 0; t<newSH.getMaxRows();t++){
  var whatAbbDisOne = check[t];      
  if (spreadsheet == whatAbbDisOne){
        return t;
        } else {
       }
    } 
  return 0;
 }

  
// DUPE CHECK 4 LINES
function TIMRfeedrTP(){
var t1 = startClock('feedrTP');
 //// how many sheets to run DUPECHECK on??
      var numRw = 4;
       //////
var overview = SpreadsheetApp.getActiveSpreadsheet();
  var livesh = overview.getSheetByName("MASTER");	
  var uptoSpot = livesh.getRange('H1');
  var uptoFig = uptoSpot.getValue(); var nextUp = uptoFig++; uptoSpot.setValue(uptoFig);
     if ((!uptoFig) || (uptoFig ==1)){         // at the end of the sheet list...
           uptoFig = 2;
           }
// get sheet ID... from H1.    
    var sheetTarg = livesh.getRange(uptoFig,2,numRw,1).getValues();  
    for (v in sheetTarg){
       
      // do dupe check ...
      var diff = AUTOfiledupCheck(sheetTarg[v]); 
         var preDiff = livesh.getRange(uptoFig,3,1,1).getValue();
          var totDiff = preDiff + diff;
          var vals = [[diff,totDiff]];
          livesh.getRange(uptoFig,3,1,2).setValues(vals);

      var len=timeChk(t1);
      jotDwn('finishing dupe now to num/tag...' +len);
var results= AUTOcheckNumNTags(sheetTarg[v]);
     var len=timeChk(t1);
      jotDwn('finishing up num/tag...' +len);
      scribe(results);
     }
   stopClk(t1);
}

function AUTOfiledupCheck(spreadsheet){
    if(spreadsheet.getSheetByName("Sheet1")){
   var sheet = spreadsheet.getSheetByName("Sheet1");
  var data = sheet.getDataRange().getValues();           
   var newData = new Array();       
   var diff = 0;           
   for(i in data){
     var row = data[i];   
     }
     var duplicate = false;                
    for(j in newData){                            
  if((row[0] == newData[j][0]) && (row[2] == newData[j][2])){
  duplicate = true;
      }
    }
    if(!duplicate){
      newData.push(row);
      }
     sheet.clearContents();  
    sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
    diff = (data.length-newData.length);
return diff;
 }
}

