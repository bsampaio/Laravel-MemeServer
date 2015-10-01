<?php

namespace MemeServer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Image extends Model
{
    protected $table    = 'images';
    protected $fillable = [
        'user_ip',
        'image_path',
        'token'
    ];
    /**
     * Essas imagens devem estar no diretório public/
     * @var array
     */
    private static $defaults = [
        [
            'name'      => 'earth',
            'path'      => '/images/defaults/',
            'extension' => '.jpg'
        ],
        [
            'name'      => 'jjam',
            'path'      => '/images/defaults/',
            'extension' => '.jpg'
        ],
        [
            'name'      => 'moon',
            'path'      => '/images/defaults/',
            'extension' => '.jpg'
        ],
        [
            'name'      => 'nebula',
            'path'      => '/images/defaults/',
            'extension' => '.jpg'
        ],
        [
            'name'      => 'wanderer',
            'path'      => '/images/defaults/',
            'extension' => '.jpg'
        ],
    ];
    public static $maxCharCount = 22;
    public static $imageDimension = [
        'x' => 1000,
        'y' => 1000
    ];

    public static $textCoordinates = [
        'top' => [
            'x' => 500,
            'y' => 20
        ],
        'bottom' =>  [
            'x' => 500,
            'y' => 900
        ]
    ];

    protected static $publicImageDirectory = 'images/';


    public static function getTextCoordinates($position = 'bottom')
    {
        return self::$textCoordinates[$position];
    }

    public static function getFontFile()
    {
        return base_path() . '/resources/assets/fonts/impact.ttf';
    }

    const tokenRegex = '/^201[5-6]((0[1-9])|(1[0-2]))((3[0-1])|([1-2][1-9]))((2[0-3])|([0-1][0-9]))([0-5][0-9])([0-5][0-9]).{4}$/i';

    public static function getDefaultsUri()
    {
        $defaults = [];
        foreach(self::$defaults as $default){
            $defaults[] = self::buildImageUri($default);
        }
        $defaults = new Collection($defaults);
        return $defaults->pluck('path');
    }

    public static function getDefaultsUrl()
    {
        $defaults = [];
        foreach(self::$defaults as $default){
            $defaults[] = self::buildImageUrl($default);
        }
        $defaults = new Collection($defaults);
        return $defaults->pluck('path');
    }

    public static function getDefaultsFormatted()
    {
        $defaults = [];
        foreach(self::$defaults as $default){
            $defaults[] = self::buildImageUrl($default);
        }
        $defaults = new Collection($defaults);
        return $defaults;
    }

    private static function buildImageUrl($image)
    {
        $image['path'] = asset(self::$publicImageDirectory . $image['name'] . $image['extension']);
        return $image;
    }

    private static function buildImageUri($image)
    {
        $image['path'] = public_path() . $image['path'] . $image['name'] . $image['extension'];
        return $image;
    }

    public static function tokenValidate($string)
    {
        return preg_match(self::tokenRegex, $string);
    }

    public function setTokenAttribute($token)
    {
        if(!self::tokenValidate($token))
        {
            $this->attributes['token'] = null;
            return;
        }

        $this->attributes['token'] = $token;
    }

    public static function generateImageToken()
    {
        $factory = new \Faker\Factory;
        $faker = $factory->create();
        $base = Carbon::now('America/Sao_Paulo')->format('YmdHis') . '????';
        return $faker->lexify($base);
    }
}
