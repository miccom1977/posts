<!DOCTYPE html> 
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title><?= $data['title'];?></title>
    </head>
    <body>
        <section>
            <?php
                echo '
                    <table  class="table table-hover table-dark">
                    <thead>
                    <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Body</th>
                    <th scope="col">Author</th>
                    </tr>
                    </thead>
                    <tbody>'
                ;
                foreach($data['posts'] as $post ){
                    echo '
                    <tr>
                        <th scope="row">'. $post->title .'</th>
                        <td>'. $post->body .'</td>
                        <td>'. $post->name .'</td>
                    </tr>';
                }
                echo '
                    </tbody></table>'
                ;
            ?>
        </section>
        <footer>
        </footer>
    </body>
</html>
