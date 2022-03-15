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
            return($default_property_value);
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
        $updateId = 0;
        if(isset($post['updateId']))
            $updateId = (int)$post['updateId'];

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

        if($updateId > 0)
        {
            //!!echo implode(', ', array_values($fields));
            if($wpdb->update($wpdb->prefix . $table_name, $fields, array('id' => $updateId)))
                echo 'Record updated successfully';
            else
                echo 'An error occurred while updating the new record';
        }
        else
        {
            //!!echo implode(', ', array_values($fields));
            if($wpdb->insert($wpdb->prefix . $table_name, $fields))
                echo 'Record created successfully';
            else
                echo 'An error occurred while creating the new record';
        }
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
            echo '<td>';
                echo '<a href="?page=' . $page_name . '&remove=' . $record['id'] . '&offset=' . $offset . '">Remove</a>';
                echo '&nbsp;';
                echo '<a href="?page=' . $page_name . '&id=' . $record['id'] . '&offset=' . $offset . '">Modify</a>';
            echo '</td>';
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

    // Process league update
    $curr = null;
    if(isset($get['id']))
    {
        $updateId = $get['id'];
        if(is_numeric($updateId))
        {
            // Prepare query for selecting leagues
            $query = 'SELECT ' . implode(', ', array_keys($def)) . ' FROM ' . $wpdb->prefix . $table_name . ' WHERE id = ' . $updateId;
            $res = $wpdb->get_results($query, 'ARRAY_A');

            if(count($res) == 1)
                $curr = $res[0];
        }
    }

    // Prepare create/update form
    echo '<form action="?page=' . $page_name . '&offset=' . $offset . '" method="post" enctype="multipart/form-data">';
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

            if($curr != null)
                $value = $curr[$key];
            else
                $value = $default;

            switch($fieldType)
            {
                case 'bool':
                    $valueBool = false;
                    if($value != null && (bool)$value)
                        $valueBool = true;

                    echo '<input type="checkbox" name="ctl_' . $key . '" id="ctl_' . $key . '" ' . ($valueBool ? 'checked' : '') . '></input>';
                    break;

                case 'date':
                    if($curr != null)
                    {
                        $valueDate = date_create('now');
                        $value = date_create_from_format('Y-m-d H:i:s', $value);
                        if($value != null && ($value instanceof DateTime))
                            $valueDate = $value;
                    }
                    else
                    {
                        $valueDate = date_create('now');
                        if($value != null && ($value instanceof DateTime))
                            $valueDate = $value;
                    }

                    echo '<input type="date" name="ctl_' . $key . '" id="ctl_' . $key . '" min="2000-01-01" max="2099-12-31" value="' . $valueDate->format('Y-m-d') . '" required></input>';
                    break;

                default:
                    echo '<input type="text" name="ctl_' . $key . '" id="ctl_' . $key . '" value="' . $value . '"></input>';
                    break;
            }

            echo '<td>';

        echo '</tr>';
    }
    echo '<tr><td>';
    if($curr != null)
    {
        submit_button('Update');
        echo '<input type="button" value="Cancel" onclick="window.location.href = \'?page='. $page_name . '&offset=' . $offset . '\'"></input>';
    }
    else
        submit_button('Create');
    echo '</td></tr>';
    echo '</table>';

    if($curr != null)
        echo '<input type="hidden" id="updateId" name="updateId" value="' . $updateId .'"></input>';

    echo ' </form>';
}