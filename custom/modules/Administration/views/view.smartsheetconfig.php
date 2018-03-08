<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'custom/include/Helpers/SmartSheets/SmartSheetApiHelper.php';

class AdministrationViewSmartSheetConfig extends SugarView {

    public function __construct() {
        $this->smart_sheet_helper = new SmartSheetApiHelper();
        parent::__construct();
    }
    
    public function display() {
        //$a = $this->getFieldOptions('test', 'floor_plan_list', 1);
        //var_dump($a);
        //die;
        echo $this->ss->fetch('custom/modules/Administration/templates/smart_sheet_config.tpl');
        parent::display();
    }

    public function preDisplay() {

        $total_sheets = $this->getSheetOptions();
        $this->ss->assign('sheet_options', $total_sheets);

        $this->ss->assign('module_options', array(
            '' => '-none-',
            'm_CAMs' => 'CAM',
                )
        );

        $this->ss->assign('module_options_selected', 'm_CAMs');
        $this->ss->assign('sheets_option_selected', '');
        //pass generic sheet id
        //$this->prepareRowData('2622275372509060', 'm_CAMS');

        parent::preDisplay();
    }

    /*
     * $sheet_id 
     * $module
     * 
     * This function prepares a row for action smartSheetConfig
     */

    public function prepareRowData($sheet_id, $module, $return_val) {

        $GLOBALS['log']->fatal('row data','prepare data function line');
        global $app_list_strings;

        if (!empty($sheet_id) && !empty($module)) {


            $admin = new Administration();
            
            $GLOBALS['log']->fatal('Administration obj');
            
            $admin_settings = $admin->retrieveSettings('smart_sheet');
            $saved_settings = json_decode($admin_settings->settings['smart_sheet_smart_sheet_' . $sheet_id]);
            $sheet_columns = $this->smart_sheet_helper->getAllColumns($sheet_id);
            $sheet_columns = $this->getSheetColumnAsOptions($sheet_columns);

            $GLOBALS['log']->fatal('before getSheetColumnAsOptions',$sheet_columns);
            
            $row_data = "";
            $row_count = 0;
            foreach ($sheet_columns as $key => $value) {
                
                $GLOBALS['log']->fatal('value is',$value);
                
                if ($value == '-none-')
                    continue;
                $row_data.= "<tr class='oddListRowS1'>";
                $old_value = "";
                if (isset($saved_settings->$key)) {
                    $old_value = $saved_settings->$key->name;
                    $old_value_direction = $saved_settings->$key->direction;
                    $old_value_option = $saved_settings->$key->option;
                }
                $fields = $this->getModuleFields($module, 'EditView', $old_value);
                $direction_html = get_select_options_with_id($app_list_strings['sync_direction_options'], $old_value_direction);
                $extra_options = $this->getExtraOptionHtml($module = 'm_CAMS', $old_value, $old_value_option, $row_count);


                /* $this->ss->assign("key", $key);
                  $this->ss->assign("value", $value);
                  $this->ss->assign("fields", $fields);
                  $this->ss->assign("row_count", $row_count);
                  $this->ss->assign("smartsheet_direction_options", array(
                  '-none-' => '-none-',
                  'sugar_to_smartsheet' => 'Sugar to smartsheet',
                  'smartsheet_to_sugar' => 'Smartsheet to sugar',
                  )); */
                //$row_data.= $this->ss->fetch('custom/modules/Administration/templates/smartsheet_row.tpl');
                $row_data .= "
                    <span>
                    

                        <td>
                            <select name='sugar_field_direction_$row_count'>
                            {$direction_html}
                            </select>
                        </td>
                        
                        <td>
                            <p>$value</p>
                            <input value ='" . $key . "'  type='hidden' name='smart_sheet_field_" . $row_count . "' />
                        </td>
                        <td>
                            Map With
                        </td>
                        <td>
                            <select onclick='handleModuleFieldOnchange(this.id)' id='sugar_field_" . $row_count . "' name='sugar_field_" . $row_count . "'>
                            {$fields}
                            </select>
                        </td>
                        
                        {$extra_options}
                        
                    </span>

                    ";

                $row_data .="<input value ='" . $row_count . "'  type='hidden' name='row_count' />
                </tr>";
                $row_count++;
            }
            
            $GLOBALS['log']->fatal('after for');
        }

        if ($return_val == true) {
            return $row_data;
        }
        
        $GLOBALS['log']->fatal('before this ss');

        $this->ss->assign('sheet_fields_row_data', $row_data);
    }

    /*
     * retreive list of module fields as dropdown
     */

    function getModuleFields($module, $view = 'EditView', $value = '', $valid = array()) {
        global $app_strings, $beanList;

        $fields = array('' => $app_strings['LBL_NONE']);
        $unset = array();

        if ($module != '') {
            if (isset($beanList[$module]) && $beanList[$module]) {
                $mod = new $beanList[$module]();
                foreach ($mod->field_defs as $name => $arr) {
                    if ($arr['type'] != 'link' && ((!isset($arr['source']) || $arr['source'] != 'non-db') || ($arr['type'] == 'relate' && isset($arr['id_name']))) && (empty($valid) || in_array($arr['type'], $valid)) && $name != 'currency_name' && $name != 'currency_symbol') {
                        if (isset($arr['vname']) && $arr['vname'] != '') {
                            $fields[$name] = rtrim(translate($arr['vname'], $mod->module_dir), ':');
                        } else {
                            $fields[$name] = $name;
                        }
                        if ($arr['type'] == 'relate' && isset($arr['id_name']) && $arr['id_name'] != '') {
                            $unset[] = $arr['id_name'];
                        }
                    }
                } //End loop.

                foreach ($unset as $name) {
                    if (isset($fields[$name]))
                        unset($fields[$name]);
                }
            }
        }
        if ($view == 'JSON') {
            return json_encode($fields);
        }
        if ($view == 'EditView') {
            return get_select_options_with_id($fields, $value);
        } else {
            return $fields[$value];
        }
    }

    /*
     * returns total smartsheets with name
     */

    private function getSheetOptions() {
        $options = array('' => '-none-');
        $res = $this->smart_sheet_helper->getAllSheets();
        foreach ($res->data as $data)
            $options[$data->id] = $data->name;

        return $options;
    }

    /*
     * param $sheet_columns
     * returns key value pair of smartsheet columns
     */

    private function getSheetColumnAsOptions($sheet_columns) {

        $options = array('' => '-none-');
        if (!empty($sheet_columns)) {

            foreach ($sheet_columns as $data)
                $options[$data->id] = $data->title;
        }
        return $options;
    }

    public function getFieldOptions($field_name = "module_options", $app_list_key, $id_name_count = "", $selected) {

        if (!empty($field_name) && !empty($field_name)) {
            global $app_list_strings;
            $options = get_select_options($app_list_strings[$app_list_key], $selected);
            return "<select name='sugar_option_" . $id_name_count . "'>
                            {$options}
                            </select>";
        }
        return "";
    }

    public function getExtraOptionHtml($module, $field, $value, $row_count) {

        $allowed_fields = array(
            'construction_stage'
        );

        $extra_option_html = "<td style='visibility:hidden' id='hidden_options_div_" . $row_count . "'>";

        if (!empty($module) && in_array($field, $allowed_fields)) {
            $extra_option_html = "<td id='hidden_options_div_" . $row_count . "'>";
            $extra_option_html.=$this->smart_sheet_helper->getFieldOptionsFromMoldule($module, $field, $row_count, $value);
        }
        $extra_option_html.="</td>";

        return $extra_option_html;
    }

}
