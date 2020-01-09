<?php

namespace MyApp\Controller;

class Threads{
    public function update_title($title, $thread_id){
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->update_title([
            'title' => $title,
            'thread_id' => $thread_id
        ]);
    }

    public function delete($thread_id){
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->delete(['thread_id' => $thread_id]);
    }

    public function update_category($category, $thread_id){
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->update_category([
            'category' => $category,
            'thread_id' => $thread_id
          ]);
    }

    public function update_flag_reflect($flag_reflect, $thread_id){
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->update_flag_reflect([
            'flag_reflect' => $flag_reflect,
            'thread_id' => $thread_id
        ]);
    }

    public function update_num_post($num_post, $thread_id){
        $threadModel = new \MyApp\Model\Thread();
        $threadModel->update_num_post([
                'num_post' => $num_post,
                'thread_id' => $thread_id
        ]);
    }

}