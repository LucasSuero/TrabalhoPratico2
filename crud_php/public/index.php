<?php
/* Pra melhor compreensão do código, é importante ressaltar que include é um comando que 
puxa um outro arquivo pra determinado ponto do arquivo o qual foi usado o include, então no 
script que temos em mãos. usamos o metodo $_GET pra identificar qual página estamos e então
usamos o case para o programa saber o que fazer quando estamos em determinada página, por tanto
quando clickamos na aba de produtos, por exemplo, o case projetará os produtos, por que a string
que o $_GET trará, será equivalente a que está escrita dentro do case.*/


$page = isset($_GET["page"]) ? $_GET["page"] : "produtos";
/*Então quebrando em partes o código, isset(está difinida?), se sim, usa a variavel definida pelo
$_GET, como eu expliquei no começo do script, se não, manda direto pro caso produtos. Então temos
a página em que estamos no navegador*/ 


$action = isset($_GET["action"]) ? $_GET["action"] : "index";
/*Aqui tentamos verificar se a variavel actions está definida, se estiver, jogamos o valor dentro
da variavel do sistema padrão, sem o get e se não estiver jogamos para o index.*/

$id = isset($_GET["id"]) ? $_GET["id"] : null;
/*Nesse caso como os casos a cima, usamos do $_GET pra verificar se há algum id já definido, caso 
haja, o utilizamos, caso não, colocamos o valor da variavel id como nula.*/

/*Os 3 operadores ternarios a cima são fundamentais para o funcionamento do programa, pois
eles encurtam uma grande parte do processo de tornar a página interativa*/

switch ($page) { // primeiro switch pra descobrir qual página estamos
    case "produtos":
        switch ($action) {
            case "index":
                include __DIR__ . '/../views/produtos/index_prod.php';
                break;
            case "create":
                include __DIR__ . '/../views/produtos/create_prod.php';
                break;
            case "edit":
                include __DIR__ . '/../views/produtos/edit_prod.php';
                break;
            case "delete":
                include_once __DIR__ . '/../controllers/ProdutoController.php';
                $controller = new ProdutoController();
                if ($controller->delete($id)) {
                    header("Location: /crud_php/public/index.php?page=produtos");
                    exit();
                } else {
                    echo "<p class=\'error\'>Não foi possível deletar o produto.</p>";
                }
                break;
            default:
                include __DIR__ . '/../views/produtos/index_prod.php';
                break;
        }
        break;
    case "categorias":
        switch ($action) {
            case "index":
                include __DIR__ . '/../views/categorias/index_cat.php';
                break;
            case "create":
                include __DIR__ . '/../views/categorias/create_cat.php';
                break;
            case "edit":
                include __DIR__ . '/../views/categorias/edit_cat.php';
                break;
            case "delete":
                include_once __DIR__ . '/../controllers/CategoriaController.php';
                $controller = new CategoriaController();
                if ($controller->delete($id)) {
                    header("Location: /crud_php/public/index.php?page=categorias");
                    exit();
                } else {
                    echo "<p class=\'error\'>Não foi possível deletar a categoria.</p>";
                }
                break;
            default:
                include __DIR__ . '/../views/categorias/index_cat.php';
                break;
        }
        break;
    case "administracao" :
        include __DIR__ . '/../views/administracao/admin_ops.php';
        break;
    case "loja":
        include __DIR__ . '/../views/loja/Loja_view.php';
        break;
    default:
        include __DIR__ . '/../views/produtos/index_prod.php';
        break;
}

?>
