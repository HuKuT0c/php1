<?php

require_once "BaseController.php"; // обязательно импортим BaseController

class TwigBaseController extends BaseController {
    public $title = ""; // название страницы
    public $template = ""; // шаблон страницы
    protected $context = [];
    protected \Twig\Environment $twig; // ссылка на экземпляр twig, для рендернига

  
    public function setTwig($twig) {
        $this->twig = $twig;
    }
    

    public function getContext() : array
    {
        $query = $this->pdo->query("SELECT * FROM space_objects");
        $this->context['space_objects'] = $query->fetchAll();
        $this->context["title"] = $this->title;  
       
        return $this->context;
    }


    public function setContext($name, $value)
    {
      $this->context[$name] = $value;
    }
    // функция гет, рендерит результат используя $template в качестве шаблона
    // и вызывает функцию getContext для формирования словаря контекста
    public function get(array $context) { // добавил аргумент в get
        echo $this->twig->render($this->template, $context); // а тут поменяем getContext на просто $context
    }
} 