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

    /**
     * Map the sections to the total photo count in each section.
     *
     * @var array
     */
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
    protected $image_widths = [666, 761, 525, 900];

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
     *   The section as a human-readable title.
     *
     * @return String
     *   The URL friendly slug of the section.
     */
    protected function getSlug(String $section): String {
        return trim(strtolower(str_replace(' ', '-', $section)));
    }

    /**
     * Give an image's section, index, and desired sizes, get the image URL.
     *
     * @param String $section
     *   The image's section.
     * @param integer $index
     *   The image's index inside its section (this index is inside the image's
     *   filename).
     * @param Array $sizes
     *   The desired sizes of the image as an array of integers.
     *
     * @return Array
     *   The array of image URIs.
     */
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
     *   The URL-friendly slug of the given portfolio section.
     *
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
            abort(404, 'Sorry, we can\'t find that page right now.');
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

        // This is just in case the user lands on `/credit-to-creation`
        // This path is not included in the menu.
        $page = '1';
        $number_of_pages = 1;

        return view('section', compact('section', 'sections', 'image_count', 'images', 'page', 'number_of_pages'));
    }

    /**
     * Method similar to `show` but used for paginated (Credit to Creations) pages.
     *
     * @param String $page
     *   The Credit to Creation page number.
     *
     * @return void
     */
    public function index(String $page) {
        if (!is_numeric($page)) {
            abort(404, 'Sorry, we can\'t find that page right now.');
        }

        $section = 'Credit to Creation';
        $sections = $this->sections;

        $total_blog_images = $this->image_count_map[$this->getSlug($section)];
        $number_of_images_per_page = 69;
        $number_of_pages = floor($total_blog_images / $number_of_images_per_page);

        if ($page > $number_of_pages || $page < 1) {
            abort(404, 'Sorry, we can\'t find that page right now.');
        }

        $tail = $page * $number_of_images_per_page;
        $head = $tail - $number_of_images_per_page + 1;

        if ($tail > $total_blog_images) {
            $tail = $total_blog_images;
            $head = $number_of_pages * $number_of_images_per_page;
        }

        $images = [];
        for ($i = $head; $i <= $tail; $i++) {
            $images[] = [
                'length' => count($this->image_widths),
                'paths' => $this->getImageUrls($section, $i, $this->image_widths),
                'sizes' => $this->image_widths,
            ];
        }

        return view('section', compact('section', 'sections', 'images', 'page', 'number_of_pages'));
    }

}
