<?php
// класс абстрактный, чтобы нельзя было создать экземпляр
abstract class BaseController {

    public PDO $pdo; // добавил поле
    public array $params; // добавил поле
    
    public function setPDO(PDO $pdo) { // и сеттер для него
        $this->pdo = $pdo;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    // так как все вертится вокруг данных, то заведем функцию,
    // которая будет возвращать контекст с данными
    public function getContext(): array {
        return []; // по умолчанию пустой контекст
    }
    
    // с помощью функции get будет вызывать непосредственно рендеринг
    // так как рендерить необязательно twig шаблоны, а можно, например, всякий json
    // то метод сделаем абстрактным, ну типа кто наследуем BaseController
    // тот обязан переопределить этот метод
    //abstract public function get();

    public function process_response() {
        if (session_status() == PHP_SESSION_NONE) {
            // Сессия не активна, запускаем её
            session_start();
            
            // Устанавливаем параметры cookie сессии (если необходимо)
            // session_set_cookie_params(60 * 60* 10);
        }elseif (session_status() === PHP_SESSION_DISABLED) {
            session_set_cookie_params(60 * 60* 10);
            session_start();
        } 
        else {
            // Сессия уже активна, ничего делать не нужно
        }
        
        
        
        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } else if ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }

    public function get(array $context) {} 
    public function post(array $context) {}
}