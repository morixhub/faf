<?php
/**
 * Plugin Name: faf
 * Plugin URI: https://faf.com
 * Description: faf management
 * Version: 1.0.0
 * Author: morix
 * Author URI: https://faf.com
 * Text Domain: faf
 * Domain Path: /faf/
 *
 * @package faf
 */

// Require DB UI package for FAF
require_once('faf-db-ui.php');

// Hook on admin_menu
add_action('admin_menu', 'faf_setup_menu');

function faf_setup_menu() {
    add_menu_page('faf', 'faf Administration', 'administrator', 'faf_admin_page_slug', 'faf_admin_page');
    add_submenu_page('faf_admin_page_slug', 'teams', 'Manage teams', 'administrator', 'faf_admin_teams_page_slug', 'faf_admin_page_teams');
    add_submenu_page('faf_admin_page_slug', 'players', 'Manage players', 'administrator', 'faf_admin_players_page_slug', 'faf_admin_page_players');
    add_submenu_page('faf_admin_page_slug', 'roles', 'Manage player roles', 'administrator', 'faf_admin_player_roles_page_slug', 'faf_admin_page_player_roles');
    add_submenu_page('faf_admin_page_slug', 'leagues', 'Manage leagues', 'administrator', 'faf_admin_leagues_page_slug', 'faf_admin_page_leagues');
    add_submenu_page('faf_admin_page_slug', 'league_rounds', 'Manage league rounds', 'administrator', 'faf_admin_league_rounds_page_slug', 'faf_admin_page_league_rounds');
}

function faf_admin_page() {
    echo "<h1>faf Administration Panel</h1>";
}

function faf_admin_page_teams() {

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_teams',
        array(
            'id' => array(
                faf_db_constants::field_label => 'ID',
                faf_db_constants::field_type => faf_db_constants::field_type_id
            ),
            'name' => array(
                faf_db_constants::field_label => 'Team name',
                faf_db_constants::field_required => true
            )
        )
    );
}

function faf_admin_page_players() {

    global $wpdb;

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_players',
        array(
            'id' => array(
                faf_db_constants::field_label => 'ID',
                faf_db_constants::field_type => faf_db_constants::field_type_id
            ),
            'name' => array(
                faf_db_constants::field_label => 'Player name',
                faf_db_constants::field_required => true
            ),
            'surname' => array(
                faf_db_constants::field_label => 'Player surname',
                faf_db_constants::field_required => true
            ),
            'roles' => array(
                faf_db_constants::field_label => 'Roles',
                faf_db_constants::field_calculate => '(SELECT GROUP_CONCAT(id_role SEPARATOR \', \') FROM ' . $wpdb->prefix . 'faf_players_roles WHERE id_player = ' . faf_db_constants::main_query_name . '.id GROUP BY id_player)'
            ),
            'import' => array(
                faf_db_constants::field_label => 'Import',
                faf_db_constants::field_type => faf_db_constants::field_type_bool
            ),
            'id_current_team' => array(
                faf_db_constants::field_label => 'Current team',
                faf_db_constants::field_source => function() {
                    return(faf_data_source_teams());
                }
            ),
            'begin_validity' => array(
                faf_db_constants::field_label => 'Begin validity',
                faf_db_constants::field_type => faf_db_constants::field_type_date,
                faf_db_constants::field_default => date_create('now'),
                faf_db_constants::field_required => true
            ),
            'end_validity' => array(
                faf_db_constants::field_label => 'End validity',
                faf_db_constants::field_type => faf_db_constants::field_type_date,
                faf_db_constants::field_default => date_create('now')->add(new DateInterval('P1Y')),
                faf_db_constants::field_required => true
            )
        ),
        null,
        function($fields, $post) {

            // Check player validity
            $beginValidity = $fields['begin_validity'];
            $endValidity = $fields['end_validity'];

            if($beginValidity >= $endValidity)
                return('Begin validity MUST preceed end validity');

            // Check that players has at least one role
            $roleset = false;
            foreach(array_keys($post) as $key)
            {
                if(str_starts_with($key, 'ctl_role_') && (bool)$post[$key])
                {
                    $roleset = true;
                    break;   
                }
            }

            if(!$roleset)
                return('At least one role must be assigned to the player');

            return(null);
        },
        function($updateId) {
            
            global $wpdb;

            $roles = array();
            if($updateId != null)
            {
                $query = 'SELECT id_role FROM ' . $wpdb->prefix . 'faf_players_roles WHERE id_player = ' . $updateId;
                $res = $wpdb->get_results($query, 'ARRAY_A');

                foreach($res as $record)
                    array_push($roles, $record['id_role']);
            }

            $query = 'SELECT id FROM ' . $wpdb->prefix . 'faf_roles';
            $res = $wpdb->get_results($query, 'ARRAY_A');

            echo '<table>';
            echo '<tr><td colspan="' . $wpdb->num_rows . '">Roles:</td></tr>';
            echo '<tr>';
            foreach($res as $record)
            {
                $id = $record['id'];
                echo '<td>';
                    echo '<input type="checkbox" name="ctl_role_' . $id . '" id="ctl_role_' . $id . '"' . (in_array($id, $roles) ? 'checked' : '') . '></input>';
                    echo '<label for=ctl_role_"' . $id . '">' . $id . '</label>';
                echo '</td>';
            }
            echo '</tr>';
            echo '</table>';
        },
        function($updateId, $post) {

            global $wpdb;

            // If no ID was provided, then give up
            if($updateId == null)
                return;

            // Get existing roles
            $roles = array();
            if($updateId != null)
            {
                $query = 'SELECT id_role FROM ' . $wpdb->prefix . 'faf_players_roles WHERE id_player = ' . $updateId;
                $res = $wpdb->get_results($query, 'ARRAY_A');

                foreach($res as $record)
                    array_push($roles, $record['id_role']);
            }

            // Collect new roles from post data
            $newRoles = array();
            foreach(array_keys($post) as $key)
            {
                if(str_starts_with($key, 'ctl_role_') && (bool)$post[$key])
                    array_push($newRoles, substr($key, 9));
            }

            // Remove roles not set
            foreach($roles as $role)
            {
                if(!in_array($role, $newRoles))
                {
                    $ret = $wpdb->delete($wpdb->prefix . 'faf_players_roles', array('id_player' => $updateId, 'id_role' => $role));

                    if(false === $ret)
                        echo 'Cannot update player roles [delete]';
                }
            }

            // Set new roles
            foreach($newRoles as $role)
            {
                if(!in_array($role, $roles))
                {
                    $ret = $wpdb->insert($wpdb->prefix . 'faf_players_roles', array('id_player' => $updateId, 'id_role' => $role));

                    if(false === $ret)
                        echo 'Cannot update player roles [insert]';
                }
            }
        }
    );
}

