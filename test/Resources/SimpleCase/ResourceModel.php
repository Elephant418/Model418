<?php

namespace Test\Elephant418\Model418\Resources\SimpleCase;

use Elephant418\Model418\DataConnection\FileDataConnection as DataConnection;
use Elephant418\Model418\ModelEntity;

class ResourceModel extends ModelEntity
{


    /* INITIALIZATION
     *************************************************************************/
    protected function initDataConnection()
    {
        $dataConnection = (new DataConnection)
            ->setDataFolder(__DIR__ . '/../data')
            ->setIdField('myName');
        return $dataConnection;
    }

    protected function initSchema()
    {
        return array('myName' => 'defaultValue');
    }


    /* FETCHING METHODS
     *************************************************************************/
    public function fetchTest()
    {
        return $this->fetchById('test');
    }
}