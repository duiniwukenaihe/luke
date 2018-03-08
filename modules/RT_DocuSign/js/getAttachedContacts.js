/**
	* Copyright (c) 2015 Rolustech
	* All rights reserved.
	Class to parse the Sugar CRM URL and create Object.
**/
function AttachedContacts(sugarUrl,authenticationToken)
{	
	cntcts_url=getContactsURL(sugarUrl,authenticationToken);	
	this.contacts=fetchContacts(cntcts_url,authenticationToken);	
}
function fetchContacts(cntcts_url,authenticationToken)
{
	var contact = [];	
	$.ajax({
		url: cntcts_url,
		headers: {
			'Content-Type': 'application/json',
			'OAuth-Token': authenticationToken
		},	
		async:false,
		success: function(ajaxresult) {			 
			if ((ajaxresult.email1) && (ajaxresult.name)){
				contact = [{
					name: ajaxresult.name,
					email1: ajaxresult.email1
				}];
			} else {
				contact = ajaxresult.records;
			}			
		}
	});
	return contact;
}
function getContactsURL(sugarUrl,authenticationToken)
{
	var SugarcontactsUrl;
	if (sugarUrl.ModuleName === 'Quotes') {
		var accountID="";
		$.ajax({
			type: 'GET',
			url: sugarUrl.currentRecordURL,
			headers: {
				'Content-Type': 'application/json',
				'OAuth-Token': authenticationToken
			},			
			success: function(ajaxresult) {
				accountID = ajaxresult.account_id;
				SugarcontactsUrl=sugarUrl.apiRootURL + '/Accounts/' + accountID + '/link/contacts';
			}
		});
	}
	else if (sugarUrl.ModuleName === 'Leads' || sugarUrl.ModuleName === 'Contacts') { 
		SugarcontactsUrl = sugarUrl.currentRecordApiURL;
	} 
	else { 
		SugarcontactsUrl = sugarUrl.currentRecordApiURL + '/link/contacts';
	}
	return SugarcontactsUrl;
}