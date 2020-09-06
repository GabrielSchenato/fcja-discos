<?php
include_once("conexao.php");
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <title>
            FCJ - Discos
        </title>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="images/icon.ico" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
    </head>
    <body id="top">
            <section id="banner" data-video="images/banner">            
                <div class="inner">
                    <header>
                        <img src="images/logo.png" alt="Imagem de página não encontrada"/>
                        <h1>
                            Buscar Disco
                        </h1>
                        <h3>
                            Filtro de busca
                        </h3>
                        <form name="form1" method="post" action="#main">
                            <select name="filtro">
                                <option value="Artista">Artista</option>
                                <option value="Num">Número</option>
                                <option value="Nome">Nome</option>    
                                <option value="Gravadora">Gravadora</option>
                                <option value="Ano">Ano</option>
                            </select>
                            <br>
                            <label>
                                <input name="busca" type="text" id="busca" value="" placeholder="Buscar" required="required" size="30">
                            </label>
                            <label></label>
                            <label>
                                &nbsp;&nbsp;
                                <input type="submit" name="pesquisar" value="Pesquisar">
                                &nbsp;
                                <input type="reset" name="Submit2" value="Limpar">
                            </label>
                        </form>
                    </header>
                    <a href="#main" class="more">Resultado</a>                
                </div>
            </section>
            <!-- Main -->
            <div id="main">
                <div class="inner">
                    <!-- Buscar -->
                    <?php
                    $filtro = filter_input(INPUT_POST, 'filtro');
                    $valor = filter_input(INPUT_POST, 'busca');
                    $pesquisar = filter_input(INPUT_POST, 'Num');

                    if ($filtro == "Num") {
                        $stmt = $db->prepare("select * from Discos where $filtro = $valor");
                        $stmt->execute();
                        $resultados = $stmt->rowCount();
                        if ($resultados >= 1) {
                            echo "Resultado(s) encontrado(s): " . $resultados . "<br /><br />";
                            echo '<table id="resultado" cellspacing="0" width="100%">';
                            echo '<thead>
                                    <tr>
                                        <th>Num</th>
                                        <th>Tipo</th>
                                        <th>Nome</th>
                                        <th>Artista</th>
                                        <th>Gravadora</th>
                                        <th>Ano</th>
                                    </tr>
                                  </thead>';
                            echo '<tfoot>
                                    <tr>
                                        <th>Num</th>
                                        <th>Tipo</th>
                                        <th>Nome</th>
                                        <th>Artista</th>
                                        <th>Gravadora</th>
                                        <th>Ano</th>
                                    </tr>
                                 </tfoot>
                                <tbody>';
                            while ($reg = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo '<tr>';
                                echo '<td>' . $reg->Num . '</td>';
                                echo '<td>' . $reg->Tipo . '</td>';
                                echo '<td>' . $reg->Nome . '</td>';
                                echo '<td>' . $reg->Artista . '</td>';
                                echo '<td>' . $reg->Gravadora . '</td>';
                                echo '<td>' . $reg->Ano . '</td>';
                                echo '</tr>';
                            }
                            echo '  </tbody>
                                  </table>';
                        } else if (empty($valor)) {
                            echo '<p>Preencha o campo de pesquisa.</p>';
                        } else {
                            echo '<p>Este disco não existe, tente novamente!</p>';
                        }
                    } else {
                        $stmt = $db->prepare("select * from Discos where $filtro like :letra");
                        $stmt->bindValue(':letra', '%' . $valor . '%', PDO::PARAM_STR);
                        $stmt->execute();
                        $resultados = $stmt->rowCount();
                        if ($resultados >= 1) {
                            echo "Resultado(s) encontrado(s): " . $resultados . "<br /><br />";
                            echo '<table id="resultado" cellspacing="0" width="100%">';
                            echo '<thead>
                                    <tr>
                                        <th>Num</th>
                                        <th>Tipo</th>
                                        <th>Nome</th>
                                        <th>Artista</th>
                                        <th>Gravadora</th>
                                        <th>Ano</th>
                                    </tr>
                                  </thead>';
                            echo '<tfoot>
                                    <tr>
                                        <th>Num</th>
                                        <th>Tipo</th>
                                        <th>Nome</th>
                                        <th>Artista</th>
                                        <th>Gravadora</th>
                                        <th>Ano</th>
                                    </tr>
                                 </tfoot>
                                <tbody>';
                            while ($reg = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo '<tr>';
                                echo '<td>' . $reg->Num . '</td>';
                                echo '<td>' . $reg->Tipo . '</td>';
                                echo '<td>' . $reg->Nome . '</td>';
                                echo '<td>' . $reg->Artista . '</td>';
                                echo '<td>' . $reg->Gravadora . '</td>';
                                echo '<td>' . $reg->Ano . '</td>';
                                echo '</tr>';
                            }
                            echo '  </tbody>
                                  </table>';
                        } else if (empty($valor)) {
                            echo '<p>Preencha o campo de pesquisa.</p>';
                        } else {
                            echo '<p>Este disco não existe, tente novamente!</p>';
                        }
                    }
                    ?>           
                </div>
            </div>        
            <!-- Footer -->
            <footer id="footer">
                <div class="inner">
                    <h2>
                        Curiosidades 
                    </h2>
                    <h3>
                        Número de discos já cadastrados: 
                    </h3>
                    <?php
                    $stmt = $db->prepare("select * from Discos");
                    $stmt->execute();
                    $resultados = $stmt->rowCount();
                    echo '<h2>' . $resultados . '</h2>'
                    ?>
                    <?php
                    $stmt = $db->prepare("SELECT * FROM Discos ORDER BY Ano ASC limit 1");
                    $stmt->execute();
                    $resultados = $stmt->rowCount();
                    if ($resultados >= 1) {
                        while ($reg = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo 'O disco mais antigo até agora cadastrado é do ano de ' . $reg->Ano . '', ' e o seu nome é ' . $reg->Nome . '', ' artista se chama ' . $reg->Artista . '', ' a gravadora é a ' . $reg->Gravadora . '';
                        }
                    }
                    ?>
                    <br/>
                    <br/>
                    <h3>
                        TOP 5 Gravadoras
                    </h3>
                    <?php
                    $i = 1;
                    $stmt = $db->prepare("SELECT Gravadora ,count(*) as Total FROM Discos GROUP BY Gravadora ORDER BY Total DESC LIMIT 5");
                    $stmt->execute();
                    $resultados = $stmt->rowCount();
                    if ($resultados >= 1) {
                        echo '<table width="30%" border="1px">';
                        echo '<tr align=center>';
                        echo '<td>Posição</td>';
                        echo '<td>Gravadora</td>';
                        echo '<td>Total de Discos</td>';
                        echo '</tr>';
                        while ($reg = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo '<tr align=center>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $reg->Gravadora . '</td>';
                            echo '<td>' . $reg->Total . '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        echo '</table>';
                    }
                    ?>
                    </p>
                    <br/>
                    <h2>
                        Sobre
                    </h2>
                    <p>
                        Criado por Gabriel Schenato para fins de aprendizado.
                        <br />
                        <br />
                        <input type="button" name="planilha" value="Localização Discos" onClick="window.open('https://docs.google.com/spreadsheets/d/1xIbR8rQ6HQn321uPpc_wlqduckaTLiu7T2VQGZJ1oXg/pubhtml?gid=1132983947')">
                        <br />
                    <ul class="icons">
                        <li>
                            <a href="https://twitter.com/gabrielschenato" target="_blank" class="icon fa-twitter"><span class="label">Twitter</span></a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/gabrielsilvaschenato" target="_blank" class="icon fa-facebook"><span class="label">Facebook</span></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/gabrielschenato/" target="_blank" class="icon fa-instagram"><span class="label">Instagram</span></a>
                        </li>
                        <li>
                            <a href="mailto:gabrielschenato152@hotmail.com" target="_blank" class="icon fa-envelope"><span class="label">Email</span></a>
                        </li>
                    </ul>
                    <p class="copyright">
                        &copy; FCJA. Design: Gabriel Schenato.
                    </p>
                </div>
                <a href="#top" class="voltar-ao-topo">Voltar ao topo</a>
            </footer>
        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/jquery.poptrox.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>    
        <script type="text/javascript" src="DataTables/datatables.min.js"></script>
        <script>
            $(document).ready(function() {
    $('#resultado').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true,

                    "language": {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
                    }
});
} );
        </script>
    </body>
</html>