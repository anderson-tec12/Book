
function isVazio(obj, mensagem, testaZero) {
    if (obj != undefined) {

        if (obj.value == '' || (testaZero != null && obj.value == '0')) {
               alerta("", mensagem);
               //alerta("", mensagem);
            try
            {
                obj.focus();
            } catch (ex) {
            }

            return true;
        }
    }
    return false;
}