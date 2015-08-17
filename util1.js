/**
 * Created by Axis on 26.06.2015.
 */
var M = new Object();

if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

function gebi(nam) { return document.getElementById(nam);}


var getcfg =  {  timeout : 3000, sync: true, arguments: { 'foo' : 'bar' }  };
//var postcfg = {  timeout : 3000, sync: true,  method: 'POST', data:'', headers: { 'Content-Type': 'application/x-www-form-urlencoded'}};
var postcfg = {  timeout : 3000, sync: true,  method: 'POST', data:''};


var Xhr = window.XDomainRequest || window.XMLHttpRequest;
var xhr = new Xhr();

// Create a YUI instance using io-base module.
var X = YUI().use("io-base", function(Y) {});

function datobg()
{
    var dateObj = new Date();
    var D = new Object();
    D.dat_d = dateObj.getDate();
    D.dat_m = dateObj.getMonth() + 1;
    D.dat_y = dateObj.getFullYear();
    if (D.dat_d < 10) D.dat_d = '0' + D.dat_d;
    if (D.dat_m < 10) D.dat_m = '0' + D.dat_m;
    if (D.dat_y < 10) D.dat_y = '0' + D.dat_y;

    D.tim_h = dateObj.getHours();
    D.tim_m = dateObj.getMinutes();
    D.tim_s = dateObj.getSeconds();
    if (D.tim_h < 10) D.tim_h = '0' + D.tim_h;
    if (D.tim_m < 10) D.tim_m = '0' + D.tim_m;
    if (D.tim_s < 10) D.tim_s = '0' + D.tim_s;

    D.dat_ymd = D.dat_y + '-' + D.dat_m + '-' + D.dat_d;
    D.dat_ymd_dot = D.dat_d + '.' + D.dat_m + '.' + D.dat_y;
    D.tim_hms = D.tim_h + ':' + D.tim_m + ':' + D.tim_s;
    return D;
}

function getxmlparam(xmlDoc, level,par)
{
    x=xmlDoc.childNodes;
    for (i=0;i<level;i++){
        x=x.item(0).childNodes;
    }

    for (i=0;i<x.length;i++){
        var pref1='';
        if (x[i].prefix!==null) {
          pref1 = x[i].prefix+':';
        }
        if (x[i].nodeName==pref1+par) {
          return x[i].textContent;
        }
    }
    return null;
}

function clearObject(ob)
{
    for (var ob1 in ob ) { //удаляем всё из объекта
        if  (ob.hasOwnProperty(ob1)){
            delete ob[ob1];
        }
    }
    ob['cnt']=0;
}

function addObject(ob,nm){
    var n= ob['cnt'];
    ob['cnt']=ob['cnt']+1;
    var id=nm+n;
    ob[id]={};
    return id;
}

function addbutton(ob,id, idusl,datusl,namusl,misname){
    var newid = addObject(ob, id);
    ob[newid]['datusl'] = datusl;
    ob[newid]['namusl'] = namusl;
    ob[newid]['idusl'] = idusl;
    ob[newid]['misname']= misname.trim();
}

function get_id_by_datusl_misname(ob,datusl,misname){
    for (ob1 in ob) {
        if (ob.hasOwnProperty(ob1)) {
            if (ob1 != 'cnt') {
                if ((ob[ob1]['datusl']==datusl)&&(ob[ob1]['misname']==misname)) {
                    return ob[ob1]['idusl'];
                }
            }
        }
    }
    return null;
}