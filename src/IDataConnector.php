<?php

namespace Elephant418\Packy;

interface IDataConnector
{

    public function fetchById($id);

    public function fetchByIdList($idList);

    public function fetchAll($limit = null, $offset = null, &$count = false);

    public function save($id, $data);

    public function delete($id);
}