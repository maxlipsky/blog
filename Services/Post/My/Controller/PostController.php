<?php

namespace My\Controller;

use My\Engine\Response;
use My\Engine\Storage;
use My\Engine\Request;
use My\Model\Post;

class PostController {

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Request
     */
    private $request;
    
    public function __construct()
    {
        $this->response = Storage::get('Response');
        $this->request = Storage::get('Request');
    }

    public function all()
    {
        $posts = Post::all();
        return $this->response->json($posts);
    }

    public function get()
    {
        $post_id = $this->request->getIntParam('id');
        $post = Post::find($post_id);
        return $this->response->json($post);
    }

    public function add()
    {
        if (!empty($this->request->post['token'])) {
            $token = $this->request->post['token'];
            $post_id = Post::add($this->request->post);
            return $this->response->json([
                'post_id' => $post_id
            ]);
        } else {
            throw new \Exception('Token not set');    
        }
    }
}