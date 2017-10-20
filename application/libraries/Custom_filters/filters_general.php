<?php
	$this->Name = "General";
	//Create group filter
	$group_args = array(
		"name" => "grupos",
		"id" => "grupos-filter",
		"class" => "select-2",
		"style" => "width: 130px",
		"label" => "Todos los grupos",
		"default" => "",
		"filter_db" => "user_groups.id",
		"odb_table" => "user_groups",
		"odb_text" => "description",
		"odb_value" => "id",
		"odb_filter" => array(
			"filter_type" => array("ramo", 3)
		),
		"process" => array(
			"director" => array(
				"users-report" => array(
					"relationships" => array(
						"user_groups_vs_agents" => "agents.id = user_groups_vs_agents.agent_id",
					),
					"filters" => array(
						"user_groups_vs_agents.user_group_id" => "grupos",
					)
				)
			)
		)
	);
	$this->create_dropdown($group_args);