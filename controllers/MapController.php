<?php

class Geolocation_MapController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
        $this->_helper->db->setDefaultModelName('Item');
    }

    public function browseAction()
    {
        $table = $this->_helper->db->getTable();
        $locationTable = $this->_helper->db->getTable('Location');

        $params = $this->getAllParams();
        $params['only_map_items'] = true;
        $limit = (int) get_option('geolocation_per_page');
        $currentPage = $this->getParam('page', 1);

        // Only get item/location data for the KML output.
        if ($this->_helper->contextSwitch->getCurrentContext() == 'kml') {
            $items = $table->findBy($params, $limit, $currentPage);
            $this->view->items = $items;
            $this->view->locations = $locationTable->findLocationsByItem($items);
        }
        // Only get pagination data for the "normal" page.
        else {
            $item_id = $this->getParam('item_id');
            if (!empty($item_id)) {
                $this->view->item = get_record_by_id('Item', $item_id);
                $this->view->location = $locationTable->findLocationsByItem($item_id, true);
            }
            $this->view->totalItems = $table->count($params);
            $this->view->params = $params;

            $pagination = array(
                'page' => $currentPage,
                'per_page' => $limit,
                'total_results' => $this->view->totalItems,
            );
            Zend_Registry::set('pagination', $pagination);
        }
    }

    public function tabularAction()
    {
        // Get pagination data via the browse action.
        $this->browseAction();

        // Get the list of items like in browse action / kml context.
        $table = $this->_helper->db->getTable();
        $locationTable = $this->_helper->db->getTable('Location');

        $params = $this->getAllParams();
        $params['only_map_items'] = true;
        $limit = (int) get_option('geolocation_per_page');
        $currentPage = $this->getParam('page', 1);

        $items = $table->findBy($params, $limit, $currentPage);
        $this->view->items = $items;
        $this->view->locations = $locationTable->findLocationsByItem($items);
    }
}
