<?php

class RT_PostActivity_Status
{    
    //function to post status in activity stream
    public function PostStatus($sugarUserId, $parentType, $parentId, $message)
    {
        // creating bean of Activities.
        $bean                = BeanFactory::getBean('Activities');
        $bean->activity_type = 'post';
        $bean->parent_type   = $parentType;
        $bean->parent_id     = $parentId;
        $beanid=$bean->save();
        
	
        // We are manually inserting data of status. If we use bean it will by default link status to given account. 
        $sql = "UPDATE activities SET created_by = '$sugarUserId', modified_user_id = '$sugarUserId', data = '$message' WHERE id = '{$bean->id}'";
        $bean->db->query($sql);
        
		
        // posting status in activities users.
        $dateModified = date("Y-m-d H:i:s");
        $sql          = "INSERT INTO activities_users (id, activity_id, parent_type, parent_id, date_modified) VALUES ('" . create_guid() . "', '{$bean->id}', '$parentType', '$parentId', '" . $dateModified . "')";
        $bean->db->query($sql);
        $sql = "INSERT INTO activities_users (id, activity_id, parent_type, parent_id, fields, date_modified) VALUES ('" . create_guid() . "', '{$bean->id}', 'Users', '$sugarUserId', '[]', '" . $dateModified . "')";
        $bean->db->query($sql);	
    }
}
