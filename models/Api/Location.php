<?php

debug('read api location');
class Api_Location extends Omeka_Record_Api_AbstractRecordAdapter
{
    public function getRepresentation(Omeka_Record_AbstractRecord $record)
    {
        return $record->toArray();
    }
    
    public function setData(Omeka_Record_AbstractRecord $record, array $data)
    {
    
    }  
    
}
