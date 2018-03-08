{sugar_getscript file="custom/modules/Administration/js/smartsheet.js"}
<div class='add_table' style='margin-bottom:5px'>

    <!-- Consumer Keys and Secret Area Finished -->                

    <br/><br/>

    <div id="CONFIGURATION_SETTINGS">

        <!--    Access Tokens Area -->        

        <br/><br/>

        <form  id='form_smartsheet_config' name="smartsheet_configurations" method="POST"  method="POST" action="index.php?action=smartSheetSave&module=Administration">
            {sugar_csrf_form_token}
            <input title="Save" id="SaveButton" class="button" onclick="" type="submit" name="Save" value="Save"/>
            <input title="Cancel" id="CancelButton" class="button" onclick="cancel_clicked();" type="button" name="Cancel" value="Cancel"/>

            <br/><br/>
            
            <h1 style="text-align: center; color: #000000">Smartsheet configurations</h1>
            <fieldset id="smartsheet_table">

                <input type="hidden" id="access_token_id" name="access_token_id" value="">                

                        
                <table width="100%" border="0" cellspacing="1" cellpadding="0" id="sheet_main_div" class="yui3-skin-sam edit view panelContainer">
                    <tbody>
                        <tr>
                            
                                 <span>
                        <td valign="top" id="data_source_name" width="12.5%" scope="col">
                            <h3 style="color: #000000">Sync Direction: </h3>
                        </td>
                    </span>  
                    
                    <span>
                        <td valign="top" id="sheet_dropdown_label" width="7%" scope="col">
                            <h3 style="color: #000000">Sheets:</h3> 
                        </td>
                        <td valign="top" width="20%">                    
                            <input type="hidden" name="" id="" size="45"  value="">
                            {html_options selected=$sheets_option_selected id=sheet_dropdown name=sheet_dropdown options=$sheet_options 
                                onChange="saveSheetData();" }
                        </td>
                    </span>                
                    <span>
                        <td valign="top" id="data_source_name" width="12.5%" scope="col">
                            
                            <span><h3 style="color: #000000"> Module: </h3> {html_options id=module_dropdown name=module_dropdown options=$module_options selected=$module_options_selected }
                            <p></p></span>
                        </td>
                    </span>
                    
                    <span>
                        <td valign="top" id="data_source_name" width="12.5%" scope="col">
                             
                        </td>
                    </span>  
               
                            
                    </tr>                   
                    </tbody>

                    <tbody id="sheet_field_mappings"> 
                        {$sheet_fields_row_data}
                    </tbody>
                </table>
            </fieldset>
        </form> 

        <!--    Module Level settings Area -->  

        <br/><br/>
    </div>

</div>