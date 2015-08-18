/** * Created by Axis on 03.07.2015. */
M.ViewUsl={};
M.AddUsl={};

M.myidclick= function () {   //клик по кнопке посмотреть
    M.OpenIdUsl(M.ViewUsl[this._node.id]['idusl']);
};

M.myvypklick=function () {  //клик по кнопке выписать
    var id = M.getFieldSelectRow('id');
    window.open(M.serverMIS+'cases/record/'+id+'/edit?backUrl=%2Ftree','_blank');
};

M.mynewidclick=function () {   //клик по кнопке добавить
    var D = datobg();

    var redirid = get_id_by_datusl_misname(M.ViewUsl, D.dat_ymd_dot, M.AddUsl[this._node.id]['misname']) ;
    // если такая услуга в этот день уже есть, то открываем
    if (redirid != null) {
        M.OpenIdUsl(redirid);
        return;
    }

    var idzog = M.getFieldSelectRow('id');

    var zoginfo = M.GetZogINfo(idzog);
    var caseid = getxmlparam(zoginfo,3,'caseId');

    var caseinfo = M.GetCaseINfo(caseid);
    var patuid = getxmlparam(caseinfo,3,'patientUid');

    //добавляем новую услугу
    var respId= M.NewUsl(caseid, idzog, M.AddUsl[this._node.id]['idusl'], D.dat_ymd, D.tim_hms, M.get_res_by_login(M.user), patuid);
    var mynewid = getxmlparam( respId,3,'id');

    M.mydtablecklick();//имитируем клик по строке чтобы обновились кнопки
    M.OpenIdUsl(mynewid);
};


M.mydtablecklick=function () {    //  клик по строке
    var patid=M.getFieldSelectRow('patientId');
    var caseuid=M.getFieldSelectRow('uid');

    var data_in = X.io(M.uslpaturl.format(patid) , getcfg);
    data_in=data_in.responseText.substr(1,data_in.responseText.length-3);
    var  arr_usl = JSON.parse(data_in);

    clearObject(M.ViewUsl);
    for(var it in arr_usl )  {//собираем текст спсика кнопок
        if (arr_usl.hasOwnProperty(it)){
            if ((arr_usl[it].caseUid==caseuid)&&(arr_usl[it].fullName.indexOf("Перевод")<0)) {
                addbutton(M.ViewUsl, 'viewusl',arr_usl[it].id,arr_usl[it].renderDate,
                    ' Посмотреть ' +arr_usl[it].renderDate+' '+ arr_usl[it].fullName,arr_usl[it].fullName);
            }
        }
    }
    M.renderbut("divoldbtn",M.ViewUsl,M.myidclick,Y,'class="yui3-button success"');
};



