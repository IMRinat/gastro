<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>  <HEAD>  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />   
<link rel="stylesheet" href="yui/build/cssbutton/cssbutton.css">
<style>.yui3-button {
    margin:3px;
}

.warning{
    background-color:#FAF55F;
}

.success{
    background-color:#57A957;
    color:white;
}

.error{
    background-color:#C43C35;
    color:white;
}

.notice{
    background-color:#1B7AE0;
    color:white;
}

.yui3-button-icon {
    background-image: url("../assets/button/icon-sprite-dark-and-light-24.png");
    background-repeat: no-repeat;
    display: inline-block;
    height: 20px;
    vertical-align: middle;
    width: 20px;
}

.yui3-button-icon-bold {
    background-position: 1px 1px;
}

.yui3-button-icon-italic {
    background-position: 1px -35px;
}

.yui3-button-icon-underline {
    background-position: 1px -71px;
}
</style>

   </HEAD>    <BODY>
<script src="yui/build/yui/yui.js"></script>
<script>
//информация о пользователе
var u_lpu_id;
var u_lpu_text;
var u_login_id;
var u_login_text;
var u_password;
var u_otdel_id;
var u_otdel_text;
var u_dol_id;
var u_dol_text;
var u_name_text;

//информация о пациенте
var p_uid;
var p_info;
var p_value;
var p_fio;

//{"state":{"TabBody":{"active":false},"protocolTabTabBody":{"active":true}}}
//eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19

//глобальные 
var uslmas={};
var url;
var myFunction;
var myCallback;
var dtable ;
var dataSource ;
var cfg;
var soaplistuslbystep;
var zogurl;


var soapnewusl = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://atria.cz/renderedServices/types">'+
'<soapenv:Header/>'+
'<soapenv:Body>'+
'<typ:sendRenderedServicesRequest>'+
'<typ:medicalCaseId>{0}</typ:medicalCaseId>'+
'<typ:stepId>{1}</typ:stepId>'+
'<typ:serviceId>{2}</typ:serviceId>'+
'<typ:dateFrom>{3}</typ:dateFrom>'+
'<typ:isRendered>true</typ:isRendered>'+
'<typ:quantity>1</typ:quantity>'+
'<typ:resourceGroupId>362003</typ:resourceGroupId>'+
'<typ:fundingSourceTypeId>8</typ:fundingSourceTypeId>'+
'<typ:patientUid>{4}</typ:patientUid>'+
'<typ:orgId>25</typ:orgId>'+
'</typ:sendRenderedServicesRequest>'+
'</soapenv:Body>'+
'</soapenv:Envelope>';

var soaplistuslbystep = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://atria.cz/renderedServices/types">'+
'<soapenv:Header/>'+
'<soapenv:Body>'+
'<typ:searchRenderedServicesRequest>'+
'<typ:medicalCaseId>{0}</typ:medicalCaseId>'+
'</typ:searchRenderedServicesRequest>'+
'</soapenv:Body>'+
'</soapenv:Envelope>';

var soapfindcase='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://atria.cz/medical-cases/interchange">'+
'<soapenv:Header/>'+
'<soapenv:Body>'+
'<int:medicalCaseCriteria>'+
'<int:patientUid>5EXHW95L1NV32A2P</int:patientUid>'+
'<int:medicalOrganizationId>490</int:medicalOrganizationId>'+
'<int:caseTypeId>1</int:caseTypeId>'+
'<int:paymentMethodId>1</int:paymentMethodId>'+
'</int:medicalCaseCriteria>'+
'</soapenv:Body>'+
'</soapenv:Envelope>';


var soapzoginfo = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://atria.cz/hospitalRecords/types">'+
'<soapenv:Header/>'+
'<soapenv:Body>'+
'<typ:getHospitalRecordByIdRequest>'+
'<typ:id>{0}</typ:id>'+
'</typ:getHospitalRecordByIdRequest>'+
'</soapenv:Body>'+
'</soapenv:Envelope>';



var soapcaseinfo = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://atria.cz/medical-cases/interchange">'+
'<soapenv:Header/><soapenv:Body>'+
'<int:getCaseByIdRequest><int:id>{0}</int:id></int:getCaseByIdRequest>'+
'</soapenv:Body></soapenv:Envelope>';


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
            var param = "--allow-file-access-from-files --disable-web-security";
            var user = "rinat";
            var pass = "mX3Q3KK9R";
            var server = "https://rmis45.cdmarf.ru/";
            var urlmis = server;
            var loginURL = server+'cas/login?service=https%3A%2F%2Frmis45.cdmarf.ru%2Fj_spring_cas_security_check';
            var Xhr = window.XDomainRequest || window.XMLHttpRequest;
            var xhr = new Xhr();
            var loginpost = "";



   


            function get_selectrow() {
                get('selectedRows')               
            };


