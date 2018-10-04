<?php
require "includes/config.php";

$commentAdded = false;
$form_name = '';
$form_nickname = '';
$form_email = '';
$form_text = '';


if( isset($_POST['do_post']) ) {
  $errors = array();

  if ( !isset($_POST['name']) || trim($_POST['name']) == '') {
    $errors[] = 'Введите имя!';
  } else {
    $form_name = $_POST['name'];
  };

  if ( !isset($_POST['nickname']) || trim($_POST['nickname']) == '') {
    $errors[] = 'Введите ваш nickname!';
  } else {
    $form_nickname = $_POST['nickname'];
  };

  if ( !isset($_POST['email']) || trim($_POST['email']) == '') {
    $errors[] = 'Введите вашу почту!';
  } else {
    $form_email = $_POST['email'];
  };

  if ( !isset($_POST['text']) || trim($_POST['text']) == '') {
    $errors[] = 'Введите текст комментария!';
  } else {
    $form_text = $_POST['text'];
  };

  if( empty($errors) ) {
    mysqli_query(
      $connection, 
      "INSERT INTO `comments` 
      (`author`, `nickname`, `email`, `text`, `articles_id`) 
      VALUES 
      ('$form_name',
      '$form_nickname',
      '$form_email',
      '$form_text',
      " . (int) $_GET['id'] . ")");
    $form_name = '';
    $form_nickname = '';
    $form_email = '';
    $form_text = '';
  };
};
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "./includes/head.php";
?>
<body>

  <div id="wrapper">

     <?php include "includes/header.php";
     
      $articleSQL = mysqli_query($connection, 'SELECT * FROM `articles` WHERE `_id` = ' . (int) $_GET['id']);

      if( mysqli_num_rows($articleSQL) <= 0) {
        ?>
          <div id="content">
            <div class="container">
              <div class="row">
                <section class="content__left col-md-8">
                  <div class="block">
                    <h3>Статья не найдена</h3>
                    <div class="block__content">
                      <div class="full-text">
                      </div>
                    </div>
                  </div>
              
                </section>
                <section class="content__right col-md-4">
                  <?php include "../includes/sidebar.php"?>
                </section>
              </div>
            </div>
          </div>

        <?php
      } else {
        $article = mysqli_fetch_assoc($articleSQL);
        mysqli_query($connection, 'UPDATE `articles` SET `views` = `views` + 1 WHERE `_id` = ' . (int) $_GET['id']);
        
        ?>
          <div id="content">
            <div class="container">
              <div class="row">
                <section class="content__left col-md-8">
                  <div class="block">
                    <a><?php echo $article['views']; ?> просмотров.</a>
                    <h3><?php echo $article['title']; ?></h3>
                    <div class="block__content">
                      <img src="/static/images/<?php echo $article['image']; ?>" alt="<?php echo $article['image']; ?>">
                      <div class="full-text">
                        <?php echo $article['text']; ?>
                      </div>
                    </div>
                  </div>

                  <div class="block">
                    <a href="#comments-add-form">Добавить свой</a>
                    <h3>Комментарии</h3>
                    <div class="block__content">
                      <div class="articles articles__vertical">

                        <?php 
                          $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $_GET['id'] . " ORDER BY `_id` DESC");

                          if( mysqli_num_rows($comments) <= 0) {
                            echo "Нет комментариев";
                          }
                          while( $comment = mysqli_fetch_assoc($comments)) {
                            ?>
                            <article class="article">
                              <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email'])?>?s=125);"></div>
                              <div class="article__info">
                                <a href="/article.php?id=<?php echo $comment['articles_id']?>"><?php echo $comment['author']?></a>
                                <div class="article__info__meta">
                          </div>
                                <div class="article__info__preview"><?php echo $comment['text'] ?></div>
                              </div>
                            </article>
                            <?php
                          }
                        ?>

                      </div>
                    </div>
                  </div>

                  <div id="comments-add-form" class="block">
                      <h3>Добавить комментарий</h3>
                        <div class="block__content">
                          <form class="form" method="POST" action="/article.php?id=<?php echo $_GET['id']?>#comments-add-form" >
                            <?php 
                              if( isset($_POST['do_post']) ) {
                                

                                if( empty($errors) ) {
                                  echo '<span style="color:green; font-weight:bold;"> Комментарий успешно добавлен.<hr>' . '</span>';

                                } else {
                                  echo '<span style="color:red; font-weight:bold;">' . $errors[0] . '<hr>' . '</span>';
                                }
                              }
                            ?>
                            <div class="form__group">
                              <div class="row">
                                <div class="col-md-4">
                                  <input type="text" class="form__control" required name="name" placeholder="Имя" value="<?php echo $form_name?>">
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form__control" required name="nickname" placeholder="Никнейм" value="<?php echo $form_nickname?>">
                                </div>
                                <div class="col-md-4">
                                  <input type="text" class="form__control" required name="email" placeholder="Почта (отображаться не будет)" value="<?php echo $form_email?>">
                                </div>
                              </div>
                            </div>
                            <div class="form__group">
                              <textarea name="text" required="" class="form__control" placeholder="Текст комментария ..."> <?php echo $form_text?> </textarea>
                            </div>
                            <div class="form__group">
                              <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
                            </div>
                          </form>
                        </div>
                    </div>
                </section>
                <section class="content__right col-md-4">
                  <?php include "includes/sidebar.php"?>
                </section>
              </div>
            </div>
          </div>
        <?php
      }
     ?>
    <?php include 'includes/footer.php' ?>

  </div>

</body>
</html>