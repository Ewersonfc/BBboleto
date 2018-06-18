<?php

namespace Ewersonfc\BBboleto\Helpers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

class Fractal
{

    /**
     * @param null $data
     * @param null $transformer
     * @return mixed
     */
    static function item($data = null, $transformer = null)
    {
        $resource = new Item($data, $transformer);
        return self::fractal($resource, $transformer);
    }

    /**
     * @param null $data
     * @param null $transformer
     * @return \League\Fractal\Scope
     */
    static function collection($data = null, $transformer = null)
    {
        $resource = new Collection($data, $transformer);
        return self::fractalTransform($resource, $transformer);
    }

    /**
     * @param null $data
     * @param null $transformer
     * @param null $serializer
     * @return \League\Fractal\Scope
     */
    static function fractalTransform($data = null, $transformer = null, $serializer = null)
    {
        $fractal = new Manager();
        return $fractal->createData($data, $transformer, $serializer);
    }
}
