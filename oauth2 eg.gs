var CLIENT_ID = 'Jf8jR7DirGfr';
var CLIENT_SECRET = 'lEEivSvJJJl3v9u8fzBfG1CMkvKY1RznK0XIF4jOPA9oUdjS';
//var KEY? 
/**
 * Authorizes and makes a request to the Wordpress API.
 */
function run() {
  var service = getService();
  if (service.hasAccess()) {
    var blogId = service.getToken_().blog_id;
    var url = 'https://organisemybiz.com/wp-json/wp/v2/posts';
    var response = UrlFetchApp.fetch(url, {
      headers: {
        'Authorization': 'Bearer ' + service.getAccessToken()
      }
    });
    var result = JSON.parse(response.getContentText());
    Logger.log(JSON.stringify(result, null, 2));
  } else {
    var authorizationUrl = service.getAuthorizationUrl();
    Logger.log('Open the following URL and re-run the script: %s',
        authorizationUrl);
  }
}

/**
 * Reset the authorization state, so that it can be re-tested.
 */
function reset() {
  var service = getService();
  service.reset();
}

/**
 * Configures the service.
 */
function getService() {
  return OAuth2.createService('Wordpress')
      // Set the endpoint URLs.
      .setTokenUrl('http://organisemybiz.com/oauth1/access')
      .setAuthorizationBaseUrl('http://organisemybiz.com/oauth1/authorize')

      // Set the client ID and secret.
      .setClientId(CLIENT_ID)
      .setClientSecret(CLIENT_SECRET)

      // Set the name of the callback function in the script referenced
      // above that should be invoked to complete the OAuth flow.
      .setCallbackFunction('authCallback')

      // Set the property store where authorized tokens should be persisted.
      .setPropertyStore(PropertiesService.getUserProperties());
}

/**
 * Handles the OAuth2 callback.
 */
function authCallback(request) {
  var service = getService();
  var authorized = service.handleCallback(request);
  if (authorized) {
    return HtmlService.createHtmlOutput('Success!');
  } else {
    return HtmlService.createHtmlOutput('Denied');
  }
}