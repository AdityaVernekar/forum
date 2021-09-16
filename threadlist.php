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
    #ques {
        min-height: 433px;
    }
    </style>

    <title>iDiscuss- Coding Forums</title>
</head>

<body>
    <!-- <h1>iDiscuss- Coding Forums</h1> -->
    <?php include 'partials/_dbconnect.php'; 
    include 'partials/_header.php';
        ?>
    <?php
     $id = $_GET['catid'];
     $sql = "SELECT * FROM `categories` WHERE category_id=$id;";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
              $catname = $row['category_name'];
              $catdesc = $row['category_description'];
            }
     ?>

    <?php
     $showAlert = false;
     $method = $_SERVER['REQUEST_METHOD'];
      if($method=='POST'){
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $th_title = str_replace("<", "&lt;", $comment);
        $th_title = str_replace(">", "&gt;", $comment);

        $th_desc = str_replace("<","&lt;", $comment );
        $th_desc = str_replace(">","&gt;", $comment );
        
        $sql = "INSERT INTO `thread` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your Thread has been added.Please wait for community to respond.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }

      }
     ?>


    <div class="container my-5">
        <div class="jumbotron my-4">
            <h1 class="display-4">Welcome to <?php echo $catname;?> Forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums,
                Do not post copyright-infringing material,
                Do not post “offensive” posts, links or images,Do not cross post questions,
                Do not PM users asking for help,
                Remain respectful of other members at all times.....</p>
            <p class="lead">

            </p>
        </div>

    </div>
    <?php
    if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
        echo '<div class="container">
        <h2 class="text-left">Start a Discussion</h2>
        <form action=" '.$_SERVER['REQUEST_URI'].'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short as posssible.</div>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc"></textarea>
                <label for="floatingTextarea">Elaborate your concern</label>
            </div>
            <button type="submit" class="btn btn-success my-2">Submit</button>
        </form>

    </div>';
    }
    else{
        echo 
        '<div class="container">
        <h2 class="text-left">Start a Discussion</h2>
        <p class="lead">You are not logged in to start a discussion</p>
        </div>';
    }
    ?>
    
    <div class="container my-3" id="ques">
        <h1>Browse Questions</h1>
        <?php
     $id = $_GET['catid'];
     $sql = "SELECT * FROM `thread` WHERE thread_cat_id =$id;";
            $result = mysqli_query($conn,$sql);
            $noresult=true;
            while($row = mysqli_fetch_assoc($result)){
              $noresult=false;
              $id = $row['thread_id'];
              $title = $row['thread_title'];
              $desc = $row['thread_desc'];
              $thread_time = $row['timestamp'];
              $thread_user_id=$row['thread_user_id'];
              $sql2="SELECT user_email FROM `users` WHERE sno ='$thread_user_id' ";
              $result2 = mysqli_query($conn,$sql2);
              $row2 = mysqli_fetch_assoc($result2);

              echo '<div class="media my-4" style="display:flex">
              <img class="align-self-start mr-3" width="40px" src="img/user3.png" alt="Generic placeholder image">
              <div class="media-body mx-4">
                  <h5 class="mt-0 "><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                  '.$desc.'<p class="text-right my-0">Asked By: <b>'.$row2['user_email'].' at '.$thread_time.'</b></p>
              </div>
              
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