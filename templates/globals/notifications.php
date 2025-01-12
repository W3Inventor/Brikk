<?php

defined('ABSPATH') || exit;

if (!function_exists('routiz')) {
    return;
}

if (version_compare(RZ_VERSION, '1.3.4') < 0) {
    return;
}

// Check if routiz()->notify returns a valid object
// Check if the 'notify' property exists before accessing it
if (isset(routiz()->notify)) {
    $notify = routiz()->notify;
    // Use $notify as needed
} else {
    // Handle the case when the 'notify' property is not defined
    $notify = null; // or any other default value
}
if ($notify !== null) {
    // Call get_active_site() method only if $notify is not null
    $active_site = $notify->get_active_site();
} else {
    // Set $active_site to null or some default value if routiz()->notify is null
    $active_site = null;
}

?>

<nav class="brk-nav brk-nav-notifications">
    <ul>
        <li>
            <a href="#" class="brk--pad" data-action="toggle-side">
                <i class="material-icon-notification_important">
                    <?php if ($active_site !== null): ?>
                        <span class="brk--dot disable-dot">
                            <?php echo (int) $active_site; ?>
                        </span>
                    <?php endif; ?>
                </i>
            </a>
        </li>
    </ul>
</nav>
