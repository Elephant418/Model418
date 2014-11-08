<?php

namespace Elephant418\Model418;

use Elephant418\Model418\Core\DataConnection\SingleFileDataConnection;

class FileDataConnection extends SingleFileDataConnection
{


    /* ATTRIBUTES
     *************************************************************************/
    protected $subAttributeList = array();


    /* SUB ATTRIBUTES METHODS
     *************************************************************************/
    public function setSubAttribute($key, $id = null, $format = null)
    {
        $this->unsetSubAttribute($key);
        if (is_null($id)) {
            $id = $key;
        }
        if (in_array($id, $this->subAttributeList)) {
            throw new \RuntimeException('Another sub attribute use the id: '.$id);
        }
        $subAttribute = array();
        $subAttribute['id'] = $id;
        if (!is_null($format)) {
            $fileDataRequest = $this->getFileDataRequestFromName($format);
            $subAttribute['fileDataRequest'] = $fileDataRequest;
        }
        $this->subAttributeList[$key] = $subAttribute;
        return $this;
    }
    
    public function unsetSubAttribute($key)
    {
        unset($this->subAttributeList[$key]);
        return $this;
    }


    /* FETCHING METHODS
     *************************************************************************/
    public function fetchById($id)
    {
        $data = parent::fetchById($id);
        if ($data) {
            foreach (array_keys($this->subAttributeList) as $subKey) {
                $data[$subKey] = $this->fetchSubAttributeById($id, $subKey);
            }
        }
        return $data;
    }


    /* SAVE METHODS
     *************************************************************************/
    public function saveById($id, $data)
    {
        $subData = array();
        foreach (array_keys($this->subAttributeList) as $subKey) {
            $subData[$subKey] = null;
            if (isset($data[$subKey])) {
                $subData[$subKey] = $data[$subKey];
                unset($data[$subKey]);
            }
        }
        $id = parent::saveById($id, $data);
        foreach (array_keys($this->subAttributeList) as $subKey) {
            $this->saveSubAttributeById($id, $subKey, $subData[$subKey]);
        }
        return $id;
    }

    public function deleteById($id)
    {
        $status = parent::deleteById($id);
        foreach (array_keys($this->subAttributeList) as $subKey) {
            $this->deleteSubAttributeById($id, $subKey);
        }
        return $status;
    }


    /* PROTECTED SUB ATTRIBUTE METHODS
     *************************************************************************/
    protected function saveSubAttributeById($id, $subKey, $subData)
    {
        $subId = $this->getSubAttributeId($id, $subKey);
        $this->getSubAttributeFileDataRequest($subKey)
            ->putContents($this->dataFolder, $subId, $subData);
    }

    protected function deleteSubAttributeById($id, $subKey)
    {
        $subId = $this->getSubAttributeId($id, $subKey);
        $this->getSubAttributeFileDataRequest($subKey)
            ->unlink($this->dataFolder, $subId);
    }

    protected function fetchSubAttributeById($id, $subKey)
    {
        $subId = $this->getSubAttributeId($id, $subKey);
        $subData = $this->getSubAttributeFileDataRequest($subKey)
            ->getContents($this->dataFolder, $subId);
        return $subData;
    }

    protected function getSubAttributeId($id, $subKey)
    {
        $subId = $id.'.'.$this->subAttributeList[$subKey]['id'];
        return $subId;
    }
    
    protected function getSubAttributeFileDataRequest($subKey) {
        if (isset($this->subAttributeList[$subKey]['fileDataRequest'])) {
            return $this->subAttributeList[$subKey]['fileDataRequest'];
        }
        return $this->getFileDataRequest();
    }
}