<?php

class faf_db_constants
{
    const field_label = 'label';
    const field_type = 'type';
    const field_default = 'default';
    const field_required = 'required';
    const field_source = 'source';
    const field_calculate = 'calculate';

    const field_type_id = 'id';
    const field_type_string = 'string';
    const field_type_bool = 'bool';
    const field_type_int = 'int';
    const field_type_date = 'date';

    const main_query_name = 'MAIN_QUERY';
}

function faf_db_definition_non_calculated_keys($def)
{
    $res = array();

    foreach(array_keys($def) as $key)
    {
        // Calculated fields are excluded for collection
        if(faf_db_definition_field_is_calculated($def, $key))
            continue;

        // Collect key
        array_push($res, $key);
    }

    return($res);
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

function faf_db_definition_get_id_key($def)
{
    foreach(array_keys($def) as $key)
    {
        if(faf_db_definition_field_is_id($def, $key))
            return($key);
    }

    return(null);
}

function faf_db_definition_field_is_id($def, $key)
{
    return(faf_db_definition_get_field_type($def, $key) == 'id');
}

function faf_db_definition_field_is_calculated($def, $key)
{
    return(faf_db_definition_get_field_calculate($def, $key) != null);
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

function faf_db_definition_get_field_required($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_required, 3, false, false));
}

function faf_db_definition_get_field_source($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_source, 4, null, false));
}

function faf_db_definition_get_field_calculate($def, $key)
{
    return(faf_db_definition_get_field_property($def, $key, faf_db_constants::field_calculate, 5, null, false));
}

