<?php


use App\Models\Admin\FrontendKeyword;
use App\Models\Admin\Language;


if (session()->has('language_id_from_dropdown')) {

    $language_id_from_dropdown = session()->get('language_id_from_dropdown');

    $frontend_keywords = FrontendKeyword::where('language_id', $language_id_from_dropdown)->get();


} else {

    $language = Language::where('default_site_language', 1)->first();

    $frontend_keywords = FrontendKeyword::where('language_id', $language->id)->get();

}


if (isset($frontend_keywords)) {

    $keywords = [];
    foreach ($frontend_keywords as $frontend_keyword) {
        $keywords += [$frontend_keyword->key => $frontend_keyword->value];
    }

    return $keywords;
}
else {

    return [

        /*
        |--------------------------------------------------------------------------
        | Pagination Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines are used by the paginator library to build
        | the simple pagination links. You are free to change them to anything
        | you want to customize your views to better match your application.
        |
        */

        // Frontend One Group Keyword
        'home' => 'Home',
        'about_us' => 'About Us',
        'services' => 'Services',
        'portfolio' => 'Portfolio',
        'blogs' => 'Blogs',
        'contact' => 'Contact',
        'pages' => 'Pages',
        'download' => 'Download',
        'read_more' => 'Read More',
        'back_to_home' => 'Back To Home',
        'scroll_down' => 'Scroll Down',
        'service_details' => 'Service Details',
        'recent_posts' => 'Recent Posts',
        'share' => 'Share',
        'subscribe_newsletter' => 'Subscribe Newsletter',
        'enter_email' => 'Enter Email',
        'all' => 'All',
        'do_you_need_a_new_project' => 'Do you need a new project?',
        'get_in_touch' => 'Get In Touch',
        'anonymous' => 'Anonymous',
        'name' => 'Name',
        'email' => 'Email',
        'subject' => 'Subject',
        'message' => 'Message',
        'send_message' => 'Send Message',
        'customer_relationship' => 'Customer Relationship',
        'address' => 'Address',
        'address_map_link' => 'Address Map Link',
        'email_and_phone' => 'Email And Phone',
        'portfolio_details' => 'Portfolio Details',
        'search' => 'Search',
        'search_here' => 'Search Here...',
        'categories' => 'Categories',
        'tags' => 'Tags',
        'leave_a_comment' => 'Leave A Comment',
        'your_name' => 'Your Name',
        'your_email' => 'Your Email',
        'your_comment' => 'Your Comment',
        'send_comment' => 'Send Comment',
        'search_results' => 'Search Results',
        'nothing_found' => 'Nothing Found',
        'your_message_has_been_delivered' => 'Your message has been delivered.',
        'your_comment_is_pending_approval' => 'Your comment is pending approval.',

    ];

}

