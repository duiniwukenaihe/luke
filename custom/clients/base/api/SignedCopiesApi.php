<?php

    if (!defined('sugarEntry') || !sugarEntry)
        die('Not A Valid Entry Point');

    require_once('data/BeanFactory.php');
    require_once('clients/base/api/ModuleApi.php');
    require_once('include/SugarQuery/SugarQuery.php');

    class SignedCopiesApi extends RelateApi {

        public function registerApiRest()
        {
            return array(
                'listRelatedRecords' => array(
                    'reqType' => 'GET',
                    'path' => array('<module>', '?', 'link', 'signed_copies'),
                    'pathVars' => array('module', 'record', 'link', 'link_name'),
                    'jsonParams' => array('filter'),
                    'method' => 'signedCopies',
                    'shortHelp' => 'Lists related records.',
                    'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
                ),
                'listRelatedRecordsCount' => array(
                    'reqType' => 'GET',
                    'path' => array('<module>', '?', 'link', 'signed_copies', 'count'),
                    'pathVars' => array('module', 'record', 'link', 'link_name', ''),
                    'jsonParams' => array('filter'),
                    'method' => 'signedCopiesCount',
                    'shortHelp' => 'Lists related records.',
                    'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
                ),
            );
        }

        public function signedCopies(ServiceBase $api, array $args)
        {
            $GLOBALS['log']->fatal('signedCopies:    38 /var/www/html/luke_prod/custom/clients/base/api/SignedCopiesApi.php');
            $offset = $args['offset'];
            if (!isset($args['offset'])) {
                $offset = 0;
            }
            $limit = 5;
            $records = $this->getRecords($args['module'], $args['record'], $offset, $limit, $args['order_by'], false);

            $result['records'] = $records;
            if (count($records) < $limit) {
                $result['next_offset'] = -1;
            } else {
                $result['next_offset'] = $offset + $limit;
            }
            return $result;
        }

        public function signedCopiesCount(ServiceBase $api, array $args)
        {
            $GLOBALS['log']->fatal('signedCopiesCount:    57 /var/www/html/luke_prod/custom/clients/base/api/SignedCopiesApi.php');
            $count = $this->getRecords($args['module'], $args['record'], 0, 5, '', true);
            return array('record_count' => $count - 1);
        }

        public function getRecords($module, $id, $offset = 0, $limit = 5, $order_by = 'date_entered:desc', $count = false)
        {
            $doc_packets_rel = array(
                'Accounts' => 'dp_doucumentspackets_accounts',
                'Opportunities' => 'dp_doucumentspackets_opportunities_1',
                'Leads' => 'dp_doucumentspackets_leads_1',
                'Cases' => 'dp_doucumentspackets_cases',
                'm_CAMS' => 'dp_doucumentspackets_m_cams',
            );

            $records = array();
            $sign_count = 0;
            $revisions_ids = array();
            $parentModule = BeanFactory::getBean($module, $id);
            $packet_relationship = $doc_packets_rel[$module];
            if ($parentModule->load_relationship($packet_relationship)) {
                $packetParams = array(
                    'where' => array(
                        'lhs_field' => 'packetstatus',
                        'operator' => '=',
                        'rhs_value' => 'Completed', //Completed
                    ),
                );
                $packets = $parentModule->$packet_relationship->getBeans($packetParams);
                foreach ($packets as $packet) {
                    if ($packet->load_relationship('dp_doucumentspackets_documents')) {
                        $packet_docs = $packet->dp_doucumentspackets_documents->getBeans();
                        foreach ($packet_docs as $packet_doc) {
                            if ($packet_doc->load_relationship('revisions')) {
                                $revisionsParams = array(
                                    'where' => 'status = "completed"',
                                );
                                $revisions = $packet_doc->revisions->getBeans($revisionsParams);
                                foreach ($revisions as $revision) {
                                    if ($count) {
                                        $sign_count++;
                                    } else {
                                        if (!in_array($revision->id, $revisions_ids)) {
                                            $revisions_ids[] = $revision->id;
                                            $record = array();
                                            $record['id'] = $revision->id;
                                            $record['name'] = $revision->filename;
                                            $record['change_log'] = $revision->change_log;
                                            $record['date_entered'] = $revision->date_entered;
                                            $record['date_modified'] = $revision->date_entered;
                                            $record['revision'] = $revision->revision;
                                            $record['created_by_id'] = $revision->created_by;
                                            $record['created_by_name'] = $revision->created_by_name;
                                            $record['_module'] = 'DocumentRevisions';
                                            $records[] = $record;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $GLOBALS['log']->fatal("Relationship of " . $args['module'] . " with documents was not found");
            }

            if ($count) {
                return $sign_count;
            } else {
                $order = explode(":", $order_by);
                $arr = array();
                foreach ($records as $key => $row) {
                    $arr[$key] = $row[$order[0]];
                }
                $direction = SORT_ASC;
                if ($order[1] == 'asc')
                    $direction = SORT_DESC;

                array_multisort($arr, $direction, $records);
                $result = array_slice($records, $offset, $limit);
                return $result;
            }
        }

    }
    