/**
	* Copyright (c) 2015 Rolustech
	* All rights reserved.
	Class to parse the Sugar CRM URL and create Object.
**/

function parseURL(urlstring)
{	
	if(urlstring.indexOf("/#bwc/") > -1)
	{// for BWC modules
		this.isbwc=true;		
		this.rootURL=urlstring.substring(0,urlstring.indexOf("/#bwc/"));		
		paramstring=urlstring.slice(urlstring.indexOf("?")+1);
		params=paramstring.split('&');
		var modulename="";
		var recid="";
		$.each(params, function(index, value) { 
			temp=value.split("=");			
			if(temp[0]=='record')
			{
				recid=temp[1];
			}
			if(temp[0] == 'module')
			{				
				modulename=temp[1];			
			}
		});		
		this.ModuleName=modulename;
		this.RecordId=recid;
		this.apiRootURL = this.rootURL + '/rest/v10';
		this.currentRecordApiURL = this.apiRootURL + '/' + this.ModuleName + '/' + this.RecordId;
		if(this.RecordId == '')
		{
			this.isListview=true;
		}
		if(this.ModuleName=='Home')
		{
			this.isAtHome=true;
		}
	}
	else 
	{		
		this.isbwc=false;				
		this.rootURL=urlstring.substring(0,urlstring.indexOf("#"));				
		this.rootURL=this.rootURL.replace('index.php','');
		paramstring=urlstring.slice(urlstring.indexOf("#")+1);		
		if(paramstring.indexOf("/") > -1)
		{
			this.ModuleName=paramstring.slice(0,paramstring.indexOf("/"));		
			this.RecordId=paramstring.slice(paramstring.indexOf("/")+1);
		}
		else 
		{
			this.ModuleName=paramstring;		
			this.RecordId="";
		}
		this.apiRootURL = this.rootURL + 'rest/v10';
		this.currentRecordApiURL = this.apiRootURL + '/' + this.ModuleName + '/' + this.RecordId;;
		if(this.RecordId == '')
		{
			this.isListview=true;
		}
		if(this.ModuleName=='Home')
		{
			this.isAtHome=true;
		}
	}
}