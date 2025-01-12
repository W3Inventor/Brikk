<?php

defined('ABSPATH') || exit;

$panel = \Routiz\Inc\Src\Admin\Panel::instance();
$panel->form->set( $panel->form::Storage_Meta );

?>

<div class="rz-outer">
    <div class="rz-outer">
        <div class="rz-panel rz-ml-auto rz-mr-auto">

            <div class="rz-content">
                <section class="rz-sections">
                    <aside class="rz-section">

                        <div class="rz-form">

                            <?php

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'overlap_header',
                                    'name' => esc_html__('Overlap Header', 'brikk'),
                                ]);

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'is_header_white_text_color',
                                    'name' => esc_html__('Header White Text Color', 'brikk'),
                                    'dependency' => [
                                        'id' => 'overlap_header',
                                        'value' => true,
                                        'compare' => '=',
                                        'style' => 'rz-opacity-30',
                                    ],
                                ]);

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'hide_heading',
                                    'name' => esc_html__('Hide Heading', 'brikk'),
                                ]);

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'enable_wide_page',
                                    'name' => esc_html__('Enable Wide Page', 'brikk'),
                                    'description' => esc_html__('The page will be displayed in full-width', 'brikk'),
                                ]);

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'hide_footer',
                                    'name' => esc_html__('Hide Footer', 'brikk'),
                                    'description' => esc_html__('No footer will be displayed', 'brikk'),
                                ]);

                                $panel->form->render([
                                    'type' => 'checkbox',
                                    'id' => 'invert_footer',
                                    'name' => esc_html__('Invert Footer Colors', 'brikk'),
                                    'dependency' => [
                                        'id' => 'hide_footer',
                                        'value' => true,
                                        'compare' => '!=',
                                    ],
                                ]);

                            ?>

                            <?php if( ! get_current_screen()->is_block_editor() ): ?>
                                <div class="rz-form-group rz-col-12 rz-text-center rz-mt-3">
                                    <button type="submit" class="rz-button rz-large">
                                        <span><?php esc_html_e( 'Save Changes', 'brikk' ); ?></span>
                                    </button>
                                </div>
                            <?php endif; ?>

                        </div>

                    </aside>
                </section>
            </div>

        </div>
    </div>
</div>
