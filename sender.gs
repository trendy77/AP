function sendLine() {
//var addy = 'https://trendypublishing.com.au';
  var identi = 'tpau';

var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");

  // GET LINE TO SEND...
  var ScriptProperties = PropertiesService.getScriptProperties();
  var line2go = ScriptProperties.getProperty('line2go'); 
  var responseCol = ScriptProperties.getProperty('responseCol');
  
  Logger.log(line2go);    Logger.log('line2go is ', line2go);
  
  if (line2go=='9'){
    line2go=2; responseCol++;
    }
  
  var lineGone = line2go;
 
  // TEST...
 var sameOr = line2go; 
 line2go = line2go++;
   
 Logger.log('line2goNow is ', line2go);
  Logger.log('this is the same/should be one more yeh', sameOr);
 
     // HIGHLIGHT THE FOLLOWING LINE...
var idTosh = newSH.getRange(line2go,7,1,9).setBackground('yellow');
 // UN-HIGHLIGHT THE PRIOR LINE...
newSH.getRange(lineGone,7,1,9).setBackground('grey');
    
  // GET THE POST @ LINE 2 SEND ....
var idTosh = newSH.getRange(line2go,7,1,9).getValues();
  for (var i = 0; i < idTosh.length; i++){ 
    var rowData = idTosh[i]; 
   
    var result = {
    'identifier': rowData[0],
    'title': rowData[1],
    'content': rowData[2],
    'articleUrl': rowData[3],
    'source': rowData[5],
    'categories': rowData[4],
    'tags': rowData[8],
    'image':rowData[6]
  };
     
    if (isBlank(title) && isBlank(content)){
 MailApp.sendEmail('trendypublishingau@gmail.com', 'no data @ line#' + line2go, 'https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit');
      Logger.log('no info @ line...');
      return;
    } else { 
  
       var options = {
         'method' : 'post',
         'params': '',
         'payload' : result,
         'muteHttpExceptions' : true
 }
if( lineGone == 2){
   var addy= 'http://fakenewsregistry.org/wau.php';
  }   
  else if (lineGone == 3){
  var addy= 'https://customkitsworldwide.com/AP/wau.php';
  }
  else if (lineGone == 4){
  var addy= 'https://vapedirectory.co/wau.php';
  }
   else if( lineGone == 5){
    var addy= 'https://govnews.info/wau.php';
    }
     else if( lineGone == 6){
       var addy= 'https://trendypublishing.com.au/wau.php';
      }
     else   if( lineGone == 7){
        var addy= 'https://trendypublishing.com/remotePost.php';
        }
      else    if( lineGone == 8){
       var addy= 'https://organisemybiz.com/wau.php';
   }
var response= UrlFetchApp.fetch(addy, options);

      // LOG AND SAVE RESPONSE...
      Logger.log(response);
newSH.getRange(lineGone,responseCol).setValue(response);
       
      // SCORE OR FAIL?
      if(!isNaN(parseFloat(response)) && isFinite(response)){
        var suc = newSH.getRange(lineGone,18).getValue();  suc++;newSH.getRange(lineGone,18).setValue(suc);
            }else{  
              var fail = newSH.getRange(lineGone,19).getValue(); fail++; newSH.getRange(lineGone,19).setValue(fail);
            }  
    // ADD ONE TO THE ATTEMPTS, EITHER WAY...
      var tot = newSH.getRange(lineGone,20).getValue(); 
      tot++;
      newSH.getRange(lineGone,20).setValue(tot); 
      var newProperties = {tot: tot, suc: suc, fail: fail, line2go: line2go, lastSent:lineGone };
 ScriptProperties.setProperties(newProperties);
 
   // PREPARE THE POST IN THE PLACE OF THE ONE JUST SENT.... 
      refill(lineGone);
    }
}


// finds number remaining posts and updates sheet
function numberL(){
  var hhh = SpreadsheetApp.getActiveSpreadsheet();
  try {
   var sheet = hhh.getSheetByName("Sheet1");
  } catch(e){
    return 'error no sheet1...'
  }
    var gov2s = ss.getSheetByName("Sheet3");
    Logger.log('last row',gov2s.getLastRow());
    var leftE = gov2s.getMaxRows(); 
 Logger.log('max rows',leftE);
  var rows = sheet.getLastRows();
    Logger.log('last row',rows);
    var left = gov1s.getMaxRows(); 
 Logger.log('max rows',left);
  return left;
}

   
function refill(line){
var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");

  // get next row ID to OPEN
  var li = newSH.getRange(line,3).getValue();

  var nextSht = SpreadsheetApp.openById(li);
  
  try { 
    var sss = nextSht.getSheetByName('Sheet1');
        } catch(e){
      return 'error - no sheet 1?';
    }
   // check REMAINING LINES IN SHEET
    var left=  numberL();
  // check TAGS
    var tags = AUTOcheckTags(li);
            
  var rngP = sss.getRange(3,1,1,8).getValues();
        
  // insert into OVERVIEW
  var lineIn = newSH.getRange(line,8,1,8).setValues(rngP);
    // translate...
var spanishHtml = LanguageApp.translate(rngP[1],'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(rngP[0], 'en', 'es', {contentType: 'text'});

  if(!nextSht.getSheetByName("Sheet3")){
  start();
  };
var destination = nextSht.getSheetByName("Sheet3");
destination.appendRow([spanishTit,spanishHtml,rngP[2],rngP[3],rngP[4],rngP[5],rngP[6],rngP[7]]); 

  // COPY TO SHEET 2 FOR POSTERITY...
  SECSht.getSheetByName("Sheet2");
    SECSht.appendRow(rngP);
  
  // DELETE LINE...
 sss.deleteRow(3);        
 return;
}
}

function getALLfiveLines(){
var t1 = startClock('allLIVElines');
var overview = SpreadsheetApp.openById('1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4'); 
var newSH = overview.getSheetByName("LIVE"); 

  // get all LINES OF IDS = rng[x, y, z...]
 var rng = newSH.getRange(2,3,7,1).getValues();

  // TIME @ START OF GETTING LINES
  var LEN = timeChk(t1);
  for (var zz = 0; zz<6;zz++){
     var id = rng[zz];
      var ovw = SpreadsheetApp.openById(id);
    try {
    var sss =  ovw.getSheetByName('Sheet1');
    }catch(e){
 Logger.log(e.line, e.message);
    }
        var nam= ovw.getName(); var urlss =ovw.getUrl(); var numm = sss.getMaxRows();
    
    //   insert 2ND COL sheet name, 3RD id(again), 4TH url,5TH numRowsLeft  6th TAGS lenar tagd = checkTags(rng[zz]);
  Logger.log( ['nam'+' numm rows is ' + numm + 'tagged are '+ tagd]);
     var rngP = sss.getRange(3,1,1,8).getValues();
    var thisss= ([nam,id,urlss,numm, tagd]);  
       var move = newSH.getRange(zz+2,2,1,5).setValues([thisss]);  // or 8+5?
     var lineIn = newSH.getRange(zz+2,8,1,8).setValues(rngP);
      timeChk(t1);
    }
  }


function isCellEmpty(cellData) {
  return typeof(cellData) == "string" && cellData == "";
}

 function AUTOcheckNumNTags(ssid){
   var numberLeft = 0;
   var tagged = 0;
   var notTagged = 0;var unsure=0;
 var ss=SpreadsheetApp.openById(ssid);
 var sheet = ss.getSheetByName("Sheet1");
 var maxRows = sheet.getMaxRows();
  var rows=sheet.getRange(1,8,maxRows,1).getValues();
  for (row in rows) { 
      if (isCellEmpty(rows[row])) {
      untagged++;
        var furtherLook = sheet.getRange(rows[row],1,1,2).getValues();
        if (!isCellEmpty(furtherlook[0]) &&(!isCellEmpty(furtherlook[1]))){
          numberLeft++;
        } else {
          unsure++;
        }
      }
    else {
      tagged++; numberLeft++;
       }
  }
 var results = ([[numberLeft,tagged,notTagged,unsure]]);
return results;
 }


function ezTranslateNsave() {
var spanishHtml = LanguageApp.translate(content,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(title, 'en', 'es', {contentType: 'text'});
var ss = SpreadsheetApp.getActiveSpreadsheet();
  var destination = ss.getSheetByName("Sheet3");
    destination.appendRow([spanishTit,spanishHtml,spanishExc,category,tags]);
}