function getlnk(lnk) {
  xhr.open('GET', lnk, false);
  xhr.send(null);  
  return xhr.responseText;
}

function postlnk(lnk,pst) {
  xhr.open('POST', lnk, false);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(pst);  
  return xhr.responseText;
}


YUI_config = 
{
  groups: 
  { 
    gallery: 
    {
      base    : './../../build/',patterns:  { 'gallery-': {} }        
    }
  }
};

var Y = YUI().use("button","gallery-datatable-selection","datatable-sort","io-base",'dataschema-json',"datasource-function", "datasource-jsonschema", "datatable-datasource", function (Y) {

    Y.one('body').addClass('yui3-skin-sam');


   zogurl ='https://rmis45.cdmarf.ru/cases/records/ajax?'+
  'page=1&size=50&organizationId=25&departmentTypeId=3'+
  '&filterDepartmentId=481&createDate.from=31.10.2014&createDate.to=30.12.2015'+
  '&fields=id&fields=patientShortName&fields=uid&fields=admissionCaseDate&fields=admissionDate'+
  '&fields=admissionTime&fields=outcomeDate&fields=outcomeTime&fields=bedDaysAmount&fields=doctor'+
  '&fields=departmentName&fields=diagnosisCode&fields=mainDiagnosisNote&fields=profileName'+
  '&fields=resultName&fields=outcomeName&fields=signDate&fields=ward&fields=healthRecordExtension'+
  '&fields=healthRecordRoot&fields=patientId&fields=patientLabel&fields=healthRecordSigned&fields=canBeRemoved';

   function complete(id, o, args) {
        var id = id; // Transaction ID.
        var data = o.responseText; // Response data.
        var args = args[1]; // 'ipsum'.
    };


    myFunction = function(request) {
        var cfg = {   timeout : 3000, sync: true,  arguments: { 'foo' : 'bar' } };
        var data_in = Y.io(zogurl, cfg);   
        return data_in;
   };

    myCallback = {
         success: function(e){  dtable.datasource.onDataReturnInitializeTable(e);  dtable.set('selectedRecords', [1]); dtable.render('#tablediv'); },
        failure: function(e){  alert("Could not retrieve data: " + e.error.message); }
    };


    myidclick = function() {
      var back1='#eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19'
      window.open('https://rmis45.cdmarf.ru/cases/service/'+uslmas[this.id]+'/edit?backUrl=https%3A%2F%2Frmis45.cdmarf.ru%2Fcases%2Ftree'+back1,'_blank');
    }


    myvypklick = function() {
       var nn=( dtable.get('selectedRows'));
       var tt=nn[0].record;
       var kk=tt.get('patientShortName');
       var id=tt.get('id');
       window.open('https://rmis45.cdmarf.ru/cases/record/'+id+'/edit?backUrl=https%3A%2F%2Frmis45.cdmarf.ru%2Fcases%2Ftree','_blank');
    }

    

            function getcontext() {
                xhr.open('GET', server+'ctx-rest/getContext?userId='+u_login_id+'&sessionId=', true);
                xhr.onload = function() {                  
                  var arr = JSON.parse(xhr.responseText);
                  u_lpu_text = arr.contextForm.dataMap.ORGANIZATION.value;
                  u_otdel_text=arr.contextForm.dataMap.DEPARTMENT.value;
                  u_dol_text=arr.contextForm.dataMap.DEPARTMENT.value;
                  u_name_text=arr.contextForm.dataMap.EMPLOYEE.value;
                  gebi('userinfodiv').innerText=u_login_text+', '+u_lpu_text+', '+u_otdel_text+', '+u_name_text;
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send();
            };


            function sendloginpost2() {
                xhr.open('POST', loginURL, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader("Content-length", loginpost.length);
                xhr.onload = function() {  
                  var resp = xhr.responseText;        
                  var i = resp.indexOf('currentUserId'); 
                  i = resp.indexOf(':', i+1);
                  var j = resp.indexOf(',', i + 1);
                  u_login_id = resp.slice(i + 1, j);
                  getcontext();
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send(loginpost);
            };


    myloginklick = function() {
      xhr.open('GET', server+'cases/tree', true);
      xhr.onload = function() {
        var resp = xhr.responseText;        
        var i = resp.indexOf('currentUserId'); 
        if (i>=0)
        {
          i = resp.indexOf(':', i+1);
          var j = resp.indexOf(',', i + 1);
          u_login_id = resp.slice(i + 1, j);
        
          i = resp.indexOf('lsd-header-username'); 
          i = resp.indexOf('title',i); 
          i = resp.indexOf('"',i); 
          j = resp.indexOf('"', i + 1);
          u_login_text = resp.slice(i + 1, j);

          getcontext();  
        }
       else
       {                     
          i = resp.indexOf('name="lt"');
          i = resp.indexOf('"', i + 15);
          var j = resp.indexOf('"', i + 1);
          var lt = resp.slice(i + 1, j);
          i = resp.indexOf('name="execution"');
          i = resp.indexOf('"', i + 20);
          j = resp.indexOf('"', i + 1);
          var es = resp.slice(i + 1, j);
          loginpost = "mac=&username=" + gebi('ilogin').value + "&password=" + gebi('ipass').value + 
                      "&lt=" + lt + "&execution=" + es + "&_eventId=login";
          u_login_text=user;
          u_password=pass;
          sendloginpost2();
       } 
     };
     xhr.onerror = function() { alert("Error"); };
     xhr.send();               
    }


    mylogout = function ()
    {
                xhr.open('GET', server+'cases/logout', true);
                xhr.onload = function() {
                  myloginklick();
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send();
    }


    selfir = function() {
      alert(777);
    }

    mynewidclick = function() {
       var dateObj = new Date();
       var dat_d=dateObj.getDate();
       var dat_m=dateObj.getMonth();
       var dat_y=dateObj.getFullYear(); 
       var dat_ymd=dat_y+'-'+dat_m+'-'+dat_d;

       var nn=( dtable.get('selectedRows'));
       var tt=nn[0].record;
       var kk=tt.get('patientShortName');
       var id=tt.get('id');
       var patid=tt.get('patientId');
       var caseuid=tt.get('uid');

       var back1='#eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19'
       var postcfg = {  timeout : 3000, sync: true,   method: 'POST',   data:'' };

       postcfg.data=soapzoginfo.format(id)
       var data_in = Y.io('https://rmis45.cdmarf.ru/hsp-records-ws/hspRecords', postcfg);   
       var caseid = data_in.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes.item(1).textContent; 

       postcfg.data=soapcaseinfo.format(caseid)
       data_in = Y.io('https://rmis45.cdmarf.ru/cases-ws/cases', postcfg);   
       var patuid = data_in.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes.item(2).textContent; 

       postcfg.data=soapnewusl.format(caseid,id,uslmas[this.id],dat_ymd,patuid);
       data_in = Y.io('https://rmis45.cdmarf.ru/medservices-ws/renderedServices', postcfg);   
       var mynewid = data_in.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes.item(0).textContent; 


       window.open('https://rmis45.cdmarf.ru/cases/service/'+mynewid+'/edit?backUrl=https%3A%2F%2Frmis45.cdmarf.ru%2Fcases%2Ftree'+back1,'_blank');
    }

 
    mydtablecklick = function() {    //  клик по строке
       var nn=( dtable.get('selectedRows'));
       if (nn.length==0) return;
       var tt=nn[0].record;
       var kk=tt.get('patientShortName');
       var id=tt.get('id');             
       var patid=tt.get('patientId');
       var caseuid=tt.get('uid');

       var postcfg = {  timeout : 3000, sync: true,   method: 'POST',   data:'' };

       var uslurl = 'https://rmis45.cdmarf.ru/cases/tree/services/jsonp?value='+patid+'&page=1&start=0&limit=25&callback=';
       var cfg = {      timeout : 3000, sync: true,  arguments: { 'foo' : 'bar' } };     
       var data_in = Y.io(uslurl, cfg);   
       data_in=data_in.responseText.substr(1,data_in.responseText.length-3);
       var  arr_usl = JSON.parse(data_in);

       var txtbut = '';

       for(var it in arr_usl )
       {
          var idusl = arr_usl[it].id;          
          var namusl = arr_usl[it].fullName;
          var datusl = arr_usl[it].renderDate;
          if ((arr_usl[it].caseUid==caseuid)&&(arr_usl[it].fullName.indexOf("Перевод")<0))
          {
            txtbut=txtbut+'<button servid='+idusl+' id="oldusl'+it+'" class="yui3-button success"> Посмотреть '+
                            datusl+' '+namusl+'<br></button> <BR><BR>';
          }
          uslmas['oldusl'+it]=idusl;

       }             
       gebi("divoldbtn").innerHTML =  txtbut;
 
       for(var it in arr_usl )
       {
          if ((arr_usl[it].caseUid==caseuid)&&(arr_usl[it].fullName.indexOf('Перевод')<0))
          {  
             Y.one('#oldusl'+it).on("click", myidclick ,gebi("oldusl"+it));
          }
       } 
   };

    mydupdateklick = function() {  //клик по кнопке обновить
       myloginklick();
       dataSource.sendRequest({  callback: myCallback });       

       var uslurl = 'https://rmis45.cdmarf.ru/cases/finder?code=medicalCard.service.for.organization&params'+
                             '={%22entityId%22%3Anull%2C%22orgId%22%3A25%2C%22resGroupId%22%3Anull%2C%22date%22%3A%22'+
                             '14.11.2014%22%2C%22root%22%3Anull}&text={0}&page=1';

       var cfg = {      timeout : 3000, sync: true,  arguments: { 'foo' : 'bar' } };     
       var txtbut = '';
       var ind=0;

       var data_in = Y.io(uslurl.format(encodeURI('врача-гастроэнтеролога стационара')), cfg);   
       var  arr_usl = JSON.parse(data_in.responseText);

       for (iusl in arr_usl) {  
         txtbut=txtbut+'<button id="mycbtn'+ind+'" class="yui3-button yui3-button-selected"> Добавить '+arr_usl[iusl].label+'<br></button> <BR><BR>';
         uslmas['mycbtn'+ind]=arr_usl[iusl].value;
         ind++;
       }

       data_in = Y.io(uslurl.format(encodeURI('врача-аллерголога-иммунолога стационара')), cfg);   
       arr_usl = JSON.parse(data_in.responseText);

       for (iusl in arr_usl) {  
         txtbut=txtbut+'<button id="mycbtn'+ind+'" class="yui3-button yui3-button-selected"> Добавить '+arr_usl[iusl].label+'<br></button> <BR><BR>';
         uslmas['mycbtn'+ind]=arr_usl[iusl].value;
         ind++;
       }

       gebi("divbtn").innerHTML =  txtbut;
       for (iusl=0;iusl<ind;iusl++) {  
          Y.one('#mycbtn'+iusl).on("click",mynewidclick,gebi("mycbtn"+iusl));
       }
   };


   dataSource =  new Y.DataSource.Function({source:myFunction});
   dataSource.plug(Y.Plugin.DataSourceJSONSchema, {
        schema: {   resultListLocator: "list",
                    resultFields: [ "id","departmentName",  "patientShortName", "admissionDate","uid","patientId","outcomeDate" ]
                }
    });    
  
    dtable = new Y.DataTable({
         columns: [  { key: "departmentName",   label: "Отделение" },
                     { key:"patientShortName", label: "Пациент" },
                     { key:"admissionDate", label: "Поступил" },
                     { key:"outcomeDate", label: "Выписан" }],
         scrollable: 'y',
         sortable:   true,      
         selectionMode: 'row'
    });
    dtable.plug(Y.Plugin.DataTableDataSource, { datasource: dataSource });
    dtable.render('#tablediv'); 
    dtable.on("selected",mydtablecklick,dtable)


    var button = new Y.Button({
        srcNode:'#myPushButton',
        on: {'click':mydupdateklick }
    }).render();


    var button = new Y.Button({
        srcNode:'#vypbtn',
        on: {'click':myvypklick }
    }).render();

    var button = new Y.Button({
        srcNode:'#mylogin',
        on: {'click':mylogout}
    }).render();
});

</script>

<table border="1">
<tr><td>Логин  <input id=ilogin><BR> Пароль <input type="password" id=ipass> </td><td><button id="mylogin">Войти</button><button id="myPushButton">Обновить</button></td></tr>
</table>        


<table border="1">
  <tr><td> <div id="userinfodiv"></div> </td></tr>
  <tr><td>
    <table border="1">
       <tr><td  valign="top" width="700px" ><font size=2> <div id="tablediv"></div></font> </td><td  valign="top" >  
         <table border="1">
           <tr><td><div id=divoldbtn></td></tr>
           <tr><td><div id=divbtn></div></td></tr>
           <tr><td><button id="vypbtn" class="yui3-button warning" > Выписка/перевод</button></td></tr>
         </table>        
       </td></tr>
    </table>
  </td></tr>
</table>        

</BODY>
</HTML>
