
<!-- Style sheet for page -->
	<link rel="stylesheet" type="text/css" href="/css/style.css" />


	<!-- describe the funtion -->
	<h2> Here are the posts you are following </h2>
	<br><br>


	<!--run through the posts -->
	<?php foreach($posts as $post): ?>

		<article>

		    <h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1> <br><br>

		    <p><?=$post['content']?></p><br><br>

		    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
		        <?=Time::display($post['created'])?>
		    </time>

		</article>

	<?php endforeach; ?>