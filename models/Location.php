<?php

/**
 * Location
 * @package: Omeka
 */
class Location extends Omeka_Record_AbstractRecord implements Omeka_Api_RecordInterface
{
    public $item_id;
    public $latitude;
    public $longitude;
    public $zoom_level;
    public $map_type;
    public $address;
    
    public function getRepresentation()
    {
        $location = array(
                'item_id' => $this->item_id,
                'lat' => $this->latitude,
                'long' => $this->longitude
                );
        return $location;
    }
    
    protected function _validate()
    {
        if (empty($this->item_id)) {
            $this->addError('item_id', __('Location requires an item id.'));
        }
    }
}