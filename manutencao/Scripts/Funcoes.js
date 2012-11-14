// Função de Fix PNG

var arVersion = navigator.appVersion.split("MSIE")
var version = parseFloat(arVersion[1])

if ((version >= 5.5) && (document.body.filters)) {
    for (var i = 0; i < document.images.length; i++) {
        var img = document.images[i]
        var imgName = img.src.toUpperCase()
        if (imgName.substring(imgName.length - 3, imgName.length) == "PNG") {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
         + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
         + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
         + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
            img.outerHTML = strNewHTML
            i = i - 1
        }
    }
}

// Função de Validação RequiredField com Tooltip
function ValRequiredTooltip(source, arguments) {

    var conteudo = arguments.Value;
    conteudo = conteudo.replace(/^\s+|\s+$/g,"");
    
    if (conteudo == "") {
        arguments.IsValid = false;
        
        $('#' + source.controltovalidate).qtip({
            content: {
                text: source.errormessage
            },
            position: {
                corner: {
                    target: 'rightTop',
                    tooltip: 'leftBottom'
                }
            },
            style: {
                name: 'light',
                padding: '7px 13px',
                width: {
                    max: 210,
                    min: 0
                },
                tip: true,
                border: {
                    width: 3,
                    radius: 5
                },
                classes: {
                    title: 'Tooltip_Titulo',
                    content: 'Tooltip_Conteudo'
                }
            },
            show: {
                ready: true,
                when: {
                    event: 'none'
                },
                effect: {
                    type: 'fade'
                }
            },
            hide: {
                effect: {
                    type: 'slide'
                }
            }
        });
    } else {
        arguments.IsValid = true;
    }
}
