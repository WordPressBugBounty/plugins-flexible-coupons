<?php

namespace FlexibleCouponsVendor\WPDesk\Tracker;

if (interface_exists(\FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable::class) && interface_exists(\FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableCollection::class)) {
    class_alias(\FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable::class, Hookable::class);
    class_alias(\FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableCollection::class, HookableCollection::class);
} else {
    require_once __DIR__ . '/Hookable.php';
    require_once __DIR__ . '/HookableCollection.php';
}
