<?php

require_once "../framework/BaseMiddleware.php"; 








class LoginRequiredMiddleware extends BaseMiddleware {

    public function apply(BaseController $controller, array $context) {
        //session_start();  
        if (session_status() == PHP_SESSION_NONE) {
            // Сессия не активна, запускаем её
            session_start();
            
            // Устанавливаем параметры cookie сессии (если необходимо)
            // session_set_cookie_params(60 * 60* 10);
        }elseif (session_status() === PHP_SESSION_DISABLED) {
            session_set_cookie_params(60 * 60* 10);
            session_start();
        } 
              
        $is_logged = isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : false;
        // $redirect_url = $_SERVER['REQUEST_URI'];
        // $_SESSION['redirect_url'] =  $_SERVER['REQUEST_URI'];
        // dd($_SESSION['redirect_url']);
        if (!$is_logged) { 
                    
            header('Location: /login');    
            exit;
        }
        else
        {            
            // exit();
        }
    }
}

/*
class LoginRequiredMiddleware extends BaseMiddleware {
    public function apply(BaseController $controller, array $context) {
        // Проверяем наличие значения is_logged в сессии
        $is_logged = isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : false;

        // Если не авторизован, делаем редирект на страницу логина
        if (!$is_logged) {
            header('Refresh: 0; url=/');
            exit();
        }
        elseif($is_logged){
            header('Refresh: 0; url=/');
            exit();
        }
    }
}*/


/*
class LoginRequiredMiddleware extends BaseMiddleware
{
    public function apply(BaseController $controller, array $context)
    {
        // берем значения, которые введет пользователь
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

        // сверяем с корректными
        if (!$this->isValidCredentials($controller, $user, $password)) {
          
            header('WWW-Authenticate: Basic realm="Space objects"');
            http_response_code(401); // ну и статус 401 -- Unauthorized, то есть неавторизован
            exit; 
        }
    }

    private function isValidCredentials(BaseController $controller, $user, $password)
    {
        // Подготавливаем SQL запрос
        $sql = "SELECT * FROM users WHERE login = :login AND password = :password";
        $query = $controller->pdo->prepare($sql);
        $query->bindParam(":login", $user);
        $query->bindParam(":password", $password);
        $query->execute();

       
        return $query->rowCount() > 0;
    }
}*/