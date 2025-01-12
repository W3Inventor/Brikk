<?php

if ( ! defined('ABSPATH') ) {
    exit;
}

/*
 * human readable dump
 *
 */
if( ! function_exists('dd') ) {
    function dd( $what = '' ) {
        print '<pre class="dump">';
        print_r( $what );
        print '</pre>';
    }
}
          

/**
 * Add "Print receipt" link to Order Received page and View Order page
 */
if( ! function_exists('isa_woo_thankyou') ) {
/**
 * Add "Print receipt" link to Order Received page and View Order page
 */
function isa_woo_thankyou() {
    echo '<a href="javascript:window.print()" id="wc-print-button">Print receipt</a>';
}
add_action( 'woocommerce_thankyou', 'isa_woo_thankyou', 1);
add_action( 'woocommerce_view_order', 'isa_woo_thankyou', 8 );

}
/* Print Button Code End */

/*
 * shim for wp_body_open,
 * ensuring backward compatibility with versions of WordPress older than 5.2.
 *
 */
if( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/*
 * define contstants
 *
 */
define( 'BK_VERSION', '2.2.0' );
define( 'BK_PATH', wp_normalize_path( get_template_directory() . DIRECTORY_SEPARATOR ) );
define( 'BK_URI', get_template_directory_uri() . '/' );



/*
 * Show phone number field in the edit account section if phone number is enabled
 */
$enable_signup_phone = get_option('rz_enable_signup_phone');
$is_signup_phone_required = get_option('rz_is_signup_phone_required');

// Display the mobile phone field
add_action('woocommerce_edit_account_form', 'add_billing_phone_to_edit_account_form'); // After existing fields

function add_billing_phone_to_edit_account_form() {
    $user = wp_get_current_user();
    $is_signup_phone_required = isset($is_signup_phone_required) ? $is_signup_phone_required : 0; // Define $is_signup_phone_required if not already defined
    ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_phone"><?php _e('Phone Number', 'woocommerce'); ?>
            <?php if ($is_signup_phone_required == 1) : ?> <span class="required">*</span> <?php endif; ?>
        </label>
        <input type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr($user->billing_phone); ?>" />
    </p>
    <?php
}

// Check and validate the mobile phone
add_action('woocommerce_save_account_details_errors', 'billing_phone_field_validation', 20, 1);

function billing_phone_field_validation($args) {
    $is_signup_phone_required = get_option('rz_is_signup_phone_required');

    // Check if the phone is required based on the option
    if ($is_signup_phone_required == 1 && (empty($_POST['billing_phone']) || !isset($_POST['billing_phone']))) {
        $args->add('error', __('Please fill in your Mobile phone', 'woocommerce'), '');
    }
}

// Save the mobile phone value to user data
add_action('woocommerce_save_account_details', 'my_account_saving_billing_phone', 20, 1);

function my_account_saving_billing_phone($user_id) {
    if (isset($_POST['billing_phone']) && !empty($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}

/*
 * autoload
 *
 */
spl_autoload_register( function( $class_name ) {
    if ( strpos( $class_name, 'Brikk' ) === false ) { return; } // check namespace

    $file_parts = explode( '\\', $class_name ); // Split the class name into an array to read the namespace and class.

    $namespace = ''; // Do a reverse loop through $file_parts to build the path to the file.
    for( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

        $current = strtolower( $file_parts[ $i ] ); // Read the current component of the file part.
        $current = str_ireplace( '_', '-', $current );

        if( count( $file_parts ) - 1 === $i ) { // If we're at the first entry, then we're at the filename.
            $file_name = "{$current}.php";
        }else{
            $namespace = '/' . $current . $namespace;
        }
    }

    $filepath  = trailingslashit( dirname( dirname( __FILE__ ) ) . $namespace ); // Now build a path to the file using mapping to the file location.
    $filepath .= $file_name;

    if( file_exists( $filepath ) ) { // If the file exists in the specified path, then include it.
        include_once( $filepath );
    }else{
        wp_die( esc_html("The file attempting to be loaded at {$filepath} does not exist.") );
    }

});

include BK_PATH . 'includes/utils/utils.php';

/* Delete post with all files attached to it */
add_action( 'before_delete_post', 'rz_remove_all_media_with_post', 10 );
function rz_remove_all_media_with_post( $post_id ) {
 
    // Ensure this only runs for the custom post type 'rz_listing'
    if ( get_post_type( $post_id ) !== 'rz_listing' ) {
        return;
    }
 
// 1. Delete all attached media
    $attached_media = get_attached_media( '', $post_id );
    foreach ( $attached_media as $media ) {
        wp_delete_attachment( $media->ID, true );
    }
 
    // 2. Delete images embedded in the post content
    $post_content = get_post_field( 'post_content', $post_id );
    if ( ! empty( $post_content ) ) {
        preg_match_all( '/<img.*?src=[\'"](.*?)[\'"].*?>/', $post_content, $matches );
        if ( ! empty( $matches[1] ) ) {
            foreach ( $matches[1] as $url ) {
                $attachment_id = attachment_url_to_postid( $url );
                if ( $attachment_id ) {
                    wp_delete_attachment( $attachment_id, true );
                }
            }
        }
    }
 
    // 3. Delete images stored in the 'rz_gallery' meta field
    $rz_gallery = get_post_meta( $post_id, 'rz_gallery', true );
    if ( ! empty( $rz_gallery ) ) {
        $gallery_images = json_decode( $rz_gallery, true );
        if ( is_array( $gallery_images ) ) {
            foreach ( $gallery_images as $image ) {
                if ( isset( $image['id'] ) ) {
                    wp_delete_attachment( $image['id'], true );
                }
            }
        }
    }
}


function rz_custom_jquery() {
    wp_register_script( 'jquery_script', get_template_directory_uri() . '/assets/dist/js/jquery.ui.touch.js', array( 'jquery' ) );
    wp_enqueue_script( 'jquery_script' );
}
add_action( 'wp_footer', 'rz_custom_jquery' ); // end jQuery


add_filter( 'woocommerce_order_item_display_meta_value', 'change_order_item_meta_value', 20, 3 );

/**
 * Changing a meta value
 * @param  string        $value  The meta value
 * @param  WC_Meta_Data  $meta   The meta object
 * @param  WC_Order_Item $item   The order item object
 * @return string        The title
 */
function change_order_item_meta_value( $value, $meta, $item ) {
    // By using $meta->key we are sure we have the correct one.
    if ( '_checkin' === $meta->key || '_checkout' === $meta->key ) {
        $date_time = json_decode( $meta->value );       
        $formatted_date_time = Rz()->local_datetime_i18n( $date_time );  
        $value = esc_html( $formatted_date_time );
    }
    return $value;
}

add_action( 'woocommerce_email_order_meta', 'add_checkin_checkout_to_order_email', 10, 3 );

/**
 * Add check-in and check-out dates to order email
 * @param WC_Order $order The order object
 * @param bool     $sent_to_admin Whether the email is sent to the admin or not
 * @param bool     $plain_text Whether the email is plain text or not
 */
function add_checkin_checkout_to_order_email( $order, $sent_to_admin, $plain_text ) {
    global $wpdb;

    // Get order ID
    $order_id = $order->get_id();

    // Query to get order item ID from wp_woocommerce_order_items table
    $order_item_id = $wpdb->get_var( $wpdb->prepare( "
        SELECT order_item_id
        FROM {$wpdb->prefix}woocommerce_order_items
        WHERE order_id = %d
    ", $order_id ) );

    // If order item ID is found
    if ( $order_item_id ) {
        // Query to get check-in and check-out dates from woocommerce_order_itemmeta table
        $checkin_timestamp = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value
            FROM {$wpdb->prefix}woocommerce_order_itemmeta
            WHERE order_item_id = %d
            AND meta_key = '_checkin'
        ", $order_item_id ) );

        $checkout_timestamp = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value
            FROM {$wpdb->prefix}woocommerce_order_itemmeta
            WHERE order_item_id = %d
            AND meta_key = '_checkout'
        ", $order_item_id ) );

        // If check-in and check-out timestamps are not empty, display them
        if ( $checkin_timestamp && $checkout_timestamp ) {
            $checkin_date = date_i18n( get_option( 'date_format' ), $checkin_timestamp );
            $checkout_date = date_i18n( get_option( 'date_format' ), $checkout_timestamp );

            echo '<p><strong>' . __( 'Check-in:', 'your-text-domain' ) . '</strong> ' . esc_html( $checkin_date ) . '</p>';
            echo '<p><strong>' . __( 'Check-out:', 'your-text-domain' ) . '</strong> ' . esc_html( $checkout_date ) . '</p>';
        }
    }
}

/* Code start for add custom taxonomy count */
function get_taxonomy_slug($taxonomy_name) {
    $taxonomy = get_taxonomy($taxonomy_name);
    return $taxonomy ? $taxonomy->rewrite['slug'] : '';
}

function add_taxonomy_custom_columns($columns) {
    // Remove the 'posts' column
    unset($columns['posts']);

    // Add a new column with the header 'Count'
    $columns['count'] = '<th scope="col" id="count" class="column-count sortable desc" abbr="Count"><a href="#"><span>Count</span><span class="sorting-indicators"><span class="sorting-indicator asc" aria-hidden="true"></span><span class="sorting-indicator desc" aria-hidden="true"></span></span> <span class="screen-reader-text">Sort ascending.</span></a></th>';
    return $columns;
}

function display_taxonomy_custom_column($content, $column_name, $term_id) {
    if ($column_name == 'count') {
        global $wpdb;

        // Specify your custom post type
        $custom_post_type = 'rz_listing';

        // Get the taxonomy object using the taxonomy associated with the term
        $term = get_term($term_id);
        $taxonomy_obj = get_taxonomy($term->taxonomy);

        // Access the slug from the taxonomy object
        $taxonomy_slug = 'rz_' . $taxonomy_obj->rewrite['slug'];

        // Custom SQL query to count the occurrences of the term ID in postmeta
        $query = $wpdb->prepare("
            SELECT COUNT(*) AS count
            FROM {$wpdb->postmeta}
            WHERE meta_key = %s
            AND meta_value = %d
        ", $taxonomy_slug, $term_id);

        // Get the count
        $count = $wpdb->get_var($query);

        return '<th scope="col" id="count" class="column-count sortable desc" abbr="Count">' . $count . '</th>';
    }

    return $content; // Return the original content if the column name doesn't match
}

function add_custom_columns_to_all_taxonomies() {
    $custom_post_type = 'rz_listing';
    $custom_taxonomies = get_object_taxonomies($custom_post_type);
    foreach ($custom_taxonomies as $taxonomy) {
        $taxonomy_slug = get_taxonomy_slug($taxonomy);
        add_filter("manage_edit-{$taxonomy}_columns", 'add_taxonomy_custom_columns');
        add_filter("manage_{$taxonomy}_custom_column", 'display_taxonomy_custom_column', 10, 3);
    }
}
add_action('admin_init', 'add_custom_columns_to_all_taxonomies');
/* Code end for add custom taxonomy count */

// Add custom meta to invoice
add_action( 'wpo_wcpdf_after_order_data', 'add_custom_meta_to_invoice', 10, 2 );
function add_custom_meta_to_invoice( $template_type, $order ) {
    global $wpdb; // Add this line to make $wpdb accessible
    
    // Get order ID
    $order_id = $order->get_id();
    
    // Query to get order item ID from wp_woocommerce_order_items table
    $order_item_id = $wpdb->get_var( $wpdb->prepare( "
        SELECT order_item_id
        FROM {$wpdb->prefix}woocommerce_order_items
        WHERE order_id = %d
    ", $order_id ) );
    
    // If order item ID is found
    if ( $order_item_id ) {
        // Query to get check-in and check-out dates from woocommerce_order_itemmeta table
        $checkin_timestamp = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value
            FROM {$wpdb->prefix}woocommerce_order_itemmeta
            WHERE order_item_id = %d
            AND meta_key = '_checkin'
        ", $order_item_id ) );
        
        $checkout_timestamp = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value
            FROM {$wpdb->prefix}woocommerce_order_itemmeta
            WHERE order_item_id = %d
            AND meta_key = '_checkout'
        ", $order_item_id ) );
        
        // If check-in and check-out timestamps are not empty, display them
        if ( $checkin_timestamp && $checkout_timestamp ) {
            $checkin_date = date_i18n( get_option( 'date_format' ), $checkin_timestamp );
            $checkout_date = date_i18n( get_option( 'date_format' ), $checkout_timestamp );

            echo '<p><strong>' . __( 'Check-in:', 'your-text-domain' ) . '</strong> ' . esc_html( $checkin_date ) . '</p>';
            echo '<p><strong>' . __( 'Check-out:', 'your-text-domain' ) . '</strong> ' . esc_html( $checkout_date ) . '</p>';
        }
    }
}

function hide_champ_plugin_menu() {
    echo '
    <style>
        #toplevel_page_utillz-ul-general-options {
            display: none !important;
        }
    </style>';
}
add_action('admin_head', 'hide_champ_plugin_menu');


/* Message Live Functionality */

function fetch_latest_messages() {
    global $wpdb;

    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        wp_die();
    }

    // Validate and sanitize conversation ID
    $conversation_id = isset($_POST['conversation_id']) ? intval($_POST['conversation_id']) : 0;
    if ($conversation_id <= 0) {
        wp_send_json_error('Invalid conversation ID');
        wp_die();
    }

    // Fetch messages from the database
    $messages = $wpdb->get_results(
        $wpdb->prepare("
            SELECT *
            FROM {$wpdb->prefix}routiz_messages
            WHERE conversation_id = %d
            ORDER BY created_at ASC
            LIMIT 500
        ", $conversation_id)
    );

    ob_start(); ?>
    <div class="rz-modal-container rz-scrollbar">
        <div class="rz-messages" id="message_load">
            <?php if (!empty($messages) && is_array($messages)) {
                $last_date = null;
                foreach ($messages as $message) {
                    $message_date = date_i18n('d-m-Y', strtotime($message->created_at));
                    $is_me = get_current_user_id() == $message->sender_id;

                    // Show date if different from last message's date
                    if ($message_date !== $last_date) { ?>
                        <div class="rz-message-date">
                            <div class="rz--date">
                                <?php echo date_i18n(get_option('date_format'), strtotime($message->created_at)); ?>
                            </div>
                        </div>
                    <?php 
                        $last_date = $message_date;
                    } ?>

                    <div class="rz-message rz-message-<?php echo $is_me ? 'me' : 'not-me'; ?>">
                        <div class="rz--inner">
                            <div class="rz--image">
                                <?php 
                                $user = get_user_by('ID', $message->sender_id);
                                $user_avatar = get_avatar_url($message->sender_id);
                                if ($user_avatar): ?>
                                    <img src="<?php echo esc_url($user_avatar); ?>" alt="">
                                <?php else: ?>
                                    <i class="fas fa-user" style="font-size: 100px; color: #f1f1f1;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="rz--content">
                                <div class="rz--time">
                                    <?php echo date_i18n(get_option('time_format'), strtotime($message->created_at)); ?>
                                </div>
                                <div class="rz--text">
                                    <?php echo wp_kses(wpautop(stripslashes($message->text)), [
                                        'br' => [],
                                        'p' => [],
                                        'u' => [],
                                        'strong' => []
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <p class="rz-text-center rz-mb-0 rz-mt-2"><?php esc_html_e('No messages', 'routiz'); ?></p>
            <?php } ?>
        </div>
    </div>
    <?php

    $html = ob_get_clean();
    wp_send_json_success($html);
    wp_die();
}
add_action('wp_ajax_fetch_latest_messages', 'fetch_latest_messages');
add_action('wp_ajax_nopriv_fetch_latest_messages', 'fetch_latest_messages');

//End Message Code 


// Function to modify the submission menu item URL based on the listing type count
function modify_submission_menu_item($items, $args) {
    // Check if we're working with the correct menu location
    if ($args->theme_location === 'mobile') {
        $listing_types = get_posts([
            'post_type' => 'rz_listing_type',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => 'rz_disable_user_submission',
                    'value' => '',
                    'compare' => '='
                ],
            ]
        ]);

        $submission_id = get_option('rz_page_submission');
        $submission_slug = get_post_field('post_name', $submission_id);

        // Check if there's only one listing type
        if (count($listing_types) === 1) {
            $single_listing_type = $listing_types[0];
            $listing_slug = Rz()->get_meta('rz_slug', $single_listing_type->ID);

            // Construct the redirect URL with submission slug and query string
            $redirect_url = home_url('/' . $submission_slug . '/');
            $redirect_url = add_query_arg('type', $listing_slug, $redirect_url);
        } else {
            // Default URL if there are multiple listing types
            $redirect_url = home_url('/' . $submission_slug . '/');
        }

        // Loop through the menu items to find the submission item
        foreach ($items as &$item) {
            if ($item->object_id == $submission_id) {
                // Check if the user is logged in
                if (is_user_logged_in()) {
                    $item->url = $redirect_url; // Update the menu item URL for logged-in users
                } else {
                    // Prevent default action and trigger the sign-in modal
                    $item->url = '#'; // Avoid redirection by setting href to #
                    $item->classes[] = 'trigger-signin-modal'; // Add class to trigger modal
                }
            }
        }
    }

    return $items;
}
add_filter('wp_nav_menu_objects', 'modify_submission_menu_item', 10, 2);

// Enqueue custom JavaScript for modal trigger
function custom_signin_modal_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.trigger-signin-modal a').on('click', function(e) {
                e.preventDefault(); // Prevent the default link action
                $('[data-modal="signin"]').trigger('click'); // Trigger the sign-in modal
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_signin_modal_script');


Brikk\Includes\Init::instance();