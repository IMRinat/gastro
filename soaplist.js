/**
 * Created by Axis on 26.06.2015.
 */
M.soapnewusl =
'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://atria.cz/renderedServices/types">\
<soapenv:Header/>\
<soapenv:Body>\
<typ:sendRenderedServicesRequest>\
<typ:medicalCaseId>{0}</typ:medicalCaseId>\
<typ:stepId>{1}</typ:stepId>\
<typ:serviceId>{2}</typ:serviceId>\
<typ:dateFrom>{3}</typ:dateFrom>\
<typ:timeFrom>{4}</typ:timeFrom>\
<typ:isRendered>true</typ:isRendered>\
<typ:quantity>1</typ:quantity>\
<typ:resourceGroupId>{5}</typ:resourceGroupId>\
<typ:fundingSourceTypeId>8</typ:fundingSourceTypeId>\
<typ:patientUid>{6}</typ:patientUid>\
<typ:orgId>25</typ:orgId>\
</typ:sendRenderedServicesRequest>\
</soapenv:Body>\
</soapenv:Envelope>';

M.soapzoginfo =
'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://atria.cz/hospitalRecords/types">\
<soapenv:Header/>\
<soapenv:Body>\
<typ:getHospitalRecordByIdRequest>\
<typ:id>{0}</typ:id>\
</typ:getHospitalRecordByIdRequest>\
</soapenv:Body>\
</soapenv:Envelope>';


M.soapcaseinfo =
'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:int="http://atria.cz/medical-cases/interchange">\
<soapenv:Header/><soapenv:Body>\
<int:getCaseByIdRequest><int:id>{0}</int:id></int:getCaseByIdRequest>\
</soapenv:Body></soapenv:Envelope>';



M.user = "rinat";
M.pass = "mX3Q3KK9R";
M.proxy="http://10.14.17.31:9083/proxyabdul.php?url=";
//M.proxy="";
M.server = M.proxy+"https://45.r-mis.ru/";

M.loginURL = M.server+'cas/login?service=https%3A%2F%2F45.r-mis.ru%2Fj_spring_cas_security_check';

M.zogurl =M.server+'cases/records/ajax?'+
    'page=1%26size=130%26organizationId=25%26departmentTypeId=3'+
    '%26filterDepartmentId=481%26createDate.from=31.10.2014%26createDate.to=30.12.2015'+
    '%26fields=id%26fields=patientShortName%26fields=uid%26fields=admissionCaseDate%26fields=admissionDate'+
    '%26fields=admissionTime%26fields=outcomeDate%26fields=outcomeTime%26fields=bedDaysAmount%26fields=doctor'+
    '%26fields=departmentName%26fields=diagnosisCode%26fields=mainDiagnosisNote%26fields=profileName'+
    '%26fields=resultName%26fields=outcomeName%26fields=signDate%26fields=ward%26fields=healthRecordExtension'+
    '%26fields=healthRecordRoot%26fields=patientId%26fields=patientLabel%26fields=healthRecordSigned%26fields=canBeRemoved';


M.uslurl = M.server+'cases/finder?code=medicalCard.service.for.organization%26params'+
    '={%22entityId%22%3Anull%2C%22orgId%22%3A25%2C%22resGroupId%22%3Anull%2C%22date%22%3A%22'+
    '14.11.2014%22%2C%22root%22%3Anull}%26text={0}%26page=1';

M.uslpaturl = M.server+'cases/tree/services/jsonp?value={0}%26page=1%26start=0%26limit=25%26callback=';

M.back1 = '#eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19';
