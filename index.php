<?php include('TemplateLeitor.php') ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Painel CMS</title>
</head>

<body>
    <header>
        <div class="center">
            <div class="logo"><a href="">Painel CMS</a></div>
            <div class="menu">
                <a href="">Cadastrar página</a>
                <a href="">Listar páginas</a>
            </div>
            <div class="clear"></div>
        </div>
    </header>
    <br />
    <div class="main">
        <div class="center">
            <?php
                if(!isset($_POST['etapa_2'])){
            ?>
            <form action="" method="post">
                <select name="arquivo">
                    <?php
                        $files = glob("templates/*.html");
                        foreach ($files as $key => $value){
                            $files = explode('/', $value);
                            $fileName = $files[count($files) -1];
                            echo '<option value="'.$fileName.'">'.$fileName.'</option>';
                        }
                    ?>
                </select>
                <input type="text" name="nome_pagina" placeholder="Nome da sua página... ">
                <input type="submit" name="etapa_2" value="Proxima Etapa!">
            </form>
            <?php } else { 
                $nomeArquivo = $_POST['arquivo'];
                $nomePagina = $_POST['nome_pagina'];

                //pegamos os dados do arquivo e calculamos quantos campos tem para serem substituídos
                $getContent = file_get_contents('templates/'.$nomeArquivo);
                $fields = TemplateLeitor::pegaCampos($getContent,'\{\{!(.*?)\}\}');
                ?>

                <h2>Editando página <?php echo $nomePagina ?> | Arquivo Base: <?php echo $nomeArquivo ?> </h2>
                <form method="post">
                    <?php
                        for($i = 0; $i < count($fields['chave']); $i++){
                            echo '<input type="text" name="'.$fields['campo'].'" />';
                            echo '<hr />';
                        }
                    ?>
                    <input type="hidden" name="nome_pagina" value="<?php echo $nomePagina; ?>">
                    <input type="submit" value="Salvar" name="acao">
                </form>

            <?php } ?>
        </div>
    </div><!--main-->
</body>

</html>