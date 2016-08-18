var nota = 0;
var raizSistema = "";

function setNota(nota, idKappa) {

    //alert(idKappa);

    var div_ressalva = document.getElementById('div_ressalva_' + idKappa);

    for (var i = 1; i <= 5; i++) {

        var img = document.getElementById('imgNota' + i + '_kappa' + idKappa);
        var input_nota = document.getElementById(idKappa + '_nota');

        if (img != null) {
            img.src = raizSistema + "painel/images/botoes_kappa_" + i.toString() + ".png";
        }

        if (i == nota) {
            if (img != null) {
                img.src = raizSistema + "painel/images/botoes_kappa_" + i.toString() + "_ativo.png";
            }

            if (input_nota != null) {
                input_nota.value = nota;
            }
        }
    }

    if (div_ressalva != null) {
        if (nota == 2 || nota == 4) {
            div_ressalva.style.display = "block";
        } else {
            div_ressalva.style.display = "none";
        }
    }

}

function setRaizSistemaKappa(raizSistema) {
    this.raizSistema = raizSistema;
}


