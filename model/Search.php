<?php
namespace model;

class Search
{
    private $db;
    private $query;
    public function __construct($db, $query)
    {
        $this->db = $db;
        $this->query = $query;
    }

    public function getSearch($startRow = 0)
    {
        $db =  $this->db;
        //Количество результатов на странице
        $rowCount = 2;
        //Количество страниц
        $count = $this->searchCount();
        $result['count'] = ceil($count / $rowCount);

        $prepare = $db->prepare("SELECT name,surname,group_name,test_score FROM user_list WHERE MATCH (name, surname, 
                                sex, group_name, test_score, birth_year, phone, comment) AGAINST (:query IN BOOLEAN MODE) LIMIT $startRow, $rowCount");
        $prepare->execute(array(':query' => $this->query.'*'));
        $result['result'] = $prepare->fetchAll();

        $result['link'] = $this->pagination($result['count']);

        return $result;
    }

    private function searchCount()
    {
        $db = $this->db;
        $countQuery = $db->prepare("SELECT COUNT(*) FROM user_list WHERE MATCH (name, surname, 
                                sex, group_name, test_score, birth_year, phone, comment) AGAINST (:query IN BOOLEAN MODE)");
        $countQuery->execute(array(':query' => $this->query.'*'));
        $count = $countQuery->fetchAll();
        return $count[0][0];
    }

    //формирование ссылки для постраничной навигации
    private function pagination($elCount)
    {
        for($i = 1; $i <= $elCount; $i++)
        {
            $link = "/?query=$this->query&page_nb=";
        }

        return $link;

    }
}