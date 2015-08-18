/**
 * Created by Axis on 23.07.2015.
 */
M.getusername=function(){
    return gebi('ilogin').value;
};

M.getuserpass=function(){
    return gebi('ipass').value;
};

M.setcontext=function (cont1){
   gebi('userinfodiv').innerText = cont1;
};

M.renderbut = function (divid,ob,onklik,Y,klas){
    var txtbut='';
    for (ob1 in ob) {
        if (ob.hasOwnProperty(ob1)) {
            if (ob1 != 'cnt') {
                txtbut = txtbut + '<button id="' + ob1 + '"  ' + klas + '>' + ob[ob1]['namusl'] + '<br></button> <BR><BR>';
            }
        }
    }

    gebi(divid).innerHTML = txtbut;

    for (ob1 in ob) {
        if (ob.hasOwnProperty(ob1)) {
            if (ob1 != 'cnt') {
                Y.one('#'+ob1).on("click", onklik);
            }
        }
    }
};

M.OpenIdUsl = function (idUsl){
    window.open(M.serverMIS+'cases/service/'+ idUsl+'/edit?backUrl=%2Ftree'+ M.back1,'_blank');
};
