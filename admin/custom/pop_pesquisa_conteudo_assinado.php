<?
if (file_exists(K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php")) {
    require_once K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php";
}

if (file_exists(K_DIR . "custom/tabela_selecao_conteudo_assinado.php")) {
    require_once K_DIR . "custom/tabela_selecao_conteudo_assinado.php";
}
?>
<div class="modal fade bs-example-modal-lg" id="modal_buscar_conteudo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Buscar Conteúdos Assinados</h4>
            </div>

            <div class="modal-body">
                <div class="container-fluid">

                    <div class="row">
                        <div class="form-group">
                            Filtrar por:

                            <label class="sr-only" for="titulo">Título</label>
                            <input type="text" placeholder="Título" name="titulo" id="titulo" class="form-control" value=""   maxlength="80">
                            <input type="button" class="btn btn-primary pull-right" value="Buscar" onclick="pesquisar();">
                        </div>
                    </div>

                    <div id="resultado_pesquisa">
                        <?
                        $itens = null;

                        $componenteTabela = new TabelaSelecaoConteudoAssinado($itens);
                        $componenteTabela->printHTML();
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var prefixoCampoSelecionado = "conteudo_assinado_1";

    function setPrefixoCampoSelecionado(prefixo) {
        prefixoCampoSelecionado = prefixo;
    }

    function pesquisar() {

        var titulo = document.getElementById('titulo').value;

        if (titulo === '') {
            alerta("", "Informe o título para o seu filtro");
            return;
        }

        var divResultadoPesquisa = document.getElementById('resultado_pesquisa');

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                divResultadoPesquisa.innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", "<?= K_RAIZ ?>custom/ajax_conteudo_assinado_pesquisa_titulo.php?titulo=" + titulo, true);

        xmlhttp.send();
    }

    function selecionar(idConteudo, titulo) {

        if (document.getElementById(this.prefixoCampoSelecionado + "_id") !== null) {
            var campoID = document.getElementById(this.prefixoCampoSelecionado + "_id");
            campoID.value = idConteudo;
        }

        if (document.getElementById(this.prefixoCampoSelecionado + "_titulo") !== null) {
            var campoTitulo = document.getElementById(this.prefixoCampoSelecionado + "_titulo");
            campoTitulo.value = titulo;
        }

        $('#modal_buscar_conteudo').modal('hide');

        document.getElementById('titulo').value = '';

        document.getElementById('corpo_tabela').innerHTML = '<td colspan="8" class="f-tabela-texto">N&atilde;o h&aacute; dados a serem exibidos!</td>';
    }
</script>