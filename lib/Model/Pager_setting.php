<?php

namespace MyApp\Model;

class Pager_setting extends \MyApp\Model{

    public function update($show_num){
        var_dump( $show_num);
        $stmt = $this->db->prepare("update pager_setting set show_num=:show_num");
        $res = $stmt->execute([
            ':show_num' => $show_num
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function getSetting(){
        $stmt = $this->db->query("select * from pager_setting");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

}
