<?php

namespace Elephant418\Model418\Core;

trait TEntity
{


    /* ATTRIBUTES
     *************************************************************************/
    protected static $_provider = array();
    protected $_modelClass;


    /* FETCHING METHODS
     *************************************************************************/
    public function fetchById($id)
    {
        $data = $this->getProvider()->fetchById($id);
        return $this->resultAsModel($data);
    }

    public function fetchByIdList($idList)
    {
        $dataList = $this->getProvider()->fetchByIdList($idList);
        return $this->resultAsModelList($dataList);
    }

    public function fetchAll($limit = null, $offset = null, &$count = false)
    {
        $dataList = $this->getProvider()->fetchAll($limit, $offset, $count);
        return $this->resultAsModelList($dataList);
    }

    public function saveById($id, $data)
    {
        return $this->getProvider()->saveById($id, $data);
    }

    public function deleteById($id)
    {
        return $this->getProvider()->deleteById($id);
    }


    /* PROTECTED PROVIDER METHODS
     *************************************************************************/
    protected function initProvider()
    {
        throw new \LogicException('This method must be overridden');
    }

    protected function injectProvider($provider)
    {
        if (!$this->hasProvider() && !$provider) {
            $provider = $this->initProvider();
        }
        if ($provider) {
            $this->setProvider($provider);
        }
    }

    protected function hasProvider()
    {
        return isset(static::$_provider[get_called_class()]);
    }

    protected function setProvider($provider)
    {
        static::$_provider[get_called_class()] = $provider;
        return $this;
    }

    protected function getProvider()
    {
        if (!$this->hasProvider()) {
            return null;
        }
        return static::$_provider[get_called_class()];
    }


    /* PROTECTED MODEL METHODS
     *************************************************************************/
    protected function getModel()
    {
        $class = $this->_modelClass;
        return new $class;
    }

    protected function resultAsModelList($dataList)
    {
        $modelList = array();
        foreach ($dataList as $data) {
            $model = $this->getModel();
            $modelList[$model->id] = $model->initByData($data);
        }
        return $modelList;
    }

    protected function resultAsModel($data)
    {
        $model = $this->getModel();
        if ($data) {
            $model->initByData($data);
        }
        return $model;
    }

}