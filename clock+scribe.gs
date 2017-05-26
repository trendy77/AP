
///// finds all spreadsheets in GDrive....
function jotDwn(nugget){
  var doc = DocumentApp.openByUrl('https://docs.google.com/document/d/1YRrn15RIbqpXo1QbMlQKwnbtVM4GG9C45VTxFtgOXGo/edit?usp=sharing');
var body = doc.getBody();
 // Append a new list item to the body.
 var item1 = body.appendListItem('nugget');
}

function scribe(nugget){
  var doc = DocumentApp.openByUrl('https://docs.google.com/document/d/1YRrn15RIbqpXo1QbMlQKwnbtVM4GG9C45VTxFtgOXGo/edit?usp=sharing');
var body = doc.getBody();
 // Append a table after the list item.
 body.appendTable([[nugget]]);
}
  
function stopClk(t1){
   var t2 = new Date();
var lengh = t2-t1;
 var formattedDate = Utilities.formatDate(new Date(), "GMT+11", "dd-MM-yyyy'@'HH:mm''");
  Logger.log('completed in tot of' ,lengh , 'seconds since t1', 'at ', formattedDate);  
 scribe([['completed in tot of' ,lengh , 'seconds since t1', 'at ', formattedDate]]);
  return;
}

function startClock(func){
  var t1 = new Date();
  var formattedDate = Utilities.formatDate(new Date(), "GMT+11", "dd-MM-yyyy'@'HH:mm''");
   Logger.log('started ', func, ' at ', formattedDate);  
scribe([[ 'started ', func, ' at ', formattedDate ]]);
  return t1;
}
function timeChk(t1){
  var t2 = new Date();
  var lengh = t2-t1;
Logger.log('has been' ,lengh , 'seconds since t1');
  scribe ([['has been' ,lengh , 'seconds since t1']]);
  return lengh;
}

function TIMRcheckLIVEDups(){
//var t1=newDate();
  var overview = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit');
var newSH = overview.getSheetByName("LIVE");
  var sheetTarg = newSH.getRange(2,3,7).getValues(); 
      for (z in sheetTarg){
   var diff = filedupCheck(sheetTarg[z]);
      }
    }
