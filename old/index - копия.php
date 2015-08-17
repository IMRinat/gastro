<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>  <HEAD>  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />      </HEAD>    <BODY>
<script src="http://yui.yahooapis.com/3.18.0/build/yui/yui-min.js"></script>
        <script>

var soapcaseinfo = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://atria.cz/medical-cases/interchange">'+
'<soapenv:Header/><soapenv:Body>'+
'<int:getCaseByIdRequest><int:id>{0}</int:id></int:getCaseByIdRequest>'+
'</soapenv:Body></soapenv:Envelope>';

//информация о пользователе
var u_lpu;
var u_login;
var u_password;


//информация о пациенте
var p_uid;
var p_info;
var p_value;
var p_fio;

//информация о случае
    var caseinfo;
    caseinfo = {
id:'',
uid:'',
patientUid:'',
medicalOrganizationId:'',
caseTypeId:'',
careLevelId:'',
fundingSourceTypeId:'',
socialGroupId:'',
paymentMethodId:'',
careRegimenId:'',
initGoalId:'',
repeatCountId:'',
referralId:'',
admissionTypeId:'',
admissionReasonId:'',
admissionStateId:'',
drunkennessTypeId:'',
timeGoneId:'',
createdDate:'',
careProvidingFormId:'',
note:''
};



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



            function onlydig(str)
            {
                return /^\d+$/.test(str);
            }

            var param = "--allow-file-access-from-files --disable-web-security";
            var user = "rinat";
            var pass = "mX3Q3KK9R";
            var server = "https://rmis45.cdmarf.ru/";
            var url = server;
            var loginURL = server+'cas/login?service=https%3A%2F%2Frmis45.cdmarf.ru%2Fj_spring_cas_security_check';
            var Xhr = window.XDomainRequest || window.XMLHttpRequest;
            var xhr = new Xhr();
            var loginpost = "";
            
            function login() {

                xhr.open('GET', url, true);
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
                    sendloginpost();
                };
                xhr.onerror = function() { alert("Error"); };
                xhr.send();
            };

            function sendloginpost() {
                xhr.open('POST', loginURL, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader("Content-length", loginpost.length);
                xhr.onload = function() {  document.getElementById("resp").innerText = xhr.responseText; };
                xhr.onerror = function() { alert("Error"); };
                xhr.send(loginpost);
            };

            function sendSoapCaseInfo(caseid) {
                xhr.open('POST', 'https://rmis45.cdmarf.ru/cases-ws/cases', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader("Content-length", loginpost.length);
                xhr.onload = function() {  document.getElementById("resp").innerText = xhr.responseText; };
                xhr.onerror = function() { alert("Error"); };
                xhr.send(soapcaseinfo);
            };


YUI().use('autocomplete','io-base','datatype-xml','json-parse', 'json-stringify', function (Y) {
    Y.one('body').addClass('yui3-skin-sam');

    function complete(id, o, args) {
        var id = id; // Transaction ID.
        var data = o.responseText; // Response data.
        var args = args[1]; // 'ipsum'.
    };

    var cfg;
    cfg = {
        sync: true,
        arguments: { 'foo' : 'bar' }
    };


    var postcfg;
    postcfg = {
        sync: true,
        method: 'POST',
        data:''
    };




   function sourcefindpac(f)
   {
      var res = 
      onlydig(f)?'https://rmis45.cdmarf.ru/cases/patientSearchService?surname=&name=&patronymic=&gender=&age=&genderPrev=&agePrev=&document={query}':'https://rmis45.cdmarf.ru/cases/patientSearchService?quick={query}';
      return  res;
   }

   function sourcefindcase(f)
   {
      var res = 'https://rmis45.cdmarf.ru/cases/tree/cases/jsonp?value=327121&page=1&start=0&limit=25&sort=[{"property"%3A"openDate"%2C"direction"%3A"DESC"}]&callback={callback}';
      return  res;
   }

   function sourcefindfin()
   {
      var res = 'https://rmis45.cdmarf.ru/cases/finder?code=FundingSourceTypeByOrg&place=&params=%7B%22orgId%22%3A25%2C%22root%22%3Anull%7D&page=1&text=';
      return  res;

   }

   function sourceuroven()
   {
      var res = 'https://rmis45.cdmarf.ru/cases/finder?code=CareLevel&place=&params={"root"%3Anull}&text=&page=1';
      return  res;

   }

   function sourcecarelevel()
   {
      var res = 'https://rmis45.cdmarf.ru/cases/finder?code=case.careRegimen.by.caseType&place=&params={%22stepResultId%22%3Anull%2C%22stepCareResultId%22%3Anull%2C%22caseTypeId%22%3A1%2C%22root%22%3Anull}&text=&page=1';
      return  res;

   }

   function sourceoplat()
   {
      var res = 'https://rmis45.cdmarf.ru/cases/finder?code=PaymentMethodByCareRegimen&place=&params={%22careRegimenId%22%3A1%2C%22root%22%3Anull}&text=&page=1';
      return  res;

   }

   function sourcecelperv()
   {
      var res = 'https://rmis45.cdmarf.ru/cases/finder?code=CaseInitGoalByCaseType&place=&params={"caseTypeId"%3A1%2C"root"%3Anull}&text=&page=1';
      return  res;

   }

   function sourceobrachenie()
   {
      var res =  [{"label":"Первично","value":"1"},{"label":"Повторно","value":"2"}];
      return  res;

   }

   function sourcenaprav()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=referral&place=&params={%22patientId%22%3A327121%2C%22caseId%22%3A481770%2C%22serviceId%22%3A-1%2C%22root%22%3Anull}&text=&page=1';
      return  res;
   }

   function sourcespirt()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=DrunkennessType&place=&params={"root"%3Anull}&text=&page=1';
      return  res;
   }

   function sourceformokaz()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=careProvidingFormByCaseType&place=&params={"caseTypeId"%3A1%2C"root"%3Anull}&text=&page=1';
      return  res;
   }

   function sourcetimewait()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=TimeGone&place=&params={"root"%3Anull}&page=1&text=';
      return  res;
   }

   function sourceprichina()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=AdmissionReason&place=&params={"root"%3Anull}&text=&page=1';
      return  res;
   }

   function sourcesost()
   {
      var res =  'https://rmis45.cdmarf.ru/cases/finder?code=AdmissionState&place=&params={"root"%3Anull}&text=&page=1';
      return  res;
   }




