<!DOCTYPE html>
<html>
  <head>
     <title></title>
     <meta charset="utf-8" />
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	  <!-- Bootstrap core CSS -->
	  <link href="css/bootstrap.min.css" rel="stylesheet">
	  <!-- Material Design Bootstrap -->
	  <link href="css/mdb.min.css" rel="stylesheet">
	  <!-- Your custom styles (optional) -->
	  <link href="css/style.css" rel="stylesheet">
  </head>



  <body>
    <div class='container border m-2 mx-auto'>
      <h1 class='p-2 m-2 bg-secondary text-white text-center'>Delivery</h1>

      <nav class='p-2 m-2 navbar navbar-expand-lg navbar-light bg-light'>
        <div class='collapse navbar-collapse' id='navbarNav'>
          <ul class='navbar-nav'>
            <li class='nav-item'><a class='nav-link' href='Index.php?opc=H'>Home</a></li>
            <li class='nav-item'><a class='nav-link' href='Index.php?opc=O'>Cardápio</a></li>
            <li class='nav-item'><a class='nav-link' href='Index.php?opc=R'>Restrito</a></li>
          </ul>
        </div>
      </nav>

      <?php 
        include "DB.php";

        if (isset($_GET['opc'])) {
          $opc = $_GET['opc'];
        }
        else 
          $opc = "H";


        if ($opc == "H") {      # HOME
          echo "<div class='container'>
            <div class='row'>
              <div class='col text-center'><img src='Imagens/Logo1.jpg' width=300 /></div>
              <div class='col text-center'><img src='Imagens/Logo2.jpg' width=300 /></div>
            </div>
          </div>
          <br />";
        }

        elseif ($opc == "O") {    # CARDÁPIO
          echo "<div class='p-2 btn-group' >
                  <button type='button' class='btn btn-secondary' onclick=location.replace('Index.php?opc=O&tipo=Sanduíches')>Sanduíches</button>
                  <button type='button' class='btn btn-secondary' onclick=location.replace('Index.php?opc=O&tipo=Acompanhamentos')>Acompanhamentos</button>
                  <button type='button' class='btn btn-secondary' onclick=location.replace('Index.php?opc=O&tipo=Bebidas')>Bebidas</button>
                  <button type='button' class='btn btn-secondary' onclick=location.replace('Index.php?opc=O&tipo=Sobremesas')>Sobremesas</button>
                </div>";
          
          if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            $argumentos = " WHERE TIPO = '$tipo' ";
            $tabela = funSelect("tb_produtos", "*", $argumentos );

            echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>$tipo </h5>";
            echo "<div class='container w-75'>
            <div class='row'>"; 
            for ($i = 0; $i < count($tabela); $i++) {
            echo "<div class='col text-center font-weight-bold'> 
            <span class='text-danger'> ". $tabela[$i]['NOME'] ." </span> <br /> 
            <img src='". $tabela[$i]['FOTO'] ."' width='100' /> <br /> 
            <span class='text-primary'>R$ ". number_format($tabela[$i]['VALOR'], 2, ",", ".") ." </span> 
            <br />
            </div>"; 
            }
            echo "</div>
            </div>";
            echo "<p class='m-2'><input type='submit' value='Voltar' onclick='history.go(-1)' /></p>";
          }
        }

        elseif ($opc == "R")  {     # RESTRITO
          echo "<div class='p-2 btn-group' >
                <button type='button' class='btn btn-secondary'
                onclick=location.replace('Index.php?opc=C')>Cadastrar</button>
                <button type='button' class='btn btn-secondary'
                onclick=location.replace('Index.php?opc=A')>Alterar</button>
                <button type='button' class='btn btn-secondary'
                onclick=location.replace('Index.php?opc=E')>Excluir</button>
                <button type='button' class='btn btn-secondary'
                onclick=location.replace('Index.php?opc=L')>Listar</button>
            </div>";
        }

        elseif ($opc == "C") {    # CADASTRAR
            echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>Cadastrar</h5>
              <form action='Index.php?opc=I' method='post'>
              <h5 class='text-center'> Nome: <input type='text' name='nome' size='40' maxlength='40' required /> </h5>
              <h5 class='text-center' > Tipo: 
              <select name='tipo' required >
                <option value='' disabled selected>Selecione...</option> 
                <option value='Acompanhamentos'>Acompanhamentos</option> 
                <option value='Bebidas'>Bebidas</option>
                <option value='Sanduíches'>Sanduíches</option>
                <option value='Sobremesas'>Sobremesas</option>
                </select> </h5>
              <h5 class='text-center'> Foto: <input type='text' name='foto' size='50' maxlength='50' value='Imagens/Fotos/' required /> </h5>
              <h5 class='text-center'> Valor: R$ <input type='number' name='valor' min='1' max='1000' value='0' required />,00 </h5>
                <h5 class='text-center'> <input type='submit' value='Cadastrar' /> </h5>
            </form>";
        }

        elseif ($opc == "I") {    # INCLUIR
          $nome = $_POST['nome'];
          $tipo = $_POST['tipo'];
          $foto = $_POST['foto'];
          $valor = $_POST['valor'];

          $campos = "nome, tipo, foto, valor";
          $valores = " '$nome', '$tipo', '$foto', '$valor' ";

          if ( funInsert("tb_produtos", $campos, $valores ) )
            echo "<p class='p-2 m-2 bg-info text-white'>Produto cadastrado com sucesso!</p>";
          else 
            echo "<p class='p-2 m-2 bg-warning text-white'>Erro ao cadastrar produto!</p>";

          echo "<p class='m-2'><input type='submit' value='Voltar' onclick=location.replace('Index.php?opc=R') /></p>";
        }

        elseif ($opc == "L") {    # LISTAR
          $tabela = funSelect("tb_produtos", "*", "");
          echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>Produtos Cadastrados:</h5>";
          echo "<div class='container'>
              <div class='row'>
              <div class='col text-center font-weight-bold'>Nome</div>
              <div class='col text-center font-weight-bold'>Tipo</div>
              <div class='col text-center font-weight-bold'>Valor</div>
              <div class='col text-center font-weight-bold'>Detalhes</div>
              </div>"; 
              for ($i = 0; $i < count($tabela); $i++) {
              echo "<div class='row'> 
      <div class='col text-center'> ". $tabela[$i]['NOME']." </div> 
      <div class='col text-center'> ". $tabela[$i]['TIPO']." </div> 
      <div class='col text-center'>R$ ". number_format($tabela[$i]['VALOR'], 2, ",", ".") ." </div> 
      <div class='col text-center'>
      <a href='Index.php?opc=D&id=".$tabela[$i]['ID']."'><img src='Imagens/view.png' /></a></div>
                </div>";
              }
              echo "</div>";
        }

        elseif ($opc == "D") {    # DETALHAR
          $id = $_GET['id'];
          $argumentos = " WHERE id = '$id' ";
          $tabela = funSelect("tb_produtos", "*", $argumentos);

  echo "<h5 class='p-2 m-2 bg-primary text-white text-center'> ". $tabela[0]['NOME']." </h5>
        <div class='container'>
<div class='row'> 
<div class='col text-center my-auto'>
<img src='". $tabela[0]['FOTO'] ."' width='100' /></div>
<div class='col text-center font-weight-bold my-auto'>Tipo: </div> 
<div class='col my-auto'>".$tabela[0]['TIPO']."</div>
<div class='col text-center font-weight-bold my-auto'>Valor: </div> 
<div class='col my-auto'>
R$ ". number_format($tabela[0]['VALOR'], 2, ",", ".") ." </div>
</div>
</div>";
echo "<p class='m-2'><input type='submit' value='Voltar' onclick='history.go(-1)' /></p>";
        }


        elseif ($opc == "A") {    # ALTERAR
          $tabela = funSelect("tb_produtos", "*", "");
          echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>Produtos Cadastrados:</h5>";
          echo "<div class='container'>
              <div class='row'>
              <div class='col text-center font-weight-bold'>Nome</div>
              <div class='col text-center font-weight-bold'>Tipo</div>
              <div class='col text-center font-weight-bold'>Valor</div>
              <div class='col text-center font-weight-bold'>Detalhes</div>
              </div>"; 
              for ($i = 0; $i < count($tabela); $i++) {
              echo "<div class='row'> 
      <div class='col text-center'> ". $tabela[$i]['NOME']." </div> 
      <div class='col text-center'> ". $tabela[$i]['TIPO']." </div> 
      <div class='col text-center'>R$ ". number_format($tabela[$i]['VALOR'], 2, ",", ".") ." </div> 
      <div class='col text-center'>
      <a href='Index.php?opc=M&id=".$tabela[$i]['ID']."'><img src='Imagens/modify.png' /></a></div>
                </div>";
              }
              echo "</div>";
        }

        elseif ($opc == "M") {    # MODIFICAR
		  $id = $_GET['id'];
          $argumentos = " WHERE id = '$id' ";
          $tabela = funSelect("tb_produtos", "*", $argumentos);

            echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>Atualizar</h5>
              <form action='Index.php?opc=U&id=$id' method='post'>
              <h5 class='text-center'> Nome: <input type='text' name='nome' size='40' maxlength='40' required value='". $tabela[0]['NOME'] ."' /> </h5>
              <h5 class='text-center' > Tipo: 
              <select name='tipo' required >
                <option value='". $tabela[0]['TIPO'] ."' selected>". $tabela[0]['TIPO'] ."</option> 
                <option value='Acompanhamentos'>Acompanhamentos</option> 
                <option value='Bebidas'>Bebidas</option>
                <option value='Sanduíches'>Sanduíches</option>
                <option value='Sobremesas'>Sobremesas</option>
                </select> </h5>
              <h5 class='text-center'> Foto: <input type='text' name='foto' size='50' maxlength='50' value='". $tabela[0]['FOTO'] ."' required /> </h5>
              <h5 class='text-center'> Valor: R$ <input type='number'
            name='valor' min='1' max='1000' value='". $tabela[0]['VALOR'] ."' required />,00 </h5>
                <h5 class='text-center'> <input type='submit' value='Atualizar' /> </h5>
            </form>";
        }


        elseif ($opc == "U") {    # UPDATE
          $id = $_GET['id'];
          	
          $nome = $_POST['nome'];
          $tipo = $_POST['tipo'];
          $foto = $_POST['foto'];
          $valor = $_POST['valor'];

          $alteracoes = " NOME = '$nome',
          				  TIPO = '$tipo',
          				  FOTO = '$foto',
          				  VALOR = '$valor' ";
          $argumentos = " WHERE ID = '$id' ";

          if ( funUpdate("tb_produtos", $alteracoes, $argumentos ) )
            echo "<p class='p-2 m-2 bg-info text-white'>Produto alterado com sucesso!</p>";
          else 
            echo "<p class='p-2 m-2 bg-warning text-white'>Erro ao alterar produto!</p>";

          echo "<p class='m-2'><input type='submit' value='Voltar' onclick=location.replace('Index.php?opc=R') /></p>";
        }

        elseif ($opc == "E") {    # EXCLUIR
          $tabela = funSelect("tb_produtos", "*", "");
          echo "<h5 class='p-2 m-2 bg-secondary text-white text-center'>Produtos Cadastrados:</h5>";
          echo "<div class='container'>
              <div class='row'>
              <div class='col text-center font-weight-bold'>Nome</div>
              <div class='col text-center font-weight-bold'>Tipo</div>
              <div class='col text-center font-weight-bold'>Valor</div>
              <div class='col text-center font-weight-bold'>Detalhes</div>
              </div>"; 
              for ($i = 0; $i < count($tabela); $i++) {
              echo "<div class='row'> 
      <div class='col text-center'> ". $tabela[$i]['NOME']." </div> 
      <div class='col text-center'> ". $tabela[$i]['TIPO']." </div> 
      <div class='col text-center'>R$ ". number_format($tabela[$i]['VALOR'], 2, ",", ".") ." </div> 
      <div class='col text-center'>
      <a href='Index.php?opc=X&id=".$tabela[$i]['ID']."'><img src='Imagens/erase.png' /></a></div>
                </div>";
              }
              echo "</div>";
        }

        elseif ($opc == "X") {    # DELETE
          $id = $_GET['id'];
          	
          $argumentos = " WHERE ID = '$id' ";

          if ( funDelete("tb_produtos", $argumentos ) )
            echo "<p class='p-2 m-2 bg-info text-white'>Produto excluído com sucesso!</p>";
          else 
            echo "<p class='p-2 m-2 bg-warning text-white'>Erro ao excluir produto!</p>";

          echo "<p class='m-2'><input type='submit' value='Voltar' onclick=location.replace('Index.php?opc=R') /></p>";
        }

      ?>         
    </div>
    <h6 class="text-secondary text-center">Desenvolvido por IFSP - Campus Guarulhos</h6>
    
      <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  </body>
</html>