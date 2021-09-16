<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <style>
            #ques{
                min-height:433px;
            }
        </style>

    <title>iDiscuss- Coding Forums</title>
</head>

<body>
    <!-- <h1>iDiscuss- Coding Forums</h1> -->
    <?php  include 'partials/_dbconnect.php';
    include 'partials/_header.php';
       ?>
    <?php
     $id = $_GET['threadid'];
     $sql = "SELECT * FROM `thread` WHERE thread_id=$id";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
              $title = $row['thread_title'];
              $desc = $row['thread_desc'];
              $thread_user_id=$row['thread_user_id'];
              $sql2="SELECT user_email FROM `users` WHERE sno ='$thread_user_id' ";
              $result2 = mysqli_query($conn,$sql2);
              $row2 = mysqli_fetch_assoc($result2);
              $postedby= $row2['user_email'];
            }
     ?>
     <?php
     $showAlert = false;
     $method = $_SERVER['REQUEST_METHOD'];
      if($method=='POST'){
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp());";
        $result = mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your Comment has been added!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }

      }
     ?>


    <div class="container my-5">
        <div class="jumbotron my-4">
            <h2 class="display-5"><?php echo $title;?></h2>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p style="font-size: small;">This is a peer to peer Forum.No Spam / Advertising / Self-promote in the forums,
                Do not post copyright-infringing material,
                Do not post “offensive” posts, links or images,Do not cross post questions,
                Do not PM users asking for help,
                Remain respectful of other members at all times.....</p>
            <p class="lead">
                Posted by: <b><?php echo $postedby;?></b>
            </p>
        </div>

        <?php
    if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
        echo '</div>
        <div class="container">
            <h2 class="text-left">Post a Comment</h2>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment"></textarea>
                    <label for="floatingTextarea">Type Here</label>
                    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                  </div>
                <button type="submit" class="btn btn-success my-2">POST</button>
            </form>
    
        </div>';
    }
    else{
        echo 
        '<div class="container">
        <h2 class="text-left">Post a Comment</h2>
        <p class="lead my-0">You are not logged in to post a Comment</p>
        <p class="lead"><b>Login</b> to continue</p>
        <hr>
        </div>';
    }
    ?>

    

    <div class="container my-3" id="ques">
        <h2>Discussions:</h2>
        <?php
     $id = $_GET['threadid'];
     $sql = "SELECT * FROM `comments` WHERE thread_id =$id;";
            $result = mysqli_query($conn,$sql);
            $noresult=true;
            while($row = mysqli_fetch_assoc($result)){
              $id = $row['comment_id'];
              $content = $row['comment_content'];
              $comment_time=$row['comment_time'];
              $thread_user_id=$row['comment_by'];
              $sql2="SELECT user_email FROM `users` WHERE sno ='$thread_user_id' ";
              $result2 = mysqli_query($conn,$sql2);
              $row2 = mysqli_fetch_assoc($result2);

             
              $noresult=false;


              echo '<div class="media my-4" style="display:flex">
              <img class="align-self-start mr-3 row" width="40px" src="img/user3.png" alt="Generic placeholder image">
              <div class="media-body mx-4">
              
                  '.$content.'
              </div>
              <p class="font-weight-bold my-0" style="font-weight:bold" >Posted by:'.$row2['user_email'].' at '.$comment_time.'</p>
          </div>';
        
            }
            if($noresult){
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <p class="display-6">No Threads available</p>
                  <p class="lead"><b>Be the first person to start a discussion</b></p>
                </div>
              </div>';
              }
     
       

        ?>
    </div>


    <?php include "partials/_footer.php";?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->
</body>

</html>