function getlabelbyvalue(value,func)
{
   var data = func();
   if (typeof(func())=='string'  ) {
     var request = Y.io(func(), cfg);
     var data = Y.JSON.parse(request.responseText);
   };

   for(var it in data)
   {  var tx = data[it];
      if ( tx.value==value) {
         return ''+value+tx.label;}
   }
   return value;
}


  
  // поиск пациента
  var FINDFIO = Y.one('#ac-findfio');  
  FINDFIO.plug(Y.Plugin.AutoComplete, {
     minQueryLength: 3,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     queryDelay: 500,
     enableCache :false,
     source:  '',
     requestTemplate:   Y.bind( function (query) { return sourcefindpac(query);}),
     resultTextLocator: 'label',  
     resultListLocator: function (response) {      // Handling the list of results is mandatory, because the service can be 
            if (response.error) {  return [];    }    // Makes sure an array is returned even on an error.
            var query = response, addresses;
            if (query.count < 1 ) { return [];  }            
            addresses = query.list;         // Grab the actual addresses from the YQL query.             
            return addresses.length > 0 ? addresses : [addresses];}
  });


    //вывод инфы о сотруднике
    FINDFIO.ac.after('activeItemChange', function (e) {
        var newVal    = e.newVal;
        if (newVal) {  document.getElementById("infopac").innerHTML = newVal._data.result.raw.data.info;};
    });


//фильтр списка случаев, убираем с пустой датой открытия
function caseFilter(query, results) {
  return Y.Array.filter(results, function (result) { return result.raw.openDate != null;  });
}

