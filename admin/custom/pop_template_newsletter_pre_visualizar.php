<?
require_once K_DIR . 'painel/newsletter/convite/interface_item_convite.php';
require_once K_DIR . 'painel/newsletter/convite/convite_cabecalho.php';
require_once K_DIR . 'painel/newsletter/convite/convite_rodape.php';
?>

<style type="text/css">
    @import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700);

    #outlook a{padding:0;} /* Força mensagem Outlook para fornecer uma "visão no navegador" */
    .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Força Hotmail para exibir e-mails com largura total */
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Força Hotmail para apresentar espaçamento de linha normal */
    body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevenir WebKit e mudando Windows mobile tamanhos de texto padrão */
    table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remover o espaçamento entre as mesas no Outlook 2007 e até */
    img{-ms-interpolation-mode:bicubic;} /* Permitir renderização suave de imagem redimensionada no Internet Explorer */

    /* RESET STYLES */
    body{margin:0; padding:0;}
    img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
    table{border-collapse:collapse !important;}
    body{height:100% !important; margin:0; padding:0; width:100% !important;}

    /* iOS BLUE LINKS */
    .appleBody a {color:#68440a; text-decoration: none;}
    .appleFooter a {color:#999999; text-decoration: none;}

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {

        /* ALLOWS FOR FLUID TABLES */
        table[class="wrapper"]{
            width:100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        td[class="logo"]{
            text-align: left;
            padding: 20px 0 20px 0 !important;
        }

        td[class="logo"] img{
            margin:0 auto!important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        td[class="mobile-hide"]{
            display:none;}

        img[class="mobile-hide"]{
            display: none !important;
        }

        img[class="img-max"]{
            max-width: 100% !important;
            height:auto !important;
        }

        /* FULL-WIDTH TABLES */
        table[class="responsive-table"]{
            width:100%!important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        td[class="padding"]{
            padding: 10px 5% 15px 5% !important;
        }

        td[class="padding-copy"]{
            padding: 10px 5% 10px 5% !important;
            text-align: center;
        }

        td[class="padding-meta"]{
            padding: 30px 5% 0px 5% !important;
            text-align: center;
        }

        td[class="no-pad"]{
            padding: 0 0 20px 0 !important;
        }

        td[class="no-padding"]{
            padding: 0 !important;
        }

        td[class="section-padding"]{
            padding: 50px 15px 50px 15px !important;
        }

        td[class="section-padding-bottom-image"]{
            padding: 50px 15px 0 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        td[class="mobile-wrapper"]{
            padding: 10px 5% 15px 5% !important;
        }

        table[class="mobile-button-container"]{
            margin:0 auto;
            width:100% !important;
        }

        a[class="mobile-button"]{
            width:80% !important;
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
        }

    }
</style>

<!-- Modal Pre-Visualizacao-->
<div class="modal fade" id="modal_pre_visualizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Pré Visualização</h4>
            </div>

            <div class="modal-body">

                <?
                $conviteCabecalho = new ConviteCabecalho("Nome Remetente");
                $conviteCabecalho->printEmail();

                if (@$registro["id"]) {
                    $itens = componente_template_newsletter::findItensByIdTemplate($registro["id"]);

                    for ($i = 0; $i < count($itens); $i++) {
                        $item = $itens[$i];
                        $itemConvite = ItemConviteFactory::getItemConvite($item['codigo'], $item['valor'], $item['id']);
                        $contador = $itemConvite->printEmail();
                    }
                }

                $conviteRodape = new ConviteRodape();
                $conviteRodape->printEmail();
                ?>

            </div>
        </div>
    </div>
</div>

