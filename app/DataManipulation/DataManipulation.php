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
        $sql = "SELECT * FROM item";
        try {
            $query = $this->pdo->query($sql);
            $query->setFetchMode(PDO::FETCH_OBJ);
            $res = $query->fetchAll();
            // $res['item'] = $res;
            return json_encode($res);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function itemIsExist($item_id)
    {
        $this->pdo = $this->getConnection();
        $sql = "SELECT  EXISTS (select id from item where id = ?) as check_item";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $res = $query->fetch();
            // if(is_bool($res)){
            //     $res['err_msg'] = "Invalid data provided";
            // }
            return json_encode($res, JSON_FORCE_OBJECT);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function subItemIsExist($item_id)
    {
        $this->pdo = $this->getConnection();
        $sql = "select * from sub_item where si_id = ?";
        try {

            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_OBJ);
            $res = $query->fetch();
            if (is_bool($res)) {
                $res['err_msg'] = "Invalid data provided";
            }
            return json_encode($res, JSON_FORCE_OBJECT);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function select_SubItem_By_ItemId($item_id)
    {
        $this->pdo = $this->getConnection();
        $sql = "select * from sub_item where item_id = ?";
        try {

            $query = $this->pdo->prepare($sql);
            $query->execute(array($item_id));
            $query->setFetchMode(PDO::FETCH_OBJ);
            $res = $query->fetchAll();
            $res['item_id'] = $item_id;
            return json_encode($res, JSON_FORCE_OBJECT);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function insertSubItem(array $data)
    {
        $this->pdo = $this->getConnection();
        $sql = "INSERT INTO sub_item (item_id, name, col_a, col_b, col_c, col_d, created_at, updated_at) VALUES (:item_id, :name, :col_a,  :col_b, :col_c, :col_d, now(), now())";
        try {
            $ress =  $this->itemIsExist($data['item_id']);
            $ress = json_decode($ress, true);
            if ($ress['check_item'] == 0) {
                $res['err_msg'] = "Invalid item_id provided";
            } else {
                $sth = $this->pdo->prepare($sql);
                $status = $sth->execute(array(
                    'item_id' => $data['item_id'],
                    'name'  => $data['name'],
                    'col_a' => $data['col_a'],
                    'col_b' => $data['col_b'],
                    'col_c' => $data['col_c'],
                    'col_d' => $data['col_d'],
                ));
                $res['ret_data'] = $sth->rowCount();
            }
            return $res;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}