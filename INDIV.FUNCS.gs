
//////   start ---> strtTEMPLT(line,id)  ----> sheetset(id of sheet)  ----->duplisheet ---->


function start(id){ // open overview
   var url = 'https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit#gid=0';
   var ov= SpreadsheetApp.openByUrl(url);
           
  var sum= ov.getSheetByName("LIVE");
 // var identi = sum.getRange(line,1,1,3);
//startTMPLT(3,'1JrTSkbWDYmOxEYIJDgoZj2MRLlfa-BZ1Mk6tvD4cMNs');
}

function startTMPLT(line,id){
var ss = SpreadsheetApp.openById(id);
var sheet = ss.getSheetByName("Sheet1");
          /// what number on master am I? @ 10th row, 1st line?
          // how many lines are in me? --- set to K?
 sheetSet(id);
  if( line == 2){
    fnr(line);
} if (line == 3){

}
  if (line == 4){
  
  }
    if( line == 5){
      
    }
      if( line == 6){
        
      }
        if( line == 7){
          
        }
          if( line == 8){
            
          }
}
  function sheetSet(id) {
 //gets Prev sheet from Overview Doc
 var url = 'https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit#gid=0';
   var ov= SpreadsheetApp.openByUrl(url);
      var sum= SpreadsheetApp.openById(id);
//in overview, creates named sheet and sends to itself
     var cop =sum.getSheetByName("Sheet2");
  if(!cop){
    var dest = ov.getSheetByName("TEMPLATE");
  var copy = dest.copyTo(sum);
    dupliSheet(cop,id);
  // 5 sheets made
   }
 SpreadsheetApp.flush();
    return;
  }

  function dupliSheet(cop,id){  
//   duplicates the sheet 5 times  
 var ss = SpreadsheetApp.openById(id);
    var a="Sheet2";var ba="Sheet3";var ca="Sheet4";var dca="Sheet5";
    var sheet2 =ss.insertSheet(a, {template: cop});
    var sheet3 =ss.insertSheet(ca, {template: cop});
    var sheet4 =ss.insertSheet(ba, {template: cop});
    var sheet5 =ss.insertSheet(dca, {template: cop});
    //ss.deleteSheet(cop);
return;
  }

function ckww(index){
var line =index;var site='https://customkitsworldwide.com'; var id = 'ckww'; var siteT = 'CustomKitsWorldwide';var siteTE='Noticias-del-Equipacion Futbol';var siteE='es.customkitsworldwide.com';  
var suc=0;var sucE=0;var failE=0; var fail=0; var sent=0;  var sentE=0; var ides='ckwwes';
var newID = {site: site, siteE:siteE, siteTE:siteTE, siteT: siteT,line:line, id:id, sent:sent,sentE:sentE,sucE:sucE,suc:suc,fail:fail,failE:failE};
  var ScriptProperties = PropertiesService.getScriptProperties();
  ScriptProperties.setProperties(newID);
  return line;
}
function gov(index){
var line =index;var site = 'http://govnews.info'; var siteT = 'GovNews';var siteTE=0; var id = 'gov'; var suc=0;var sucE=0;var siteE = 0;var failE=0; var fail=0; var sent=0;  var sentE=0; var tagged=0; var notTagged=0;var ides='ides';
var newID = {site: site, siteE:siteE, siteTE:siteTE, siteT: siteT,line:line, ides:ides,  id:id, sent:sent,sentE:sentE,sucE:sucE,suc:suc,fail:fail,failE:failE};
  var ScriptProperties = PropertiesService.getScriptProperties();
  ScriptProperties.setProperties(newID);
  return line;
}
function vape(index){
var line =index; var site = 'http://vapedirectory.co';  var siteT = 'VapeDirectory';  var id = 'vape';     
var suc=0;var sucE=0;var failE=0; var fail=0; var sent=0;  var sentE=0;var siteTE=0; var siteE=0; 
var newID = {site: site, siteT: siteT,line:line, id:id, sent:sent,suc:suc,fail:fail};
  var ScriptProperties = PropertiesService.getScriptProperties();
  ScriptProperties.setProperties(newID);
return line;
}
function orgbiz(index){
var site = 'https://organisemybiz.com';  var line =index; var siteT = 'OrganiseMyBiz';    var id = 'orgbiz'; var siteTE = 'Organizar-Mi-Noticias'; var siteE = 'https://organisemybiz.com/es';
var suc=0;var sucE=0;var failE=0; var fail=0; var sent=0;  var sentE=0; var tagged=0; var notTagged=0;var ides='orgbizes';
var newID = {site: site, siteE:siteE, siteTE:siteTE, siteT: siteT,line:line, id:id,ides:ides, sent:sent,sentE:sentE,sucE:sucE,suc:suc,fail:fail,failE:failE, tagged:tagged, notTagged:notTagged};
  var ScriptProperties = PropertiesService.getScriptProperties();
  ScriptProperties.setProperties(newID);1
return line;
}

