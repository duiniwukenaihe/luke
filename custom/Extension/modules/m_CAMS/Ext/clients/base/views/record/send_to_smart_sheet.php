<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$viewdefs['m_CAMS']['base']['view']['record']['buttons'][2]['buttons'][] = array(
   'type' => 'send_to_smart_sheet',
   'name' => 'send_to_smart_sheet',
   'label' => 'LBL_TERMINATE_BUTTON',
   'acl_action' => 'edit',
   'view' => 'edit',
   'event' => 'button:send_to_smart_sheet:click'
);