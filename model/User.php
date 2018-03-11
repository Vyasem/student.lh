<?php
namespace model;

class User
{
    protected $db;
    protected $arCheckReturn = array();
    protected $arForm = array();

    public function __construct($db, $arForm = array())
    {
        $this->arForm = $arForm;
        $this->db = $db;
    }

    public function addUser()
    {
        $passHash = $this->passwordPrepare($this->arForm['PASS']);
        $unUserId = $this->arForm['LOGIN'] . strstr($this->arForm['EMAIL'], '@', true);
        $prepareQuery = $this->db->prepare("INSERT INTO user_list(name,surname,sex,group_name,email,test_score,
                                            birth_year,visa,phone,comment,user) VALUES(:name,:surname,:sex,:group_name,
                                            :email,:test_score,:birth_year,:visa,:phone,:comment,:user)");
        $executeQuery[] = $prepareQuery->execute(
                            array(
                                ':name' => $this->arForm['NAME'],
                                ':surname' => $this->arForm['SURNAME'],
                                ':sex' => $this->arForm['SEX'],
                                ':group_name' => $this->arForm['FACULTY'],
                                ':email' => $this->arForm['EMAIL'],
                                ':test_score' => $this->arForm['SCORE'],
                                ':birth_year' => $this->arForm['YEAR'],
                                ':visa' => $this->arForm['VISA'],
                                ':phone' => $this->arForm['PHONE'],
                                ':comment' => $this->arForm['COMMENT'],
                                ':user' => $unUserId
                            ));
       $prepareQuery = $this->db->prepare("INSERT INTO user(login, password, user_list) VALUES (:login,:password,:user_list)");
       $executeQuery[] = $prepareQuery->execute(array(':login' => $this->arForm['LOGIN'], ':password' => $passHash, ':user_list' => $unUserId));

        if($executeQuery[0] == true && $executeQuery[1] == true)
            return true;
        else
            return false;
    }

    public function editUser($startData)
    {
        $checkLogin = true;
        $checkEmail = true;

        if($startData[0]['login'] !== $this->arForm['LOGIN'])
        {
            $checkLogin = $this->checkLogin($this->arForm['LOGIN']);
        }

        if($startData[0]['email'] !== $this->arForm['EMAIL'])
        {
            $checkEmail = $this->checkEmail($this->arForm['EMAIL']);
        }

        if($checkLogin && $checkEmail)
        {

            $passQuery='';
            $arExecute = array(
                ':name' => $this->arForm['NAME'],
                ':surname' => $this->arForm['SURNAME'],
                ':sex' => $this->arForm['SEX'],
                ':group_name' => $this->arForm['FACULTY'],
                ':email' => $this->arForm['EMAIL'],
                ':test_score' => $this->arForm['SCORE'],
                ':birth_year' => $this->arForm['YEAR'],
                ':visa' => $this->arForm['VISA'],
                ':phone' => $this->arForm['PHONE'],
                ':comment' => $this->arForm['COMMENT'],
                ':login'=> $this->arForm['LOGIN'],
                ':user' => $startData[0]['user_list']
            );
            if(!empty($this->arForm['PASS']))
            {
                $passHash = $this->passwordPrepare($this->arForm['PASS']);
                $passQuery = ',l.password=:password';
                $arExecute[':password']=$passHash;

            }

            $prepareQuery = $this->db->prepare("UPDATE user_list u,user l SET u.name=:name,u.surname=:surname,u.sex=:sex,u.group_name=:group_name,
                                            u.email=:email,u.test_score=:test_score,u.birth_year=:birth_year,u.visa=:visa,u.phone=:phone,
                                            u.comment=:comment,l.login=:login$passQuery WHERE u.user=:user AND l.user_list=:user");
            return $prepareQuery->execute($arExecute);

        }

    }

    public function checkUser()
    {
        $login = $this->arForm["LOGIN"];
        $password = $this->arForm["PASS"];
        $prQuery = $this->db->prepare("SELECT * FROM user WHERE login=:login");
        $prQuery->execute(array(':login' => $login));
        $result = $prQuery->fetchAll();

        if(!empty($result))
        {
            $this->arCheckReturn['LOGIN'] = true;
            $chPs = $this->checkPassword($password, $result[0]['password']);

            if($chPs)
                $this->arCheckReturn['PASS'] = true;
            else
                $this->arCheckReturn['PASS'] = false;
        }
        else
        {
            $this->arCheckReturn['LOGIN'] = false;
        }
        return $this->arCheckReturn;

    }

    public function getUser()
    {

        if($_COOKIE['auth'] == 1)
            $login = $_COOKIE['lgusrit'];
        else
            $login = $_SESSION['lgusrit'];

        $db = $this->db;
        $prQuery = $this->db->prepare("SELECT login,user_list,name,surname,sex,group_name,email,test_score,birth_year,visa,phone,comment  FROM user INNER JOIN user_list ON user_list.user=user.user_list WHERE login=:login");
        $prQuery->execute(array(':login' => $login));
        $result = $prQuery->fetchAll($db::FETCH_ASSOC);
        return $result;
    }

    public function getUsers($startRow)
    {
        $db = $this->db;
        //Количество результатов на странице
        $rowCount = 2;
        //Количество страниц
        $count = $this->rowCount();
        $result['count'] = ceil($count / $rowCount);
        $prQuery =$db->prepare("SELECT name,surname,sex,group_name,email,test_score,birth_year,visa,phone,comment FROM user_list LIMIT $startRow, $rowCount");
        $prQuery->execute();
        $result['result'] = $prQuery->fetchAll();

        $result['link'] = $this->pagination($result['count']);
        return $result;
    }

    private function pagination($elCount)
    {
        for($i = 1; $i <= $elCount; $i++)
        {
            $link = "/?page_nb=";
        }

        return $link;

    }

    private function rowCount()
    {
        $db = $this->db;
        $countQuery = $db->prepare("SELECT COUNT(*) FROM user_list");
        $countQuery->execute();
        $count = $countQuery->fetchAll($db::FETCH_NUM);

        return $count[0][0];
    }

    public function checkUnicum()
    {
        $login = $this->arForm["LOGIN"];
        $email = $this->arForm["EMAIL"];

        $prQuery = $this->db->prepare("SELECT * FROM user WHERE login=:login");
        $prQuery->execute(array(':login' => $login));
        $this->arCheckReturn['LOGIN'] = $prQuery->fetchAll();

        $prQuery = $this->db->prepare("SELECT * FROM user_list WHERE email=:email");
        $prQuery->execute(array(':email' => $email));
        $this->arCheckReturn['EMAIL'] = $prQuery->fetchAll();
        return $this->arCheckReturn;

    }

    private function checkLogin($login)
    {
        $prQuery = $this->db->prepare("SELECT id FROM user WHERE login=:login");
        $prQuery->execute(array(':login' => $login));
        $res = $prQuery->fetchAll();

        if(empty($res))
            return true;
        else
            return false;
    }

    private function checkEmail($email)
    {
        $prQuery = $this->db->prepare("SELECT id FROM user_list WHERE email=:email");
        $prQuery->execute(array(':email' => $email));
        $res = $prQuery->fetchAll();
        if(empty($res))
            return true;
        else
            return false;
    }

    private function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    private function passwordPrepare($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT);
    }


}