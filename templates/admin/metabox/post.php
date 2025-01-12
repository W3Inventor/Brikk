<?php

// use \Routiz\Inc\Src\Page\Component as Page;

defined('ABSPATH') || exit;

$panel = \Routiz\Inc\Src\Admin\Panel::instance();
$panel->form->set( $panel->form::Storage_Meta );
// $page = Page::instance();

?>

<div class="rz-outer">
    <div class="rz-panel rz-ml-auto rz-mr-auto">

        <div class="rz-content">
            <section class="rz-sections">
                <aside class="rz-section">

                    <div class="rz-form">

                        <?php

                            $panel->form->render([
                                'type' => 'textarea',
                                'id' => 'summary',
                                'name' => esc_html__('Article Summary', 'brikk'),
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

