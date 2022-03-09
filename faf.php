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
    add_submenu_page('faf_admin_page_slug', 'leagues', 'Manage leagues', 'administrator', 'faf_admin_leagues_page_slug', 'faf_admin_page_leagues');
    add_submenu_page('faf_admin_page_slug', 'players', 'Manage players', 'administrator', 'faf_admin_players_page_slug', 'faf_admin_page_players');
}

function faf_admin_page() {
    echo "<h1>faf Administration Panel</h1>";
}

function faf_admin_page_leagues() {

    //!!faf_db_table_ui($_GET, $_POST, 'faf_admin_leagues_page_slug', 'faf_leagues', array('id' => 'ID', 'name' => 'League name', 'description' => 'League description'));

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_admin_leagues_page_slug',
        'faf_leagues',
        array(
            'id' => array('ID', 'string'),
            'name' => array('League name', 'string'),
            'description' => array('League description', 'string')
        )
    );
}

function faf_admin_page_players() {

    //!!faf_db_table_ui($_GET, $_POST, 'faf_admin_players_page_slug', 'faf_players', array('id' => 'ID', 'name' => 'Player name', 'surname' => 'Player surname', 'import' => 'Import', 'begin_validity' => 'Begin validity', 'end_validity' => 'End validity'));

    faf_db_table_ui(
        $_GET,
        $_POST,
        'faf_admin_players_page_slug',
        'faf_players',
        array(
            'id' => array('ID', 'string'),
            'name' => array('Player name', 'string'),
            'surname' => array('Player surname', 'string'),
            'import' => array('Import', 'bool'),
            'begin_validity' => array('Begin validity', 'date', date_create('now')),
            'end_validity' => array('End validity', 'date', date_create('now')->add(new DateInterval('P1Y')))
        )
    );

    /*
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
    */
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
