{sugar_getscript file="custom/modules/Administration/js/smartsheet.js"}
<div class='add_table' style='margin-bottom:5px'>
    <!-- Consumer Keys and Secret Area Finished -->                

    <br/><br/>

    <div id="CONFIGURATION_SETTINGS">

        <!--    Access Tokens Area -->        

        <br/><br/>



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
            <h2>SmartSheet Keys</h2>
            <form id='form_validate_smartsheet_key' name="SmartSheetConfiguration"  method="post">
                {sugar_csrf_form_token}
                <table width="100%">
                    <tbody>
                        <!-- <tr>
                           <td colspan="2">
                               <div style="padding-top: 2px;">
                                   <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
                                   &nbsp;
                                   <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
                               </div>
                           </td>
                       </tr>  -->

                        <tr>
                            <td colspan="2">
                                <div class="alert alert-success" role="alert" id="SmartSheet_connection_success" style="display: {$smartsheet_connection_success}"> Connected with SmartSheet.</div>
                                <div class="alert alert-danger" role="alert" id="SmartSheet_connection_error" style="display: {$smartsheet_connection_error}"> Not Connected with SmartSheet.</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <strong for="ss_api_key">API Key</strong>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="API Key" type="text" name="ss_api_key" value="{$smartsheet_api_key}" id="ss_api_key" required />
                                    <input class="button primary" type="button" id="test_connection" value="Test Connection" class="button primary"/>
                                </div>
                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <strong for="ss_api_key">SmartSheet ID</strong>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" placeholder="SmartSheet ID" type="text" name="ss_id" value="{$smartsheet_id}" id="ss_id" required />
                                </div>

                                <br>

                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <strong for="ss_api_key">WebHook ID</strong>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="WebHook ID" type="text" name="ss_webhook_id" value="{$smartsheet_webhook_id}" id="ss_webhook_id" required />
                                </div>

                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <strong for="ss_email_id">Primary Email</strong>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Primary Email" type="text" name="ss_email_id" value="{$smartsheet_email_id}" id="ss_email_id" required />
                                </div>

                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div style="padding-top: 2px;">
                                    <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
                                    &nbsp;
                                    <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href = 'index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
                                </div>
                            </td>
                        </tr>
                </table>         

            </form>
        </div>

        {literal}
            <script type="text/javascript">

            </script>
        {/literal}
        <!--    Module Level settings Area -->  
        <br/><br/>
    </div>

</div>