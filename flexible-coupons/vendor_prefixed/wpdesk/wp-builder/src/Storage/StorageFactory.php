<?php

namespace FlexibleCouponsVendor\WPDesk\PluginBuilder\Storage;

class StorageFactory
{
    /**
     * @return PluginStorage
     */
    public function create_storage()
    {
        return new \FlexibleCouponsVendor\WPDesk\PluginBuilder\Storage\WordpressFilterStorage();
    }
}
