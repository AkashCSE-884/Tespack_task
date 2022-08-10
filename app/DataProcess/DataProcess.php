<?php

namespace App\DataProcess;

use App\DataManipulation\DataManipulation;

class DataProcess extends DataManipulation
{
    private $requestMethod;
    private $itemid;
    private $dm;
    public function __construct($requestMethod, $itemid, $dm)
    {
        $this->requestMethod = $requestMethod;
        $this->itemid = $itemid;
        $this->dm = $dm;
    }
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->itemid) {
                    $response = $this->findSubItem($this->itemid);
                } else {
                    $response = $this->getItem();
                };
                break;
            case 'POST':
                if (empty($this->itemid)) {
                    $response = $this->storeSubItemData();
                }
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    private function getItem()
    {
        $result = $this->dm->selectItem();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }
    private function findSubItem($itemid)
    {
        $result = $this->dm->select_SubItem_By_ItemId($itemid);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    private function storeSubItemData()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!array_key_exists("item_id", $input)) {
            return $this->unprocessableEntityResponse('item_id is required');
        }
        if (!isset($input['name'])) {
            return  $this->unprocessableEntityResponse('name is required');
        }
        if (!isset($input['col_a'])) {
            return  $this->unprocessableEntityResponse('col_a is required');
        }
        if (!isset($input['col_b'])) {
            return  $this->unprocessableEntityResponse('col_b is required');
        }
        if (!isset($input['col_c'])) {
            return $this->unprocessableEntityResponse('col_c is required');
        }
        if (!isset($input['col_d'])) {
            return $this->unprocessableEntityResponse('col_d is required');
        }
        $result = $this->dm->insertSubItem($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] =  json_encode($result);
        return $response;
    }
    private function unprocessableEntityResponse($msg)
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => $msg,
        ]);
        return $response;
    }
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
