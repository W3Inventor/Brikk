<?php

global $rz_explore;

$term = null;
$has_more = null;
$listing_type_title = null;
$title = apply_filters('brikk/explore/global/title', esc_html__( 'Explore', 'brikk') );



if( $rz_explore->type && $rz_explore->type->id ) {

    $listing_type_title = $rz_explore->type->get('rz_name_plural'); // Store the listing type title
    $title = $listing_type_title; // Set the default title

    $fields = Rz()->json_decode( $rz_explore->type->get('rz_fields') );
    foreach( $fields as $field ) {
        if( $field->template->id == 'taxonomy' ) {
            if( ! $rz_explore->request->is_empty( Rz()->unprefix( $field->fields->key ) ) ) {

                $term_value = $rz_explore->request->get( Rz()->unprefix( $field->fields->key ) );
                $term_name = Rz()->prefix( $field->fields->key );

                if( is_array( $term_value ) ) {
                    $has_more = true;
                    $term_value = reset( $term_value );
                }

                $term = get_term_by( 'slug', $term_value, $term_name );

                if( $term ) {
                    // Update the title with the searched term
                    $title .= ' - ' . $term->name;
                }

            }
        }
    }
}

?>


<?php 
// Get the Explore page URL
$explore_page = get_page_by_title('Explore');
$explore_page_url = get_permalink($explore_page->ID);

// Get the current URL without query parameters
global $wp;
$current_url = home_url($wp->request);

// Check if the current URL is the exact Explore page URL
$is_exact_explore_page = untrailingslashit($current_url) === untrailingslashit($explore_page_url);

// Check if there are no query parameters
$has_no_query_params = empty($_GET);

if( $title ): ?>
    <div class="rz-taxonomy-heading">
        <div class="rz--inner">

            <div class="rz--title">
                <h4 class="rz--name">
                    <?php
                    if ($is_exact_explore_page || !$has_no_query_params && !$rz_explore->type){
                        if(!$rz_explore->type && !$has_no_query_params)
                            {
                                echo esc_html('Explore');
                            }
                        $query_string = $_SERVER['QUERY_STRING']; // Retrieves the entire query string
                        parse_str($query_string, $params); // Parses the query string into an associative array
                        $values = array_values($params); // Get only the values
                        foreach ($values as $value) {
                            if(!$has_no_query_params && !$rz_explore->type){
                        echo '<h3 class="searched-term">' . ucwords(str_replace('-', ' ', $value)) . '</h3>' . PHP_EOL; 
                            break; // Exit the loop after printing the first value
                        }
                        }

                    }

                    if( $is_exact_explore_page && $has_no_query_params ) {
                        echo esc_html('Explore');


                    }

                     else {
                        echo '<h3 class="searched-term">'.$listing_type_title .'</h3>'; // Display listing type title
                        if( $has_more ) { echo ' ...'; }
                    }
                    ?>
                </h4>
                <?php if( $term ): ?>
                    <h3 class="searched-term"><?php echo esc_html( $term->name ); ?></h3> <!-- Display searched term below -->
                <?php endif; ?>
            </div>

            <div class="rz--action">
                <ul>
                    <?php if( $term ): ?>
                        <li>
                            <a href="<?php echo esc_url( Rz()->get_explore_page_url( [ 'type' => $rz_explore->type->get('rz_slug') ], false ) ); ?>" class="rz--close rz-action-dynamic-explore">
                                <i class="fas fa-times"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
<?php endif; ?>