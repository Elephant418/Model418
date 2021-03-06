<?php

namespace Baddum\Model418\Test\Resources\JSON;

use Baddum\Model418\FileProvider as Provider;
use Baddum\Model418\ModelQuery;

class ResourceModel extends ModelQuery
{


    /* INITIALIZATION
     *************************************************************************/
    protected function initProvider()
    {
        $provider = (new Provider)
            ->setRequest('JSON')
            ->setFolder(__DIR__ . '/../data')
            ->setIdField('myName');
        return $provider;
    }

    protected function initSchema()
    {
        return array(
            'myName' => 'defaultValue',
            'myArray' => 'defaultArray'
        );
    }


    /* FETCHING METHODS
     *************************************************************************/
    public function fetchTest()
    {
        return $this->fetchById('json');
    }
}