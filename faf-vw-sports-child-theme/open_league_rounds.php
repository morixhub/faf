<?php /* Template Name: faf-open-league-rounds */ ?>

<?php
get_header(); ?>

<?php do_action( 'vw_sports_page_top' ); ?>

<main id="maincontent" class="middle-align pt-5" role="main"> 
    
    
    <div class="container">
        <?php while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/content-page'); 
        endwhile; ?>

        <table class="wp-block-table">
            <tr>
                <th>League</th>
                <th>Round name</th>
                <th>Round opening</th>
                <th>Round closing</th>
                <th>Operations</th>
            </tr>

                <?php
                global $wpdb;
                
                $query = 'SELECT L.id AS league_id, L.name AS league_name, R.id AS round_id, R.round_name AS round_name, R.opening AS round_opening, R.closing AS round_closing ' .
                    'FROM ' . $wpdb->prefix . 'faf_leagues L INNER JOIN ' . $wpdb->prefix . 'faf_league_rounds R ON L.id = R.id_league ' .
                    'WHERE curdate() BETWEEN R.opening AND R.closing';
                    
                $res = $wpdb->get_results($query, 'ARRAY_A');

                foreach($res as $record)
                {
                    echo '<tr>';
                    echo '<td>' . $record['league_name'] . '</td>';
                    echo '<td>' . $record['round_name'] . '</td>';
                    echo '<td>' . date_create_from_format('Y-m-d H:i:s', $record['round_opening'])->format('d/m/Y') . '</td>';
                    echo '<td>' . date_create_from_format('Y-m-d H:i:s', $record['round_closing'])->format('d/m/Y') . '</td>';
                    echo '<td><a href="/faf-league-round-participation?id=' . $record['round_id'] . '">Participate</a></td>';
                    echo '</tr>';
                }

                ?>
        </table>
    </div>
    
    
</main>

<?php do_action( 'vw_sports_page_bottom' ); ?>

<?php get_footer(); ?>
