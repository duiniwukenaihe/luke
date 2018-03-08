<?php

return array (
  'id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
  'name' => 'Opportunity quick deal',
  'description' => '',
  'team_id' => '1',
  'team_set_id' => '1',
  'acl_team_set_id' => '',
  'acl_team_names' => '',
  'available_modules' => '^Opportunities^',
  'dri_subworkflow_templates' => 
  array (
    '5deef3ac-fcc9-11e6-9550-5254009e5526' => 
    array (
      'id' => '5deef3ac-fcc9-11e6-9550-5254009e5526',
      'name' => 'Opportunity Start',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '01. Opportunity Start',
      'sort_order' => '1',
      'points' => '40',
      'related_activities' => '4',
      'dri_workflow_task_templates' => 
      array (
        '8de75a7c-fcc9-11e6-85ac-5254009e5526' => 
        array (
          'id' => '8de75a7c-fcc9-11e6-85ac-5254009e5526',
          'name' => 'Customer requirements',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => '',
          'priority' => 'High',
          'type' => 'customer_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '0',
          'sort_order' => '1',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '5deef3ac-fcc9-11e6-9550-5254009e5526',
          'dri_subworkflow_template_name' => 'Opportunity Start',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        'a96b911e-fcc9-11e6-97df-5254009e5526' => 
        array (
          'id' => 'a96b911e-fcc9-11e6-97df-5254009e5526',
          'name' => 'Book meeting for presentation of solution',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '2',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '5deef3ac-fcc9-11e6-9550-5254009e5526',
          'dri_subworkflow_template_name' => 'Opportunity Start',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
          'blocked_by' => json_encode(array ('8de75a7c-fcc9-11e6-85ac-5254009e5526')),
        ),
        'c0e7e8e2-fcc9-11e6-9e14-5254009e5526' => 
        array (
          'id' => 'c0e7e8e2-fcc9-11e6-9e14-5254009e5526',
          'name' => 'Identify Power',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '5deef3ac-fcc9-11e6-9550-5254009e5526',
          'dri_subworkflow_template_name' => 'Opportunity Start',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        'e50e9860-fcc9-11e6-9d7c-5254009e5526' => 
        array (
          'id' => 'e50e9860-fcc9-11e6-9d7c-5254009e5526',
          'name' => 'Price from 3rd parties',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'agency_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '4',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '5deef3ac-fcc9-11e6-9550-5254009e5526',
          'dri_subworkflow_template_name' => 'Opportunity Start',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
      ),
      'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
      'dri_workflow_template_name' => 'Opportunity quick deal',
    ),
    '6edde9ca-fcc9-11e6-8130-5254009e5526' => 
    array (
      'id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
      'name' => 'Present Solution',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '02. Present Solution',
      'sort_order' => '2',
      'points' => '50',
      'related_activities' => '5',
      'dri_workflow_task_templates' => 
      array (
        '1459d08a-fcca-11e6-98d3-5254009e5526' => 
        array (
          'id' => '1459d08a-fcca-11e6-98d3-5254009e5526',
          'name' => 'Send propsale / quotation',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '2',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
          'dri_subworkflow_template_name' => 'Present Solution',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
          'blocked_by' => json_encode(array ('f535684a-fcc9-11e6-803f-5254009e5526')),
        ),
        '2f32e9a0-fcca-11e6-a9cf-5254009e5526' => 
        array (
          'id' => '2f32e9a0-fcca-11e6-a9cf-5254009e5526',
          'name' => 'Confirm Short Shortlist',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'milestone',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
          'dri_subworkflow_template_name' => 'Present Solution',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        '4bf18e70-fcca-11e6-bff9-5254009e5526' => 
        array (
          'id' => '4bf18e70-fcca-11e6-bff9-5254009e5526',
          'name' => 'New requirements?',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'customer_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '4',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
          'dri_subworkflow_template_name' => 'Present Solution',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        '5cd8d43c-fcca-11e6-97f9-5254009e5526' => 
        array (
          'id' => '5cd8d43c-fcca-11e6-97f9-5254009e5526',
          'name' => 'Send final Quotation',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '5',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
          'dri_subworkflow_template_name' => 'Present Solution',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
          'blocked_by' => json_encode(array ('4bf18e70-fcca-11e6-bff9-5254009e5526')),
        ),
        'f535684a-fcc9-11e6-803f-5254009e5526' => 
        array (
          'id' => 'f535684a-fcc9-11e6-803f-5254009e5526',
          'name' => 'Define budget',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_stage_started',
          'priority' => 'Medium',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '1',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '6edde9ca-fcc9-11e6-8130-5254009e5526',
          'dri_subworkflow_template_name' => 'Present Solution',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
      ),
      'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
      'dri_workflow_template_name' => 'Opportunity quick deal',
    ),
    '755a0e64-fcc9-11e6-81ea-5254009e5526' => 
    array (
      'id' => '755a0e64-fcc9-11e6-81ea-5254009e5526',
      'name' => 'Close Deal',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '03. Close Deal',
      'sort_order' => '3',
      'points' => '30',
      'related_activities' => '3',
      'dri_workflow_task_templates' => 
      array (
        '6f15aa12-fcca-11e6-876c-5254009e5526' => 
        array (
          'id' => '6f15aa12-fcca-11e6-876c-5254009e5526',
          'name' => 'Book final Meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_stage_started',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Meetings',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '1',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '755a0e64-fcc9-11e6-81ea-5254009e5526',
          'dri_subworkflow_template_name' => 'Close Deal',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        '8be3c746-fcca-11e6-b719-5254009e5526' => 
        array (
          'id' => '8be3c746-fcca-11e6-b719-5254009e5526',
          'name' => 'Contract signed / opportunity Won',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'milestone',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '2',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '755a0e64-fcc9-11e6-81ea-5254009e5526',
          'dri_subworkflow_template_name' => 'Close Deal',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
        '9a1ae984-fcca-11e6-b223-5254009e5526' => 
        array (
          'id' => '9a1ae984-fcca-11e6-b223-5254009e5526',
          'name' => 'Hand over to delivery',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'High',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '755a0e64-fcc9-11e6-81ea-5254009e5526',
          'dri_subworkflow_template_name' => 'Close Deal',
          'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
          'dri_workflow_template_name' => 'Opportunity quick deal',
        ),
      ),
      'dri_workflow_template_id' => '467fb2a6-fcc9-11e6-b7a6-5254009e5526',
      'dri_workflow_template_name' => 'Opportunity quick deal',
    ),
  ),
  'points' => '120',
  'related_activities' => '12',
  'active' => '1',
  'assignee_rule' => 'stage_start',
  'target_assignee' => 'parent_assignee',
);