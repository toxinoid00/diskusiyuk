<!DOCTYPE html>
<?php
session_start();
include("./../credentials.php");
$db = new PDO(DB_DSN, DB_USER, DB_PASS);
$user = $db->prepare("SELECT * FROM user u, discussion d WHERE u.username = :u AND u.id_user = d.id_user");
$user->bindValue(':u',$_SESSION['login_user']);
$user->execute();
$user = $user->fetch();
?>
<html lang="en">
<head>
  <title>Group Discuss</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="./../css/admin.css">
  <link rel="stylesheet" href="./../css/chat.css">
</head>
  <body>
  <?php echo "
            <script type=\"text/javascript\">
   
            localStorage.setItem('nickname',\"$_SESSION[login_user]\");
            </script>
            ";?>
    <div class="header">
       <div class="container">
          <div class="row">
             <div class="col-md-5">
                <!-- Logo -->
                <div class="logo">
                   <h1><a href="#"><?php echo $user['nick_name'];?> Group Discuss</a></h1>
                   <p><?php echo $user['name_discussion'];?></p>
                </div>
             </div>
             <div class="col-md-7">
                <div class="navbar navbar-inverse" role="banner">
                    <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                      <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                          <ul class="dropdown-menu animated fadeInUp">
                            <li><a href="../index.php">Logout</a></li>
                          </ul>
                        </li>
                      </ul>
                    </nav>
                </div>
             </div>
          </div>
       </div>
  </div>

    <div class="page-content">
      <div class="row">
      <div class="col-md-3">
        <div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="index.php" <?php if(!isset($_GET['page'])){echo 'class="active';}?>><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                    <li><a href="index.php?page=Dislike Opinion" <?php if(isset($_GET['page']) && $_GET['page']=="User"){echo 'class="active';}?>><i class="glyphicon glyphicon-ban-circle"></i>Dislike Opinion</a></li>
                    <li><a href="index.php?page=Sentiment Analysis" <?php if(isset($_GET['page']) && $_GET['page']=="Sistem"){echo 'class="active';}?>><i class="glyphicon glyphicon-stats"></i>Sentiment Analysis</a></li>
                    <li><a href="index.php?page=Irrelevant Opinion" <?php if(isset($_GET['page']) && $_GET['page']=="relevansi"){echo 'class="active';}?>><i class="glyphicon glyphicon-minus-sign"></i>Irrelevant Opinion</a></li>
                    <li><a href="../user/home.php"><i class="glyphicon glyphicon-off"></i>Close</a></li>
                </ul>
        </div>
      </div>
                <?php
                    $id_discussion_forum = $user['id_discussion_forum'];
                    if(isset($_GET['page']))
                      {
                        switch($_GET['page'])  {
                          case 'Dislike Opinion': include'monitoring.php'; break;
                          case 'Sentiment Analysis': include 'monitoring.php'; break;
                          case 'Sentiment System': include 'monitoring.php'; break;
                          case 'Irrelevant Opinion': include 'monitoring.php'; break;
                            }
                          }
                          else{
                            include 'dashboard.php';
                          }
                ?>
    </div>
    </div>
    <?php include('modal.php');?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  $(document).on("click", ".setting", function () {
    var action = $(this).attr("data-action");
    var back = $(this).attr("data-back");
    if(action == "delete"){
      document.getElementById("deletecomment").href = "./setmonitoring.php?id="+$(this).attr("data-comment")+"&&action="+action+"&&back="+back;
      $('#Delete').modal('show');
    }
    else if(action == "block"){
      document.getElementById("blockuser").href = "./setmonitoring.php?id="+$(this).attr("data-user")+"&&action="+action+"&&back="+back;
      $('#Block').modal('show');
    }
  });
  </script>
</html>
