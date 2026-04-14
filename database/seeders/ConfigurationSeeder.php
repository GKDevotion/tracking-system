<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configurations = [
            ['key' => 'CONTACT_EMAIL', 'value' => 'support@wealthora.io', 'display_name' => 'Contact Email'],
            ['key' => 'CONTACT_PHONE', 'value' => '-', 'display_name' => 'Contact Phone'],
            ['key' => 'OFFICE_ADDRESS', 'value' => '-', 'display_name' => 'Office Address'],
            ['key' => 'SOCIAL_FACEBOOK_LINK', 'value' => '-', 'display_name' => 'Facebook'],
            ['key' => 'SOCIAL_TWITTER_LINK', 'value' => '-', 'display_name' => 'Twitter'],
            ['key' => 'SOCIAL_LINKEDIN_LINK', 'value' => '-', 'display_name' => 'LinkedIn'],
            ['key' => 'SOCIAL_INSTAGRAM_LINK', 'value' => '-', 'display_name' => 'Instagram'],
            ['key' => 'SOCIAL_PINTEREST_LINK', 'value' => '-', 'display_name' => 'Pinterest'],
            ['key' => 'SOCIAL_YOUTUBE_LINK', 'value' => '-', 'display_name' => 'YouTube'],
            ['key' => 'SOCIAL_WHATSAPP_LINK', 'value' => '-', 'display_name' => 'WhatsApp'],
            ['key' => 'SOCIAL_TELEGRAM_LINK', 'value' => '-', 'display_name' => 'Telegram'],
            ['key' => 'SOCIAL_TIKTOK_LINK', 'value' => '-', 'display_name' => 'Tiktok'],
            ['key' => 'FOOTER_COPYRIGHT', 'value' => '-', 'display_name' => 'Footer Copyright']

        ];

        foreach ($configurations as $configuration) {
            Configuration::firstOrCreate(['key' => $configuration['key']], $configuration);
        }
    }
}
