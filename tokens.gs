function myFunction() {
 //  wp oauth add --name=gapps --description=gapps   
// ID: 264356
// Key: Jf8jR7DirGfr
// Secret: lEEivSvJJJl3v9u8fzBfG1CMkvKY1RznK0XIF4jOPA9oUdjS
// redirect URL : https://script.google.com/macros/d/1tsf2YD4wYHfK50x26STJ3H75enZ-7Pt0-sxE01ls3lmbv3hrqAqCT29B/usercallback  

// oauth AutoPost with callback!//
//Client Key	FlztJEcxFlkW
//Client Secret	SVKFh82nD8R2mAPXjZ7tVqw9IZFwkOljHm9e2lyU9bQuMJj3


var value = 'POST&http%3A%2F%2Forganisemybiz.com%2Fwp-json%2Fwp%2Fv2%2Fposts&oauth_consumer_key%3DFlztJEcxFlkW%26oauth_nonce%3Dnonce%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D' + newDate() + '%26oauth_token%3D';
var key = 'SVKFh82nD8R2mAPXjZ7tVqw9IZFwkOljHm9e2lyU9bQuMJj3&';
var signature = Utilities.computeHmacSignature(Utilities.DigestAlgorithm.SH_1, value, key);

Logger.log(signature);

 var response = UrlFetchApp.fetch('http://organisemybiz.com/wp-json/wp-v2/posts', {
    headers: {
      Authorization: 'Bearer ' + driveService.getAccessToken()
    }
  });
  
  
 // .setTokenHeaders({
 // 'Authorization': 'Basic ' + Utilities.base64Encode(CLIENT_ID + ':' + CLIENT_SECRET)
//});


}

//We use the three-legged flow
//To find the REST API index, apply the API autodiscovery process
//The endpoints for the OAuth process are available in the REST API index: check for $.authentication.oauth1 in the index data.
//The temporary credentials (request token) endpoint is $.authentication.oauth1.request (typically /oauth1/request)
//The authorization endpoint is $.authentication.oauth1.authorize (typically /oauth1/authorize)
//The token exchange (access token) endpoint is $.authentication.oauth1.access (typically /oauth1/access)
//Your callback URL must match the registered callback URL for the application in the scheme, authority (user/password) host, port, and path sections. (Subpaths are not allowed.)
//The only signature method supported is HMAC-SHA1.