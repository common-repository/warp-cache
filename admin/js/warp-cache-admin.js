/**
 * @since 1.0.1
 */


// Specify your actual API key here:
var API_KEY = 'AIzaSyAGSsnZvEQhnJkL7z1LjNvwClp9F9NRAec';
//var URL_TO_GET_RESULTS_FOR = window.location.protocol + "//" + window.location.host;
var URL_TO_GET_RESULTS_FOR = WPURLS.siteurl;


var API_URL = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?';
//var CHART_API_URL = 'http://chart.apis.google.com/chart?';

// Object that will hold the callbacks that process results from the
// PageSpeed Insights API.
var callbacks = {}

// Invokes the PageSpeed Insights API. The response will contain
// JavaScript that invokes our callback with the PageSpeed results.
function runPagespeed() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  var query = [
    'url=' + URL_TO_GET_RESULTS_FOR,
    'callback=runPagespeedCallbacks',
    'key=' + API_KEY,
  ].join('&');
  s.src = API_URL + query;
  document.head.insertBefore(s, null);
}

// Our JSONP callback. Checks for errors, then invokes our callback handlers.
function runPagespeedCallbacks(result) {
  if (result.error) {
    var errors = result.error.errors;
    for (var i = 0, len = errors.length; i < len; ++i) {
      if (errors[i].reason == 'badRequest' && API_KEY == 'yourAPIKey') {
        alert('Please specify your Google API key in the API_KEY variable.');
      } else {
        // NOTE: your real production app should use a better
        // mechanism than alert() to communicate the error to the user.
        alert(errors[i].message);
      }
    }
    return;
  }

  // Dispatch to each function on the callbacks object.
  for (var fn in callbacks) {
    var f = callbacks[fn];
    if (typeof f == 'function') {
      callbacks[fn](result);
    }
  }
}

// Invoke the callback that fetches results. Async here so we're sure
// to discover any callbacks registered below, but this can be
// synchronous in your code.
setTimeout(runPagespeed, 0);

callbacks.displayPageSpeedScore = function(result) {
  var score = result.ruleGroups.SPEED.score;
  var scoreAfter = document.getElementById('warp-cache-after-speed-status');
  scoreAfter.innerHTML = score + '/100';
};

// Display top PageSpeed suggestions

callbacks.displayTopPageSpeedSuggestions = function(result) {
  var results = [];
  var ruleResults = result.formattedResults.ruleResults;
  for (var i in ruleResults) {
    var ruleResult = ruleResults[i];
    // Don't display lower-impact suggestions.
    if (ruleResult.ruleImpact < 0.5) continue;
    results.push({
      name: ruleResult.localizedRuleName,
      impact: ruleResult.ruleImpact//,
      //description: ruleResult.summary.format
    });
  }
  results.sort(sortByImpact);
  var ul = document.getElementById('warp-cache-suggestions');
  for (var i = 0, len = results.length; i < len; ++i) {
    var elementWrapper = document.createElement('div'); //document.createElement('li');
    elementWrapper.className = "warp-cache-suggestion";
    var nameWrapper = document.createElement('div');
    nameWrapper.className = "warp-cache-suggestion-title";
    nameWrapper.innerHTML = results[i].name;
    ul.insertBefore(elementWrapper, null);
    elementWrapper.insertBefore(nameWrapper, null);
  }
  if (ul.hasChildNodes()) {
    //document.body.insertBefore(ul, null);
  } else {
    var div = document.createElement('div');
    div.innerHTML = 'No high impact suggestions. Good job!';
    document.body.insertBefore(div, null);
  }
};

// Helper function that sorts results in order of impact.
function sortByImpact(a, b) { return b.impact - a.impact; }