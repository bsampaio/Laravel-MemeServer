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

    public function index()
    {
        $images = Image::getDefaultsFormatted();
        return view('images.index', compact('images'));
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
        $validator = Validator::make($request->all(), [
            'top' => 'max:'. Image::$maxCharCount,
            'bottom' => 'required|max:'. Image::$maxCharCount,
            'image' => 'required'
        ]);

        if($validator->fails()){
            $errors = '';
            foreach($validator->errors()->all() as $error){
                $errors .= "<br/>" . $error;
            }

            return response('Erro(s) de validação: ' . $errors, 500);
        }

        $image = $request->get('image');
        if(substr($image, -4) !== '.jpg'){
            $image .= '.jpg';
        }

        $imageObject = $this->manager->make(public_path(). '/images/' . $image);
        $token = Image::generateImageToken();
        $path = public_path() . '/images/' . $token . '.jpg';

        $imageObject = $this->write($imageObject, $request->get('bottom'));

        if($request->get('top'))
            $imageObject = $this->write($imageObject, $request->get('top'), 'top');

        $result = $imageObject->save($path);

        if($result){
            return [
                'message'     => 'Your image was saved successfully',
                'token'       => $token,
                'image_src'   => asset('images/'.$token.'.jpg')
            ];
        }
    }

    /**
     * Get all registered public images and build the links.
     * Send all avaliable images to user request;
     */
    public function all()
    {
        return Image::getDefaultsUrl();
    }

    private function write($image, $text, $position = 'bottom')
    {
        $image->insert($this->addTextLayer($image, $text, $position));

        return $image;
    }

    private function addTextLayer($image, $text, $position)
    {
        $coordinates = Image::getTextCoordinates($position);
        $textLayer = $this->manager->canvas(
            $image->width(),
            $image->height(),
            [0, 0, 0, 0]
        );

        for( $x = -2; $x <= 2; $x++ ) {
            for( $y = -2; $y <= 2; $y++ ) {
                $textLayer->text($text, $coordinates['x'] + $x, $coordinates['y'] + $y, function($font) {
                    $font->file(Image::getFontFile());
                    $font->size(85);
                    $font->color('#000'); // Glow color
                    $font->align('center');
                    $font->valign('top');
                });
            }
        }

        //$textLayer->blur(10);

        $textLayer->text($text, $coordinates['x'], $coordinates['y'], function($font) {
            $font->file(Image::getFontFile());
            $font->size(85);
            $font->color('#FFF'); // Text color
            $font->align('center');
            $font->valign('top');
        });

        return $textLayer;
    }
}
