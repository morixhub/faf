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


add_action('admin_menu', 'faf_setup_menu');

function faf_setup_menu() {
    add_menu_page('faf', 'faf Administration', 'manage_options', 'faf_admin_page_slug', 'faf_admin_page');
    add_submenu_page('faf_admin_page_slug', 'leagues', 'Manage leagues', 0, 'faf_admin_leagues_page_slug', 'faf_admin_page_leagues');
    add_submenu_page('faf_admin_page_slug', 'players', 'Manage players', 0, 'faf_admin_players_page_slug', 'faf_admin_page_players');
}

function faf_admin_page() {
    echo "<h1>faf Administration Panel</h1>";
}

function faf_admin_page_leagues() {

    // Declare global usages
    global $wpdb;

    // Declare vars
    $pagename = 'faf_admin_leagues_page_slug';

    // Process league removal
    $removeId = $_GET['remove'];
    if(is_numeric($removeId))
    {
        if($wpdb->delete($wpdb->prefix . 'faf_leagues', array('id' => $removeId)))
            echo 'League ID ' . $removeId . ' was removed successfully';
        else
            echo 'An error occurred while removing league ID ' - $removeId;
    }

    // Process league insertion
    if(isset($_POST['submit']))
    {
        if($wpdb->insert($wpdb->prefix . 'faf_leagues', array('name' => $_POST['league_name'], 'description' => $_POST['league_description'])))
            echo 'League created successfully';
        else
            echo 'An error occurred while creating the new league';
    }

    // Prepare query for selecting leagues
    $query = 'SELECT id, name, description FROM ' . $wpdb->prefix . 'faf_leagues';
    $res = $wpdb->get_results($query);

    // Prepare table header
    echo '<table class="tablebox">';
    echo '<tr>';
        echo '<td>ID</td>';
        echo '<td>League name</td>';
        echo '<td>League description</td>';
        echo '<td>Operations</td>';
    echo '</tr>';

    // Prepare table body
    foreach($res as $league)
    {
        echo '<tr>';
            echo '<td>' . $league->id . '</td>';
            echo '<td>' . $league->name . '</td>';
            echo '<td>' . $league->description . '</td>';
            echo '<td>' . '<a href="?page=' . $pagename . '&remove=' . $league->id . '">Remove</a></td>';
        echo '</tr>';
    } 

    // Prepare table footer
    echo '</table>';

    // Prepare new league form
    echo '<form action="?page=' . $pagename . '" method="post" enctype="multipart/form-data">';
        echo 'League name';
        echo '<input type="text" name="league_name" id="league_name">';
        echo 'League description';
        echo '<input type="text" name="league_description" id="league_description">';
        echo '<input type="hidden" name="submit">';
        submit_button('Create league');
    echo ' </form>';
}

function faf_admin_page_players() {
    // Check whether the button has been pressed AND also check the nonce
    if (isset($_POST['submit'])){

        echo '<p>File upload button was clicked!</p>';
        // the button has been pressed AND we've passed the security check
        file_upload_action();
    }

    echo '<form action="?page=faf_admin_players_page_slug" method="post" enctype="multipart/form-data">';

        echo '<p>Upload a File:</p>';

        echo '<input type="file" name="myfile" id="fileToUpload">';
        echo '<input type="hidden" name="submit">';
        submit_button('Upload File');
    echo ' </form>';
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
