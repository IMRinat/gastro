/**
 * Created by Axis on 22.07.2015.
 */

M.myFunction=function (request) {     //функция для скачки списка зогов
    return X.io(M.zogurl, getcfg);
};

M.myCallback = {
    success: function(e){
        M.dtable.datasource.onDataReturnInitializeTable(e);
        M.dtable.set('selectedRecords', [1]);
        M.dtable.render('#tablediv');
    },
    failure: function(e){  alert("Could not retrieve data: " + e.error.message); }
};

M.mydupdateklick=function () {  //клик по кнопке обновить
    //обновляем данные таблицы
    M.dataSource.sendRequest({ callback: M.myCallback });

    clearObject(M.AddUsl);
    //получаем список услуг и генерируем текст с кнопками
    var data_in = X.io(M.uslurl.format(encodeURI('врача-гастроэнтеролога стационара')), getcfg);
    var arr_usl = JSON.parse(data_in.responseText);
    for (var iusl in arr_usl) {
        if (arr_usl.hasOwnProperty(iusl)) {
            addbutton(M.AddUsl,'addusl',arr_usl[iusl].value,'',' Добавить '+arr_usl[iusl].label,arr_usl[iusl].label);
        }
    }

    data_in = X.io(M.uslurl.format(encodeURI('врача-аллерголога-иммунолога стационара')), getcfg);
    arr_usl = JSON.parse(data_in.responseText);
    for (iusl in arr_usl) {
        if (arr_usl.hasOwnProperty(iusl)) {
            addbutton(M.AddUsl, 'addusl',arr_usl[iusl].value,'',' Добавить '+arr_usl[iusl].label,arr_usl[iusl].label);
        }
    }
    M.renderbut("divbtn",M.AddUsl,M.mynewidclick,Y,'class="yui3-button yui3-button-selected"');
};    //клик по кнопке обновить

M.logoutfun= function () { //логин и обновить
    var islogin=M.mylogout(M.getusername(), M.getuserpass());
    if (islogin){
        M.setcontext(M.getcontext());
        return;
        M.mydupdateklick();
    }

M.getFieldSelectRow = function (ff)
    {
        var nn=( M.dtable.get('selectedRows'));
        if (nn.length==0) return null;

        var tt=nn[0].record;
        var id=tt.get(ff);
        return id;
    }
};
