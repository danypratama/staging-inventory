$(function () {
    $("#table1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print"],
    }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
});

$(document).ready(function() {
    var table = $('#table2').DataTable({
        "lengthChange": false,
        "ordering": false,
        "autoWidth": false
    });
});

$(document).ready(function() {
  var table = $('#table3').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
  });
});


$(function () {
  $("#table4").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');

  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });
});

$(document).ready(function() {
  // Set default number format options
  $.extend(true, $.fn.dataTable.defaults, {
    "language": {
      "decimal": ",",
      "thousands": "."
    },
    "pageLength": 25,
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
  });

  // Apply DataTables plugin to table with ID "table1"
  $('#table5').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": [
      {
        extend: 'csvHtml5',
        exportOptions: {
          format: {
            body: function (data, row, column, node) {
              if (column === 2 || column === 3) {
                // Format numbers with dot separator
                return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              }
              return data;
            }
          }
        }
      },
      {
        extend: 'excelHtml5',
        exportOptions: {
          format: {
            body: function (data, row, column, node) {
              if (column === 2 || column === 3) {
                // Format numbers with dot separator
                return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              }
              return data;
            }
          }
        }
      },
      {
        extend: 'pdfHtml5',
        exportOptions: {
          format: {
            body: function (data, row, column, node) {
              if (column === 2 || column === 3) {
                // Format numbers with dot separator
                return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              }
              return data;
            }
          }
        }
      },
      'print'
    ]
  }).buttons().container().appendTo('#table5_wrapper .col-md-6:eq(0)');
});

