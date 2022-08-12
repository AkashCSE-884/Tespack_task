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
    private function inputValidation(array $input)
    {
        if (!array_key_exists("item_id", $input)) {
            return $this->unprocessableEntityResponse('item_id is required');
        }
        if (!isset($input['si_id'])) {
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
        $response['body'] =  $input;
        return $response;
    }
    private function modifyInputData($input)
    {

        $input = trim($input);
        $input = str_replace(" ", "", $input);
        $input = explode("&", $input);

        $sub_item = array();
        $result = null;

        for ($i = 0; $i <= count($input) - 1; $i++) {

            $temp = explode(",", $input[$i]);
            array_push($sub_item, $temp);
            $sub_temp = explode("=", $sub_item[$i][0]);
            $sub_item[$i][0] = $sub_temp[1];
        }

        $modify_input = array();
        for ($j = 1; $j <= count($sub_item) - 1; $j++) {

            $modify_input['item_id'] = $sub_item[0][0];
            $modify_input['si_id'] = $sub_item[$j][0];
            $modify_input['col_a'] = $sub_item[$j][1];
            $modify_input['col_b'] = $sub_item[$j][2];
            $modify_input['col_c'] = $sub_item[$j][3];
            $modify_input['col_d'] = $sub_item[$j][4];

            $result = $this->dm->insertSubItem($modify_input);
            if (!empty($result['err_msg'])) {
                break;
            }
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function storeSubItemData()
    {
        $input = file_get_contents('php://input');
        $this->modifyInputData($input);
        // var_dump($input);
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
