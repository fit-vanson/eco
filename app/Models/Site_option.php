<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site_option extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_id',
        'general_settings',
        'mail_settings',
        'custom_css',
        'custom_js',
        'theme_option_seo',
        'theme_logo',
        'facebook',
        'twitter',
        'whatsapp',
        'currency',
        'theme_option_header',
        'theme_option_footer',
        'home-video',
        'facebook-pixel',
        'google_analytics',
        'google_tag_manager',
        'cash_on_delivery',
        'bank_transfer',
        'stripe',
        'mailchimp',
        'subscribe_popup',
        'seller_settings',
        'language_switcher',
        'paypal',
        'razorpay',
        'mollie',
        'page_variation',
        'google_map',
        'theme_color',
    ];
}
