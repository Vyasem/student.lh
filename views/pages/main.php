<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Факультет</th>
        <th scope="col">Средний бал успеваемости</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($data[0]['result'] as $key => $val){?>
            <tr>
                <th scope="row"><?=$key+1?></th>
                <td><?=$val['name']?></td>
                <td><?=$val['surname']?></td>
                <td><?=$val['group_name']?></td>
                <td><?=$val['test_score']?></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<pre>
<?php // var_dump($_SERVER)?>
</pre>
<?php if($data[0]['count'] > 1){?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if(!empty($_REQUEST['page_nb']) && $_REQUEST['page_nb'] != 1){?>
                <li class="page-item"><a class="page-link" href="<?=$data[0]['link'].($_REQUEST['page_nb']-1)?>">Previous</a></li>
            <?php }?>
            <?php for($i = 1; $i <= $data[0]['count']; $i++){?>
                <li class="page-item"><a class="page-link" href="<?=$data[0]['link'].$i?>"><?=$i?></a></li>
            <?php }?>
            <?php if($_REQUEST['page_nb'] != $data[0]['count']){?>
                <li class="page-item"><a class="page-link" href="<?=$data[0]['link'].($_REQUEST['page_nb']+1)?>"">Next</a></li>
            <?php }?>
        </ul>
    </nav>
<?php }?>