function faf_admin_page_player_roles() {

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_roles',
        array(
            'id' => array(
                faf_db_constants::field_label => 'ID',
                faf_db_constants::field_type => faf_db_constants::field_type_id
            ),
            'label' => array(
                faf_db_constants::field_label => 'Role label',
                faf_db_constants::field_required => true
            )
        )
    );
}

function faf_admin_page_leagues() {

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_leagues',
        array(
            'id' => array(
                faf_db_constants::field_label => 'ID',
                faf_db_constants::field_type => faf_db_constants::field_type_id
            ),
            'name' => array(
                faf_db_constants::field_label => 'League name',
                faf_db_constants::field_required => true
            ),
            'description' => 'League description'
        )
    );
}

function faf_admin_page_league_rounds() {

    // Declare global usages
    global $wpdb;

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_league_rounds',
        array(
            'id' => array(
                faf_db_constants::field_label => 'ID',
                faf_db_constants::field_type => faf_db_constants::field_type_id
            ),
            'id_league' => array(
                faf_db_constants::field_label => 'League',
                faf_db_constants::field_source => function() {
                    return(faf_data_source_leagues());
                },
                faf_db_constants::field_required => true
            ),
            'round_name' => array(
                faf_db_constants::field_label => 'Round name',
                faf_db_constants::field_required => true
            ),
            'enabled_teams_count' => array(
                faf_db_constants::field_label => 'Enabled teams',
                faf_db_constants::field_calculate => '(SELECT COUNT(*) FROM ' . $wpdb->prefix . 'faf_round_enabled_teams WHERE id_round = ' . faf_db_constants::main_query_name . '.id)'
            ),
            'opening' => array(
                faf_db_constants::field_label => 'Opening date',
                faf_db_constants::field_type => faf_db_constants::field_type_date,
                faf_db_constants::field_default => date_create('now'),
                faf_db_constants::field_required => true
            ),
            'closing' => array(
                faf_db_constants::field_label => 'Closing date',
                faf_db_constants::field_type => faf_db_constants::field_type_date,
                faf_db_constants::field_default => date_create('now')->add(new DateInterval('P2W')),
                faf_db_constants::field_required => true
            )
        ),
        null,
        null,
        function($updateId) {
            
            global $wpdb;

            $teams = array();
            if($updateId != null)
            {
                $query = 'SELECT id_team FROM ' . $wpdb->prefix . 'faf_round_enabled_teams WHERE id_round = ' . $updateId;
                $res = $wpdb->get_results($query, 'ARRAY_A');

                foreach($res as $record)
                    array_push($teams, $record['id_team']);
            }

            $query = 'SELECT id, name FROM ' . $wpdb->prefix . 'faf_teams';
            $res = $wpdb->get_results($query, 'ARRAY_A');

            echo '<table>';
            echo '<tr><td colspan="' . $wpdb->num_rows . '">Enabled teams:</td></tr>';
            echo '<tr>';
            foreach($res as $record)
            {
                $id = $record['id'];
                $name = $record['name'];
                echo '<tr><td>';
                    echo '<input type="checkbox" name="ctl_team_' . $id . '" id="ctl_team_' . $id . '"' . (in_array($id, $teams) ? 'checked' : '') . '></input>';
                    echo '<label for=ctl_team_"' . $id . '">' . $name . '</label>';
                echo '</td></tr>';
            }
            echo '</tr>';
            echo '</table>';
        },
        function($updateId, $post) {

            global $wpdb;

            // If no ID was provided, then give up
            if($updateId == null)
                return;

            // Get existing teams
            $teams = array();
            if($updateId != null)
            {
                $query = 'SELECT id_team FROM ' . $wpdb->prefix . 'faf_round_enabled_teams WHERE id_round = ' . $updateId;
                $res = $wpdb->get_results($query, 'ARRAY_A');

                foreach($res as $record)
                    array_push($teams, $record['id_team']);
            }

            // Collect new teams from post data
            $newTeams = array();
            foreach(array_keys($post) as $key)
            {
                if(str_starts_with($key, 'ctl_team_') && (bool)$post[$key])
                    array_push($newTeams, (int)substr($key, 9));
            }

            // Remove teams not set
            foreach($teams as $team)
            {
                if(!in_array($team, $newTeams))
                {
                    $ret = $wpdb->delete($wpdb->prefix . 'faf_round_enabled_teams', array('id_round' => $updateId, 'id_team' => $team));

                    if(false === $ret)
                        echo 'Cannot update enabled teams [delete]';
                }
            }

            // Set new teams
            foreach($newTeams as $team)
            {
                if(!in_array($team, $teams))
                {
                    $ret = $wpdb->insert($wpdb->prefix . 'faf_round_enabled_teams', array('id_round' => $updateId, 'id_team' => $team));

                    if(false === $ret)
                        echo 'Cannot update enabled teams [insert]';
                }
            }
        }
    );
}

