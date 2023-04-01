/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
PNotify.prototype.options.styling = "bootstrap3";
PNotify.prototype.options.styling = "fontawesome";
PNotify.prototype.options.delay = 1000;

function notification(type, message)
{
    new PNotify({
        type: type,
        text: message,
        buttons: {
            sticker: false
        },
        addclass: "stack-bottomright"
    });
}


