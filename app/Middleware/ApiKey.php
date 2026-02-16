<?php
namespace App\Middleware;

use Core\Http\Response;

class ApiKey {
    public function handle() {
        $teste = true;
        if ($teste) {
            return $this;
        } else {
            (new Response())->json([
                'message' => 'nao passou'
            ])->send();
        }
        
    }
}