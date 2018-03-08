<?php

class unlink_account_before_save
{
    //Before Save if we remove opportunity from the cam module then It will unlink the acount 
    function unlink_account_before_save($bean, $event, $arguments)
    {
        if(empty($bean->m_cams_opportunities_1_name) && empty($bean->m_cams_opportunities_1opportunities_idb))
        {
            $bean->account_id = "";            
        }
        
    }
}
