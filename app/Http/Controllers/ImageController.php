<?php

namespace MemeServer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MemeServer\Http\Requests;
use MemeServer\Http\Controllers\Controller;
use MemeServer\Image;
use Intervention\Image\ImageManager as ImageManager;

class ImageController extends Controller
{


    /**
     * @var ImageManager
     */
    protected $manager;

    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->manager = new ImageManager();
    }

    public function get()
    {
        return 'Ok';
    }

    /**
     * Proccess image and write the text
     * Verify if the image needs to be downloaded
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'top' => 'required|max:'. Image::$maxCharCount,
            'bottom' => 'required|max:'. Image::$maxCharCount,
            'image' => ''
        ]);

        $image = $this->manager->make(public_path(). '/images/earth.jpg');
        $token = Image::generateImageToken();
        $path = public_path() . '/images/' . $token;

        $image = $this->write($image, 'MAX LENGTH IS 22!');
        $image = $this->write($image, 'MAX LENGTH IS 22!', 'top');

        $image->save();
    }

    /**
     * Get all defaut images;
     */
    public function all()
    {
        $image = $this->manager->make(public_path(). '/images/earth.jpg');

        dd(Image::generateImageToken());
        // $image->save(public_path().'/images/foobar.jpg');
        //return Image::getDefaults();
    }

    private function write($image, $text, $position = 'bottom')
    {
        $impact = Image::getFontFile();
        $coordinates = Image::getTextCoordinates($position);
        $image->text($text, $coordinates['x'], $coordinates['y'], function($font) use ($impact) {
            $font->file($impact);
            $font->size(85);
            $font->color('#FFF');
            $font->align('center');
            $font->valign('top');
        });

        return $image;
    }
}