function substringFilter(query, results) {
  return Y.Array.filter(results, function (result) {
  var q=query.toLowerCase();
  var t=result.text.toLowerCase();
  var i=t.indexOf(q);
 return i>=0;  });
}

   // поиск старых случаев
  var FINDOLDCASE = Y.one('#ac-oldcase');  
  FINDOLDCASE.plug(Y.Plugin.AutoComplete, {
     minQueryLength: 3,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     queryDelay: 500,
     enableCache :false,
     maxResults:20,
     resultFilters: caseFilter,
     source:  sourcefindcase(),
     resultTextLocator:  function (result) {
       var od=result.openDate;
       var md=result.mainDiagnosis;
       var cd=result.closeDate;
       var status='Открыт';
       if (cd!=null){status='Закрыт';}
       return status+' '+od + ': ' + md; }, 
  });

  FINDOLDCASE.on('focus', function(){this.ac.fire('query')});

    FINDOLDCASE.ac.after('select', function (e) {
       postcfg.data=soapcaseinfo.format(e.result.raw.id);
       var request = Y.io('https://rmis45.cdmarf.ru/cases-ws/cases', postcfg);
       var elems = request.responseXML.documentElement.childNodes.item(0).childNodes.item(0).childNodes; 

       for(var it in caseinfo) {caseinfo[it]='';}


       for(var it in elems)
       {
          var tx = elems.item(it).textContent;
          //теперь надо найти название услуги
          
       }       

       for(var it in caseinfo)
       {
            if (it=='uid')                  {gebi("ac-casenum").value   =caseinfo[it];}
            if (it=='fundingSourceTypeId')  {gebi("ac-findfin").value   =caseinfo[it];}
            if (it=='careLevelId')          {gebi("ac-uroven").value    =caseinfo[it];}
            if (it=='careRegimenId')        {gebi("ac-uslokaz").value   =caseinfo[it];}
            if (it=='paymentMethodId')      {gebi("ac-oplat").value     =caseinfo[it];}
            if (it=='initGoalId')           {gebi("ac-celperv").value   =caseinfo[it];}
            if (it=='repeatCountId')        {gebi("ac-obrachenie").value=caseinfo[it];}
            if (it=='referralId')           {gebi("ac-naprav").value    =caseinfo[it];}
            if (it=='note')                 {gebi("ac-prim").value      =caseinfo[it];}
            if (it=='drunkennessTypeId')    {gebi("ac-spirt").value     =caseinfo[it];}
            if (it=='careProvidingFormId')  {gebi("ac-formaokaz").value =caseinfo[it];}
            if (it=='timeGoneId')           {gebi("ac-timewait").value  =caseinfo[it];}
            if (it=='admissionReasonId')    {gebi("ac-prichina").value  =caseinfo[it];}
            if (it=='admissionStateId')     {gebi("ac-sost").value      =caseinfo[it];}
//return;

            if (it=='fundingSourceTypeId')  {gebi("ac-findfin").value   =getlabelbyvalue(caseinfo[it],sourcefindfin);}
            if (it=='careLevelId')          {gebi("ac-uroven").value    =getlabelbyvalue(caseinfo[it],sourceuroven);}
            if (it=='careRegimenId')        {gebi("ac-uslokaz").value   =getlabelbyvalue(caseinfo[it],sourcecarelevel);}
            if (it=='paymentMethodId')      {gebi("ac-oplat").value     =getlabelbyvalue(caseinfo[it],sourceoplat);}
            if (it=='initGoalId')           {gebi("ac-celperv").value   =getlabelbyvalue(caseinfo[it],sourcecelperv);}
            if (it=='repeatCountId')        {gebi("ac-obrachenie").value=getlabelbyvalue(caseinfo[it],sourceobrachenie);}
            if (it=='referralId')           {gebi("ac-naprav").value    =getlabelbyvalue(caseinfo[it],sourcenaprav);}
            if (it=='note')                 {gebi("ac-prim").value      =caseinfo[it];}
            if (it=='drunkennessTypeId')    {gebi("ac-spirt").value     =getlabelbyvalue(caseinfo[it],sourcespirt);}
            if (it=='careProvidingFormId')  {gebi("ac-formaokaz").value =getlabelbyvalue(caseinfo[it],sourceformokaz);}
            if (it=='timeGoneId')           {gebi("ac-timewait").value  =getlabelbyvalue(caseinfo[it],sourcetimewait);}
            if (it=='admissionReasonId')    {gebi("ac-prichina").value  =getlabelbyvalue(caseinfo[it],sourceprichina);}
            if (it=='admissionStateId')     {gebi("ac-sost").value      =getlabelbyvalue(caseinfo[it],sourcesost);}
       }


    });


  // поиск видов финансирования 
  Y.one('#ac-findfin').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourcefindfin(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-findfin').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск условий оказания 
  Y.one('#ac-uslokaz').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourcecarelevel(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-uslokaz').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск уровня мед помощи 
  Y.one('#ac-uroven').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourceuroven(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-uroven').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск направления 
  Y.one('#ac-naprav').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     queryDelay: 500,
     source: sourcenaprav(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-naprav').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск цели обращения
  Y.one('#ac-celperv').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     enableCache :false,
     resultFilters: substringFilter,
     width: 'auto',
     queryDelay: 500,
     source: sourcecelperv(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-celperv').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});


  // поиск причины обращения
  Y.one('#ac-prichina').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourceprichina(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-prichina').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск формы оказания
  Y.one('#ac-formaokaz').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourceformokaz(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-formaokaz').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск обращения в текущем году
  Y.one('#ac-obrachenie').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourceobrachenie(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-obrachenie').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});


  // поиск способа оплаты
  Y.one('#ac-oplat').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourceoplat(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-oplat').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск состояния при поступлении
  Y.one('#ac-sost').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     enableCache :false,
     resultFilters: substringFilter,
     width: 'auto',
     queryDelay: 500,
     source: sourcesost(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-sost').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск вида опьянения
  Y.one('#ac-spirt').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourcespirt(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-spirt').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

  // поиск времени прошедшего
  Y.one('#ac-timewait').plug(Y.Plugin.AutoComplete, {
     minQueryLength: 0,          // To display the suggestions, the minimum of typed chars is five.     
     activateFirstItem: true,    // Highlight the first result of the list.        
     width: 'auto',
     enableCache :false,
     resultFilters: substringFilter,
     queryDelay: 500,
     source: sourcetimewait(),
     resultTextLocator: 'label',  
  });
  Y.one('#ac-timewait').on('focus', function(){ if (this._node.value=='') this.ac.fire('query')});

});


YUI().use("gallery-datatable-selection","datatable-sort","io-base",'dataschema-json',"datasource-function", "datasource-jsonschema", "datatable-datasource", function (Y) {

    var url ='https://rmis45.cdmarf.ru/cases/records/ajax?'+
  'page=1&size=18&organizationId=25&departmentTypeId=3'+
  '&filterDepartmentId=481&createDate.from=31.10.2014&createDate.to=14.11.2014'+
  '&fields=id&fields=patientShortName&fields=uid&fields=admissionCaseDate&fields=admissionDate'+
  '&fields=admissionTime&fields=outcomeDate&fields=outcomeTime&fields=bedDaysAmount&fields=doctor'+
  '&fields=departmentName&fields=diagnosisCode&fields=mainDiagnosisNote&fields=profileName'+
  '&fields=resultName&fields=outcomeName&fields=signDate&fields=ward&fields=healthRecordExtension'+
  '&fields=healthRecordRoot&fields=patientId&fields=patientLabel&fields=healthRecordSigned&fields=canBeRemoved';


   var myFunction = function(request) {
        var cfg = {   sync: true,  arguments: { 'foo' : 'bar' } };
        var data_in = Y.io(url, cfg);   
        return data_in;
   };

   var myCallback = {
         success: function(e){  dtable.datasource.onDataReturnInitializeTable(e); },
        failure: function(e){  alert("Could not retrieve data: " + e.error.message); }
    };

   var dataSource =  new Y.DataSource.Function({source:myFunction});
   dataSource.plug(Y.Plugin.DataSourceJSONSchema, {
        schema: {   resultListLocator: "list",
                    resultFields: [ "departmentName",  "patientShortName", "admissionDate" ]
                }
    });    
  
    var dtable = new Y.DataTable({
         columns: [  { key: "departmentName",   label: "Отделение" },
                     { key:"patientShortName", label: "Пациент" },
                     { key:"admissionDate", label: "Поступил" }],
         scrollable: 'y',
         sortable:   true,      
         highlightMode: 'row',
         selectionMode: 'row'
    });
    dtable.plug(Y.Plugin.DataTableDataSource, { datasource: dataSource });
    dataSource.sendRequest({  callback: myCallback });
    dtable.render('#tablediv');  
});

</script>

<table border="1">
<tr>
  <td height="200"><div id="resp">  resp      </div></td>
  <td height="200"><div id="infopac">  infopac    </div></td>
  <td height="200"><div id="infouser">  infouser  </div></td></tr>
<tr><td>                                              </td><td><input type="button" onclick=login()  value="Логин"></td></tr>
<tr><td>Вид Случая                                    </td><td><input size=100 id=ac-typecase readonly value="Случай поликлинического обслуживания"></input></td></tr>
<tr><td>Быстрый поиск по ФИО                          </td><td><input size=100 id=ac-findfio></input></td></tr>
<tr><td>Старый случай                                 </td><td><input size=100 id=ac-oldcase></input></td></tr>
<tr><td>                                              </td><td><input type="button" onclick="sendSoapCaseInfo()"  value="Новый случай"></td></tr>
<tr><td>Номер случая                                  </td><td><input size=100 id=ac-casenum></input></td></tr>
<tr><td>Вид финансирования                            </td><td><input size=100 id=ac-findfin></input></td></tr>
<tr><td>Условия Оказания                              </td><td><input size=100 id=ac-uslokaz></input></td></tr>
<tr><td>Уровень Медицинской помощи                    </td><td><input size=100 id=ac-uroven></input></td></tr>
<tr><td>Направление                                   </td><td><input size=100 id=ac-naprav></input></td></tr>
<tr><td>Цель первичного обращения                     </td><td><input size=100 id=ac-celperv></input></td></tr>
<tr><td>Причина обращения                             </td><td><input size=100 id=ac-prichina></input></td></tr>
<tr><td>Форма оказания                                </td><td><input size=100 id=ac-formaokaz></input></td></tr>
<tr><td>Обращение с данным заболеванием в текущем году</td><td><input size=100 id=ac-obrachenie></input></td></tr>
<tr><td>Способ оплаты                                 </td><td><input size=100 id=ac-oplat></input></td></tr>
<tr><td>Состояние пациента при поступлении            </td><td><input size=100 id=ac-sost></input></td></tr>
<tr><td>Вид опьянения                                 </td><td><input size=100 id=ac-spirt></input></td></tr>
<tr><td>Время прошедшее с момента причины             </td><td><input size=100 id=ac-timewait></input></td></tr>
<tr><td>Примечание                                    </td><td><input size=100 id=ac-prim></input></td></tr>
<tr><td>----</td></tr>
<tr><td>Посещение</td></tr>
<tr><td>Дата                                          </td><td><input size=100 id=ac-datavis></input></td></tr>
<tr><td>Время                                         </td><td><input size=100 id=ac-timevis></input></td></tr>
<tr><td>Ресурс                                        </td><td><input size=100 id=ac-res></input></td></tr>
<tr><td>Врач                                          </td><td><input size=100 id=ac-vrach></input></td></tr>
<tr><td>Медсестра                                     </td><td><input size=100 id=ac-mses></input></td></tr>
<tr><td>Цель                                          </td><td><input size=100 id=ac-celvis></input></td></tr>
<tr><td>Место обслуживания                            </td><td><input size=100 id=ac-mesto></input></td></tr>
<tr><td>Актив                                         </td><td><input size=100 id=ac-activ></input></td></tr>
<tr><td>Профиль                                       </td><td><input size=100 id=ac-profil></input></td></tr>
<tr><td>МЭС                                           </td><td><input size=100 id=ac-mes></input></td></tr>
<tr><td>Услуга                                        </td><td><input size=100 id=ac-servic></input></td></tr>
<tr><td>Отказ пациента                                </td><td><input size=100 id=ac-otkaz></input></td></tr>
<tr><td>Вид Финансирования                            </td><td><input size=100 id=ac-finvis></input></td></tr>
<tr><td>УЕТ                                           </td><td><input size=100 id=ac-uet></input></td></tr>
<tr><td>основной                                      </td><td><input size=100 id=ac-maindiag></input></td></tr>
<tr><td>Вид                                           </td><td><input size=100 id=ac-typediag></input></td></tr>
<tr><td>Диагноз по МКБ                                </td><td><input size=100 id=ac-mkbdiag></input></td></tr>
<tr><td>Дополнение                                    </td><td><input size=100 id=ac-dopoldiag></input></td></tr>
<tr><td>Характер заболевания                          </td><td><input size=100 id=ac-xardiag></input></td></tr>
<tr><td>Подозрение                                    </td><td><input size=100 id=ac-podozren></input></td></tr>
<tr><td>Д-учет                                        </td><td><input size=100 id=ac-duchet></input></td></tr>
<tr><td>Начало больничного                            </td><td><input size=100 id=ac-startbol></input></td></tr>
<tr><td>Конец больничного                             </td><td><input size=100 id=ac-endbol></input></td></tr>
<tr><td>                                              </td><td><input type="button" onclick=""  value="Сохранить"></td></tr>
</table>        

<div id="tablediv"></div>


</BODY>
</HTML>
