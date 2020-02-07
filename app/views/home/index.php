
<?php if($this->model['result']):  ?>

  <?php foreach($this->model['result'] as $post):
      include(APP_FOLDER.'/views/shared/_post.php');
  endforeach; ?>

<?php endif; ?>