function fnr(index){
 var line =index;var site = 'http://fakenewsregistry.org'; var siteT = 'FakeNewsRegistry';var id = 'fnr'; var siteTE = 'Falsas-Honcho Noticias'; var siteE = 'http://fakenewsregistry.org/es';
var ides = 'fnres';var suc=0;var sucE=0;var failE=0; var fail=0; var sent=0;  var sentE=0; var tagged=0; var notTagged=0;var ides='fnres';
  var newID = {site: site, siteE:siteE, siteTE:siteTE, siteT: siteT,line:line, ides:ides, id:id, sent:sent,sentE:sentE,sucE:sucE,ides:ides,fail:fail,failE:failE, tagged:tagged, notTagged:notTagged};
  var ScriptProperties = PropertiesService.getScriptProperties();
  ScriptProperties.setProperties(newID);
  return line;
}
   

// INSERTED EXTRA LINES FOR INFO....v861a - tagging +remote title
function dupCheck(options){
var ScriptProperties = PropertiesService.getScriptProperties();
var id = ScriptProperties.getProperty('id');
 var ss = SpreadsheetApp.getActiveSpreadsheet(); 
  var sheet = ss.getSheetByName("Sheet1");
   var data = sheet.getDataRange().getValues();            //we do a single call to the spreadsheet to retrieve all the data.
  var newData = new Array();        var diff = 0;                   // newData is an empty array where we will put all rows which are not duplicates.
  for(i in data){
    var row = data[i];    var duplicate = false;                             //      for loop iterates over each row in the data 2-dimensional array. 
    for(j in newData.length()){                            
  if(row[0] == newData[j][0] || row[1] == newData[j][1]){
  duplicate = true;
}
    }
    if(!duplicate){
      newData.push(row);
      }
  }  sheet.clearContents();                            //      the script deletes the existing content of the sheet and inserts the content of the newData array.
   sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
     if (data.length != newData.length){
		diff = (data.length-newData.length);
		var sheet5 = ss.getSheetByName('Sheet5');
		var totDiff = ScriptProperties.getProperty('totDiff');
			for (var z=0;z<diff;z++){
			totDiff++;
			}
		var formattedDate = Utilities.formatDate(new Date(), "GMT+11", "dd-MM-yyyy_HH:mm''");
		ScriptProperties.setProperty('totDiff', totDiff);
	       var dee = ([diff,newData.length,formattedDate]);
	sheet5.getRange(2,1,1,3).setValues([dee]);
		}
 SpreadsheetApp.flush();
  return diff ;
}
 function sendXml(){
 var ScriptProperties = PropertiesService.getScriptProperties();
 var id = ScriptProperties.getProperty('id');var siteT = ScriptProperties.getProperty('siteT');  var site = ScriptProperties.getProperty('site');
 var ss = SpreadsheetApp.getActiveSpreadsheet();
var sheet = ss.getSheetByName("Sheet1");
 var range = sheet.getRange(2, 1, 1, 9); var data = range.getValues();
  for (var i = 0; i < data.length; i++){ 
    var rowData = data[i];
    var title = rowData[0];  
    var desc = rowData[1]; 
    var articleUrl = rowData[2];
	var category = rowData[3];  
    var source = rowData[4];  
    var image = rowData[5];
    var tags = rowData[7];
    }
// var post_excerpt = "New post by " + source + " discussing " + tags + "here at " + siteT + ":" + post_title;
  if ((!desc) && (!post_title)){
   return 'error'; 
  } else {
 	// ADD METATAGS 
		//var html = ('<!DOCTYPE html><html><head><base target="_top"><meta charset="UTF-8"><title>' + post_title + '</title></head><body>' + desc + '<a href="' + articleUrl + '">Read Original Article HERE</a><br><a href="http://' + site + '/'+ category + '">View More HERE</a><br><a href="http://' + '/tag/' + source+ '">View More' + source + ' HERE</a><br></body></html>');
  var payload = {
   'identifier': id,
   'post_title': title,
    'post_content': desc,
     'categories': category,
     'tags': tags
    };    
   var options = {
        'method' : 'post',
      'payload' : payload
            };   
 Logger.log(response.getContentText());
var destination = ss.getSheetByName("Sheet2");
  destination.appendRow([title,desc,formattedDate]); 
var spanishHtml = LanguageApp.translate(desc,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(title, 'en', 'es', {contentType: 'text'});
var destination = ss.getSheetByName("Sheet3");
destination.appendRow([spanishTit,spanishHtml,category,source,tags]); 
sheet.deleteRow(2); 
//ezSend();
}
}

function ezTranslate(){
   var id = '1JrTSkbWDYmOxEYIJDgoZj2MRLlfa-BZ1Mk6tvD4cMNs';
  var ovw = SpreadsheetApp.openById(id);
  var sheet = ovw.getSheetByName("Sheet1");
 var data = sheet.getDataRange().getValues();
var newData = new Array();                         // newData is an empty array where we will put all rows which are not duplicates.
  for(i in data){
    var row = data[i];                              //      for loop iterates over each row in the data 2-dimensional array. 
    for(j in data[i]){                            
      var col = data[j][i];
    }
var spanishHtml = LanguageApp.translate(data[1][j],'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(data[0][j], 'en', 'es', {contentType: 'text'});
var espD=([spanishTit,spanishHtml,data[2][j],data[3][j],data[4][j],data[5][j],data[6][j],data[7][j]]);
  
var destination = ovw.getSheetByName("Sheet3");
destination.appendRow(espD);
}
}
function ezSend() {
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");
var upTo = newSH.getRange(15,4).getValue();
if ((upTo == '4')||(upTo == '5')) {      // then there's no ESP specific site...
  upTo++;
}else{
  for (var zz = 0; zz<7;zz++){
     var id = rng[zz];
     Logger.log(rng[zz]);
      	 ezTranslate(id);
   //  var id = ScriptProperties.getProperty('ides');
//  var siteE = ScriptProperties.getProperty('siteE');var siteTE = ScriptProperties.getProperty('siteTE');
// var id = ScriptProperties.getProperty('ides');
//   var ss = SpreadsheetApp.getActiveSpreadsheet();
return;
}
}
}
// INSERTED EXTRA LINES FOR INFO....v861a - tagging +remote title
function dupCheck(){
var ScriptProperties = PropertiesService.getScriptProperties();
var id = ScriptProperties.getProperty('id');
 var ss = SpreadsheetApp.getActiveSpreadsheet(); 
  var sheet = ss.getSheetByName("Sheet1");
   var data = sheet.getDataRange().getValues();            //we do a single call to the spreadsheet to retrieve all the data.
  var newData = new Array();        var diff = 0;                   // newData is an empty array where we will put all rows which are not duplicates.
  for(i in data){
    var row = data[i];    var duplicate = false;                             //      for loop iterates over each row in the data 2-dimensional array. 
    for(j in newData){                            
  if(row[0] == newData[j][0] || row[1] == newData[j][1]){
  duplicate = true;
}
    }
    if(!duplicate){
      newData.push(row);
      }
  }  sheet.clearContents();                            //      the script deletes the existing content of the sheet and inserts the content of the newData array.
   sheet.getRange(1, 1, newData.length, newData[0].length).setValues(newData);
 SpreadsheetApp.flush();
return diff;
}

