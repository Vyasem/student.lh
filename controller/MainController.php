<?php
namespace controller;

use model\FormValidation;
use model\User;
use model\Search;

class MainController
{
    private $db;
    private $config;
    private $requestPage;
    private $requestLogin;
    private $requestAdd;
    private $requestEdit;
    private $itemUser;
    private $requestSearch;


    public function __construct($dbObejct, $config)
    {
        $this->db = $dbObejct;
        $this->config = $config;
        $this->requestPage = $_GET['page'];
        $this->requestLogin = $_POST['LOGIN'];
        $this->requestAdd = $_POST['ADD'];
        $this->requestEdit = $_POST['EDIT'];
        $this->requestSearch = $_GET['query'];
    }

    public function pageDefine()
    {
        //определяем имя страницы
        $page = $this->pageName();
        //Заголовок страницы и браузера. Находиться в файле конфигурации
        $title = $this->config['pages'][$page]['title'];
        $header = $this->config['pages'][$page]['header'];
        $checkUser = array();

        //Вход пользователя либо поиск в COOCIES или в SESSION
        if(!empty($this->requestLogin))
        {
            $checkUser = $this->checkUser($this->requestLogin);
        }
        else if($_SESSION['auth']|| $_COOKIE['auth'] == 1)
        {
            $this->itemUser = $this->itemUser();
            $data['item_user'] = $this->itemUser;
            $checkUser = [$this->itemUser['0']['name'], $this->itemUser['0']['surname']];
        }

        //Выход пользователя
        if($page == 'logout')
        {
            unset($_SESSION['lgusrit']);
            unset($_GET['page']);
            $_SESSION['auth'] = false;
            if($_COOKIE['auth'] == 1)
            {
                setcookie('lgusrit', '', time()-1);
                setcookie('auth', true, time()-1);
            }
            header('Location:/');
            exit;
        }

        //определяем какое действие нужно выполнить на странице
        $data[0] = $this->defineAction();
        //Поля формы
        $data['fields'] = $this->config['formFields'];
        //Поделючение шаблона сайта и страницы
        echo $this->includeTemplate("views/pages/$page.php","views/tamplate/{$this->config['template']}.php", $title, $header, $data, $checkUser);
    }

    private function pageName()
    {
        if(empty($this->requestPage))
            return 'main';
        else
            return $this->requestPage;
    }

    private function defineAction()
    {
        if(!empty($this->requestAdd))
        {
            return $this->validData($this->requestAdd);
        }
        else if(!empty($this->requestEdit))
        {
            return $this->validData($this->requestEdit, true);
        }
        else if(!empty($this->requestSearch))
        {
            $query = $this->requestSearch;
            $objSearch = new Search($this->db, $query);
            $startRow = $this->defineStartRow();
             return $objSearch->getSearch($startRow);
        }
        else
        {
            $startRow = $this->defineStartRow();
            return $this->getUsers($startRow);
        }
    }


    private function defineStartRow()
    {
        if(isset($_REQUEST['page_nb']) && $_REQUEST['page_nb'] > 1)
        {
            return $_REQUEST['page_nb'] * 2 - 2;
        }
        else
        {
            return 0;
        }

    }

    public function validData($data, $edit = false)
    {


        $formValidObj = new FormValidation($data, $this->config['formFields'], $this->config['validationRules']);
        $formValid = $formValidObj->checkData($edit);
        if($formValid === true)
        {
            $userObj = new User($this->db, $data);
            $resCheck = $userObj->checkUnicum();

            if($edit)
            {
                $res = $userObj->editUser($this->itemUser);
                if($res == 1)
                {
                    unset($_POST['EDIT']);
                    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    header('Location:'.$url);
                }
                else
                {
                    return $_POST['EDIT'];
                }
            }

            if($resCheck['LOGIN'] == false && $resCheck['EMAIL'] == false)
            {
                $res = $userObj->addUser();
                if($res == true)
                    unset($_POST['ADD']);

            }
            else
            {
                foreach($resCheck as $key => $val)
                {
                    if(!empty($val))
                    {
                        $res[strtolower($key) . '_group']['TEXT'] = "Такой " . $this->config['formFields'][$key] . " уже существует!";
                        $res[strtolower($key) . '_group']['STATUS'] = "is-invalid";
                    }

                }
                return $res;
            }

            return array();
        }
        else
        {
            return $formValid;
        }

    }

    public function checkUser($data)
    {
        $check = false;
        $userObj = new User($this->db, $data);
        $checkRes = $userObj->checkUser();
        foreach($checkRes as $key => $val)
        {
            if($val == false)
            {
                $res[strtolower($key) . '_login']['TEXT'] = "Не верный " . $this->config['formFields'][$key];
                $res[strtolower($key) . '_login']['STATUS'] = "is-invalid";
            }

        }

        if(empty($res))
        {
            $res = array();
            if($checkRes['LOGIN'] === true && $checkRes['LOGIN'] == true)
                $check = true;

            if($check)
            {
                if(isset($this->requestLogin['REMEMBER']) && $this->requestLogin['REMEMBER'] == 'Y')
                {
                    setcookie('lgusrit', $data['LOGIN'], time()+2592000);
                    setcookie('auth', true, time()+2592000);
                    header('Location: /');
                    exit;
                }
                else if(empty($_SESSION['lgusrit']))
                {
                    $_SESSION['lgusrit'] = $data['LOGIN'];
                    $_SESSION['auth'] = true;
                }
            }
        }
        return $res;
    }

    private function itemUser()
    {
        $userObj = new User($this->db);
        return $userObj->getUser();
    }

    private function getUsers()
    {
        $startRow = 0;
        if(!empty($_REQUEST['page_nb']) && $_REQUEST['page_nb'] != 1)
            $startRow = $this->defineStartRow();

        $userObj = new User($this->db);
        return $userObj->getUsers($startRow);
    }

    //подключение шаблона сайта и шаблона страницы
    private function includeTemplate($pageName, $templateName, $title, $header = '', $content = array(), $additional = array())
    {
        $pageContent = $this->viewInclude($pageName, $content);
        return $this->viewInclude($templateName, array('title' => $title, 'header' => $header, 'content' => $pageContent, 'additional' => $additional));
    }

    private function viewInclude($file, $data = array(), $additional = array())
    {
        if(!empty($data))
        {
            foreach($data as $key => $val)
            {
                $$key = $val;
            }
        }

        ob_start();
        include($file);
        return ob_get_clean();
    }
}