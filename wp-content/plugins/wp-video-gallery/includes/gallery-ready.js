$( document ).ready(function() {
		$( "#gallery-list" ).sortable({ connectWith: ".setupload", cursor: "move", axis: "y", opacity: 0.75, handle: ".setup-wrapper h3"});
		
		$( "#gallery-list" ).accordion({ header: ".setup-wrapper h3" });
});