<?php

defined('ABSPATH') || exit;

use \Routiz\Inc\Src\Form\Component as Form;

$form = new Form( Form::Storage_Option );

?>

<div class="rz-outer">
    <form method="post" autocomplete="nope">

        <div class="rz-meta-container rz-container-left">
            <h1><?php esc_html_e( 'Theme Settings', 'brikk' ); ?></h1>
        </div>

        <div class="rz-panel rz-loading" id="rz-panel" data-tab-start="site/styles" :class="{ 'rz-ready' : ready }">

            <input type="hidden" name="routiz_current_tab" v-bind:value="tab">

            <div class="rz-header">

                <nav class="rz-nav">
                    <ul>
                        <li :class="{ 'rz-active': tabMain == 'site' }">
                            <a href="#" v-on:click.prevent="tabClick('site/styles')">
                                <?php esc_html_e( 'Site', 'brikk' ); ?>
                            </a>
                        </li>
                        <li :class="{ 'rz-active': tabMain == 'header' }">
                            <a href="#" v-on:click.prevent="tabClick('header/general')">
                                <?php esc_html_e( 'Header', 'brikk' ); ?>
                            </a>
                        </li>
                        <li :class="{ 'rz-active': tabMain == 'footer' }">
                            <a href="#" v-on:click.prevent="tabClick('footer/general')">
                                <?php esc_html_e( 'Footer', 'brikk' ); ?>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

            <div class="rz-sub-navs">

                <!-- site -->
                <ul class="rz-sub-nav rz-bg" v-if="tabMain == 'site'">
                    <li :class="{ 'rz-active': tabSub == 'styles' }">
                        <a href="#" v-on:click.prevent="tabClick('site/styles')">
                            <?php esc_html_e( 'Styles', 'brikk' ); ?>
                        </a>
                    </li>
                    <li :class="{ 'rz-active': tabSub == 'fonts' }">
                        <a href="#" v-on:click.prevent="tabClick('site/fonts')">
                            <?php esc_html_e( 'Fonts', 'brikk' ); ?>
                        </a>
                    </li>
                </ul>

                <!-- header -->
                <ul class="rz-sub-nav rz-bg" v-if="tabMain == 'header'">
                    <li :class="{ 'rz-active': tabSub == 'general' }">
                        <a href="#" v-on:click.prevent="tabClick('header/general')">
                            <?php esc_html_e( 'Header', 'brikk' ); ?>
                        </a>
                    </li>
                    <li :class="{ 'rz-active': tabSub == 'cta' }">
                        <a href="#" v-on:click.prevent="tabClick('header/cta')">
                            <?php esc_html_e( 'CTA', 'brikk' ); ?>
                        </a>
                    </li>
                    <li :class="{ 'rz-active': tabSub == 'mobile-bar' }">
                        <a href="#" v-on:click.prevent="tabClick('header/mobile-bar')">
                            <?php esc_html_e( 'Mobile Bar', 'brikk' ); ?>
                        </a>
                    </li>
                </ul>

                <!-- footer -->
                <ul class="rz-sub-nav rz-bg" v-if="tabMain == 'footer'">
                    <li :class="{ 'rz-active': tabSub == 'general' }">
                        <a href="#" v-on:click.prevent="tabClick('footer/general')">
                            <?php esc_html_e( 'Footer', 'brikk' ); ?>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="rz-content">

                <section class="rz-sections" :class="{'rz-none': tabMain !== 'site'}">

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'styles'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'Styles', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    /*
                                     * main color
                                     *
                                     */
                                    $form->render([
                                        'type' => 'heading',
                                        'name' => esc_html__('Theme Colors', 'brikk'),
                                        'description' => esc_html__('Specify the main theme colors', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'main_color',
                                        'name' => esc_html__('Main Color', 'brikk'),
                                        'placeholder' => '#e61e4d',
                                        'col' => 6
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'main_shade_color',
                                        'name' => esc_html__('Main Shade Color', 'brikk'),
                                        'placeholder' => '#d80566',
                                        'col' => 6
                                    ]);

                                    /*
                                     * minor color
                                     *
                                     */
                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'minor_color',
                                        'name' => esc_html__('Minor Color', 'brikk'),
                                        'placeholder' => '#000',
                                        'col' => 6
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'minor_shade_color',
                                        'name' => esc_html__('Minor Shade Color', 'brikk'),
                                        'placeholder' => '#555',
                                        'col' => 6
                                    ]);

                                    /*
                                     * cursor shade color
                                     *
                                     */
                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'cursor_shade_color',
                                        'name' => esc_html__('Cursor Shade Color', 'brikk'),
                                        'placeholder' => 'rgba(255,255,255,.35)'
                                    ]);

                                    /*
                                     * marker color
                                     *
                                     */
                                    $form->render([
                                        'type' => 'heading',
                                        'name' => esc_html__('Marker Colors', 'brikk'),
                                        'description' => esc_html__('Specify the marker colors for explore pages', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_color',
                                        'name' => esc_html__('Marker Color', 'brikk'),
                                        'placeholder' => '#fff',
                                        'col' => 4
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_shade_color',
                                        'name' => esc_html__('Marker Shade Color', 'brikk'),
                                        'placeholder' => '#fff',
                                        'col' => 4
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_text_color',
                                        'name' => esc_html__('Marker Text Color', 'brikk'),
                                        'placeholder' => '#111',
                                        'col' => 4
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_active_color',
                                        'name' => esc_html__('Marker Active Color', 'brikk'),
                                        'placeholder' => '#111',
                                        'col' => 4
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_active_shade_color',
                                        'name' => esc_html__('Marker Active Color', 'brikk'),
                                        'placeholder' => '#444',
                                        'col' => 4
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'marker_active_text_color',
                                        'name' => esc_html__('Marker Active Text Color', 'brikk'),
                                        'placeholder' => '#fff',
                                        'col' => 4
                                    ]);

                                    /*
                                     * tooltip text
                                     *
                                     */
                                    $form->render([
                                        'type' => 'heading',
                                        'name' => esc_html__('Tooltip Text', 'brikk'),
                                        'description' => esc_html__('Specify the tooltip text for fees', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'service_tool',
                                        'name' => esc_html__('Service fee tooltip text', 'brikk'),
                                        'placeholder' => 'This helps us run our platform and offer services like 24/7 support on your trip. it includes VAT.',
                                        'col' => 12
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'fonts'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'Fonts', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'font_heading',
                                        'name' => esc_html__('Heading Font', 'brikk'),
                                        'description' => sprintf( esc_html__('Set custom font for headings from Google Fonts. %s', 'brikk'), '<a href="https://fonts.google.com/" target="_blank">Search fonts</a>' ),
                                        'placeholder' => 'Sen:wght@400;700;800',
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'font_body',
                                        'name' => esc_html__('Body Font', 'brikk'),
                                        'description' => sprintf( esc_html__('Set custom font for site content. %s', 'brikk'), '<a href="https://fonts.google.com/" target="_blank">Search fonts</a>' ),
                                        'placeholder' => 'Open Sans:wght@400;600;700;800',
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                </section>

                <section class="rz-sections" :class="{'rz-none': tabMain !== 'header'}">

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'general'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'Header', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'enable_dark_header',
                                        'name' => esc_html__('Enable Header Dark Mode', 'brikk'),
                                    ]);
                                    
                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'hide_notification_icon',
                                        'name' => esc_html__('Hide Notification Icon', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'hide_user_icon',
                                        'name' => esc_html__('Hide User Icon', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'site_name',
                                        'name' => esc_html__('Custom Site Name', 'brikk'),
                                        'placeholder' => esc_html( Brk()->get_name() )
                                    ]);

                                    $form->render([
                                        'type' => 'radio_image',
                                        'id' => 'header_style',
                                        'name' => esc_html__('Header Style', 'brikk'),
                                        'options' => [
                                            'default' => [
                                                'label' => esc_html__( 'Default', 'brikk' ),
                                                'image' => BK_URI . 'assets/dist/images/admin/header-styles/default.png',
                                            ],
                                            'center' => [
                                                'label' => esc_html__( 'Center', 'brikk' ),
                                                'image' => BK_URI . 'assets/dist/images/admin/header-styles/center.png',
                                            ],
                                        ],
                                        'value' => 'default',
                                    ]);

                                    /*
                                     * logo
                                     *
                                     */
                                    $form->render([
                                        'type' => 'select',
                                        'id' => 'logo_type',
                                        'name' => esc_html__('Site Logo Type', 'brikk'),
                                        'options' => [
                                            'upload' => esc_html__('Upload', 'brikk'),
                                            'path' => esc_html__('Path', 'brikk'),
                                        ],
                                        'value' => 'upload',
                                        'allow_empty' => false,
                                    ]);

                                    // upload
                                    $form->render([
                                        'type' => 'upload',
                                        'id' => 'logo',
                                        'name' => esc_html__('Upload Site Logo', 'brikk'),
                                        'dependency' => [
                                            'id' => 'logo_type',
                                            'value' => 'upload',
                                            'compare' => '=',
                                        ],
                                        'col' => 6
                                    ]);

                                    $form->render([
                                        'type' => 'upload',
                                        'id' => 'logo_white',
                                        'name' => esc_html__('Upload White Logo for Dark Overlaps', 'brikk'),
                                        'dependency' => [
                                            'id' => 'logo_type',
                                            'value' => 'upload',
                                            'compare' => '=',
                                        ],
                                        'col' => 6
                                    ]);

                                    // path
                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'logo_path',
                                        'name' => esc_html__('Path to Site Logo', 'brikk'),
                                        'dependency' => [
                                            'id' => 'logo_type',
                                            'value' => 'path',
                                            'compare' => '=',
                                        ],
                                        'col' => 6
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'logo_path_white',
                                        'name' => esc_html__('Path to White Logo for Dark Overlaps', 'brikk'),
                                        'dependency' => [
                                            'id' => 'logo_type',
                                            'value' => 'path',
                                            'compare' => '=',
                                        ],
                                        'col' => 6
                                    ]);

                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'enable_dropdown_favorites',
                                        'name' => esc_html__('Enable Favorites in Account Drop-down', 'brikk'),
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'cta'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'CTA', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'enable_cta',
                                        'name' => esc_html__('Enable Header Call-to-Action', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'cta_label',
                                        'name' => esc_html__('Call-to-Action Label', 'brikk'),
                                        'dependency' => [
                                            'id' => 'enable_cta',
                                            'value' => true,
                                            'compare' => '=',
                                            'style' => 'rz-opacity-30', // css class
                                        ],
                                    ]);

                                    $form->render([
                                        'type' => 'select2',
                                        'id' => 'cta_target',
                                        'name' => esc_html__('Call-to-Action Target', 'brikk'),
                                        'options' => [
                                            'query' => [
                                                'post_type' => 'page',
                                                'posts_per_page' => -1,
                                            ]
                                        ],
                                        'dependency' => [
                                            'id' => 'enable_cta',
                                            'value' => true,
                                            'compare' => '=',
                                            'style' => 'rz-opacity-30', // css class
                                        ],
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'mobile-bar'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'Mobile Bar', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    $form->render([
                                        'type' => 'repeater',
                                        'id' => 'mobile_bar_nav',
                                        'name' => esc_html__('Mobile Bar Navigation', 'brikk'),
                                        'description' => esc_html__('Select the mobile bar navigation when the user is not logged-in.', 'brikk'),
                                        'templates' => [

                                            /*
                                             * custom link
                                             *
                                             */
                                            'custom' => [
                                                'name' => esc_html__( 'Custom', 'brikk' ),
                                                'heading' => 'name',
                                                'fields' => [
                                                    'name' => [
                                                        'type' => 'text',
                                                        'name' => esc_html__( 'Name', 'brikk' ),
                                                    ],
                                                    'url' => [
                                                        'type' => 'text',
                                                        'name' => esc_html__( 'URL', 'brikk' ),
                                                        'placeholder' => 'https://',
                                                    ],
                                                    'icon' => [
                                                        'type' => 'icon',
                                                        'name' => esc_html__( 'Icon', 'brikk' )
                                                    ],
                                                    'highlight' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Highlight', 'brikk' ),
                                                        'description' => esc_html__( 'Enable this option if you want to gain more visibility for this item', 'brikk' ),
                                                    ],
                                                    'hide_out' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Hide when Logged-out', 'brikk' ),
                                                        'description' => esc_html__( 'Hide this item if the user is not logged-in', 'brikk' ),
                                                    ],
                                                    'hide_in' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Hide when Logged-in', 'brikk' ),
                                                        'description' => esc_html__( 'Hide this item if the user is logged-in', 'brikk' ),
                                                    ],
                                                ]
                                            ],

                                            /*
                                             * pre-defined
                                             *
                                             */
                                            'defined' => [
                                                'name' => esc_html__( 'Pre-Defined', 'brikk' ),
                                                'heading' => 'name',
                                                'fields' => [
                                                    'name' => [
                                                        'type' => 'text',
                                                        'name' => esc_html__( 'Name', 'brikk' ),
                                                    ],
                                                    'id' => [
                                                        'type' => 'select',
                                                        'name' => esc_html__( 'Select Page', 'brikk' ),
                                                        'options' => [
                                                            'explore' => esc_html__( 'Explore Page', 'brikk' ),
                                                            'submission' => esc_html__( 'Submission Page', 'brikk' ),
                                                            'messages' => esc_html__( 'Messages Page', 'brikk' ),
                                                            'notifications' => esc_html__( 'Open Notifications Panel', 'brikk' ),
                                                            'favorites' => esc_html__( 'Open Favorites Modal', 'brikk' ),
                                                            'signup' => esc_html__( 'Open Sign-Up Modal', 'brikk' ),
                                                            'logout' => esc_html__( 'Sign-Out', 'brikk' ),
                                                        ]
                                                    ],
                                                    'icon' => [
                                                        'type' => 'icon',
                                                        'name' => esc_html__( 'Icon', 'brikk' )
                                                    ],
                                                    'highlight' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Highlight', 'brikk' ),
                                                        'description' => esc_html__( 'Enable this option if you want to gain more visibility for this item', 'brikk' ),
                                                    ],
                                                    'hide_out' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Hide when Logged-out', 'brikk' ),
                                                        'description' => esc_html__( 'Hide this item if the user is not logged-in', 'brikk' ),
                                                    ],
                                                    'hide_in' => [
                                                        'type' => 'checkbox',
                                                        'name' => esc_html__( 'Hide when Logged-in', 'brikk' ),
                                                        'description' => esc_html__( 'Hide this item if the user is logged-in', 'brikk' ),
                                                    ],
                                                ]
                                            ]

                                        ]
                                    ]);

                                    $form->render([
                                        'type' => 'checkbox',
                                        'id' => 'mobile_bar_display_names',
                                        'name' => esc_html__( 'Display Mobile Nav Names', 'brikk' ),
                                        'description' => esc_html__( 'Enable this options if you want to display the names under the mobile nav icons', 'brikk' ),
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                </section>

                <section class="rz-sections" :class="{'rz-none': tabMain !== 'footer'}">

                    <aside class="rz-section rz-section-large" :class="{'rz-none': tabSub !== 'general'}">
                        <div class="rz-panel-heading">
                            <h3 class="rz-title"><?php esc_html_e( 'Footer', 'brikk' ); ?></h3>
                        </div>
                        <div class="rz-form">
                            <div class="rz-grid">
                                <?php

                                    $form->render([
                                        'type' => 'textarea',
                                        'id' => 'footer_summary',
                                        'name' => esc_html__('Footer Summary', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'footer_copy',
                                        'name' => esc_html__('Footer Copyright Text', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'text',
                                        'id' => 'footer_account',
                                        'name' => esc_html__('Footer Account Text', 'brikk'),
                                    ]);

                                    $form->render([
                                        'type' => 'number',
                                        'input_type' => 'stepper',
                                        'style' => 'v2',
                                        'id' => 'footer_columns',
                                        'name' => esc_html__('Footer Number of Columns', 'brikk'),
                                        'min' => 3,
                                        'max' => 6,
                                        'value' => 3,
                                    ]);

                                ?>

                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </aside>

                </section>

            </div>
        </div>

    </form>
</div>
