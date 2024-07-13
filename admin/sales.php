<?php 
include 'includes/session.php'; 
include 'includes/header.php'; 
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" action="sales_print.php">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range">
                  </div>
                  <button type="submit" class="btn btn-success btn-sm btn-flat" name="print"><span class="glyphicon glyphicon-print"></span> Print</button>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Buyer Name</th>
                  <th>Transaction#</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Proof</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT sales.id AS salesid, sales.sales_date, users.firstname, users.lastname, sales.transaction_id, payments.amount, sales.status, payments.proof 
                                            FROM sales 
                                            LEFT JOIN users ON users.id = sales.user_id 
                                            LEFT JOIN payments ON payments.id = sales.transaction_id 
                                            ORDER BY sales.sales_date DESC");
                      $stmt->execute();
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".date('M d, Y', strtotime($row['sales_date']))."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".$row['transaction_id']."</td>
                            <td>&#36; ".number_format($row['amount'], 2)."</td>
                            <td>
                              <div class='dropdown'>
                                <button class='btn btn-sm btn-default dropdown-toggle' type='button' data-toggle='dropdown'>".$row['status']." <span class='caret'></span></button>
                                <ul class='dropdown-menu'>
                                  <li><a href='#' class='update-status' data-id='".$row['salesid']."' data-status='Pending'>Pending</a></li>
                                  <li><a href='#' class='update-status' data-id='".$row['salesid']."' data-status='Pemesanan'>Pemesanan</a></li>
                                  <li><a href='#' class='update-status' data-id='".$row['salesid']."' data-status='Pesanan Selesai'>Pesanan Selesai</a></li>
                                </ul>
                              </div>
                            </td>
                            <td>
                              <a href='../uploads/".$row['proof']."' class='popup-link'>
                                <img src='../uploads/".$row['proof']."' class='img-responsive' style='max-width: 100px; max-height: 100px;' alt='Proof'>
                              </a>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </div>
    <?php include 'includes/footer.php'; ?>
    <?php include '../includes/profile_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->
<script>
$(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  //Date range picker
  $('#reservation').daterangepicker()
  //Date range picker with time picker
  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  )
  
  // Ajax request to update status
  $(document).on('click', '.update-status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var status = $(this).data('status');
    $.ajax({
      type: 'POST',
      url: 'update_status.php', // Replace with your update status script URL
      data: {id:id, status:status},
      dataType: 'json',
      success:function(response){
        if(response.success) {
          // Update UI or show success message
          location.reload(); // Reload the page or update specific elements as needed
        } else {
          alert('Failed to update status. Please try again.');
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        alert('An error occurred while updating status. Please try again.');
      }
    });
  });
});
</script>
</body>
</html>
