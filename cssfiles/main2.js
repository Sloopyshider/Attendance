let d,h,m,s,animate,b,t,a,j;

function init(){
    d=new Date();
    h=d.getHours();
    m=d.getMinutes();
    s=d.getSeconds();
    clock();
}

function clock(){
    s++;
    if(s===60){
        s=0;
        m++;
        if(m===60){
            m=0;
            h++;
            if(h===24){
                h=0;
            }
        }
    }
    $('sec',s);
    $('min',m);
    $('hr',h);
    animate=setTimeout(clock,1000);
}

function $(id,val){
    if(val<10){
        val='0'+val;
    }
    document.getElementById(id).innerHTML=val;
}

window.onload=init;

function btn() {
    alert("You have successfully Time in!");
}

function button() {
    alert("You have successfully Time in!");
}

function n(){
    d =  new Date();
    t = n.getFullYear();
    j = n.getMonth() + 1;
    a = n.getDate();
}