/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var activeRowDiv;

document.addEventListener('DOMContentLoaded', function () {
    
    //AUDIO PLAYER SONG ENDED
    $('#analogplayer').bind("ended", function(){
        var nextRowDiv = $(activeRowDiv).next();
        if(nextRowDiv.length===0) {
            nextRowDiv = $('.divTableRow').first();
        }
        
        playSong(nextRowDiv);
        
    });

});

function playSong(rowDiv) {
    activeRowDiv = rowDiv;
    
    $('#analogplayer > source').attr('src',$(activeRowDiv).find('.divTableCell .file').attr('value'));
    document.getElementById("analogplayer").load();
    document.getElementById("analogplayer").play();
    
    $('#artist').text($(activeRowDiv).find('.divTableCell .artist').attr('value'));
    $('#album').text($(activeRowDiv).find('.divTableCell .album').attr('value'));
    $('#title').text($(activeRowDiv).find('.divTableCell .title').attr('value'));
}