function faf_db_table_ui($get, $post, $table_name, $def, $where = null, $customValidator = null, $customEditor = null, $customInsertUpdate = null, $actions = null, $class = 'tablebox', $supports_insert = true, $supports_update = true, $supports_delete = true)
{
    // Declare global usages
    global $wpdb;

    // Declare vars
    $offset = 0;
    $max_count = 50;

    // Check table ID availability
    $idKey = faf_db_definition_get_id_key($def);

    if($idKey == null)
    {
        echo 'Error: DB definition does not expose a valid key';
        return;
    }

    // Process sources
    $sources = array();

    foreach(array_keys($def) as $key)
    {
        $source = faf_db_definition_get_field_source($def, $key);

        if($source != null)
        {
            if(!is_callable($source))
            {
                echo 'Error: invalid callable for key ' . $key . ': ' . $source;
                return;   
            }
            
            $sources[$key] = call_user_func($source);
        }
    }

    // Handle offset
    if(isset($get['offset']))
    {
        $offset = $get['offset'];
        if(is_numeric($offset))
            $offset = (int)$offset;
        else
            $offset = 0;
    }

    // Process entity removal
    if(!is_array($table_name) && $supports_delete)
    {
        if(isset($get['remove']))
        {
            $removeId = $get['remove'];
            if(is_numeric($removeId))
            {
                $ret = $wpdb->delete($wpdb->prefix . $table_name, array($idKey => $removeId));

                if(false === $ret)
                    echo 'An error occurred while removing record ID ' . $removeId;
                else
                    echo 'Record ID ' . $removeId . ' was removed successfully';
            }

            unset($get['remove']);
        }
    }
    
    // Process entity insertion/update
    if(!is_array($table_name) && ($supports_insert || $supports_update))
    {
        if(isset($post['submit']))
        {
            $updateId = NULL;
            if(isset($post['updateId']))
                $updateId = $post['updateId'];

            $fields = array();
            foreach(array_keys($def) as $key)
            {
                // If the key is an ID then it has to be excluded by insert/update statement
                if(faf_db_definition_field_is_id($def, $key))
                    continue;

                // If the key represents a calculated field then it has to be excluded by insert/update statement
                if(faf_db_definition_field_is_calculated($def, $key))
                    continue;

                $fieldType = faf_db_definition_get_field_type($def, $key);
                $source = faf_db_definition_get_field_source($def, $key);

                if(isset($post['ctl_' . $key]))
                {
                    if($source != null)
                    {
                        if($post['ctl_' . $key] == 'null')
                            $fields[$key] = null;
                        else
                            $fields[$key] = $post['ctl_' . $key];
                    }
                    else
                    {
                        switch($fieldType)
                        {
                            case faf_db_constants::field_type_bool:
                                $fields[$key] = ($post['ctl_' . $key] == 'on' ? 1 : 0);
                                break;

                            default:
                                $fields[$key] = $post['ctl_' . $key];
                                break;
                        }
                    }                
                }
                else
                {
                    if($source != null)
                    {
                        $fields[$key] = null;
                    }
                    else
                    {
                        switch($fieldType)
                        {
                            case faf_db_constants::field_type_bool:
                                $fields[$key] = 0;
                                break;

                            default:
                                break;
                        }
                    }
                }   
            }

            // Perform custom validation, if requested
            $validRes = null;
            if(is_callable($customValidator))
            {
                $validRes = call_user_func($customValidator, $fields, $post);

                if($validRes != null)
                    echo '<script>setTimeout(function() { alert("' . $validRes . '"); }, 1);</script>';
            }

            if($validRes == null)
            {
                // Process insert/update
                if($updateId != NULL)
                {
                    $ret = $wpdb->update($wpdb->prefix . $table_name, $fields, array($idKey => $updateId));
                    
                    if(false === $ret)
                        echo 'An error occurred while updating the new record';
                    else
                        echo 'Record updated successfully';
                }
                else
                {
                    $ret = $wpdb->insert($wpdb->prefix . $table_name, $fields);

                    if(false === $ret)
                        echo 'An error occurred while creating the new record';
                    else
                    {
                        $updateId = $wpdb->insert_id;
                        echo 'Record created successfully';
                    }
                }

                // Provide extension logic for insert/update
                if(is_callable($customInsertUpdate))
                    call_user_func($customInsertUpdate, (isset($updateId) ? $updateId : null), $post);
            }

            // Reset updateId here so that subsequent parts of the page are not affected
            $updateId = null;
        }
    }

    // Prepare data
    $queryItems = faf_db_definition_non_calculated_keys($def);

    foreach(array_keys($def) as $key)
    {
        $calculate = faf_db_definition_get_field_calculate($def, $key);
        if($calculate != null)
            array_push($queryItems, $calculate . ' AS ' . $key);
    }

    if(!is_array($table_name))
    {
        $query = 'SELECT ' . implode(', ', $queryItems) . ' FROM ' . $wpdb->prefix . $table_name . ' AS ' . faf_db_constants::main_query_name;

        if($where != null)
            $query = $query . ' WHERE ' . $where;

        $res = $wpdb->get_results($query, 'ARRAY_A');
    }
    else
        $res = $table_name;

    // Prepare table header
    echo '<table class="' . $class . '">';
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

                $source = faf_db_definition_get_field_source($def, $key);
                if($source != null)
                {
                    if(isset($sources[$key], $record[$key]))
                        echo $sources[$key][$record[$key]];
                }
                else
                {
                    $fieldType = faf_db_definition_get_field_type($def, $key); 
                    switch($fieldType)
                    {
                        case faf_db_constants::field_type_bool:
                            if((int)$record[$key])
                                echo '&check;';
                            break;

                        case faf_db_constants::field_type_date:
                            echo date_create_from_format('Y-m-d H:i:s', $record[$key])->format('d/m/Y');
                            break;

                        default:
                            echo $record[$key];
                            break;
                    }
                }

                echo '</td>';
            }
            echo '<td>';
                if($actions != null)
                {
                    $actionsArray = array();

                    if(is_callable($actions))
                        $actionsArray = call_user_func($actions, $record[$idKey]);
                    else if(is_array($actions))
                        $actionsArray = $actions;

                    if(is_array($actionsArray))
                    {
                        foreach(array_keys($actionsArray) as $action)
                        {
                            $actionUrl = $actionsArray[$action];
                            echo '<a href="?'. $actionUrl . '&offset=' . $offset . '">' . $action . '</a>&nbsp;&nbsp;';
                        }
                    }
                }
                else
                {
                    if(!is_array($table_name))
                    {
                        if($supports_delete)
                        {
                            $qstr = $get;
                            $qstr['remove'] = $record[$idKey];
                            $qstr = http_build_query($qstr);
                            echo '<a href="?' . $qstr . '">Remove</a>';
                            echo '&nbsp;';
                        }

                        if($supports_update)
                        {
                            $qstr = $get;
                            $qstr['id'] = $record[$idKey];
                            $qstr = http_build_query($qstr);
                            echo '<a href="?' . $qstr . '">Modify</a>';
                        }
                    }
                }
            echo '</td>';
        echo '</tr>';

        $rendered++;
    } 

    echo '<p>';
    if($offset > 0)
    {
        $qstr = $get;
        $qstr['offset'] = max(0, $offset - $max_count);
        $qstr = http_build_query($qstr);
        echo '<a href="?' . $qstr . '">&lt;&nbsp;</a>';
    }
    else
        echo '&lt;&nbsp;';

    if($following)
    {
        $qstr = $get;
        $qstr['offset'] = ($offset + $max_count);
        $qstr = http_build_query($qstr);
        echo '<a href="?' . $qstr . '">&nbsp;&gt;</a>';
    }
    else
        echo '&nbsp;&gt;';

    echo '</p>';


    // Prepare table footer
    echo '</table>';

    if(!is_array($table_name) && $supports_update)
    {
        // Process entity update
        $curr = null;
        if(isset($get['id']))
        {
            $updateId = $get['id'];
            if($updateId != null)
            {
                // Prepare query for selecting entities
                $queryItems = faf_db_definition_non_calculated_keys($def);

                if(is_numeric($updateId))
                    $query = 'SELECT ' . implode(', ', $queryItems) . ' FROM ' . $wpdb->prefix . $table_name . ' WHERE id = ' . $updateId;
                else
                    $query = 'SELECT ' . implode(', ', $queryItems) . ' FROM ' . $wpdb->prefix . $table_name . ' WHERE id = "' . $updateId . '"';
                $res = $wpdb->get_results($query, 'ARRAY_A');

                if(count($res) == 1)
                    $curr = $res[0];
            }
        }
    }

    if(!is_array($table_name) && ($supports_insert || $supports_update))
    {
        // Prepare create/update form
        $qstr = $get;
        unset($qstr['id']);
        $qstr = http_build_query($qstr);

        echo '<form action="?' . $qstr . '" method="post" enctype="multipart/form-data">';
        echo '<table style="margin-top:50px">';
        
        foreach(faf_db_definition_non_calculated_keys($def) as $key)
        {
            // If key is an ID then it has not to be layouted in create/update form
            if(faf_db_definition_field_is_id($def, $key))
                continue;

            // If the key represents a calculated field then it has to be excluded by insert/update statement
            if(faf_db_definition_field_is_calculated($def, $key))
                continue;

            echo '<tr>';
                echo '<td>' . faf_db_definition_get_field_label($def, $key) . ':</td>';

                echo '<td>';

                $fieldType = faf_db_definition_get_field_type($def, $key);
                $default = faf_db_definition_get_field_default($def, $key);
                $required = '';
                if(faf_db_definition_get_field_required($def, $key))
                    $required = 'required';

                if($curr != null)
                    $value = $curr[$key];
                else
                    $value = $default;

                $source = faf_db_definition_get_field_source($def, $key);
                if($source != null)
                {
                    echo '<select name="ctl_' . $key . '" id="ctl_' . $key . '">';
                    $s = $sources[$key];

                    if(!faf_db_definition_get_field_required($def, $key))
                        echo '<option value="null" ' . ($value == null ? 'selected' : '') . '>(none)</option>';

                    foreach(array_keys($s) as $k)
                        echo '<option value="' . $k . '" ' . ($value == $k ? 'selected' : '') . '>' . $s[$k] . '</option>'; 
                    
                    echo '</select>';
                }
                else
                {
                    switch($fieldType)
                    {
                        case faf_db_constants::field_type_bool:
                            $valueBool = false;
                            if($value != null && (bool)$value)
                                $valueBool = true;

                            echo '<input type="checkbox" name="ctl_' . $key . '" id="ctl_' . $key . '" ' . ($valueBool ? 'checked' : '') . ' ' . $required . '></input>';
                            break;

                        case faf_db_constants::field_type_date:
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

                            echo '<input type="date" name="ctl_' . $key . '" id="ctl_' . $key . '" min="2000-01-01" max="2099-12-31" value="' . $valueDate->format('Y-m-d') . '" ' . $required .'></input>';
                            break;

                        default:
                            echo '<input type="text" name="ctl_' . $key . '" id="ctl_' . $key . '" value="' . $value . '" ' . $required . '></input>';
                            break;
                    }
                }

                echo '<td>';

            echo '</tr>';
        }    

        if($curr != null)
            echo '<input type="hidden" id="updateId" name="updateId" value="' . $updateId .'"></input>';

        // Provide extension custom editor
        if(is_callable($customEditor))
            call_user_func($customEditor, (isset($updateId) ? $updateId : null));

        // Provide submit buttons
        echo '<p>';
        if($curr != null)
        {
            $qstr = $get;
            unset($qstr['id']);
            $qstr = http_build_query($qstr);

            echo '<input type="submit" name="submit" value="Update"></input>';
            echo '<input type="button" value="Cancel" onclick="window.location.href = \'?' . $qstr . '\'"></input>';
        }
        else
        {
            echo '<input type="submit" name="submit" value="Create"></input>';
        }
        echo '</p>';

        echo ' </form>';
    }
}

function faf_get_current_user_id()
{
    global $current_user;
    wp_get_current_user();
    return($current_user->ID);
}