function faf_data_source_teams() {

    // Declare global usages
    global $wpdb;
    
    // Prepare query for selecting entities
    $query = 'SELECT id, name FROM ' . $wpdb->prefix . 'faf_teams';
    $res = $wpdb->get_results($query, 'ARRAY_A');

    // Collect
    $r = array();
    foreach(array_values($res) as $record)
        $r[$record['id']] = $record['name'];

    return($r);
}

function faf_data_source_leagues() {

    // Declare global usages
    global $wpdb;
    
    // Prepare query for selecting entities
    $query = 'SELECT id, name FROM ' . $wpdb->prefix . 'faf_leagues';
    $res = $wpdb->get_results($query, 'ARRAY_A');

    // Collect
    $r = array();
    foreach(array_values($res) as $record)
        $r[$record['id']] = $record['name'];

    return($r);
}

function file_upload_action() {

    $enableimport = true; 

    echo "<p>File upload function is now running!</p>";

    $currentDir = getcwd();
    $uploadDirectory = plugin_dir_path( __FILE__ ) . "uploads/";

    echo $uploadDirectory;

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['csv']; // Get all the file extensions

    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $uploadDirectory . basename($fileName); 

    var_dump($fileTmpName);
    var_dump($uploadPath);

    if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = '<p>This file extension is not allowed. Please upload a CSV file</p>';
        }

        if ($fileSize > 2000000) {
            $errors[] = '<p>This file is more than 2MB. Sorry, it has to be less than or equal to 2MB</p>';
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo '<p>The file ' . basename($fileName) . ' has been uploaded</p>';


            } else {
                echo '<p>An error occurred somewhere. Try again or contact the admin</p>';
            }
        } else {
            foreach ($errors as $error) {
                echo $error . '<p>These are the errors' . '\n' . '</p>';
            }
        }
    }

    var_dump($didUpload);

    return;
}

 
 
function faf_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //* Create the teams table
    $table_name = $wpdb->prefix . 'faf_players';
    $sql = "CREATE TABLE $table_name (
    player_id INTEGER NOT NULL AUTO_INCREMENT,
    player_name TEXT NOT NULL,
    player_surname TEXT NOT NULL,
    PRIMARY KEY (player_id)
    ) $charset_collate;";
    dbDelta( $sql );
}

function faf_destroy_db() {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //* Drop table
    $table_name = $wpdb->prefix . 'faf_players';
    $sql = "DROP TABLE $table_name;";
    $wpdb->query( $sql );
}

register_activation_hook( __FILE__, 'faf_create_db' );
register_deactivation_hook( __FILE__, 'faf_destroy_db' );
