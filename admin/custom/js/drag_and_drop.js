$(function(){
    $('.drag').draggable({
        connectToSortable: '.drop-container',
        helper: 'clone',
        stop: function(event, ui) {
            OnStopDiv( event,ui, $(this).html(), $(this) );
        }
    });

    $('.drop-container').sortable({
        placeholder: 'placeholder',
        activate: function(event, ui){
            $('.drop-container p').remove();
        }
    });

    $('.lixeira').droppable({
        hoverClass: 'lixeira-ativa',
        drop: function(event, ui) {
            
            //alert( event );
            $(ui.draggable).remove();
            //ui.draggable.hide(1000);
        }
    });

    $('.salvar').click(function(){
        var valores = new Array();
        
        $('.drop-container .drag').each(function(){
            valores.push( $(this).html() );
        });
        
        alert(valores);
    });
});


