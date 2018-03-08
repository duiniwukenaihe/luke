({
    extendsFrom: 'BaseField',
    oid: null,
    initialize: function (options) {
        this._super('initialize', [options]);
        var id = this.model.get('id');
        this.id = id;
    },
    _render: function () {
        this._super('_render');

        var id = this.model.get('id');
        this.id = id;
        envelopeID = '';
        var module = this.model.get('_module');
        this.module = module;
        url = window.location.href;
        srch = "#DP_DoucumentsPackets";
        n = url.indexOf(srch);
        l = srch.length;
        envelopeID = url.substr(n + l + 1);

        this.envelopeid = envelopeID;
        var params = "";
        if (module == 'Documents')
        {
            params = "func=getDocumentStatus&envID=" + envelopeID + "&docID=" + id;
        }
        else if (module == 'Contacts')
        {
            params = "func=getContatctStatus&envID=" + envelopeID + "&cntctID=" + id;
        }

        app.bwc.login(null, _.bind(function () {

            var oReq = new XMLHttpRequest();
            oReq.open("POST", "index.php?module=RT_DocuSign&action=getrelationshipstatus", false);
            oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oReq.onload = function (oEvent) {
                if (oReq.readyState == 4 && oReq.status == 200) {
                    ajaxresult = oReq.responseText;
                    aid = '#a_' + id;
                    if (ajaxresult)
                    {
                        $(aid).text(ajaxresult);
                    }
                }
            }
            oReq.send(params);
        }, this));
    }
})


