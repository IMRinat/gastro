/**
 * Created by Axis on 22.07.2015.
 */

M.loginpost = "";

M.get_res_by_login=function (l)
{
    var ll=l.toLowerCase();
    if (ll=='ПоповаОА79'.toLowerCase()) return '1260814';
    else if (ll=='МедведеваЕФ51'.toLowerCase()) return '1260815';
    else if (ll=='НарицынаЕП82'.toLowerCase()) return '1260819';
    else if (ll=='КотенкоМА83'.toLowerCase()) return '362003';
    else if (ll=='ФилипповаЕА81'.toLowerCase()) return '1260821';
    else if (ll=='КовалевДП85'.toLowerCase()) return '1270525';
    else if (ll=='Ворончихин'.toLowerCase()) return '1388699';
    else if (ll=='Голощапова'.toLowerCase()) return '1448284';
    else return '';
};

M.calcloginpost=function (resp,login,pass)
{
    var i = resp.indexOf('name="lt"');
    i = resp.indexOf('"', i + 15);
    var j = resp.indexOf('"', i + 1);
    var lt = resp.slice(i + 1, j);
    i = resp.indexOf('name="execution"');
    i = resp.indexOf('"', i + 20);
    j = resp.indexOf('"', i + 1);
    var es = resp.slice(i + 1, j);
    return "mac=&username=" + login + "&password=" + pass +
        "&lt=" + lt + "&execution=" + es + "&_eventId=login";
};


M.mylogout = function (s_user,s_pass)   //выход и логин
{
    //M.user = gebi('ilogin').value;
    //M.pass = gebi('ipass').value;
    M.user = s_user;
    M.pass = s_pass;
    if ((M.user=="")||(M.pass==""))
    {
        alert("Отсутствуют логин или пароль");
        return false;
    }
    if (M.get_res_by_login(M.user)=="")
    {
        alert("Логин не поддерживается.");
        return false;
    }

    var logout = X.io(M.server+'cases/logout',getcfg);
    if (logout.responseText=== undefined)
    {
        //alert("Error logout");
        //return false;
    }

    var logintree = X.io(M.server+'cases/tree',getcfg);
    if (logintree.responseText=== undefined)
    {
        alert("Error logintree");
        return false;
    }
    M.loginpost = M.calcloginpost(logintree.responseText,M.user,M.pass);
    M.u_login_text=M.user;
    M.u_password=M.pass;


    postcfg.data= M.loginpost;
    var loginmis = X.io(M.loginURL,postcfg);
    loginmis =   X.io(M.server+'cases/tree',getcfg);


    if (loginmis.responseText=== undefined)
    {
        alert("Error loginmis");
        return false;
    }

    var resp = loginmis.responseText;
    var i = resp.indexOf('currentUserId');
    if (i<0)
    {
        alert("Неправильный логин или пароль.");
        return;
    }

    i = resp.indexOf(':', i+1);
    var j = resp.indexOf(',', i + 1);
    M.u_login_id = resp.slice(i + 1, j);
    return true;
};

M.getcontext=function () { // заполнение контекста
    var cont= X.io(M.server+'ctx-rest/getContext?userId='+M.u_login_id+'&sessionId=',getcfg);
    if (cont.responseText === undefined)
    {
        alert("Error loginmis");
        return false;
    }

    var arr = JSON.parse(cont.responseText);
    M.u_lpu_text = arr.contextForm.dataMap.ORGANIZATION.value;
    M.u_otdel_text=arr.contextForm.dataMap.DEPARTMENT.value;
    M.u_dol_text=arr.contextForm.dataMap.DEPARTMENT.value;
    M.u_name_text=arr.contextForm.dataMap.EMPLOYEE.value;
    return M.u_login_text+', '+M.u_lpu_text+', '+M.u_otdel_text+', '+M.u_name_text;
};

M.GetZogINfo = function (id){
    postcfg.data = M.soapzoginfo.format(id);
    var resp=X.io(M.server+'hsp-records-ws/hspRecords', postcfg);
    return resp.responseXML;
};

M.GetCaseINfo = function (id){
    postcfg.data = M.soapcaseinfo.format(id);
    var resp = X.io(M.server+'cases-ws/cases', postcfg);
    return resp.responseXML;
};

M.NewUsl = function (_caseid, _id, _uslmas, _dat_ymd, _tim_hms, _res_by_login, _patuid){
    postcfg.data = M.soapnewusl.format(_caseid, _id, _uslmas, _dat_ymd, _tim_hms, _res_by_login, _patuid);
    var resp = X.io(M.server+'medservices-ws/renderedServices', postcfg); //новая услуга
    return resp.responseXML;

};