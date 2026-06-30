
<?php

use App\Models\Configuration;

if (!function_exists('getConfigurationField')) {
    /**
     * Get configuration value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getConfigurationField($key, $default = null)
    {
        $config = Configuration::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

     function getConfigurationDisplayName($key)
    {
        return \App\Models\Configuration::where('key', $key)
            ->value('display_name');
    }
}

