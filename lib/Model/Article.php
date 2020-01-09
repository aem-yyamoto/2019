<?php

namespace MyApp\Model;

class Article extends \MyApp\Model{
    
    public function create($values){
        $stmt = $this->db->prepare("insert into articles (article_id, thread_id, created_user_id, text, created, modified, quote_article_id, flag_reflect, nickname, flag_exist) values (:article_id, :thread_id, :created_user_id, :text, now(), now(), :quote_article_id, :flag_reflect, :nickname, true)");
        $res = $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id'],
            ':created_user_id' => $values['created_user_id'],
            ':text' => $values['text'],
            ':quote_article_id' => $values['quote_article_id'],
            ':flag_reflect' => $values['flag_reflect'],
            ':nickname' => $values['nickname']
        ]);
        if($res === false){
            throw new \MyApp\Exception\InvalidText();
        }
    }

    public function delete($values){
        $stmt = $this->db->prepare("delete from articles where article_id=:article_id and thread_id=:thread_id");
        $res = $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function update_text($values){
        $stmt = $this->db->prepare("update articles set text=:text, modified=now() where article_id=:article_id and thread_id=:thread_id");
        $res = $stmt->execute([
            ':text' => $values['text'],
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }

    public function update_flag_reflect($values){
        $stmt = $this->db->prepare("update articles set flag_reflect=:flag_reflect where thread_id=:thread_id and article_id=:article_id");
        $res = $stmt->execute([
            ':flag_reflect' => $values['flag_reflect']==true?false:true,
            ':thread_id' => $values['thread_id'],
            ':article_id' => $values['article_id']
        ]);
        if($res === false){
            throw new \MyApp\Exception\UpdateError();
        }
    }
    
    // 退会したときの処理
    public function subscribe($values){
        $stmt = $this->db->prepare("update articles set flag_exist=false where created_user_id=:email");
        $res = $stmt->execute([
            ':email' => $values['email']
        ]);
        if($res === false){
            throw new \MyApp\Exception\NotEmail();
        }
    }

    public function findAll(){
        $stmt = $this->db->query("select * from articles order by article_id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findArticles($values){
        $stmt = $this->db->prepare("select * from articles where thread_id=:thread_id");
        $stmt->execute([
            ':thread_id' => $values['thread_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findQuoteArticles($values){
        $stmt = $this->db->prepare("select * from articles where thread_id=:thread_id and quote_article_id is not null");
        $stmt->execute([
            ':thread_id' => $values['thread_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    public function findArticles_isreflect($thread_id){
        $stmt = $this->db->prepare("select * from articles where thread_id=:thread_id and flag_reflect=true");
        $stmt->execute([
            ':thread_id' => $thread_id
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }
    
    /* https://blog.sus-happy.net/php-pdo-limit/ 参照 */
    public function findArticles_limit_isreflect($values){
        $stmt = $this->db->prepare("select * from articles where thread_id=:thread_id and flag_reflect=true limit :num offset :start");
        $stmt->bindParam(':thread_id', $values['thread_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':num', $values['num'], \PDO::PARAM_INT);
        $stmt->bindParam(':start', $values['start'], \PDO::PARAM_INT);
        $stmt->execute();
        /*$stmt->execute([
            ':thread_id' => $values['thread_id'],
            ':num' => $values['num'],
            ':start' => $values['start']
        ]);*/
        // $stmt = $this->db->query("select * from articles where thread_id=16 and flag_reflect=true limit 30 offset 0");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }
    
    public function findArticle($values){
        $stmt = $this->db->prepare("select * from articles where article_id=:article_id and thread_id=:thread_id");
        $stmt->execute([
            ':article_id' => $values['article_id'],
            ':thread_id' => $values['thread_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetch();
    }

    // 洗濯したスレッドの反映されていない記事を返す
    public function findArticles_flag_reflect0($values){
        $stmt = $this->db->prepare("select * from articles where thread_id=:thread_id and flag_reflect=false");
        $stmt->execute([
            ':thread_id' => $values['thread_id']
        ]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        return $stmt->fetchAll();
    }

    private function _validate(){
        if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
          echo "Invalid Token!";
          exit;
        }
        if($_POST['text'] === 'text'){
          if($_POST['text'] === ""){
            throw new \MyApp\Exception\EmptyText();;
          }
        }
    }

}
