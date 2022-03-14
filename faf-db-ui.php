<?php

class faf_db_constants
{
    const field_label = 'label';
    const field_type = 'type';
    const field_default = 'default';
}

function faf_db_definition_get_field_property($def, $key, $property_name, $property_index, $default_property_value, $is_default_property)
{
    // Check input
    if(!is_array($def))
        return('invalid_array');

    if(!is_string($key))
        return('invalid_key');

    // Check if given key exists in array
    if(!array_key_exists($key, $def))
        return('missing_key');

    // Check entry
    $dk = $def[$key];
    if(!is_array($dk))
    {
        if($is_default_property)
            return($dk);
        else
            return('invalid_entry');
    }        

    // If key type exists, then return it...
    if(array_key_exists($property_name, $dk))
        return($dk[$property_name]);

    // ...otherwise check for position...
    if(array_key_exists($property_index, $dk))
        return($dk[$property_index]);

    // ...otherwise return default
    return($default_property_value);
}

function faf_db_definition_get_field_label($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_label, 0, $key, true));
}

function faf_db_definition_get_field_type($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_type, 1, 'string', false));
}

function faf_db_definition_get_field_default($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_default, 2, null, false));
}

function faf_db_table_ui($get, $post, $page_name, $table_name, $def) {

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
        foreach(array_keys($def) as $key)
        {
            if($key == 'id')
                continue;

            $fieldType = faf_db_definition_get_field_type($def, $key);
            if(isset($post['ctl_' . $key]))
            {
                switch($fieldType)
                {
                    case 'bool':
                        $fields[$key] = ($post['ctl_' . $key] == 'on' ? 1 : 0);
                        break;

                    default:
                        $fields[$key] = $post['ctl_' . $key];
                        break;
                }                
            }
            else
            {
                switch($fieldType)
                {
                    case 'bool':
                        $fields[$key] = 0;
                        break;

                    default:
                        break;
                }
            }   
        }

        //!!
        echo implode(', ', array_values($fields));
        if($wpdb->insert($wpdb->prefix . $table_name, $fields))
            echo 'Record created successfully';
        else
            echo 'An error occurred while creating the new record';
    }

    // Prepare query for selecting leagues
    $query = 'SELECT ' . implode(', ', array_keys($def)) . ' FROM ' . $wpdb->prefix . $table_name;
    $res = $wpdb->get_results($query, 'ARRAY_A');

    // Prepare table header
    echo '<table class="tablebox">';
    echo '<tr>';
        foreach(array_keys($def) as $key)
        {
            echo '<th>' . faf_db_definition_get_field_label($def, $key) . '</th>';
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
            foreach(array_keys($def) as $key)
            {
                echo '<td>';

                $fieldType = faf_db_definition_get_field_type($def, $key); 
                switch($fieldType)
                {
                    case 'bool':
                        if((int)$record[$key])
                            echo '&check;';
                        break;

                    case 'date':
                        echo date_create_from_format('Y-m-d H:i:s', $record[$key])->format('d/m/Y');
                        break;

                    default:
                        echo $record[$key];
                        break;
                }

                echo '</td>';
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
    foreach(array_keys($def) as $key)
    {
        if($key == 'id')
            continue;

        echo '<tr>';
            echo '<td>' . faf_db_definition_get_field_label($def, $key) . ':</td>';

            echo '<td>';

            $fieldType = faf_db_definition_get_field_type($def, $key);
            $default = faf_db_definition_get_field_default($def, $key);
            switch($fieldType)
            {
                case 'bool':
                    echo '<input type="checkbox" name="ctl_' . $key . '" id="ctl_' . $key . '">';
                    break;

                case 'date':
                    $defaultDate = date_create('now');
                    if($default != null && ($default instanceof DateTime))
                        $defaultDate = $default;

                    echo '<input type="date" name="ctl_' . $key . '" id="ctl_' . $key . '" min="2000-01-01" max="2099-12-31" value="' . $defaultDate->format('Y-m-d') . '" required>';
                    break;

                default:
                    echo '<input type="text" name="ctl_' . $key . '" id="ctl_' . $key . '">';
                    break;
            }

            echo '<td>';

        echo '</tr>';
    }
    echo '<tr><td>';
    submit_button('Create');
    echo '</td></tr>';
    echo '</table>';
    echo ' </form>';
}