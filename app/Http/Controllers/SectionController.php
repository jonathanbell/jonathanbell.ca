<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionController extends Controller
{

    /**
     * All of the possible sections for the portfolio site, mapping to their
     * respective slugs.
     *
     * @var array
     */
    protected $sections = [
        'credit-to-creation' => 'Credit to Creation',
        'selected-works-i' => 'Selected Works I',
        'selected-works-ii' => 'Selected Works II',
        'portraits' => 'Portraits',
    ];

    protected $image_count_map = [
        'credit-to-creation' => 665,
        'selected-works-i' => 100,
        'selected-works-ii' => 65,
        'portraits' => 9,
    ];

    /**
     * List of image widths for the section (responsive images).
     *
     * @var array
     */
    protected $image_widths = [666, 365, 700, 900];

    /**
     * An array of possible section slugs.
     *
     * @var array
     */
    protected $section_slugs;


    public function __construct() {
        $this->section_slugs = array_keys($this->sections);
    }

    /**
     * Helper function to convert human-readble sections to slugs.
     *
     * @param String $section
     * @return String
     */
    protected function getSlug(String $section): String {
        return trim(strtolower(str_replace(' ', '-', $section)));
    }

    protected function getImageUrls(String $section, int $index, Array $sizes): Array {
        // `q_83` = quality 83 percent
        $base = 'https://res.cloudinary.com/jonathanbell/image/upload/f_auto,c_fit,q_83,w_';
        $pad = str_pad((string) $index, 3, '0', STR_PAD_LEFT);

        $image = [];
        foreach ($sizes as $size) {
            $image[] = $base.$size.'/jonathanbell.ca/'.$this->getSlug($section)
              .'/jonathan-bell-'.$this->getSlug($section).'_'.$pad.'.jpg';
        }

        return $image;
    }

    /**
     * Displays a portfolio section based on the portfolio slug.
     *
     * @param String $section_slug
     * @return void
     */
    public function show(String $section_slug = null) {
        $sections = $this->sections;

        if ($section_slug === null) {
            // We are on the homepage, show a random image
            $section = array_keys($this->section_slugs);
            shuffle($section);
            $section_slug = $this->section_slugs[$section[0]];
            $section = $this->sections[$section_slug];

            $image_number = rand(1, $this->image_count_map[$section_slug]);
            $image = $this->getImageUrls($section, $image_number, $this->image_widths);
            $image_count = 1;
            $images = [
                [
                    'length' => count($this->image_widths),
                    'paths' => $image,
                    'sizes' => $this->image_widths,
                ],
            ];

            return view('section', compact('section', 'sections', 'image_count', 'images'));
        }

        if (!in_array($section_slug, $this->section_slugs)) {
            abort(404, 'Sorry, we can\'t find that page right now');
        }

        $section = $this->sections[$section_slug];
        $image_count = $this->image_count_map[$section_slug];

        $images = [];
        for ($i = 1; $i <= $image_count; $i++) {
            $images[] = [
                'length' => count($this->image_widths),
                'paths' => $this->getImageUrls($section, $i, $this->image_widths),
                'sizes' => $this->image_widths,
            ];
        }

        return view('section', compact('section', 'sections', 'image_count', 'images'));
    }

    public function index(String $page) {
        $number_of_pages = 7;

        if (!is_numeric($page) || (int) $page > $number_of_pages || $page < 1) {
            abort(404, 'Sorry, we can\'t find that page right now');
        }

        $section = 'Credit to Creation';
        $sections = $this->sections;

        $image_count = (int) floor($this->image_count_map['credit-to-creation'] / $number_of_pages);

        $tail = $image_count * (int) $page;
        $head = $tail - $image_count + 1;

        $images = [];
        for ($i = $head; $i <= $tail; $i++) {
            $images[] = [
                'length' => count($this->image_widths),
                'paths' => $this->getImageUrls($section, $i, $this->image_widths),
                'sizes' => $this->image_widths,
            ];
        }

        return view('section', compact('section', 'sections', 'image_count', 'images', 'page', 'number_of_pages'));
    }

}
