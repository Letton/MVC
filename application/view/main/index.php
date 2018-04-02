<p>Главная страница</p>
<?php foreach ($news as $key => $val) : ?>
        <h3><?php echo $val['title'];?></h3>
        <p><?php echo $val['main_description'];?></p>
        <hr>
<?php endforeach; ?>