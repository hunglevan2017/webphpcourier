$(document).ready(function() {
  hideLoading()

  var countReportTeamLeading = 0
  var currentDate = moment(new Date()).format('MM_DD_YYYY')
  $('#btn-system-monitoring').trigger('click')

  var aoData =  [
    {"mData": "", "defaultContent": ""},
    {"mData": "app_id", "defaultContent": ""},
    {"mData": "tracking_no", "defaultContent": ""},
    {"mData": "cus_name", "defaultContent": ""},
    {"mData": "status", "defaultContent": ""},
    {"mData": "is_send", "defaultContent": ""},
    {"mData": "result", "defaultContent": ""},
    {"mData": "reason", "defaultContent": ""},
  ];

  var columnDefs = [
    {"title":"#","targets": 0,"width":"1%",
          "render": function(data, type, row, meta) {
                 return  `<span>${meta.row + 1}</span>`;
          }
    },
    {"title":"App Id","targets": 1,"width":"5%"},
    {"title":"Tracking No","targets": 2,"width":"5%"},
    {"title":"Customer Name","targets": 3,"width":"5%"},
    {"title":"Status","targets": 4,"width":"5%"},
    {"title":"Send To 247","targets": 5,"width":"5%"},
    {"title":"Result","targets": 6,"width":"5%"},
    {"title":"Reason","targets": 7,"width":"5%"},
  ];

  table_detail_send_to_247 = $('#table-detail-send-to-247').dataTable({
       "ajax": {
        url: "function.php",
        type: "POST",
        data:function(d){
           var rangeDate = $('#datepicker-monitoring').val().split("-")
           var fromDate = ""
           var toDate = ""
           if(rangeDate.length > 1){
             fromDate = rangeDate[0].trim()
             toDate = rangeDate[1].trim()
           }

           d.action = "ReportSgbSendTo247Detail",
           d.fromDate = fromDate,
           d.toDate = toDate
         },
         dataSrc: ""
       },
       select: {
         style: 'single'
       },
       "fnCreatedRow": function(row, data, index) {
         $('td', row).eq(0).html(index + 1);
       },
       "columnDefs": columnDefs,
       "aoColumns": aoData,
       "ordering": false,
       "bPaginate": true,
       "pageLength": 10,
       "responsive": false,
       "scrollX": "300rem",
        "scrollCollapse": true,
       "processing": true,
       dom: '<"row"<"col-12 mb-2" <"text-right" B>>><"row"<"col-sm-12 col-md-6" l><"col-sm-12 col-md-6" f>>rtip',
       buttons: [
             { extend: 'excel',text: "Export excel" ,filename: `Report Sale Retry_${currentDate}`}
         ],
       "autoWidth": false


    }); /*End table*/


    var aoDataSaleRetry =  [
      {"mData": "", "defaultContent": ""},
      {"mData": "app_id", "defaultContent": ""},
      {"mData": "old_tracking_no", "defaultContent": ""},
      {"mData": "new_tracking_no", "defaultContent": ""},
      {"mData": "ten_kh", "defaultContent": ""}
    ];

    var columnDefsSaleRetry = [
      {"title":"#","targets": 0,"width":"1%",
            "render": function(data, type, row, meta) {
                   return  `<span>${meta.row + 1}</span>`;
            }
      },
      {"title":"App Id","targets": 1,"width":"5%"},
      {"title":"Old Tracking No","targets": 2,"width":"5%"},
      {"title":"New Tracking No","targets": 3,"width":"5%"},
      {"title":"Customer Name","targets": 4,"width":"5%"}
    ];

    table_detail_sale_retry = $('#table-detail-sale-retry').dataTable({
         "ajax": {
          url: "function.php",
          type: "POST",
          data:function(d){
             var rangeDate = $('#datepicker-monitoring').val().split("-")
             var fromDate = ""
             var toDate = ""
             if(rangeDate.length > 1){
               fromDate = rangeDate[0].trim()
               toDate = rangeDate[1].trim()
             }

             d.action = "ReportSalesRetryDetail",
             d.fromDate = fromDate,
             d.toDate = toDate
           },
           dataSrc: ""
         },
         select: {
           style: 'single'
         },
         "fnCreatedRow": function(row, data, index) {
           $('td', row).eq(0).html(index + 1);
         },
         "columnDefs": columnDefsSaleRetry,
         "aoColumns": aoDataSaleRetry,
         "ordering": false,
         "bPaginate": true,
         "pageLength": 10,
         "responsive": false,
         "scrollX": "300rem",
          "scrollCollapse": true,
         "processing": true,
         dom: '<"row"<"col-12 mb-2" <"text-right" B>>><"row"<"col-sm-12 col-md-6" l><"col-sm-12 col-md-6" f>>rtip',
         buttons: [
               { extend: 'excel',text: "Export excel" ,filename: `Report SGB Send To 247 Detail_${currentDate}`}
           ],
         "autoWidth": false
      }); /*End table*/


      var aoDataChangeStage =  [
        {"mData": "", "defaultContent": ""},
        {"mData": "app_id", "defaultContent": ""},
        {"mData": "tracking_no", "defaultContent": ""},
        {"mData": "customer_name", "defaultContent": ""},
        {"mData": "change_state", "defaultContent": ""},
        {"mData": "result", "defaultContent": ""},
        {"mData": "reason", "defaultContent": ""}
      ];

      var columnDefsChangeStage = [
        {"title":"#","targets": 0,"width":"1%",
              "render": function(data, type, row, meta) {
                     return  `<span>${meta.row + 1}</span>`;
              }
        },
        {"title":"App Id","targets": 1,"width":"5%"},
        {"title":"Tracking No","targets": 2,"width":"5%"},
        {"title":"Customer Name","targets": 3,"width":"5%"},
        {"title":"Change State","targets": 4,"width":"5%"},
        {"title":"Result","targets": 5,"width":"5%"},
        {"title":"Reason","targets": 6,"width":"5%"}
      ];

      table_detail_sgbchangestage = $('#table-detail-sgbchangestage').dataTable({
           "ajax": {
            url: "function.php",
            type: "POST",
            data:function(d){
               var rangeDate = $('#datepicker-monitoring').val().split("-")
               var fromDate = ""
               var toDate = ""
               if(rangeDate.length > 1){
                 fromDate = rangeDate[0].trim()
                 toDate = rangeDate[1].trim()
               }

               d.action = "ReportSgbChangeStageDetail",
               d.fromDate = fromDate,
               d.toDate = toDate
             },
             dataSrc: ""
           },
           select: {
             style: 'single'
           },
           "fnCreatedRow": function(row, data, index) {
             $('td', row).eq(0).html(index + 1);
           },
           "columnDefs": columnDefsChangeStage,
           "aoColumns": aoDataChangeStage,
           "ordering": false,
           "bPaginate": true,
           "pageLength": 10,
           "responsive": false,
           "scrollX": "300rem",
            "scrollCollapse": true,
           "processing": true,
           dom: '<"row"<"col-12 mb-2" <"text-right" B>>><"row"<"col-sm-12 col-md-6" l><"col-sm-12 col-md-6" f>>rtip',
           buttons: [
                 { extend: 'excel',text: "Export excel" ,filename: `Report Change State Detail_${currentDate}`}
             ],
           "autoWidth": false


        }); /*End table*/

  $('#btn-system-monitoring').click(function(){

    var rangeDate = $('#datepicker-monitoring').val().split("-")
    var fromDate = ""
    var toDate = ""
    if(rangeDate.length > 1){
      fromDate = rangeDate[0].trim()
      toDate = rangeDate[1].trim()
    }

    showLoading()

    ReportSgbSendTo247Summary(fromDate,toDate)
    table_detail_send_to_247.api().ajax.reload()

    ReportSalesRetrySummary(fromDate,toDate)
    table_detail_sale_retry.api().ajax.reload()

    ReportSgbChangeStageSummary(fromDate,toDate)
    table_detail_sgbchangestage.api().ajax.reload()
  })

  function ReportSgbSendTo247Summary(fromDate,toDate){
    $('#table-summary-send-to-247').html('')

    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ReportSgbSendTo247Summary",
        fromDate: fromDate,
        toDate: toDate
      }
    }).done(function( msg ) {
      countReportTeamLeading++
      hideReportTeamLeading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      var thead = `<thead><tr><th>Status</th><th>Total</th><th>Send To 247</th><th>Success</th><th>Fail</th></tr></thead>`

      var tbody = "<tbody>"
      for(value of obj){
        var row = "<tr>";
        row += `<td style="white-space: nowrap">${value['status']}</td>`
        row += `<td style="white-space: nowrap">${value['total_hd']}</td>`
        row += `<td style="white-space: nowrap">${value['total_send']}</td>`
        row += `<td style="white-space: nowrap">${value['total_success']}</td>`
        row += `<td style="white-space: nowrap">${value['total_fail']}</td>`
        row += "</tr>"
        tbody += row
      }

      tbody += "</tbody>"

      $('#table-summary-send-to-247').append(thead)
      $('#table-summary-send-to-247').append(tbody)
    })
  }

  function ReportSalesRetrySummary(fromDate,toDate){
    $('#table-summary-sale-retry').html('')

    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ReportSalesRetrySummary",
        fromDate: fromDate,
        toDate: toDate
      }
    }).done(function( msg ) {
      countReportTeamLeading++
      hideReportTeamLeading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      var thead = `<thead><tr><th>Status</th><th>Total</th><th>New Tracking No</th></tr></thead>`

      var tbody = "<tbody>"
      for(value of obj){
        var row = "<tr>";
        row += `<td style="white-space: nowrap">${value['status']}</td>`
        row += `<td style="white-space: nowrap">${value['total']}</td>`
        row += `<td style="white-space: nowrap">${value['new_tracking_no']}</td>`
        row += "</tr>"
        tbody += row
      }

      tbody += "</tbody>"

      $('#table-summary-sale-retry').append(thead)
      $('#table-summary-sale-retry').append(tbody)
    })
  }

  function ReportSgbChangeStageSummary(fromDate,toDate){
    $('#table-summary-sgbchangestage').html('')

    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ReportSgbChangeStageSummary",
        fromDate: fromDate,
        toDate: toDate
      }
    }).done(function( msg ) {
      countReportTeamLeading++
      hideReportTeamLeading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      var thead = `<thead><tr><th>Status</th><th>Total</th><th>Change Stage</th><th>Success</th><th>Fail</th></tr></thead>`

      var tbody = "<tbody>"
      for(value of obj){
        var row = "<tr>";
        row += `<td style="white-space: nowrap">${value['status']}</td>`
        row += `<td style="white-space: nowrap">${value['total_hs']}</td>`
        row += `<td style="white-space: nowrap">${value['change_state']}</td>`
        row += `<td style="white-space: nowrap">${value['success']}</td>`
        row += `<td style="white-space: nowrap">${value['fail']}</td>`
        row += "</tr>"
        tbody += row
      }

      tbody += "</tbody>"

      $('#table-summary-sgbchangestage').append(thead)
      $('#table-summary-sgbchangestage').append(tbody)
    })
  }

  function hideReportTeamLeading(){
    if(countReportTeamLeading >= 3){
      countReportTeamLeading = 0
      hideLoading()
    }
  }

})
