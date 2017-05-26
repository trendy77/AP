
function startTMPLT(line,id){
var ss = SpreadsheetApp.openById(id);
  if (ss.getSheetByName("Sheet5")){ 
    return; 
  } else {
var sheet = ss.getSheetByName("Sheet1"); 
 sheetSet(id);
  
  if( line == 2){
    fnr(line);
} if (line == 3){
  ckww(line);
}
  if (line == 4){
  vape(line);
  }
    if( line == 5){
     gov(line); 
    }
      if( line == 6){
        glo(line);
      }
        if( line == 7){
        orgbiz(line);  
        }
          if( line == 8){
            ckwwes(line);
          }
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


//////   start ---> strtTEMPLT(line,id)  ----> sheetset(id of sheet)  ----->duplisheet ---->


function start(){
  var url = 'https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit#gid=0';
   var ov= SpreadsheetApp.openByUrl(url);
     var dest = ov.getSheetByName("LIVE");
var range = dest.getRange(2, 3,7,1).getValues();
for (var line =2; line < range.length;line++){
var id = range[line];
  startTMPLT(line,id);
}
}
