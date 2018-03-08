({
    plugins: ['Dashlet'],
	events: {
        'click [name="show_graph"]': 'showGraph',
		'click [name="show_details"]': 'showDetails',
    },
	initDashlet: function () {				
	},	
	loadData: function (options) {
		$("#details").hide();
		$("#show_graph").hide();
		
		this.showGraph(); // calling function to show graph
	},
	showGraph :function() {
		parenturl=window.location.href;				
		authtoken=SUGAR.App.api.getOAuthToken();	
		var loadGraph=this.loadGraph; // copying function in global variables.
		
		var UrlParams1="";
		$.getScript('modules/RT_DocuSign/js/parseurl.js', function() {			
			urlobj=new parseURL(parenturl);// parsing url and creating object
			var UrlParams = {// url params for function to get Total count of Envelopes
				func: "GetTotal",		
				parent_module: urlobj.ModuleName,
				parent_id: urlobj.RecordId,
				parent_url: parenturl,
			};
			
			var UrlParams1 = {// url params for function to get count of Each Status of Envelopes
				func: "GetStatuses",		
				parent_module: urlobj.ModuleName,
				parent_id: urlobj.RecordId,
				parent_url: parenturl,
			};			
			loadGraph(UrlParams,UrlParams1,authtoken);// calling function to load graph
			$("#show_details").show();
			$("#details").hide();
			$("#show_graph").hide();
			$("#canvas").show();
		});	
    },
	showDetails : function() {
	
		//GetDetails
		parenturl=window.location.href;				
		authtoken=SUGAR.App.api.getOAuthToken();	
		var UrlParams1="";
		$.getScript('modules/RT_DocuSign/js/parseurl.js', function() {			
			urlobj=new parseURL(parenturl);// parsing url and creating object
			var UrlParams = {// url params for function to get Total count of Envelopes
				func: "GetDetails",		
				parent_module: urlobj.ModuleName,
				parent_id: urlobj.RecordId,
				parent_url: parenturl,
			};
			
			app.bwc.login(null, _.bind(function() {	
			
				 $("#details").find("tr:gt(0)").remove();
				// to Get Details of each envelope
				$.ajax({
					url: "index.php?module=RT_DocuSign&action=getenvelopecount&"+$.param(UrlParams),
					headers: {
						'Content-Type': 'application/json',
						'OAuth-Token': authtoken,
					},
					async: false,
					success: function(data) {
						obj1=JSON.parse(data);						
						$.each(obj1,function(index,value){							
							urllink=app.router.buildRoute('DP_DoucumentsPackets',value.id);							
							row='<tr><td><a class="ellipsis_inline" data-placement="bottom" href="#'+urllink+'" > '+value.name+'</a></td><td><b>'+value.packetstatus+'</b></td></tr>';
							$("#details").append(row);
						});
					}
				});
			}, this));	
			
		});
		$("#show_graph").show();
		$("#show_details").hide();
		$("#canvas").hide();
		$("#details").show();
    },
	loadGraph : function(UrlParams,UrlParams1,authtoken) {
	
		var totalCount;
		 $.getScript('modules/RT_DocuSign/js/Chart.min.js', function() {
			
			// first we login into sugar to access it.
			app.bwc.login(null, _.bind(function() {	
				// to get total count of envelopes
				$.ajax({
					url: "index.php?module=RT_DocuSign&action=getenvelopecount&"+$.param(UrlParams),
					headers: {
						'Content-Type': 'application/json',
						'OAuth-Token': authtoken,
					},
					async: false,
					success: function(data) {
						data=JSON.parse(data);
						totalCount=data;
					}
				});
			
			
				// to Get Count of Each Status of Envelope
				$.ajax({
					url: "index.php?module=RT_DocuSign&action=getenvelopecount&"+$.param(UrlParams1),
					headers: {
						'Content-Type': 'application/json',
						'OAuth-Token': authtoken,
					},
					async: false,
					success: function(data) {
						obj=JSON.parse(data);
						arr = new Array();			
						arr[0]=(obj.Created ? parseInt(obj.Created):0);
						arr[1]=(obj.Send ? parseInt(obj.Send):0);
						arr[2]=(obj.Delivered ? parseInt(obj.Delivered):0);
						arr[3]=(obj.Completed ? parseInt(obj.Completed):0);
						arr[4]= parseInt( (obj.Voided ? parseInt(obj.Voided):0)) + parseInt ((obj.Cancel ? parseInt(obj.Cancel):0));
						arr[5]=(totalCount? parseInt(totalCount):0);
						
						var BarChart = {
						labels: ["Created","Send", "Delivered", "Completed", "Voided","Total"],
						datasets: [{
							fillColor: "rgba(23,109,229,1)",
							strokeColor: "rgba(0,0,0,1)",
							data: arr
						}]
						}
						var myBarChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(BarChart, {scaleFontSize : 13,scaleFontColor : "#ffa45e"});
						
					}
				});
			}, this));	
		});
    },
})