
  

function tester(){
  var idsh = '12cLS6o_M8wi4xAENE1LxcEbiSIirT9q9L4CFzsnMus8';
 var ID = 'orgbiz'; 
 var resp= sendXml(idsh);
  
  Logger.log(ID, resp);
}

 function sendXml(ID, idsh){

   var ss = SpreadsheetApp.openById(idsh);
var sheet = ss.getSheetByName("Sheet1");
var range = sheet.getRange(3, 1, 1, 8); var data = range.getValues();
  for (var i = 0; i < data.length; i++){ 
    var rowData = data[i];
    var post_title = rowData[0];  
    var desc = rowData[1]; 
    var articleUrl = rowData[2];
	var category = rowData[3];  
    var wp_author_display_name = rowData[4];  
    var image = rowData[5];
    var tags = rowData[7];
    }
 
  if ((!desc) && (!post_title)){
  return 'error NO TITLE OR CONTENT'; 
  } else {
   var payload = {
   'identifier': ID,
   'post_title': post_title,
    'post_content': post_content,
    'post_excerpt': post_excerpt, 
    'categories': category,
     'tags': tags
    };    
   var options = {
        'method' : 'post',
      'payload' : payload
            };   
     var url= 'organisemybiz.com/wau.php';  
  var response = UrlFetchApp.fetch(url, options);
 Logger.log(response.getContentText());
 
 var ScriptProperties = PropertiesService.getScriptProperties();
 var thh = ScriptProperties.getProperty('sent'); 
 var suc = ScriptProperties.getProperty('suc'); var fail = ScriptProperties.getProperty('fail');
 if(!isNaN(parseFloat(response)) && isFinite(response)){
    suc++;
		var formattedDate = Utilities.formatDate(new Date(), "GMT+11", "dd-MM-yyyy'@'HH:mm''");
     }else{
   fail++;
      }  
 thh++;
    var values44 = ([thh, suc, fail, response]);
return values44;
  }
    var main = ss.getSheetByName("Sheet2");

 var newProperties = {sent: res, suc: suc, fail: fail};
 ScriptProperties.setProperties(newProperties);
if (res==1){
var destination = ss.getSheetByName("Sheet2");
  destination.appendRow([post_title,response,formattedDate]); 
var spanishHtml = LanguageApp.translate(post_content,'en', 'es', {contentType: 'html'});
var spanishTit = LanguageApp.translate(post_title, 'en', 'es', {contentType: 'text'});
var Sphtml = "New post by " + wp_author_display_name + " discussing " + tags + "." + post_title;
var spanishExc = LanguageApp.translate(Sphtml, 'en', 'es', {contentType: 'text'});
var ss = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1JIk3NlUVH300FRxUfUEXSDyYht_CyU5bZp1M8WQ9ET4/edit');
var id = ID + 'es';
  var destination2222 = ss.getSheetByName(id);
destination2222.appendRow([spanishTit,spanishHtml,spanishExc,category,tags]); 
sheet.deleteRow(2); 
//ezSend();
} else {
var destination = ss.getSheetByName("Sheet2");
destination.appendRow([post_title,post_content,post_excerpt,category,tags]); 
}
}

