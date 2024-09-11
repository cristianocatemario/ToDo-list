<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo-list</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-dark">
  <div class="container text-light" style="margin-top: 2%; height: 11%;">
    <?php
      $host = "localhost";
      $username = "cate";
      $password = "admin";
      $db_nome = "todo";

      $conn = new mysqli($host, $username, $password, $db_nome);

      if ($conn->connect_errno) {
        echo "Impossibile connettersi al server: " . $conn->connect_error . "\n";
        exit;
      }
    ?>

    <div class="row">
      <div class="col-2">
      </div>

      <div class="col-3 bg-warning" style="padding-bottom: 15px;">
        <h1 class="text-center text-dark">Lists</h1>
          <ul class="list-group"name="list">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">              
              <?php
                $sql = "SELECT nome, id FROM lista";
                $result = $conn->query($sql);
                $lists = $result;
                
                $list_class = "\"list-group-item list-group-item-action\"";

                while ($lists = $result->fetch_assoc()) { //mostra il nome delle liste nel db 
                  echo "<input type=\"button\" name=\"list_name\" id=\"listName\" class={$list_class} data-bs-toggle=\"list\" value=\"{$lists['nome']}\"></input>";
                }
              ?>
            </form>
          </ul>

          <button type="button" class="btn bg-black text-light" data-bs-toggle="modal" data-bs-target="#modalCreateList" style="margin-top: 10px; float: center" name="create_list">Create new list</button>
          
          <!-- Modal -->
          <div class="modal fade text-black" id="modalCreateList" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-3" id="exampleModalLabel">Create new list</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <p style="text-align:center;">Insert data for the creation of a new To-Do list</p>
                    <label for="list_name" class="form-label">List name</label>
                    <input type="text" class="form-control" id="InputListName" required>
                    
                    <label for="task_name" class="form-label">Tasks</label>
                    <input type="text" class="form-control" id="inputTaskName">
                    
                    <input type="submit" name="addTask" class="btn btn-primary" value="+ Add Task" style="margin-top: 2%;"></input>
                  </form>

                  <?php
                    if(isset($_POST["addTask"])){
                      echo "<input type=\"text\" class=\"form-control\" id=\"inputTaskName\">";
                    }
                  ?>

                </div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">Create list</button>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="col-6 bg-black">
        <h1 class="text-center">Tasks</h1>
        <div class="container text-left">
          <ul class="list-group">
            <?php
              $sql = "SELECT nome, idLista FROM tasks WHERE tasks.idLista = 1";
              $result = $conn->query($sql);
              $tasks = $result ;              
              
              while ($tasks = $result->fetch_assoc()) { //show tasks
                if ($tasks['idLista'] == 1){ //1 = idListaSelezionata, modificare prendendo l'id della lista con le task da visualizzare
                  echo "<li class=\"list-group-item\">
                          <input type=\"checkbox\" name=\"state\" id=\"state\" style=\"float: right; padding-top: 10px; height: 20px; width: 20px; margin: 5px 5px;\">{$tasks['nome']}</input>  
                        </li>";
                }
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>