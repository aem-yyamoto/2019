<?php

namespace MyApp\Model;

class Thread extends \MyApp\Model{
    public function create($values){
        $stmt = $this->db->prepare("insert into threads (created_user_id, title, created, modified, category, flag_reflect, num_post) values (:created_user_id, :title, now(), now(), :category, true, 0)");
        $res = $stmt->execute([
            ':created_user_id' => $values['email'],
            ':title' => $values['title'],
            ':category' => $values['category']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateTitle();
        }
    }
    public function update_title($values){
        $stmt = $this->db->prepare("update threads set title=:title,modified=now() where thread_id=:thread_id");
        $res = $stmt->execute([
            ':title' => $values['title'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateTitle();
        }
    }
    public function update_category($values){
        $stmt = $this->db->prepare("update threads set category=:category,modified=now() where thread_id=:thread_id");
        $res = $stmt->execute([
            ':category' => $values['category'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateTitle();
        }
    }

    public function update_num_post($values){
        $stmt = $this->db->prepare("update threads set num_post=:num_post where thread_id=:thread_id");
        $res = $stmt->execute([
            ':num_post' => $values['num_post'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateTitle();
        }
    }

    public function update_flag_reflect($values){
        $stmt = $this->db->prepare("update threads set flag_reflect=:flag_reflect where thread_id=:thread_id");
        $res = $stmt->execute([
            ':flag_reflect' => $values['flag_reflect']==true?false:true,
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function delete($values){
        $stmt = $this->db->prepare("delete from threads where thread_id=:thread_id");
        $res = $stmt->execute([
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\DuplicateTitle();
        }
    }

     public function findAll(){
        $stmt = $this->db->query("select * from threads");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    // カテゴリーから複数のスレッドを返す
    public function findThreads($category){
        $stmt = $this->db->prepare("select * from threads where category=:category order by thread_id");
        $stmt->execute([
            ':category' => $category
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    // 1つのスレッドを取得
    public function findThread($thread_id){
        $stmt = $this->db->prepare("select * from threads where thread_id=:thread_id order by thread_id");
        $stmt->execute([
            ':thread_id' => $thread_id
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

}
