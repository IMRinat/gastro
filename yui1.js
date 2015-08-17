/**
 * Created by Axis on 26.06.2015.
 */
//var param = "--allow-file-access-from-files --disable-web-security";
//{"state":{"TabBody":{"active":false},"protocolTabTabBody":{"active":true}}}
//eyJzdGF0ZSI6eyJUYWJCb2R5Ijp7ImFjdGl2ZSI6ZmFsc2V9LCJwcm90b2NvbFRhYlRhYkJvZHkiOnsiYWN0aXZlIjp0cnVlfX19

YUI_config =
{
    groups:
    {
        gallery:
        {
            base    : './../../../../../../../../yui/build/',patterns:  { 'gallery-': {} }
        }
    }
};

    var Y = YUI().use("node","button","gallery-datatable-selection","datatable-sort",'dataschema-json',"datasource-function", "datasource-jsonschema", "datatable-datasource",function (Y) {

    Y.one('body').addClass('yui3-skin-sam');

     //!!!!!!!!!!!!!!!!!!!!!
    M.dataSource =  new Y.DataSource.Function({source: M.myFunction});
    M.dataSource.plug(Y.Plugin.DataSourceJSONSchema, {
        schema: {   resultListLocator: "list",
          resultFields: [ "id","departmentName",  "patientShortName", "admissionDate","uid","patientId","outcomeDate" ]
        }
    });

    //!!!!!!!!!!!!!!!!!!!!!!
    M.dtable = new Y.DataTable({
        columns: [  { key: "departmentName",   label: "Отделение" },
            { key:"patientShortName", label: "Пациент" },
            { key:"admissionDate", label: "Поступил" },
            { key:"outcomeDate", label: "Выписан" }],
        scrollable: 'y',
        sortable:   true,
        selectionMode: 'row'
    });
    M.dtable.plug(Y.Plugin.DataTableDataSource, { datasource: M.dataSource });
    M.dtable.render('#tablediv');
    M.dtable.on("selected", M.mydtablecklick,M.dtable);

    //!!!!!!!!!!!!!!!!!!!!
    M.button1 = new Y.Button({
        srcNode:'#vypbtn',
        on: {'click':M.myvypklick }
    }).render();

    //!!!!!!!!!!!!!!!!!!!!
    M.button2 = new Y.Button({
        srcNode:'#mylogin',
        on: {'click':M.logoutfun }
    }).render();
 });

