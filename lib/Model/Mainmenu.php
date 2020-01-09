<?php

namespace MyApp\Model;

class Mainmenu extends \MyApp\Model{
    
    public function update_title($title){
        $stmt = $this->db->prepare("update main set title=:title");
        $res = $stmt->execute([
            ':title' => $title
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function update_attention($attention){
        $stmt = $this->db->prepare("update main set attention=:attention");
        $res = $stmt->execute([
            ':attention' => $attention
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function getAll(){
        $stmt = $this->db->query("select * from main");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }
}
