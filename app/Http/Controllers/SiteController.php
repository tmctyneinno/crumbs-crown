<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function page(string $page)
    {
        $pages = [
            'shop' => [
                'eyebrow' => 'The collection',
                'title' => 'Small luxuries, made fresh.',
                'description' => 'Browse handcrafted cakes, pastries and thoughtful gift boxes made for ordinary days and memorable ones.',
                'image' => 'images/featured-1.jpg',
                'items' => ['Signature cakes', 'Pastries and breads', 'Gift boxes'],
            ],
            'cakes' => [
                'eyebrow' => 'The cake studio',
                'title' => 'A centrepiece worth gathering around.',
                'description' => 'From rich chocolate layers to bright celebration cakes, every design is baked and finished with care.',
                'image' => 'images/featured-2.jpg',
                'items' => ['Birthday cakes', 'Custom designs', 'Classic favourites'],
            ],
            'corporate' => [
                'eyebrow' => 'Corporate gifting',
                'title' => 'Thoughtful treats for your people.',
                'description' => 'Say thank you, welcome a new teammate or mark a milestone with beautifully presented gifts at any scale.',
                'image' => 'images/banana-cake-offer.jpg',
                'items' => ['Client gifts', 'Team celebrations', 'Branded orders'],
            ],
            'wedding' => [
                'eyebrow' => 'Weddings and events',
                'title' => 'Sweet details for the big day.',
                'description' => 'Bring your vision to the table with bespoke cakes, dessert tables and pastries designed around your celebration.',
                'image' => 'images/featured-3.jpg',
                'items' => ['Wedding cakes', 'Dessert tables', 'Event catering'],
            ],
            'about' => [
                'eyebrow' => 'Our story',
                'title' => 'Baked with intention. Shared with joy.',
                'description' => 'Crumbs & Crown is a Lagos bakery creating generous, beautiful food for the moments that deserve a little more care.',
                'image' => 'images/about-baker.jpg',
                'items' => ['Made in Lagos', 'Small-batch baking', 'Warm hospitality'],
            ],
            'contact' => [
                'eyebrow' => 'Let’s make something sweet',
                'title' => 'Tell us what you are celebrating.',
                'description' => 'Our team is ready to help with an order, a custom idea or the right treat for your next gathering.',
                'image' => 'images/featured-4.jpg',
                'items' => ['Ikeja, Lagos', '+234 800 000 0000', 'hello@crumbsandcrown.ng'],
            ],
        ];

        abort_unless(isset($pages[$page]), 404);

        return view('pages.site', [
            'page' => $pages[$page],
            'pageKey' => $page,
        ]);
    }
}