function sendLine() {
var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");
 
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
    'payload' : result
 };
 uptoSpot++;
  if (uptoSpot==8){
    uptoSpot=2;
    }
  newSH.getRange('B13').setValue(uptoSpot);
   // shoot off the POST Details
var response= UrlFetchApp.fetch('https://trendypublishing.com/why.php', options);
  if(!isNaN(parseFloat(response)) && isFinite(response)){
    var out = newSH.getRange(uptoSpot,15).getValue();
   out++;newSH.getRange(uptoSpot,15).setValue(out);
        next(uptoSpot);
    checkTags(upToSpot);
   }else{
  var out = newSH.getRange(uptoSpot,16).getValue();out++;
newSH.getRange(uptoSpot,16).setValue(out);
      }  
}

// finds number remaining posts and updates sheet
function numberL(hhh){
 var ss = SpreadsheetApp.openById(hhh);
//var gov2s = ss.getSheetByName("Sheet3");var leftE = gov2s.getMaxRows(); 
 var gov1s = ss.getSheetByName("Sheet1");var rows = gov1s.getMaxRows();
return rows;
}

function next(line){
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit'); 
var newSH = overview.getSheetByName("LIVE");
    // get next row ID value
  var li = newSH.getRange(line,3).getValue();
var theShe = SpreadsheetApp.openById(li);
  var sss =  theShe.getSheetByName('Sheet1');
  //check name n url again?
var nam= ovw.getName(); var urlss =ovw.getUrl(); var numm = sss.getMaxRows();
     // check lines remaining
  var left=  numberL(li);
       // get the next row to post
  var rngP = sss.getRange(3,1,1,8).getValues();
           // insert titles   
  var thisss= ([nam,li,urlss,numm,li]);
     var move = newSH.getRange(zz+2,2,1,5).setValues([thisss]);  // or 8+5?
       // insert next post info   
  var lineIn = newSH.getRange(zz+2,8,1,8).setValues(rngP);
       // then remove the line...
   sss.deleteRow(3);        
return;
}