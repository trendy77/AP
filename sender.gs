function sendLine() {
var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");
var LOG = overview.getSheetByName("LOGS");
   /// get cell with current line info
    var uptoSpot = newSH.getRange("B13").getValue();
      // get said range
  var idTosh = newSH.getRange(uptoSpot,7,1,8).getValues();
  for (var i = 0; i < idTosh.length; i++){ 
    var rowData = idTosh[i];
  }
var result = {
    'identifier': rowData[0],
    'title': rowData[1],
    'content': rowData[2],
    'articleUrl': rowData[2],
    'source': rowData[4],
    'categories': rowData[3],
    'tags': rowData[7],
    'image':rowData[5]
  };
  
  var options = {
   'method' : 'post',
    'payload' : result,
    'muteHttpExceptions' : true
 };
  var line = uptoSpot;
LOG.appendRow(['title is ' + rowData[1]]);
 LOG.appendRow([ 'line uptoSpot is ' + uptoSpot]); 
uptoSpot++;
  if (uptoSpot==9){
    uptoSpot=2;
    }
      // set next line #
  newSH.getRange('B13').setValue(uptoSpot);
   // shoot off the POST Details
var response= UrlFetchApp.fetch('https://trendypublishing.com.au/whyau.php', options);
   LOG.appendRow([ 'response from ' + rowData[0] + ' is '+ response]);      
           // if it worked
         if(!isNaN(parseFloat(response)) && isFinite(response)){
             // add one to the success tally
        var win = newSH.getRange(line,16).getValue();  win++;newSH.getRange(line,16).setValue(win);
            }else{     // failure
    var out = newSH.getRange(line,17).getValue(); out++; newSH.getRange(uptoSpot,17).setValue(out);
            }  
          // either way add a try, then prepare next line
      var tot = newSH.getRange(line,18).getValue(); tot++;newSH.getRange(line,18).setValue(tot); 
    next(line);
    }

// finds number remaining posts and updates sheet
function numberL(hhh){
 var ss = SpreadsheetApp.openById(hhh);
//var gov2s = ss.getSheetByName("Sheet3");var leftE = gov2s.getMaxRows(); 
 var gov1s = ss.getSheetByName("Sheet1");var rows = gov1s.getMaxRows();
return rows;
}
    // param line - the next line in process order...
function next(line){
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");
    // get next row ID value
  var li = newSH.getRange(line,3).getValue();
var nextSht = SpreadsheetApp.openById(li);
  var sss = nextSht.getSheetByName('Sheet1');
     // check lines remaining
           var left=  numberL(li);
      var tags = checkTags(li);
            // get the next row to post
      var rngP = sss.getRange(3,1,1,8).getValues();
          // next line inserted into OVERVIEW
  var lineIn = newSH.getRange(line,8,1,8).setValues(rngP);
       // then remove the line...
   sss.deleteRow(3);        
    return;
    }

function getLines(){
var t1 = new Date();
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); 
var newSH = overview.getSheetByName("LIVE"); 
var LOG = overview.getSheetByName("LOGS");
 
 
 // get all ids
 var rng = newSH.getRange(2,3,7,1).getValues();
var t2 = new Date();
  
  // for each id, open
  for (var zz = 0; zz<6;zz++){
     var id = rng[zz];
 LOG.appendRow([ 'this rng aka: '+ rng[zz] + ' is :' + rng[zz]]);
     var ovw = SpreadsheetApp.openById(id);
  var sss =  ovw.getSheetByName('Sheet1');

var nam= ovw.getName(); var urlss =ovw.getUrl(); var numm = sss.getMaxRows();

               //   insert 2ND COL sheet name, 3RD id(again), 4TH url,5TH numRowsLeft  6th TAGS 
          // row to post
var tagd = checkTags(rng[zz]);
  LOG.appendRow( ['numm rows is ' + numm + 'tagged are '+ tagd]);
  var rngP = sss.getRange(3,1,1,8).getValues();
     var thisss= ([nam,id,urlss,numm, tagd]);
     var move = newSH.getRange(zz+2,2,1,5).setValues([thisss]);  // or 8+5?
     var lineIn = newSH.getRange(zz+2,8,1,8).setValues(rngP);
    var fdsthis = new Date();
var thissss1=  timeReport(t2,fdsthis);
    LOG.appendRow([ 'time rep: ' + thissss1]);
  var tggd = checkTags(rng[zz]);
  var t3 = new Date();
var zzd = timeReport(t1,t3);
 LOG.appendRow([ 'time end - t1: ' + zzd]);
  }
  
 }
 
 function timeReport(t1,t2){
 var lengh = t2-t1;
return lengh;
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

function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}

function filedupCheck(sheetTarg){
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


// param - sheet ID - checks number of tags
 function checkTags(ssid){
 var ta = new Date();
var tagged = 0;var notTagged = 0;
 var ss=SpreadsheetApp.openById(ssid);
   var sheet = ss.getSheetByName("Sheet1");

 var numm= sheet.getMaxRows();
 var rows=sheet.getRange(2,8,numm,1).getValues();
    for (var row=1; row < numm; row++) { 
      if (isCellEmpty(row)) {
        notTagged++;
            } else {
            tagged++;
    }
}
return tagged;
}


function ezTranslateNsave() {
var spanishHtml = LanguageApp.translate(content,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(title, 'en', 'es', {contentType: 'text'});
var ss = SpreadsheetApp.getActiveSpreadsheet();
  var destination = ss.getSheetByName("Sheet3");
    destination.appendRow([spanishTit,spanishHtml,spanishExc,category,tags]);
}