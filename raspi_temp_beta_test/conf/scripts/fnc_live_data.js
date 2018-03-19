var groups;
var refreshgroups;
var trimed = { 'created':"yus" }; 
$(document).ready(function(){
	function reloadData( el ) {
	        $.ajax({url: el.src, async: true, success: function(result){
	            el.html(result);
	            console.log(el);
	        }});
	        //el.contentDocument.location.reload(true);
	};
	function trimGroups( groups ) {
		//var trimed;
		for ( x in groups ) {
			//trimed[groups] = x.replace("group","");
			var i = 5;
			var lasti;
				// trimed.group1 = 10...
			while ( i < x.length ) {
				var curnum = x.substring(i,i+1);
				if ( lasti ) {
					if (lasti == "1" && curnum == "0" || lasti == "9" && curnum == "9" || lasti == curnum && curnum != "1" ) {
						trimed["group"+lasti+""+(curnum)] = groups[x];
					} else if ( curnum != "0") {
						trimed["group"+(curnum)] = groups[x];
					}
					//console.log("# "+lasti+" - "+(curnum));
				}
				if ( lasti ) {
					i++;
				}
				lasti = curnum;
			}
		}
		return trimed;
	}
	// Funktion 2: timer / timeout -> reloadData(this)
	function refreshSites() {
		refreshgroups = { group1023456789:10, group99:25 };
		// var refreshgroups = { group1023456789:10, group99:25 };
		console.log("_____________________________________________");
		var groups = trimGroups(refreshgroups); // Send the groups and times to trim! >;3
		for ( reloadTime in groups ) {
			if(reloadTime != 'created') {
				var frame = $("#frame_"+reloadTime);
				console.log(groups[reloadTime] * 1000);
				setInterval( reloadData( frame ), (groups[reloadTime] * 1000) ); // reloadTime with for ( x in groups )
			}
		}
		console.log("---------------------------------------------");
	}
	
	//setTimeout(refreshSites(),1000);
});