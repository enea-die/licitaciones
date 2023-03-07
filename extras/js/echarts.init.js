function getChartColorsArray(e){
    if(null!==document.getElementById(e)){
        var t=document.getElementById(e).getAttribute("data-colors");
        if(t)
            return(t=JSON.parse(t)).map(function(e){
                var t=e.replace(" ","");
                if(-1===t.indexOf(",")){
                    var o=getComputedStyle(document.documentElement).getPropertyValue(t);
                    return o||t
                }
                var a=e.split(",");
                return 2!=a.length?t:"rgba("+getComputedStyle(document.documentElement).getPropertyValue(a[0])+","+a[1]+")"
            });
            console.warn("data-colors Attribute not found on:",e)
    }
}