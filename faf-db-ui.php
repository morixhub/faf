<?php

function faf_db_table_ui($get, $post, $page_name, $table_name, $keys_labels_array) {

    // Declare global usages
    global $wpdb;

    $offset = 0;
    $max_count = 50;

    if(isset($get['offset']))
    {
        $offset = $get['offset'];
        if(is_numeric($offset))
            $offset = (int)$offset;
        else
            $offset = 0;
    }

    // Process league removal
    if(isset($get['remove']))
    {
        $removeId = $get['remove'];
        if(is_numeric($removeId))
        {
            if($wpdb->delete($wpdb->prefix . $table_name, array('id' => $removeId)))
                echo 'Record ID ' . $removeId . ' was removed successfully';
            else
                echo 'An error occurred while removing record ID ' . $removeId;
        }
    }
    
    // Process league insertion
    if(isset($post['submit']))
    {
        $fields = array();
        foreach(array_keys($keys_labels_array) as $key)
        {
            if($key == 'id')
                continue;

            $fields[$key] = $post['ctl_' . $key];
        }

        if($wpdb->insert($wpdb->prefix . $table_name, $fields))
            echo 'Record created successfully';
        else
            echo 'An error occurred while creating the new record';
    }

    // Prepare query for selecting leagues
    $query = 'SELECT ' . implode(', ', array_keys($keys_labels_array)) . ' FROM ' . $wpdb->prefix . $table_name;
    $res = $wpdb->get_results($query, 'ARRAY_A');

    // Prepare table header
    echo '<table class="tablebox">';
    echo '<tr>';
        foreach(array_values($keys_labels_array) as $label)
        {
            echo '<th>' . $label . '</th>';
        }
        echo '<th>Operations</th>';
    echo '</tr>';

    // Prepare table body
    $idx = -1;
    $rendered = 0;
    $following = false;
    foreach($res as $record)
    {
        $idx++;

        if($rendered >= $max_count)
        {
            $following = true;
            break;
        }

        if($idx < $offset)
            continue;

        echo '<tr>';
            foreach(array_keys($keys_labels_array) as $key)
            {
                echo '<td>' . $record[$key] . '</td>';
            }
            echo '<td>' . '<a href="?page=' . $page_name . '&remove=' . $record['id'] . '">Remove</a></td>';
        echo '</tr>';

        $rendered++;
    } 

    echo '<p>';
    if($offset > 0)
        echo '<a href="?page=' . $page_name . '&offset=' . max(0, $offset - $max_count) . '">&lt;&nbsp;</a>';
    else
        echo '&lt;&nbsp;';

    if($following)
        echo '<a href="?page=' . $page_name . '&offset=' . ($offset + $max_count) . '">&nbsp;&gt;</a>';
    else
        echo '&nbsp;&gt;';

    echo '</p>';


    // Prepare table footer
    echo '</table>';

    // Prepare new record form
    echo '<form action="?page=' . $page_name . '" method="post" enctype="multipart/form-data">';
    echo '<table style="margin-top:50px">';
    foreach(array_keys($keys_labels_array) as $key)
    {
        if($key == 'id')
            continue;

        echo '<tr>';
            echo '<td>' . $keys_labels_array[$key] . ':</td>';
            echo '<td><input type="text" name="ctl_' . $key . '" id="ctl_' . $key . '"></td>';
        echo '</tr>';
    }
    echo '<tr><td>';
    submit_button('Create');
    echo '</td></tr>';
    echo '</table>';
    echo ' </form>';
}