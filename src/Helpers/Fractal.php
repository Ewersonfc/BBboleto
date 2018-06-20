<?php

namespace Ewersonfc\BBboleto\Helpers;

use League\Fractal\Manager;
use League\Fractal\Scope;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class Fractal
{   

    /**
     * @param null $data
     * @param null $transformer
     * @return mixed
     */
    public static function item($data = null, $transformer = null)
    {

        $manager = new Manager;
        $manager->setSerializer(new JsonApiSerializer);

        $resource = new Item($data, $transformer);
        return new Scope($manager, $resource);
    }
}
