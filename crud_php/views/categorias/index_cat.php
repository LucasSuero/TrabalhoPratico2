<?php
include_once __DIR__ . '/../../controllers/CategoriaController.php';
/******************************************************************************
Curso: Engenharia de Software
Disciplina: Linguagem e Técnicas de Programacão
Professor: José Carlos Domingues Flôres
Turma: ESOFT-2A
Componentes:
 25185655-2 - Leonardo Kenji Tanida Soares
 25125961-2 - Elias Borgers Neckel
 25011023-2 - Lucas Coelho Suero 
Data: 10 de novembro de 2025
*******************************************************************************/

$controller = new CategoriaController();
$data = $controller->index();
$stmt = $data['stmt'];
$num = $data['num'];

include __DIR__ . '/../../views/includes/header.php';
?>

<h2 class="textoAba">Categorias</h2>
<div class="tabelas">
<a href="/crud_php/public/index.php?page=categorias&action=create" class="button">Criar Nova Categoria</a>

<?php
if($num > 0){
    echo "<table>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Ações</th>";
        echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
            echo "<td>{$id}</td>";
            echo "<td>{$nome}</td>";
            echo "<td>";
                echo "<a href=\"/crud_php/public/index.php?page=categorias&action=edit&id={$id}\" class=\"button edit\">Editar</a>";
                echo "<a href=\"/crud_php/public/index.php?page=categorias&action=delete&id={$id}\" class=\"button delete\">Deletar</a>";
            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhuma categoria encontrada.</p>";
}
echo "</div>"
?>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
