<?php
namespace Database\Seeders;

use App\Models\BmCategory;
use App\Models\BmClient;
use App\Models\BmMailTemplate;
use Illuminate\Database\Seeder;

class BusinessMailSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $cat1 = BmCategory::create(['name' => 'Dentist',  'status' => 1]);

        // Templates
        BmMailTemplate::create([
            'category_id'       => $cat1->id,
            'name'              => 'Shree Gurve',
            'subject'           => 'Grow Your Business Digitally with Shree Gurve Technology — {{company}}',
            'short_description' => 'New Website developement Template',
            'status'            => 1,
            'mail_template'     => <<<HTML
                <h2>Dear Sir/Madam <strong>{{company}}</strong>,</h2>
                <p>Greetings from Shree Gurve.</p>
                <p>I hope you are doing well.</p><br><br>
                <p>We noticed that your business has strong potential for growth, and we would like to introduce our IT and software development services that help businesses build a powerful digital presence and streamline operations.</p><br><br>
                <p>Today, having a professional website and customized software solutions is essential for business growth, customer trust, and operational efficiency. At Shree Gurve Technology, we specialize in helping businesses start and scale digitally with affordable and modern technology solutions.</p><br><br>

                <strong>Our Services Include:</strong>
                • Business Website Development<br>
                • Custom Software Development<br>
                • Mobile Application Development<br>
                • E-commerce Website Setup<br>
                • Digital Business Automation<br>
                • Domain, Hosting & Technical Support<br>
                • IT Consultation for New Businesses<br><br><br>

                <p>Whether you are starting a new business or planning to expand digitally, our team can design solutions tailored specifically to your business needs.</p><br><br>

                <p>We would be happy to schedule a short discussion to understand your requirements and suggest the best digital strategy for your company.</p><br><br>

                <p>Please feel free to reply to this email or contact us at:</p><br>

                📞 <strong>Phone:</strong> +91 82000 17181<br>
                🌐 <strong>Website:</strong> www.shreegurvetech.com<br>
                📧 <strong>Email:</strong> contact@shreegurvetech.com<br><br>

                <p>We look forward to working together and supporting your business growth.</p><br><br>

                <p>Warm regards,</p>
                <p>Shree Gurve</p>
                <p>IT Solutions & Software Development</p>
            HTML,
        ]);

        // Clients
        BmClient::create([
            'name'          => 'Gautam Kakadiya ',
            'company_name'  => 'Cloud Webs',
            'email'         => 'cloudwebs17@gmail.com',
            'mobile_number' => '+91 82000 17181',
            'website'       => 'https://cloudwebs.com',
            'status'        => 1,
        ]);
    }
}
