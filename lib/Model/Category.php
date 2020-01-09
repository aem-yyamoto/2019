<?php

namespace MyApp\Model;

class Category extends \MyApp\Model{
    
    public function create($category){
        $stmt = $this->db->prepare("insert into categories (category) values (:category)");
        $res = $stmt->execute([
            ':category' => $category
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateCategory();
        }
    }

    public function delete($category_id){
        $stmt = $this->db->prepare("delete from categories where category_id=:category_id");
        $res = $stmt->execute([
            ':category_id' => $category_id
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function getAll(){
        $stmt = $this->db->query("select * from categories order by category_id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function getCategory($category_id){
        $stmt = $this->db->prepare("select * from categories where category_id=:category_id");
        $res = $stmt->execute([
            ':category_id' => $category_id
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

    

}
