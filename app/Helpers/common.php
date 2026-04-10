
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
}