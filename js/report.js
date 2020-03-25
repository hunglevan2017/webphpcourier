$(document).ready(function() {

  var countReportLoading = 0
  var countReportTeamLeading = 0

  var currentDate = moment(new Date()).format('MM_DD_YYYY');

  $.fn.datepicker.dates['en'] = {
    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    monthsShort: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", "T12"],
    today: "Today",
    clear: "Clear",
    format: "mm/dd/yyyy",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0
  };


  $('#datepicker').datepicker({
    format: "mm/yyyy",
    minViewMode: "months",
    defaultDate: new Date(),
    autoclose:true,
	});
  $("#datepicker").datepicker().datepicker("setDate", new Date());

  var aoData =  [
    {"mData": "", "defaultContent": ""},
    {"mData": "app_id", "defaultContent": ""},
    {"mData": "received_date", "defaultContent": ""},
    {"mData": "vendor", "defaultContent": ""},
    {"mData": "date_of_allocated_vendor", "defaultContent": ""},
    {"mData": "last_status_date", "defaultContent": ""},
    {"mData": "last_status_name", "defaultContent": ""},
  ];

  var columnDefs = [
    {"title":"#","targets": 0,"width":"1%",
          "render": function(data, type, row, meta) {
                 return  `<span>${meta.row + 1}</span>`;
          }
    },
    {"title":"App Id","targets": 1,"width":"5%"},
    {"title":"Received Date","targets": 2,"width":"5%"},
    {"title":"Vendor","targets": 3,"width":"5%"},
    {"title":"Date Of Allocated Vendor","targets": 4,"width":"5%"},
    {"title":"Last Status Date","targets": 5,"width":"5%"},
    {"title":"Last Status Name","targets": 6,"width":"5%"},
  ];

  table_detail_report = $('#table-detail-courier-printing').dataTable({
       "ajax": {
        url: "function.php",
        type: "POST",
        data:function(d){
           d.action = "DailyReportCourierPrintingDetails",
           d.date = $('#datepicker').val(),
           d.vendor = $('#delivery-vendor').val().join(",")
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
             { extend: 'excel',text: "Export excel", filename: `ReportCoutierPrintingDetail_${currentDate}`}
         ],

       "initComplete": function(settings, json) {
         $("#search").attr("disabled", false);
         //$("#cusloading").hide();
       },
       "autoWidth": false


    }); /*End table*/

  hideLoading()
  $('#btn-daily-report-courier-printing').click(function(){

    var dateReport =  $('#datepicker').val()
    var vendor = $('#delivery-vendor').val().join(",")

    if(vendor.trim() == ""){
        showPopup("Please select vendor !","danger")
        return
    }
    showLoading();
    FecSendToSGB(dateReport,vendor)
    SGBAllocationToDeliveryVendor(dateReport,vendor)
    ProcessingStatusOfDeliveryVendor(dateReport,vendor)
    SignedContractOfDeliveryVendor(dateReport,vendor)
    table_detail_report.api().ajax.reload();

  })

  $('#btn-daily-report-courier').click(function(){

    var dateReport =  $('#datepicker').val()
    var vendor = $('#delivery-vendor').val().join(",")

    if(vendor.trim() == ""){
        showPopup("Please select vendor !","danger")
        return
    }

    DailyReportCourier(dateReport,vendor)
  })

  $('#btn-daily-report-team-printing').click(function(){
    var dateReport =  $('#datepicker').val()
    var vendor = $('#delivery-vendor').val().join(",")

    if(vendor.trim() == ""){
        showPopup("Please select vendor !","danger")
        return
    }
    showLoading();
    ReportTeamPrintingGeneral(dateReport,vendor)
    DailyReportCourier(dateReport,vendor)
    ReceiveImageUpload(dateReport,vendor)
  })

   $('#exportExcelSummary1').click(function(){
     try{
       exportExcelSummary()
     }catch(e){
       showPopup(`Error export ${e}` ,"danger")
     }
   })

   $('#exportExcelTeamPrinting').click(function(){
     try{
       exportExcelTeamPringting()
     }catch(e){
       showPopup(`Error export ${e}` ,"danger")
     }
   })

   $('#exportExcelCourier').click(function(){
     try{
       exportExcelCourier()
     }catch(e){
       showPopup(`Error export ${e}` ,"danger")
     }
   })

  function FecSendToSGB(dateReport,vendor){
    $('#table-fec-send-to-sgb').html('');
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "FecSendToSGB",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportLoading++
      hideReportLoading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      if(count > 1){
        obj.shift()
      }

      var tbody = "<tbody>"

      for(value of obj){
        var row = "<tr>";
        for(valueKey in value){
            row += `<td style="white-space: nowrap">${value[valueKey]}</td>`
        }
        row += "</tr>"

        tbody += row
      }

      tbody += "</tbody>"

      $('#table-fec-send-to-sgb').append(tbody)

    });
  }

  function SGBAllocationToDeliveryVendor(dateReport,vendor){
    $('#table-sgb-allocated').html('');
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "SGBAllocatedToDeliverVendor",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportLoading++
      hideReportLoading()
      var obj = $.parseJSON(msg)
      var count = obj.length

      if(count > 0){
        if(count > 1){
          obj.shift()
        }
        var tbody = "<tbody>"

        for(value of obj){
          var row = "<tr>";
          for(valueKey in value){
              row += `<td style="white-space: nowrap">${value[valueKey]}</td>`
          }
          row += "</tr>"

          tbody += row
        }

        tbody += "</tbody>"

        $('#table-sgb-allocated').append(tbody)
      }else{
        var tbody = "<tbody><tr><td>Không tìm thấy dữ liệu</td></tr></tbody>"

        $('#table-sgb-allocated').append(tbody)
      }



    });
  }

  function SignedContractOfDeliveryVendor(dateReport,vendor){
    $('#table-signed-contract').html('');
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "SignedContractOfDeliveryVendor",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportLoading++
      hideReportLoading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      if(count > 1){
        obj.shift()
      }
      var tbody = "<tbody>"

      for(value of obj){
        var row = "<tr>";
        for(valueKey in value){
            row += `<td style="white-space: nowrap">${value[valueKey]}</td>`
        }
        row += "</tr>"

        tbody += row
      }

      tbody += "</tbody>"

      $('#table-signed-contract').append(tbody)

    });
  }

  function ProcessingStatusOfDeliveryVendor(dateReport,vendor){
    $('#table-processing-status').html('');
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ProcessingStatusOfDeliveryVendor",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportLoading++
      hideReportLoading()
      var obj = $.parseJSON(msg)
      var count = obj.length
      var thead = `<thead><tr><th>Last status</th><th>247</th><th>Solar</th></tr></thead>`

      var tbody = "<tbody>"
      for(value of obj){
        var row = "<tr>";
        row += `<td style="white-space: nowrap">${value['last_status']}</td>`
        row += `<td style="white-space: nowrap">${value['247']}</td>`
        row += `<td style="white-space: nowrap">${value['solar']}</td>`
        row += "</tr>"
        tbody += row
      }

      tbody += "</tbody>"

      $('#table-processing-status').append(thead)
      $('#table-processing-status').append(tbody)

    });
  }

  function exportExcelSummary(){
    var workbook = XLSX.utils.book_new();
    var arrayTable = document.getElementsByClassName('exportSummary')
    for(i=0;i<arrayTable.length;i++){
      var titleSheet = document.getElementsByClassName('exportSummary')[i].getAttribute('data-title')
      var ws1 = XLSX.utils.table_to_sheet(arrayTable[i])
      XLSX.utils.book_append_sheet(workbook, ws1, `${titleSheet}`)
    }

    XLSX.writeFile(workbook, (`ReportSummary_${currentDate}.xlsx`))
  }

  function exportExcelTeamPringting(){
    var workbook = XLSX.utils.book_new();
    var arrayTable = document.getElementsByClassName('exportTeamPrinting')
    for(i=0;i<arrayTable.length;i++){
      var titleSheet = document.getElementsByClassName('exportTeamPrinting')[i].getAttribute('data-title')
      var ws1 = XLSX.utils.table_to_sheet(arrayTable[i])
      XLSX.utils.book_append_sheet(workbook, ws1, `${titleSheet}`)
    }

    XLSX.writeFile(workbook, (`ReportTeamPrinting_${currentDate}.xlsx`))
  }

  function exportExcelCourier(){
    var workbook = XLSX.utils.book_new();
    var arrayTable = document.getElementsByClassName('exportCourier')
    for(i=0;i<arrayTable.length;i++){
      var titleSheet = document.getElementsByClassName('exportCourier')[i].getAttribute('data-title')
      var ws1 = XLSX.utils.table_to_sheet(arrayTable[i])
      XLSX.utils.book_append_sheet(workbook, ws1, `${titleSheet}`)
    }

    XLSX.writeFile(workbook, (`ReportCourier_${currentDate}.xlsx`))
  }

  function DailyReportCourier(dateReport,vendor){
    $('#table-daily-report-courier').html('')
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "DailyReportCourier",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportTeamLeading++
      hideReportTeamLeading()
      try{
        var obj = $.parseJSON(msg)
        var count = obj.length

        if(count > 0){
          if(count > 1){
            obj.shift()
          }
          var tbody = "<tbody>"

          for(value of obj){
            var row = "<tr>";
            for(valueKey in value){
                row += `<td style="white-space: nowrap">${value[valueKey]}</td>`
            }
            row += "</tr>"

            tbody += row
          }

          tbody += "</tbody>"

          $('#table-daily-report-courier').append(tbody)
        }else{
          var tbody = "<tbody><tr><td>Không tìm thấy dữ liệu</td></tr></tbody>"
          $('#table-daily-report-courier').append(tbody)
        }
      }catch(e){
        showPopup(`Error : can't not find data. ${e} \n ${msg}` ,"danger")
      }
    });
  }

  function ReportTeamPrintingGeneral(dateReport,vendor){
    $('#table-general').html('')
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ReportTeamPrintingGeneral",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportTeamLeading++
      hideReportTeamLeading()
      try{
        var obj = $.parseJSON(msg)
        var count = obj.length
        var thead = `<thead><tr><th>Product</th><th>Plan</th><th>Fact</th><th>Pending</th><th>Percent</th></tr></thead>`

        var tbody = "<tbody>"
        for(value of obj){
          var row = "<tr>";
          row += `<td style="white-space: nowrap">${value['product']}</td>`
          row += `<td style="white-space: nowrap">${value['plan']}</td>`
          row += `<td style="white-space: nowrap">${value['fact']}</td>`
          row += `<td style="white-space: nowrap">${value['pending']}</td>`
          row += `<td style="white-space: nowrap">${value['percent']}</td>`
          row += "</tr>"
          tbody += row
        }

        tbody += "</tbody>"

        $('#table-general').append(thead)
        $('#table-general').append(tbody)
      }catch(e){
        showPopup(`Error : can't not find data. ${e} \n ${msg}` ,"danger")
      }

    });
  }

  function ReceiveImageUpload(dateReport,vendor){
    $('#table-receive-image-upload').html('')
    $.ajax({
      method: "POST",
      url: "function.php",
      data: {
        action: "ReceiveImageUpload",
        date: dateReport,
        vendor: vendor
      }
    }).done(function( msg ) {
      countReportTeamLeading++;
      hideReportTeamLeading()

      try{
        var obj = $.parseJSON(msg)
        var count = obj.length

        if(obj != "" || count > 0){
          if(count > 1){
            obj.shift()
          }
          var tbody = "<tbody>"

          for(value of obj){
            var row = "<tr>";
            for(valueKey in value){
                row += `<td style="white-space: nowrap">${value[valueKey]}</td>`
            }
            row += "</tr>"

            tbody += row
          }

          tbody += "</tbody>"

          $('#table-receive-image-upload').append(tbody)
        }else{
          var tbody = "<tbody><tr><td>Không tìm thấy dữ liệu</td></tr></tbody>"
          $('#table-receive-image-upload').append(tbody)
        }
      }catch(e){
        showPopup(`Error : can't not find data. ${e} \n ${msg}` ,"danger")
      }
    });
  }

  function hideReportLoading(){
    if(countReportLoading >= 4){
      countReportLoading = 0
      hideLoading()
    }
  }

  function hideReportTeamLeading(){
    if(countReportTeamLeading >= 3){
      countReportTeamLeading = 0
      hideLoading()
    }
  }
});
