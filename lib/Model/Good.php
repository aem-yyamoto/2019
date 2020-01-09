<?php

namespace MyApp\Model;

class Good extends \MyApp\Model{
    
    public function create($values){
        $stmt = $this->db->prepare("insert into goods (article_id, thread_id, from_user_id, to_user_id, time, flag_exist) values (:article_id, :thread_id, :from_user_id, :to_user_id, now(), :flag_exist)");
        $res = $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id'],
            ':from_user_id' => $values['from_user_id'],
            ':to_user_id' => $values['to_user_id'],
            ':flag_exist' => true
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function delete($values){
        $stmt = $this->db->prepare("delete from goods where article_id=:article_id and thread_id=:thread_id and from_user_id=:from_user_id");
        $res = $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id'],
            ':from_user_id' => $values['from_user_id'],
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function delete_all_article($values){
        $stmt = $this->db->prepare("delete from goods where article_id=:article_id and thread_id=:thread_id");
        $res = $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    // 退会したときの処理
    public function subscribe($values){
        $stmt = $this->db->prepare("update goods set flag_exist=false where from_user_id=:email");
        $res = $stmt->execute([
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\NotEmail();
        }
    }

    public function findAll(){
        $stmt = $this->db->query("select * from goods order by article_id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findGoods_thread($values){
        $stmt = $this->db->prepare("select * from goods where thread_id=:thread_id");
        $stmt->execute([
            ':thread_id' => $values['thread_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findGoods_article($values){
        $stmt = $this->db->prepare("select * from goods where thread_id=:thread_id and article_id=:article_id");
        $stmt->execute([
            ':thread_id' => $values['thread_id'],
            ':article_id' => $values['article_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findGood($values){
        $stmt = $this->db->prepare("select * from goods where article_id=:article_id and thread_id=:thread_id and from_user_id=:from_user_id");
        $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id'],
            ':from_user_id' => $values['from_user_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

}
