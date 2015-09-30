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
    private static $defaults = [
        [
            'name'      => 'earth',
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


    public static function getTextCoordinates($position = 'bottom')
    {
        return self::$textCoordinates[$position];
    }

    public static function getFontFile()
    {
        return base_path() . '/resources/assets/font/impact.ttf';
    }

    const tokenRegex = '/^201[5-6]((0[1-9])|(1[0-2]))((3[0-1])|([1-2][1-9]))((2[0-3])|([0-1][0-9]))([0-5][0-9])([0-5][0-9]).{4}$/i';

    public static function getDefaults()
    {
        $defaults = [];
        foreach(self::$defaults as $default){
            $defaults[] = self::buildImagePath($default);
        }
        $defaults = new Collection($defaults);
        return $defaults->pluck('path');
    }

    private static function buildImagePath($image)
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
