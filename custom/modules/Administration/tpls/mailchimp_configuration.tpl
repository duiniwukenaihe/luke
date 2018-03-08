{literal}
    <style type="text/css">
    .alert {
    	padding: 0.75rem 1.25rem;
    	margin: 0.5rem 0;
    	border: 1px solid transparent;
    	border-radius: 0.25rem;
    }
    .alert-success {
    	background-color: #dff0d8;
    	border-color: #d0e9c6;
    	color: #3c763d;
    }
    .alert-danger {
    	background-color: #f2dede;
    	border-color: #ebcccc;
    	color: #a94442;
    }
    </style>
{/literal}

<div id="moduleTitle">
    <h2>{$MOD.LBL_MAILCHIMP_CONFIGURATION}</h2>
	<form id="mailChimpConfiguration">
    	<table width="100%">
    		<tbody>
                <tr>
                    <td colspan="2">
                    	<div style="padding-top: 2px;">
    						<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
    						&nbsp;
    						<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
    					</div>
                    </td>
                </tr>

                <tr>
                	<td colspan="2">
    					<div class="alert alert-success" style="display: none;" id="mailchimp_connection_success"> {$MOD.LBL_CONNECTED_WITH_MAILCHIMP}</div>
    					<div class="alert alert-danger" style="display: none;" id="mailchimp_connection_error"> {$MOD.LBL_NOT_CONNECTED_WITH_MAILCHIMP}</div>
                	</td>
                </tr>

                <tr>
                	<td colspan="2">
    					<div class="form-group">
    						<label for="mc_api_key">{$MOD.LBL_API_KEY} </label>
    						<input class="form-control" placeholder="{$MOD.LBL_API_KEY}" type="text" name="mc_api_key" id="mc_api_key" required style="width: 280px; margin: 0 10px 0 0" />
    						<input class="button primary" type="button" id="test_connection" value="{$MOD.LBL_TEST_CONNECTION}" class="button primary"/>
    					</div>
                	</td>
                </tr>

                <tr>
                    <td colspan="2">
                    	<div style="padding-top: 2px;">
    						<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
    						&nbsp;
    						<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
    					</div>
                    </td>
                </tr>
    	</table>
	</form>
</div>

{literal}
    <script type="text/javascript" src="custom/modules/Administration/js/mailchimp_configuration.js"></script>
{/literal}
