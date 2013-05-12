function loadMap() {
  if (GBrowserIsCompatible()) {
    var map = new GMap2(document.getElementById("map"));
    map.setCenter(new GLatLng(55.527306, -2.6948127), 5);
    map.addControl(new GLargeMapControl3D());

    // Change this depending on the name of your PHP file
    GDownloadUrl("map.xml", function(data) {
      var xml = GXml.parse(data);
      var markers = xml.documentElement.getElementsByTagName("marker");
      for (var i = 0; i < markers.length; i++) {
        var name = markers[i].getAttribute("name");
        var mpname = markers[i].getAttribute("mpname");
        var person_id = markers[i].getAttribute("personid");
        var party = markers[i].getAttribute("party");
        var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                parseFloat(markers[i].getAttribute("lng")));
        var marker = createMarker(point, name, mpname, person_id, party);
        map.addOverlay(marker);
      }
    });
  }
}

function createMarker(point, name, mpname, person_id, party) {
  if ((party == "Conservative") || (party == "Labour") || (party == "Liberal Democrat") || (party == "Green") || (party == "Sinn Fein") || (party == "DUP") || (party == "Plaid Cymru") || (party == "Scottish National Party") || (party == "Social Democratic and Labour Party")) {
  	var marker = new GMarker(point, customIcons[party]);
  } else {
	var marker = new GMarker(point, iconGrey);
  }
  var html = "<b>" + name + "</b> <br/>" + mpname + " (" + party + ")<br/><a href=\"" + mpname.replace(" ", "_") + "\">View Details >></a>";
  GEvent.addListener(marker, 'click', function() {
    marker.openInfoWindowHtml(html);
  });

  return marker;
}

// Sends the status form.  Enables the user to hit enter and act like Submit
// was pressed.
function send() {
	document.statusform.submit();
}

// Performs an action via the actionbox without confirmation
function doAction(link) {
	$("#actionbox").load(link);
}

// Sets up autocompletion on the search box
function setAutoComplete() {
    $("#query").autocomplete("autocomplete.php");
    $("#query").result(function(event, data, formatted) {
		if (data)
			$(this).val(data[1]);
			document.findform.submit();
	});
	
    $("#name").autocomplete("autocomplete.php");
    $("#name").result(function(event, data, formatted) {
		if (data)
			$(this).val(data[1]);
	});
}

// Shows the search on the main page
function showSearch() {
    $("#mainpagecontents").load("search.php");
    setTimeout('setAutoComplete()', 2000);
}

// Shows the map on the main page
function showMap() {
    $("#mainpagecontents").load("map.php");
    setTimeout('loadMap()', 2000);
}

// Shows the list on the main page
function showList() {
    $("#mainpagecontents").load("list.php");
}

// Shows the add detail form on the main page
function showAddDetail() {
    $("#mainpagecontents").load("adddetail.php");
}

// Refreshes the live feed on the main page
function refreshLiveFeed() {
    $("#mainpagelivefeed").load("feeds.php?widget=true");
}

// Sets an MP detail
function setDetail(person_id, type, defaulttext, prompttext) {
    newValue = prompt(prompttext, defaulttext);
	if (newValue != null) {
    	$("#actionbox").load("setdetail.php?person_id=" + person_id + "&type=" + type+ "&newvalue=" + encodeURIComponent(newValue));
	    alert("New item submitted for moderation.");
	}
}

// Filter form behaviour
function setFilters(person_id) {
    filterstring = "";
    if (document.filterform.website.checked == false) { filterstring = filterstring + "website,"; }
    if (document.filterform.blog.checked == false) { filterstring = filterstring + "blog,"; }
    if (document.filterform.twitter.checked == false) { filterstring = filterstring + "twitter,"; }
    if (document.filterform.facebook.checked == false) { filterstring = filterstring + "facebook,"; }
    if (document.filterform.youtube.checked == false) { filterstring = filterstring + "youtube,"; }
    if (document.filterform.other.checked == false) { filterstring = filterstring + "other,"; }
    if (document.filterform.twfy.checked == false) { filterstring = filterstring + "twfy,"; }
    $("#feeds").load("feeds.php?person_id=" + person_id + "&filterstring=" + filterstring);
}

function showMoreItems(person_id, pages) {
    if (person_id == '') {
        $("#feeds").load("feeds.php?timelimit=" + (pages + ""));
    } else {
        $("#feeds").load("feeds.php?person_id=" + person_id + "&timelimit=" + (pages + ""));
    }
}

function showMoreBlog(pages) {
    $("#blogfeeds").load("feeds.php?blog=true&timelimit=" + (pages + ""));
}
