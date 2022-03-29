<?php /* Template Name: faf-league-participation */ ?>

<?php
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

            echo '<table class="wp-block-table">';
            foreach($res as $record)
            {
                echo '<tr><td>League:</td><td>' . $record['league_name'] . '</td></tr>';
                echo '<tr><td>Round:</td><td>' . $record['round_name'] . '</td></tr>';
                echo '<tr><td>Round opening:</td><td>' . date_create_from_format('Y-m-d H:i:s', $record['round_opening'])->format('d/m/Y') . '</td></tr>';
                echo '<tr><td>Round closing:</td><td>' . date_create_from_format('Y-m-d H:i:s', $record['round_closing'])->format('d/m/Y') . '</td></tr>';
            }
            echo '</table>';
        }
        ?>
    </div>
    
    
</main>

<?php do_action( 'vw_sports_page_bottom' ); ?>

<?php get_footer(); ?>
