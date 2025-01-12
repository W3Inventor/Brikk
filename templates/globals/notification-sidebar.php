<?php

defined('ABSPATH') || exit;

if (!function_exists('routiz') || routiz()->notify === null) {
    return;
}

if (version_compare(RZ_VERSION, '1.3.4') < 0) {
    return;
}

$site_notifications = routiz()->notify->get_latest_site();

?>

<div class="brk-side" id="brk_notifi_list">
    <div class="brk--header">
        <span class="brk--title">
            <?php esc_html_e('Notifications', 'brikk'); ?>
        </span>
        <a href="#" class="rz-close" data-action="toggle-side">
            <i class="fas fa-times"></i>
        </a>
    </div>
    <?php if ($site_notifications): ?>
        <div class="brk--actions">
            <a href="#" data-action="marz-as-read">
                <span>
                    <i class="fas fa-check rz-mr-1"></i>
                    <?php esc_html_e('Mark all as read', 'brikk'); ?>
                </span>
                <?php Rz()->preloader(); ?>
            </a>
        </div>
       <div class="brk--actions">
        <!-- Add the "Clear All" button with a custom ID -->
        <a href="#" data-action="rz-clear-all" id="reload_clear">
            <span>
                <i class="fas fa-times rz-mr-1"></i>
                <?php esc_html_e('Clear All', 'brikk'); ?>
            </span>
            <?php Rz()->preloader(); ?>
        </a>
    </div>
    <?php endif; ?>
    <div class="brk--content rz-scrollbar" id="brk_notifi_list">

        <?php if ($site_notifications): ?>
            <ul>
                <?php foreach ($site_notifications as $site): ?>
                    <?php $tag = isset($site->url) ? 'a' : 'em'; ?>
                    <?php $href = isset($site->url) ? sprintf(' href="%s"', esc_url($site->url)) : ''; ?>
                    <li class="<?php if ($site->active) {
                        echo 'rz-active';
                    } ?>">
                        <<?php echo esc_html($tag) . $href; ?>>
                            <div class="rz--icon">
                                <i class="<?php echo isset($site->icon) ? $site->icon : 'fas fa-map-marker-alt'; ?>"></i>
                            </div>
                            <div class="rz--text">
                                <?php if (isset($site->text)): ?>
                                    <?php echo esc_html($site->text); ?>
                                <?php endif; ?>
                                <span class="rz--date">
                                    <?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($site->created_at)); ?>
                                </span>
                            </div>
                            <?php if ($site->active): ?>
                                <div class="rz--dot">
                                    <span></span>
                                </div>
                            <?php endif; ?>
                        </<?php echo esc_html($tag); ?>>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><?php esc_html_e('You don\'t have any notifications', 'brikk'); ?></p>
        <?php endif; ?>

    </div>
</div>

<span class="brk-side-overlay" data-action="toggle-side"></span>







