<?php

	$func=$_GET['func'];
	$seding_user_id=$_SESSION['user_id'];
	$parent_module=$_GET['parent_module'];
	$parent_url=$_GET['parent_url'];
	$parent_id=$_GET['parent_id'];
	if($parent_module=="")
	{
		$parent_module=substr("$parent_url",strrpos($parent_url, "#")+1);
	}
	

	if($func=="GetTotal")
	{
		global $db;
		$query="";
		if(($parent_module=="Home")||($parent_module=="Dashboards"))
		{
			$query="select COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND deleted=0 ";
		}
		else if(($parent_module !="")&&($parent_id==""))
		{
			$query="select COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND deleted=0 ";
		}
		else 
		{
			$query="select COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND parent_id='".$parent_id."' AND deleted=0";		
		}
		$result= $db->query($query);
		$count='';
		while($row = $result->fetch_assoc()) 
		{					
			$count=$row['Count'];
			
		}
		echo json_encode($count);
		//default_view();
		exit();
	}
	else if($func=="GetStatuses")
	{
		global $db;
		$query="";
		if(($parent_module=="Home")||($parent_module=="Dashboards"))
		{
			$query="select packetstatus as 'envelope_status',COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND deleted=0  GROUP BY packetstatus";
		}
		else if(($parent_module !="")&&($parent_id==""))
		{
			$query="select packetstatus as 'envelope_status',COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND deleted=0  GROUP BY packetstatus";
		}
		else 
		{
			$query="select packetstatus as 'envelope_status',COUNT(*) as 'Count' from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND deleted=0 AND parent_id='".$parent_id."' GROUP BY packetstatus";
		}
		$result= $db->query($query);
		$statuses=array();
		while($row = $result->fetch_assoc()) 
		{					
			$status=$row['envelope_status'];
			$count=$row['Count'];
			$statuses[$status]=$count;
		}
		echo json_encode($statuses);
		exit();
	}
	else if($func=="GetDetails")
	{
		global $db;
		$query="";
		if(($parent_module=="Home")||($parent_module=="Dashboards"))
		{
			$query="select id,name,packetstatus from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND deleted=0";			
		}
		else if(($parent_module !="")&&($parent_id==""))
		{
			$query="select id,name,packetstatus from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND deleted=0";
		}
		else 
		{	
			$query="select id,name,packetstatus from dp_doucumentspackets where sendinguserid='".$seding_user_id."' AND parent_type='".$parent_module."' AND parent_id='".$parent_id."' AND deleted=0";
		}
		$result= $db->query($query);		
		$response=array();
		while($row = $result->fetch_assoc()) 
		{					
			$response[]=array( 'id' => $row['id'], 'name'=> $row['name'], 'packetstatus' => $row['packetstatus']);
		}
		echo json_encode($response);
		exit();
	}
	
