<?php

namespace MyApp\Model;

class Admin extends \MyApp\Model{

    public function update_password($values){
        $stmt = $this->db->prepare("update users set password=:password where email=:email");
        $res = $stmt->execute([
            ':password' => password_hash($values['password'], PASSWORD_DEFAULT),
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\Update_Error();
        }
    }

    public function update_nickname($values){
        $stmt = $this->db->prepare("update users set nickname=:nickname where email=:email");
        $res = $stmt->execute([
            ':nickname' => $values['nickname'],
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function create($values){
        $stmt = $this->db->prepare("insert into users (email, password, created, modified, num_post, total_good, nickname, flag_admin, flag_reflect) values (:email, :password, now(), now(), 0, 0, :nickname, true, true)");
        $res = $stmt->execute([
            ':email' => $values['email'],
            ':password' => password_hash($values['password'], PASSWORD_DEFAULT),
            ':nickname' => $values['nickname']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateEmail();
        }
    }

    public function delete($values){
        $stmt = $this->db->prepare("delete from users where email=:email and flag_admin=true");
        $res = $stmt->execute([
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\NotEmail();
        }
    }

    public function login($values){
        $stmt = $this->db->prepare("select * from users where email = :email");
        $stmt->execute([
            ':email' => $values['email']
        ]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $admin = $stmt->fetch();

        if(empty($admin)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        if(!password_verify($values['password'], $admin->password)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        // userがadminであるか判別
        if(!$admin->flag_admin){
            throw new \MyApp\Exception\UnAdminUser();
        }
        return $admin;
    }

    public function findAll(){
        $stmt = $this->db->query("select * from users order by email");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findAdmin($email){
        $stmt = $this->db->prepare("select * from users where email=:email and flag_admin=true");
        $stmt->execute([
            ':email' => $email
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

    public function findme($email){
        $stmt = $this->db->prepare("select * from users where email=:email");
        $stmt->execute([
            ':email' => $email
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

}
