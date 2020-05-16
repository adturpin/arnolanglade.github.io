<?php foreach ($postNames as $postName) :?>
<div class="col-md-6 col-sm-6 portfolio-item text-center">
    <a href="/blog/build/<?php echo $postName?>.hmlt">
        <img src="img/<?php echo $postName?>.svg" width="95%">
        <h4><?php echo $postName?></h4>
    </a>
</div>
<?php endforeach;?>