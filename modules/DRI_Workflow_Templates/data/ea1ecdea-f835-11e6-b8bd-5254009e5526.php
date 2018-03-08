<?php

return array (
  'id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
  'name' => 'Yearly Account Planning A customer',
  'description' => '',
  'team_id' => '1',
  'team_set_id' => '1',
  'acl_team_set_id' => '',
  'acl_team_names' => '',
  'available_modules' => '^Accounts^',
  'dri_subworkflow_templates' => 
  array (
    '01a62f80-f836-11e6-b51e-5254009e5526' => 
    array (
      'id' => '01a62f80-f836-11e6-b51e-5254009e5526',
      'name' => 'Q3',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '03. Q3',
      'sort_order' => '3',
      'points' => '60',
      'related_activities' => '6',
      'dri_workflow_task_templates' => 
      array (
        '1a972264-f837-11e6-8694-5254009e5526' => 
        array (
          'id' => '1a972264-f837-11e6-8694-5254009e5526',
          'name' => 'Check status, support and turnover',
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
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '277e9426-f837-11e6-87e5-5254009e5526' => 
        array (
          'id' => '277e9426-f837-11e6-87e5-5254009e5526',
          'name' => 'Book Q3 meeting',
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
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('1a972264-f837-11e6-8694-5254009e5526')),
        ),
        '3c1bf108-f837-11e6-9ad3-5254009e5526' => 
        array (
          'id' => '3c1bf108-f837-11e6-9ad3-5254009e5526',
          'name' => 'Action plan for Q4',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
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
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '5e1fd1e8-f837-11e6-a565-5254009e5526' => 
        array (
          'id' => '5e1fd1e8-f837-11e6-a565-5254009e5526',
          'name' => 'Start renewal proces of contract',
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
          'sort_order' => '5',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '6e9bd1c0-f837-11e6-8df6-5254009e5526' => 
        array (
          'id' => '6e9bd1c0-f837-11e6-8df6-5254009e5526',
          'name' => 'Completed Q3 review',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_stage_started',
          'priority' => 'Medium',
          'type' => 'milestone',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '30',
          'sort_order' => '6',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'c68eaf18-fcf8-11e6-a0a7-3c15c2bc32c0' => 
        array (
          'id' => 'c68eaf18-fcf8-11e6-a0a7-3c15c2bc32c0',
          'name' => 'Q3 meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Meetings',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '01a62f80-f836-11e6-b51e-5254009e5526',
          'dri_subworkflow_template_name' => 'Q3',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('277e9426-f837-11e6-87e5-5254009e5526')),
        ),
      ),
      'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
      'dri_workflow_template_name' => 'Yearly Account Planning A customer',
    ),
    '080ba30a-f836-11e6-af76-5254009e5526' => 
    array (
      'id' => '080ba30a-f836-11e6-af76-5254009e5526',
      'name' => 'Q4',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '04. Q4',
      'sort_order' => '4',
      'points' => '80',
      'related_activities' => '8',
      'dri_workflow_task_templates' => 
      array (
        '102bacfe-f838-11e6-a213-5254009e5526' => 
        array (
          'id' => '102bacfe-f838-11e6-a213-5254009e5526',
          'name' => 'Contract meeting and final negotation',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '7',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '1a9b6d00-f838-11e6-b7da-5254009e5526' => 
        array (
          'id' => '1a9b6d00-f838-11e6-b7da-5254009e5526',
          'name' => 'Contract signed',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => '',
          'priority' => 'Medium',
          'type' => 'milestone',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '0',
          'sort_order' => '8',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '88c2feb6-f837-11e6-b576-5254009e5526' => 
        array (
          'id' => '88c2feb6-f837-11e6-b576-5254009e5526',
          'name' => 'Check status, support and turnover',
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
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '9bb93e54-f837-11e6-9c0b-5254009e5526' => 
        array (
          'id' => '9bb93e54-f837-11e6-9c0b-5254009e5526',
          'name' => 'Plan for contract review meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => '',
          'priority' => 'Medium',
          'type' => 'internal_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '0',
          'sort_order' => '2',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'a2b29820-fcf8-11e6-8f3e-3c15c2bc32c0' => 
        array (
          'id' => 'a2b29820-fcf8-11e6-8f3e-3c15c2bc32c0',
          'name' => 'Q4 meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Meetings',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '4',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('aedb6c6e-f837-11e6-b602-5254009e5526')),
        ),
        'aedb6c6e-f837-11e6-b602-5254009e5526' => 
        array (
          'id' => 'aedb6c6e-f837-11e6-b602-5254009e5526',
          'name' => 'Book Q4 meeting',
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
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('9bb93e54-f837-11e6-9c0b-5254009e5526')),
        ),
        'c1d1b49a-f837-11e6-9f40-5254009e5526' => 
        array (
          'id' => 'c1d1b49a-f837-11e6-9f40-5254009e5526',
          'name' => 'Any new services / products for the new contract',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Tasks',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '5',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'd7475f82-f837-11e6-9140-5254009e5526' => 
        array (
          'id' => 'd7475f82-f837-11e6-9140-5254009e5526',
          'name' => 'Draft new contract and plan presentation',
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
          'sort_order' => '6',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => '080ba30a-f836-11e6-af76-5254009e5526',
          'dri_subworkflow_template_name' => 'Q4',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
      ),
      'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
      'dri_workflow_template_name' => 'Yearly Account Planning A customer',
    ),
    'f525e55c-f835-11e6-bd49-5254009e5526' => 
    array (
      'id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
      'name' => 'Q1',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '01. Q1',
      'sort_order' => '1',
      'points' => '50',
      'related_activities' => '5',
      'dri_workflow_task_templates' => 
      array (
        '25ad35e0-f836-11e6-bb75-5254009e5526' => 
        array (
          'id' => '25ad35e0-f836-11e6-bb75-5254009e5526',
          'name' => 'Check status, support and turnover',
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
          'dri_subworkflow_template_id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
          'dri_subworkflow_template_name' => 'Q1',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '401aacfa-f836-11e6-979a-5254009e5526' => 
        array (
          'id' => '401aacfa-f836-11e6-979a-5254009e5526',
          'name' => 'Book Q1 meeting',
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
          'sort_order' => '2',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
          'dri_subworkflow_template_name' => 'Q1',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('25ad35e0-f836-11e6-bb75-5254009e5526')),
        ),
        '641b6f72-f836-11e6-9d74-5254009e5526' => 
        array (
          'id' => '641b6f72-f836-11e6-9d74-5254009e5526',
          'name' => 'Agree on action plan for Q2',
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
          'dri_subworkflow_template_id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
          'dri_subworkflow_template_name' => 'Q1',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        '85dc5324-f836-11e6-ad03-5254009e5526' => 
        array (
          'id' => '85dc5324-f836-11e6-ad03-5254009e5526',
          'name' => 'Q1 review completed',
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
          'sort_order' => '5',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
          'dri_subworkflow_template_name' => 'Q1',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'f9eccf2a-fcf8-11e6-a345-3c15c2bc32c0' => 
        array (
          'id' => 'f9eccf2a-fcf8-11e6-a345-3c15c2bc32c0',
          'name' => 'Q1 meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Meetings',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => 'f525e55c-f835-11e6-bd49-5254009e5526',
          'dri_subworkflow_template_name' => 'Q1',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('401aacfa-f836-11e6-979a-5254009e5526')),
        ),
      ),
      'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
      'dri_workflow_template_name' => 'Yearly Account Planning A customer',
    ),
    'fbe7b73a-f835-11e6-9f29-5254009e5526' => 
    array (
      'id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
      'name' => 'Q2',
      'description' => '',
      'team_id' => '1',
      'team_set_id' => '1',
      'acl_team_set_id' => '',
      'acl_team_names' => '',
      'label' => '02. Q2',
      'sort_order' => '2',
      'points' => '50',
      'related_activities' => '5',
      'dri_workflow_task_templates' => 
      array (
        '027f7898-f837-11e6-9f20-5254009e5526' => 
        array (
          'id' => '027f7898-f837-11e6-9f20-5254009e5526',
          'name' => 'Review Q2 completed',
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
          'sort_order' => '5',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
          'dri_subworkflow_template_name' => 'Q2',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'a48f6680-f836-11e6-a884-5254009e5526' => 
        array (
          'id' => 'a48f6680-f836-11e6-a884-5254009e5526',
          'name' => 'Check status, support and turnover',
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
          'dri_subworkflow_template_id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
          'dri_subworkflow_template_name' => 'Q2',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
        'c07149fe-f836-11e6-920f-5254009e5526' => 
        array (
          'id' => 'c07149fe-f836-11e6-920f-5254009e5526',
          'name' => 'Book Q2 meeting',
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
          'dri_subworkflow_template_id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
          'dri_subworkflow_template_name' => 'Q2',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('a48f6680-f836-11e6-a884-5254009e5526')),
        ),
        'd566683c-fcf8-11e6-acc3-3c15c2bc32c0' => 
        array (
          'id' => 'd566683c-fcf8-11e6-acc3-3c15c2bc32c0',
          'name' => 'Q2 meeting',
          'description' => '',
          'team_id' => '1',
          'team_set_id' => '1',
          'acl_team_set_id' => '',
          'acl_team_names' => '',
          'task_due_date_type' => 'days_from_previous_activity_completed',
          'priority' => 'Medium',
          'type' => 'customer_task',
          'activity_type' => 'Meetings',
          'duration_minutes' => '0',
          'direction' => 'Outbound',
          'points' => '10',
          'time_of_day' => '12:00',
          'task_due_days' => '1',
          'sort_order' => '3',
          'duration_hours' => '1',
          'duration' => '',
          'dri_subworkflow_template_id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
          'dri_subworkflow_template_name' => 'Q2',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
          'blocked_by' => json_encode(array ('c07149fe-f836-11e6-920f-5254009e5526')),
        ),
        'e1470934-f836-11e6-9ea0-5254009e5526' => 
        array (
          'id' => 'e1470934-f836-11e6-9ea0-5254009e5526',
          'name' => 'Agree on action plan and forecast next 6 months',
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
          'dri_subworkflow_template_id' => 'fbe7b73a-f835-11e6-9f29-5254009e5526',
          'dri_subworkflow_template_name' => 'Q2',
          'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
          'dri_workflow_template_name' => 'Yearly Account Planning A customer',
        ),
      ),
      'dri_workflow_template_id' => 'ea1ecdea-f835-11e6-b8bd-5254009e5526',
      'dri_workflow_template_name' => 'Yearly Account Planning A customer',
    ),
  ),
  'points' => '240',
  'related_activities' => '24',
  'active' => '1',
  'assignee_rule' => 'stage_start',
  'target_assignee' => 'parent_assignee',
);