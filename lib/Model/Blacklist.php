<?php

namespace MyApp\Model;

class Blacklist extends \MyApp\Model{

    public function create($values){
        $stmt = $this->db->prepare("insert into blacklist (user_id, created) values (:user_id, now())");
        $res = $stmt->execute([
            ':user_id' => $values['user_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function delete($user_id){
        $stmt = $this->db->prepare("delete from blacklist where user_id=:user_id");
        $res = $stmt->execute([
            ':user_id' => $user_id
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function findAll(){
        $stmt = $this->db->query("select * from blacklist order by created");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findUser($email){
        $stmt = $this->db->prepare("select * from blacklist where user_id=:user_id");
        $stmt->execute([
            ':user_id' => $email
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }
}
