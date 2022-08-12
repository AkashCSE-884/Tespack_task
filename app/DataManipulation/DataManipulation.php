<?php

namespace App\DataManipulation;

use PDO;
use PDOException;
use App\DbConnection\DbConnection as DB;

class DataManipulation extends DB
{

    private $pdo = null;

    public function selectItem()
    {
        $this->pdo = $this->getConnection();
        $res = null;
        $sql = "SELECT * FROM item";
        try {
            $query = $this->pdo->query($sql);
            $query->setFetchMode(PDO::FETCH_OBJ);
            $res = $query->fetchAll();
            // $res['item'] = $res;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return json_encode($res, JSON_FORCE_OBJECT);
    }

    public function itemIsExist($item_id)
    {
        $this->pdo = $this->getConnection();
        // $sql = "SELECT  EXISTS (select id from item where id = ?) as check_item";

        $sql = "SELECT  EXISTS (select id from item where id = ? AND (SELECT COUNT(si.item_id) < 6 FROM sub_item si WHERE si.item_id = ?) )as check_item ";
        $res = null;

        try {
            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id, $item_id));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $res = $query->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return json_encode($res, JSON_FORCE_OBJECT);
    }

    public function subItemIsExist($item_id)
    {
        $this->pdo = $this->getConnection();
        // $sql = "SELECT  EXISTS (select id from item where id = ?) as check_item";

        $sql = "SELECT  EXISTS (select si_id from sub_item where si_id = ?  )as check_Subitem";
        $res = null;

        try {
            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $res = $query->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return json_encode($res, JSON_FORCE_OBJECT);
    }

    public function select_Item_By_Id($item_id)
    {
        $this->pdo = $this->getConnection();
        $sql = "select * from item where id = ?";
        $res = null;
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $res = $query->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return $res;
    }

    public function select_SubItem_By_ItemId($item_id)
    {
        $this->pdo = $this->getConnection();
        $res = null;
        $sql = "select * from sub_item where item_id = ? order by si_id desc ";
        try {

            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_OBJ);
            $res = $query->fetchAll();
            $res['item_details'] = $this->select_Item_By_Id($item_id);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return json_encode($res, JSON_FORCE_OBJECT);
    }


    public function insertSubItem(array $data)
    {

        $res = null;
        $sql = "INSERT INTO sub_item (item_id, si_id, col_a, col_b, col_c, col_d, created_at, updated_at) VALUES (:item_id, :si_id, :col_a,  :col_b, :col_c, :col_d, now(), now())";

        try {
            $ress =  $this->itemIsExist($data['item_id']);
            $ress = json_decode($ress, true);
            if ($ress['check_item'] == 0) {
                $res['err_msg'] = "Invalid item_id provided or item is full";
            } else {
                try {
                    $res_sub_item =  $this->subItemIsExist($data['si_id']);
                    $res_sub_item = json_decode($res_sub_item, true);
                    if ($res_sub_item['check_Subitem'] == 1) {
                        $res['err_msg'] = "Duplicate sub item id provided";
                    } else {
                        $this->pdo = $this->getConnection();
                        $sth = $this->pdo->prepare($sql);
                        $status = $sth->execute(array(
                            'item_id' => $data['item_id'],
                            'si_id'  => $data['si_id'],
                            'col_a' => $data['col_a'],
                            'col_b' => $data['col_b'],
                            'col_c' => $data['col_c'],
                            'col_d' => $data['col_d'],
                        ));
                        // $res['ret_data'] = $sth->rowCount();
                        $res['ret_data_msg'] = "Sub item inserted successfully";
                    }
                } catch (\PDOException $e) {
                    exit($e->getMessage());
                }
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
        $this->pdo = null;
        return $res;
    }
}
