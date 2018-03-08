({
    offset: 0,
    limit: 20,
    set_datepicker: true,
    track_date_from: null,
    track_date_to: null,
    select_module: null,
    select_status: null,
    sort_by: 'date_entered',
    order: 'desc',
    date_format: '',
    plugins: ['Dashlet', 'Dropdown'],
    events: {
        'click .more-env': 'moreRecords',
        'click .show_contacts': 'togglePanel',
        'click .cancel_from': 'cancelFrom',
        'click .cancel_to': 'cancelTo',
        'click .sort': 'sortEnvelopes',
        'change [name="select_module"]': 'filterRecords',
        'change input[name="track_date_to"]': 'filterRecords',
        'change [name="select_status"]': 'filterRecords',
    },
    refreshClicked: function () {
        this.showDetails();
        return;
    },
    loadData: function (options) {
        this.offset = 0;
        this.showDetails();
    },
    moreRecords: function () {
        this.offset = this.offset + this.limit;
        this.showDetails();
    },
    filterRecords: function () {
        this.offset = 0;
        this.track_date_from = $('[name="track_date_from"]').val();
        this.track_date_to = $('[name="track_date_to"]').val();
        this.select_module = $('[name="select_module"]').val();
        this.select_status = $('[name="select_status"]').val();
        this.showDetails();
    },
    cancelFrom: function () {
        $(".cancel_from").addClass("hide");
        $('[name="track_date_from"]').val('');
        this.filterRecords();
    },
    cancelTo: function () {
        $(".cancel_to").addClass("hide");
        $('[name="track_date_to"]').val('');
        this.filterRecords();
    },
    sortEnvelopes: function (e) {
        this.sort_by = e.currentTarget.id;
        this.order = e.currentTarget.align;
        if (this.order == "none" || this.order == "asc") {
            this.order = "desc";
            $("#track_details #"+this.sort_by+" i").removeClass("fa-sort-up");
            $("#track_details #"+this.sort_by+" i").addClass("fa-sort-down");
        } else {
            this.order = "asc";
            $("#track_details #"+this.sort_by+" i").removeClass("fa-sort-down");
            $("#track_details #"+this.sort_by+" i").addClass("fa-sort-up");
        }
        $("#track_details .sort").attr("align","none");
        $("#track_details .sort i").hide();
        $("#track_details #"+this.sort_by).attr("align",this.order);
        $("#track_details #"+this.sort_by+" i").show();
        this.showDetails();
    },
    togglePanel: function (e) {
        var id = e.currentTarget.id;
        var is_down = $(".env_icon_" + id).hasClass("fa-chevron-down");
        var is_up = $(".env_icon_" + id).hasClass("fa-chevron-up");
        if (is_down) {
            $(".env_icon_" + id).removeClass("fa-chevron-down");
            $(".env_icon_" + id).addClass("fa-chevron-up");

            $(".env_id_for_contacts_" + id).removeClass("hide");
        } else if (is_up) {
            $(".env_icon_" + id).removeClass("fa-chevron-up");
            $(".env_icon_" + id).addClass("fa-chevron-down");

            $(".env_id_for_contacts_" + id).addClass("hide");
        }
    },
    showDetails: function () {
        app.alert.show('getting-envs', {
            level: 'process',
        });
        self = this;
        parenturl = window.location.href;
        authtoken = SUGAR.App.api.getOAuthToken();
        $.getScript('modules/RT_DocuSign/js/parseurl.js', function () {
            urlobj = new parseURL(parenturl);// parsing url and creating object

            app.bwc.login(null, _.bind(function () {
                var UrlParams = {
                    limit: self.limit,
                    offset: self.offset,
                    track_date_from: self.track_date_from,
                    track_date_to: self.track_date_to,
                    select_module: self.select_module,
                    select_status: self.select_status,
                    sort_by: self.sort_by,
                    order: self.order,
                };
                $.ajax({
                    url: "index.php?module=RT_DocuSign&action=getenvelopetracking&" + $.param(UrlParams),
                    headers: {
                        'Content-Type': 'application/json',
                        'OAuth-Token': authtoken,
                    },
                    async: false,
                    success: function (result) {
                        app.alert.dismiss('getting-envs');
                        if (self.offset == 0) {
                            $("#track_details").find("tr:gt(0)").remove();
                        }
                        var result = JSON.parse(result);
                        var data = result.data;
                        var total = result.total;
                        self.date_format = result.date_format;
                        var count = 0;
                        if (total != 0) {
                            $.each(data, function (index, value) {
                                count++;
                                total = value.total;
                                var env_url = app.router.buildRoute('DP_DoucumentsPackets', value.id);
                                var parent_url = app.router.buildRoute(value.parent_type, value.parent_id);
                                var sender_url = app.router.buildRoute('Employees', value.created_by_id);
                                var doc_url = app.router.buildRoute('Documents', value.document_id);
                                var row = '<tr>';
                                row += '<td class="env"><ul class="the-icons"><li><i id ="' + value.id + '" class="show_contacts env_icon_' + value.id + ' fa fa-chevron-down"></i></li></ul></td>';
                                row += '<td class="env env_name"><a class="ellipsis_inline" href="#' + env_url + '" >' + value.name + '</a></td>';
                                row += '<td class="env env_status">' + value.packetstatus + '</td>';
                                row += '<td class="env env_status">' + value.parent_label + '</td>';
                                row += '<td class="env env_module"><a class="ellipsis_inline" href="#' + parent_url + '" >' + value.parent_name + '</a></td>';
                                row += '<td class="env env_sender"><a class="ellipsis_inline" href="#' + sender_url + '" >' + value.created_by_name + '</a></td>';
                                row += '<td class="env env_signed_by">' + value.completed + '</td>';
                                row += '<td class="env env_date">' + value.date_entered + '</td>';
                                row += '<td class="env env_sender"><a class="ellipsis_inline" href="#' + doc_url + '" >' + value.document_name + '</a></td>';
                                row += '</tr>';
                                $("#track_details").append(row);
                                var related_records = value.related_contacts;
                                if (related_records.length) {
                                    var contacts_head = '<tr  class="hide env_id_for_contacts_' + value.id + '"><td class="contact_name up_down"></td><td colspan="3"><b>Recipient Name</b></td><td colspan="3"><b>Document Status</b></td><td colspan="2"><b>Date</b></td></tr>';

                                    $("#track_details").append(contacts_head);

                                    $.each(related_records, function (related_index, related_value) {
                                        var contact_url = app.router.buildRoute('Contacts', related_value.contact_id);
                                        var contacts_row = '<tr  class="hide env_id_for_contacts_' + value.id + '">';
                                        contacts_row += '<td class="contact_name up_down"></td>';
                                        contacts_row += '<td colspan="3" class="contact_name"><a class="ellipsis_inline" href="#' + contact_url + '" >' + related_value.contact_name + '</a></td>';
                                        contacts_row += '<td colspan="3" class="contact_status">' + related_value.contact_status + '</td>';
                                        contacts_row += '<td colspan="2" class="env_date">' + related_value.date_modified + '</td>';
                                        contacts_row += '</tr>';
                                        $("#track_details").append(contacts_row);
                                    });
                                } else {
                                    var contacts_head = '<tr  class="hide env_id_for_contacts_' + value.id + '"><td class="no_contact" align="center" colspan="9" >No Recipient Found</td></tr>';
                                    $("#track_details").append(contacts_head);
                                }
                            });
                        } else {
                            var env_head = '<tr><td class="no_contact" align="center" colspan="9" >No Envelope Found</td></tr>';
                            $("#track_details").append(env_head);
                        }
                        $(".track_docusign_env").parent().css("overflow-y", "hidden");
                        $(".track_docusign_env").parent().css("overflow-x", "hidden");
                        $(".track_docusign_env").parent().css("max-height", "500px");
                        $("#docusign_main").css("max-height", "410px");
                        $("#docusign_main").css("overflow", "auto");
                        var list_count = self.offset + count;
                        var count_text = 'RT Track DocuSign Envelopes (' + list_count + ' of ' + total + ')';
                        $(".track_docusign_env").parent().parent().parent().find(".dashlet-header h4").text(count_text);
                        if (count < self.limit) {
                            $(".more-env").hide();
                        } else {
                            $(".more-env").show();
                        }
                        if (self.set_datepicker) {
                            self.set_datepicker = false;
                            $('[name="track_date_to"]').datepicker().on('changeDate', function (ev) {
                                $(".cancel_from").removeClass("hide");
                                self.filterRecords();
                            });
                            $('[name="track_date_from"]').datepicker().on('changeDate', function (ev) {
                                $(".cancel_to").removeClass("hide");
                                self.filterRecords();
                            });
                            
                            $(".track_date_from").parent().css("margin-left","10px");
                            $(".track_date_to").parent().css("margin-left","23px");
                            $(".select_status").parent().css("margin-left","23px");
                        }
                    }
                });
            }, this));

        });
    }
})