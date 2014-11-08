<?php

namespace Test\Elephant418\Model418\Resources\JSONCase;

use Elephant418\Model418\FileProvider as Provider;
use Elephant418\Model418\ModelEntity;

class ResourceModel extends ModelEntity
{


    /* INITIALIZATION
     *************************************************************************/
    protected function initProvider()
    {
        $provider = (new Provider)
            ->setFileRequest('JSON')
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