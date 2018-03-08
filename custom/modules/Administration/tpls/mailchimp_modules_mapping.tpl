{literal}
    <style type="text/css">
      td h3{
        background: #eee;
        padding: 5px 0;
        margin: 10px 0;
      }
      span#add_more,span#remove_row {
        cursor: pointer;
      }
    </style>
{/literal}

<div id="moduleTitle">
    <h2>{$MOD.LBL_MAILCHIMP_MODULES_MAPPING}</h2>
    <form id="mailChimpModulesMapping">
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
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th><h3>{$MOD.LBL_ADMIN_USER_MAPPING}</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <label>{$MOD.LBL_SELECT_ADMIN_USER}</label>
                                        <select name="user_id" id="user_id"></select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
        
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th><h3>{$MOD.LBL_LEADS_MAPPING}</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <label>{$MOD.LBL_SELECT_LEADS_MAPPING}</label>
                                        <select name="Leads" id="Leads"></select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th colspan="3"><h3>{$MOD.LBL_CONTACTS_MAPPING}</h3></th>
                                </tr>
                            </thead>
                            <tbody id="Contacts"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right;font-size:30px;font-weight:bold;padding-right:5px;"><span id="add_more">+</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="padding-top: 2px;">
                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" />
                            &nbsp;
                            <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

{literal}
    <script type="text/javascript" src="custom/modules/Administration/js/mailchimp_modules_mapping.js"></script>
{/literal}
