<?php
namespace Core\Http;

use Core\Helper\TwigSingleton;

class Response {

    private string $type = 'html';
    private string $view;
    private array $data = [];
    private int $status_code = 200;

    public function view(string $view, array $data) {
        $this->type = 'html';
        $this->view = $view;
        $this->data = $data;
        return $this;
    }
    public function json(array $data) {
        $this->type = 'json';
        $this->data = $data;
        return $this;
    }

    public function status(int $code) {
        $this->status_code = $code;
        return $this;
    }

    public function redirect(string $url) {
        header("Location: $url");
        exit;
    }

    public function send() {
        http_response_code($this->status_code);
        if($this->type === 'json') {
            header("Content-Type: application/json");
            echo json_encode($this->data);
            exit;
        } else {
            $twig = TwigSingleton::getInstance()->getEnvironment();
            echo $twig->render($this->view, $this->data);
        }
    }
}