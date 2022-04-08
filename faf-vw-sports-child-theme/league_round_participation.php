<?php /* Template Name: faf-league-participation */ ?>

<?php
require_once(WP_PLUGIN_DIR . '/faf/faf-db-ui.php');
get_header(); ?>

<?php do_action( 'vw_sports_page_top' ); ?>

<main id="maincontent" class="middle-align pt-5" role="main"> 
    
    <div class="container">
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content-page'); 
        endwhile; ?>

        <?php
        if(isset($_GET['id']))
        {
            $query = 'SELECT L.id AS league_id, L.name AS league_name, R.id AS round_id, R.round_name AS round_name, R.opening AS round_opening, R.closing AS round_closing ' .
            'FROM ' . $wpdb->prefix . 'faf_leagues L INNER JOIN ' . $wpdb->prefix . 'faf_league_rounds R ON L.id = R.id_league ' .
            'WHERE R.id = ' . $_GET['id'];
            
            $res = $wpdb->get_results($query, 'ARRAY_A');

            foreach($res as $record)
            {
                echo '<h3>League: ' . $record['league_name'] . ', round: ' . $record['round_name'] . '</h3>';
                echo '<h5>' . date_create_from_format('Y-m-d H:i:s', $record['round_opening'])->format('d/m/Y') . ' -> ' . date_create_from_format('Y-m-d H:i:s', $record['round_closing'])->format('d/m/Y') . '</h5>';
            }

            echo '<hr/>';
            echo '<h5>Selected players:</h5>';

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
                    ),
                    'surname' => array(
                        faf_db_constants::field_label => 'Player surname',
                    ),
                    'selected_role' => array(
                        faf_db_constants::field_label => 'Selected role',
                        faf_db_constants::field_calculate => '(SELECT id_role FROM ' . $wpdb->prefix . 'faf_round_selections WHERE id_user = ' . faf_get_current_user_id() . ' AND id_round=' . $_GET['id'] . ')'
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
                    )
                ),
                'id IN (SELECT id_player FROM ' . $wpdb->prefix . 'faf_round_selections WHERE id_user = ' . faf_get_current_user_id() . ' AND id_round=' . $_GET['id'] . ')',
                null,
                null,
                null,
                array(
                    'Remove' => 'remove&id=' . $_GET['id']
                ),
                'wp-block-table',
                false,
                false,
                false
            );

            echo '<hr/>';
            echo '<h5>Available players:</h5>';

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
                    ),
                    'surname' => array(
                        faf_db_constants::field_label => 'Player surname',
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
                    )
                ),
                'begin_validity <= "' . date_create('now')->format('Y-m-d')  . '" AND ' . 'end_validity >= "' . date_create('now')->format('Y-m-d') . '" AND id NOT IN (SELECT id_player FROM ' . $wpdb->prefix . 'faf_round_selections WHERE id_user = ' . faf_get_current_user_id() . ' AND id_round=' . $_GET['id'] . ')',
                null,
                null,
                null,
                array(
                    'Select' => 'select&id=' . $_GET['id']
                ),
                'wp-block-table',
                false,
                false,
                false
            );
        }
        ?>
    </div>
    
    
</main>

<?php do_action( 'vw_sports_page_bottom' ); ?>

<?php get_footer(); ?>
