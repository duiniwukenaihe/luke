<?php

class unlink_opportunity
{
    //It will unlink the acount if opportunity related to cam in unlink
    function unlink_account($bean, $event, $arguments)
    {
        if(!empty($arguments['related_module']) && $arguments['related_module'] == 'Opportunities' 
            && !empty($arguments['relationship']) && $arguments['relationship'] == 'm_cams_opportunities_1' )
        {
             if($bean->load_relationship('accounts'))
             {
                 $bean->accounts->delete($bean->account_id);
             }
        }
    }
}
