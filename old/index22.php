<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>  <HEAD>  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />   
<link rel="stylesheet" href="http://yui.yahooapis.com/3.18.0/build/cssbutton/cssbutton.css">
   </HEAD>    <BODY>
<script src="http://yui.yahooapis.com/3.18.0/build/yui/yui-min.js"></script>
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

//глобальные 
var uslmas={};
var url;
var myFunction;
var myCallback;
var dtable ;
var dataSource ;
var cfg;
var soaplistuslbystep;

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



            function testlogin() {
                xhr.open('GET', server +'cases/tree', true);
                xhr.onload = function() {
                    var i = xhr.responseText.indexOf('name="lt"');
                    i = xhr.responseText.indexOf('"', i + 15);
                    var j = xhr.responseText.indexOf('"', i + 1);
                    var lt = xhr.responseText.slice(i + 1, j);
                    i = xhr.responseText.indexOf('name="execution"');
                    i = xhr.responseText.indexOf('"', i + 20);
                    j = xhr.responseText.indexOf('"', i + 1);
                    var es = xhr.responseText.slice(i + 1, j);
                    loginpost = "mac=&username=" + user + "&password=" + pass + "&lt=" + lt + "&execution=" + es + "&_eventId=login";
                    u_login_text=user;
                    u_password=pass;
                    sendloginpost();
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send();
            };


            function getcontext() {

                xhr.open('GET', 'https://rmis45.cdmarf.ru/ctx-rest/getContext?userId='+u_login_id+'&sessionId=', true);
                xhr.onload = function() {
                    var json = xhr.responseText;
                    var arr = JSON.parse(json);
                    u_lpu_text = arr.contextForm.dataMap.ORGANIZATION.value;
                    u_otdel_text=arr.contextForm.dataMap.DEPARTMENT.value;
                    u_dol_text=arr.contextForm.dataMap.DEPARTMENT.value;
                    u_name_text=arr.contextForm.dataMap.EMPLOYEE.value;
                    gebi('userinfodiv').innerText=u_login_text+', '+u_lpu_text+', '+u_otdel_text+', '+u_name_text;

                };
                xhr.onerror = function() { alert("Ошибка контекста"); };
                xhr.send();
            };

            
            function login() {
                xhr.open('GET', server +'cases/tree', true);
                xhr.onload = function() {
                    var i = xhr.responseText.indexOf('currentUserId'); 
                    if (i>=0){
                      i = xhr.responseText.indexOf(':', i+1);
                      var j = xhr.responseText.indexOf(',', i + 1);
                      u_login_id = xhr.responseText.slice(i + 1, j);
                      getcontext();  
                    }
                    else{                     
                      i = xhr.responseText.indexOf('name="lt"');
                      i = xhr.responseText.indexOf('"', i + 15);
                      var j = xhr.responseText.indexOf('"', i + 1);
                      var lt = xhr.responseText.slice(i + 1, j);
                      i = xhr.responseText.indexOf('name="execution"');
                      i = xhr.responseText.indexOf('"', i + 20);
                      j = xhr.responseText.indexOf('"', i + 1);
                      var es = xhr.responseText.slice(i + 1, j);
                      loginpost = "mac=&username=" + user + "&password=" + pass + "&lt=" + lt + "&execution=" + es + "&_eventId=login";
                      u_login_text=user;
                      u_password=pass;
                      sendloginpost();
                    }
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send();
            };


            function get_selectrow() {
                get('selectedRows')               
            };


            function sendloginpost() {
                xhr.open('POST', loginURL, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader("Content-length", loginpost.length);
                xhr.onload = function() {  
                   //gebi("resp").innerText = xhr.responseText; 
                   var i = xhr.responseText.indexOf('currentUserId'); 
                   i = xhr.responseText.indexOf(':', i+1);
                   var j = xhr.responseText.indexOf(',', i + 1);
                   u_login_id = xhr.responseText.slice(i + 1, j);
                   getcontext();
                };
               
                xhr.onerror = function() { alert("Error"); };
                xhr.send(loginpost);
            };

var Y = YUI().use("button","gallery-datatable-selection","datatable-sort","io-base",'dataschema-json',"datasource-function", "datasource-jsonschema", "datatable-datasource", function (Y) {

    Y.one('body').addClass('yui3-skin-sam');


   url ='https://rmis45.cdmarf.ru/cases/records/ajax?'+
  'page=1&size=50&organizationId=25&departmentTypeId=3'+
  '&filterDepartmentId=481&createDate.from=31.10.2014&createDate.to=30.11.2014'+
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
        var cfg = {   sync: true,  arguments: { 'foo' : 'bar' } };
        var data_in = Y.io(url, cfg);   
        return data_in;
   };

    myCallback = {
         success: function(e){  dtable.datasource.onDataReturnInitializeTable(e); },
        failure: function(e){  alert("Could not retrieve data: " + e.error.message); }
    };


    myidclick = function() {
      var back1='#eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19'
      window.open('https://rmis45.cdmarf.ru/cases/service/'+uslmas[this.id]+'/edit?backUrl='+back1,'_blank');
    }


 
    mydtablecklick = function() {
       var nn=( dtable.get('selectedRows'));
       var tt=nn[0].record;
       var kk=tt.get('patientShortName');
       var id=tt.get('id');
       var patid=tt.get('patientId');
       var caseuid=tt.get('uid');

       var postcfg = {  sync: true,   method: 'POST',   data:'' };

       var uslurl = 'https://rmis45.cdmarf.ru/cases/tree/services/jsonp?value='+patid+'&page=1&start=0&limit=25&callback=';
       var cfg = {      sync: true,  arguments: { 'foo' : 'bar' } };     
       var data_in = Y.io(uslurl, cfg);   
       data_in=data_in.responseText.substr(1,data_in.responseText.length-3);
       var  arr_usl = JSON.parse(data_in);

       var txtbut = '';

       for(var it in arr_usl )
       {
          var idusl = arr_usl[it].id;          
          var namusl = arr_usl[it].fullName;
          var datusl = arr_usl[it].renderDate;
          if (arr_usl[it].caseUid==caseuid)
          {
            txtbut=txtbut+'<button servid='+idusl+' id="oldusl'+it+'" class="yui3-button yui3-button-selected"> Посмотреть '+datusl+' '+namusl+'<br></button> <BR><BR>';
          }
          uslmas['oldusl'+it]=idusl;

       }             
       gebi("divoldbtn").innerHTML =  txtbut;
 
       for(var it in arr_usl )
       {
          if (arr_usl[it].caseUid==caseuid)
          {  
             Y.one('#oldusl'+it).on("click", myidclick ,gebi("oldusl"+it));
          }
       } 



      // postcfg.data=soapzoginfo.format(id)
      // var data_in = Y.io('https://rmis45.cdmarf.ru/hsp-records-ws/hspRecords', postcfg);   
      // var caseid = data_in.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes.item(1).textContent; 

      // postcfg.data=soaplistuslbystep.format(caseid)
      // data_in = Y.io('https://rmis45.cdmarf.ru/medservices-ws/renderedServices', postcfg);   
       
      // var elems = data_in.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes; 

      // for(var it in elems)
      // {
      //    var tx = elems.item(it).textContent;          
      // }             


   };

    mydupdateklick = function() {
       dataSource.sendRequest({  callback: myCallback });
       var uslurl = 'https://rmis45.cdmarf.ru/cases/finder?code=medicalCard.service.for.organization&params'+
                             '={%22entityId%22%3Anull%2C%22orgId%22%3A25%2C%22resGroupId%22%3Anull%2C%22date%22%3A%22'+
                             '14.11.2014%22%2C%22root%22%3Anull}&text=%D0%B2%D1%80%D0%B0%D1%87%D0%B0-%D0%B3%D0%B0%D1%81'+
                             '%D1%82%D1%80%D0%BE%D1%8D%D0%BD%D1%82%D0%B5%D1%80%D0%BE%D0%BB%D0%BE%D0%B3%D0%B0%20%D1%81%D1'+
                             '%82%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%B0%D1%80%D0%B0&page=1';

       var cfg = {      sync: true,  arguments: { 'foo' : 'bar' } };     
       var data_in = Y.io(uslurl, cfg);   
       var  arr_usl = JSON.parse(data_in.responseText);
       var txtbut = '';
       for (iusl in arr_usl) {  
         txtbut=txtbut+'<button id="mycbtn'+iusl+'" class="yui3-button yui3-button-selected"> Добавить '+arr_usl[iusl].label+'<br></button> <BR><BR>';
       }

       gebi("divbtn").innerHTML =  txtbut;
       for (iusl in arr_usl) {  
          Y.one('#mycbtn'+iusl).on("click",mydtablecklick,dtable);
       }
   };


   dataSource =  new Y.DataSource.Function({source:myFunction});
   dataSource.plug(Y.Plugin.DataSourceJSONSchema, {
        schema: {   resultListLocator: "list",
                    resultFields: [ "id","departmentName",  "patientShortName", "admissionDate","uid","patientId" ]
                }
    });    
  
    dtable = new Y.DataTable({
         columns: [  { key: "departmentName",   label: "Отделение" },
                     { key:"patientShortName", label: "Пациент" },
                     { key:"admissionDate", label: "Поступил" }],
         scrollable: 'y',
         sortable:   true,      
         selectionMode: 'row'
    });
    dtable.plug(Y.Plugin.DataTableDataSource, { datasource: dataSource });
    dtable.render('#tablediv'); 

    Y.one("#myBtn2").on("click",mydtablecklick,dtable);

    var button = new Y.Button({
        srcNode:'#myPushButton',
        on: {'click':mydupdateklick }
    }).render();

});

</script>

<table border="1">
<tr>
  <td><div id="resp">  resp      </div></td>
<tr><td>  </td><td><input type="button" onclick=login()  value="Логин"></td></tr>
<tr><td>  </td><td><button id="myPushButton">Обновить</button>         </td></tr>
<tr><td>  </td><td><button id="myBtn2">Выделенная строка</button>      </td></tr>

</table>        


<table border="1">
  <tr><td> <div id="userinfodiv"></div> </td></tr>
  <tr><td>
    <table border="1">
       <tr><td  valign="top" > <div id="tablediv"></div> </td><td  valign="top" >  
         <table border="1">
           <tr><td><div id=divoldbtn></td></tr>
           <tr><td><div id=divbtn></div></td></tr>
         </table>        
       </td></tr>
    </table>
  </td></tr>
</table>        

</BODY>
</HTML>
