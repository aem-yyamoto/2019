<?php

namespace MyApp\Model;

class User extends \MyApp\Model{

    public function create($values){
        $stmt = $this->db->prepare("insert into users (email, password, created, modified, num_post, total_good, nickname, flag_admin, flag_reflect) values (:email, :password, now(), now(), 0, 0, :nickname, false, true)");
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
        $stmt = $this->db->prepare("delete from users where email=:email");
        $res = $stmt->execute([
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\NotEmail();
        }
    }

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

    public function update_num_post($values){
        $stmt = $this->db->prepare("update users set num_post=:num_post where email=:email");
        $res = $stmt->execute([
            ':num_post' => $values['num_post'],
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function update_flag_reflect($values){
        $stmt = $this->db->prepare("update users set flag_reflect=:flag_reflect where email=:email");
        $res = $stmt->execute([
            ':flag_reflect' => $values['flag_reflect']==true?false:true,
            ':email' => $values['email']
        ]);

        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function update_total_good($values){
        $stmt = $this->db->prepare("update users set total_good=:total_good where email=:email");
        $res = $stmt->execute([
            ':total_good' => $values['total_good'],
            ':email' => $values['email']
        ]);

        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function login($values){
        $stmt = $this->db->prepare("select * from users where email = :email");
        $stmt->execute([
            ':email' => $values['email']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        $user = $stmt->fetch();

        if(empty($user)){
            throw new \MyApp\Exception\UnmatchEmailOrPassword();
        }
        if($user->email  !== GUEST_EMAIL){
            if(!password_verify($values['password'], $user->password)){
                throw new \MyApp\Exception\UnmatchEmailOrPassword();
            }
        }
        $stmt = $this->db->prepare("update users set modified=now() where email=:email");
        $stmt->execute([
            ':email' => $values['email']
        ]);

        return $user;
    }

    public function findAll(){
        $stmt = $this->db->query("select * from users order by created");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findUser($email){
        $stmt = $this->db->prepare("select * from users where email=:email");
        $stmt->execute([
            ':email' => $email
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

    public function findUsers(){
        $stmt = $this->db->prepare("select * from users where email=:email and flag_admin=false");
        $stmt->execute([
            ':email' => $email
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findAdmin(){
        $stmt = $this->db->query("select * from users where flag_admin=true order by email");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

}
