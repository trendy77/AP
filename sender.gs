///// collates next post for each site , num rows left, tags...
function logID(){
var ss = SpreadsheetApp.getActiveSpreadsheet();
var overview = ss.getId();
Logger.log(overview);
}

function getLines(){
var t1 = new Date();
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); 
var newSH = overview.getSheetByName("LIVE"); 
var rng = newSH.getRange(2,3,7,1).getValues();
var t2 = new Date();
  for (var zz = 0; zz<7;zz++){
     var id = rng[zz];
     Logger.log(rng[zz]);
     var ovw = SpreadsheetApp.openById(id);
  var sss =  ovw.getSheetByName('Sheet1');
 var nam= ovw.getName(); var urlss =ovw.getUrl(); var numm = sss.getMaxRows();
     //   insert 2ND COL sheet name, 3RD id(again), 4TH url,5TH numRowsLeft 
 //  var tggd = checkTags(id);
     var rngP = sss.getRange(3,1,1,8).getValues();
     var thisss= ([nam,id,urlss,numm]);
     var move = newSH.getRange(zz+2,2,1,4).setValues([thisss]);  // or 8+5?
     var lineIn = newSH.getRange(zz+2,8,1,8).setValues(rngP);
    var fdsthis = new Date();
    timeReport(t2,fdsthis);
           } 
var t3 = new Date();
timeReport(t1,t3);
  }
 
 function timeReport(t1,t2){
 var lengh = t2-t1;
 Logger.log('took '+lengh+' millisecs');
 }
 

function checkLIVEDups(){
//var t1=newDate();
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit');
var newSH = overview.getSheetByName("LIVE");
  var sheetTarg = newSH.getRange(2,3,7).getValues(); 
      for (z in sheetTarg){
   var diff = filedupCheck(sheetTarg[z]);
      }
    }

// Returns true if the cell where cellData was read from is empty.
// Arguments:
//   - cellData: string
function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}

function filedupCheck(sheetTarg){
  Logger.log(sheetTarg);
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
  return diff;
}
}

function ezTranslateNsave() {
var spanishHtml = LanguageApp.translate(content,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(title, 'en', 'es', {contentType: 'text'});
var ss = SpreadsheetApp.getActiveSpreadsheet();
  var destination = ss.getSheetByName("Sheet3");
    destination.appendRow([spanishTit,spanishHtml,spanishExc,category,tags]);
}