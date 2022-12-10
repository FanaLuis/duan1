<?php  include "layout/header.php";
//  liên kết file Oder và OrderItem

?>


<div id="content-wrapper">
   <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
         <li class="breadcrumb-item active">Tổng quan</li>
      </ol>
      <?php
      $type = !empty($_GET["type"]) ? $_GET["type"] : "today";
      ?>
      <div class="mb-3 my-3">
         <a href="index.php?type=today&from_date=<?=date("Y-m-d")?>&to_date=<?=date("Y-m-d")?>" class="<?=$type=="today" ? "active": ""?> btn btn-primary">Hôm nay</a>
         <a href="index.php?type=yesterday&from_date=<?=date("Y-m-d",strtotime("-1 days"))?>&to_date=<?=date("Y-m-d", strtotime("-1 days"))?>" class="<?=$type=="yesterday" ? "active": ""?> btn btn-primary">Hôm qua</a>
         <a href="index.php?type=thisweek&from_date=<?=date("Y-m-d",strtotime("this week"))?>&to_date=<?=date("Y-m-d")?>" class="<?=$type=="thisweek" ? "active": ""?> btn btn-primary">Tuần này</a>
         <!-- doanh thu tháng này tính từ ngày 1 đầu tháng  -->
         <a href="index.php?type=thismonth&from_date=<?=date("Y-m-01")?>&to_date=<?=date("Y-m-d")?>" class="<?=$type=="thismonth" ? "active": ""?> btn btn-primary">Tháng này</a>
         <a href="index.php?type=3months&from_date=<?=date("Y-m-d",strtotime("-3 months"))?>&to_date=<?=date("Y-m-d")?>" class="<?=$type=="3months" ? "active": ""?> btn btn-primary">3 tháng</a>
         <a href="index.php?type=thisyear&from_date=<?=date("Y-01-01")?>&to_date=<?=date("Y-m-d")?>" class="<?=$type=="thisyear" ? "active": ""?> btn btn-primary">Năm này</a>
         <div class="dropdown" style="display:inline-block">
            <a class="<?=$type=="custom" ? "active" : ""?> btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
               <div style="margin:20px">
                  <form action="index.php">
                     Từ ngày <input type="date" class="form-control" name="from_date" required value="<?=$type == "custom" ? $_GET["from_date"]: ""?>">
                     Đến ngày <input type="date" class="form-control" name="to_date" required value="<?=$type == "custom" ? $_GET["to_date"]: ""?>">
                     <br>
                     <input type="hidden" value="custom" name="type">
                     <input type="submit" value="Tìm" class="btn btn-primary form-control">
                  </form>

               </div>
            </div>
         </div>
      </div>
      <!-- Icon Cards-->
      <div class="row">
         <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
               <div class="card-body">
                  <div class="card-body-icon">
                     <i class="fas fa-fw fa-list"></i>
                  </div>
                  <div class="mr-5"><?=count($orders)?> Đơn hàng</div>
               </div>
               <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">Chi tiết</span>
                  <span class="float-right">
                     <i class="fas fa-angle-right"></i>
                  </span>
               </a>
            </div>
         </div>
         <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
               <div class="card-body">
                  <div class="card-body-icon">
                     <i class="fas fa-fw fa-shopping-cart"></i>
                  </div>

                  <?php
                  $revenue = 0;
                  $cancel_number = 0;
                  foreach ($orders as $order):
                  //   doanh thu của tháng = tổng doanh thu của các đơn hàng trong tháng
                 if ($order->getStatusId() == 1) {
                        $cancel_number++;
                     }
                     $orderItems = $order->getOrderItems();
                     foreach($orderItems as $orderItem) {
                        $revenue += $orderItem->getTotalPrice();
                     }
                     $revenue += $order->getShippingFee();



                  endforeach
                  ?>

                  <div class="mr-5">Doanh thu <?=number_format($revenue)?> đ</div>
               </div>
               <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">Chi tiết</span>
                  <span class="float-right">
                     <i class="fas fa-angle-right"></i>
                  </span>
               </a>
            </div>
         </div>
         <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
               <div class="card-body">
                  <div class="card-body-icon">
                     <i class="fas fa-fw fa-life-ring"></i>
                  </div>
                  <div class="mr-5"><?=$cancel_number?> đơn hàng bị hủy</div>
               </div>
               <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">Chi tiết</span>
                  <span class="float-right">
                     <i class="fas fa-angle-right"></i>

                  </span>
               </a>
            </div>

         </div>

      </div>
      <!-- DataTables Example -->
      <!-- tạo biểu đồ thống kê doanh thu theo tháng trong admin dashboard bằng chart.js và php thuật toán đơn giản như sau: -->
 <!-- 1. lấy ra tất cả các đơn hàng trong năm -->
 <!-- 2. duyệt qua từng đơn hàng, lấy ra ngày đặt hàng -->
 <!-- 3. nếu ngày đặt hàng nằm trong tháng hiện tại thì cộng thêm vào doanh thu của tháng đó -->
 <!-- 4. lặp lại bước 2 và 3 cho đến khi duyệt hết tất cả các đơn hàng -->
<!-- 5. hiển thị doanh thu của các tháng lên biểu đồ -->

                     <!-- TẠO BIỂU ĐỒ THỐNG KÊ và đỗ dữ liệu vào biểu đồ -->

 <?php

                     $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                     $revenues = [];



                     foreach ($orders as $order):
                        $orderItems = $order->getOrderItems();
                        $revenue = 0;
                        foreach($orderItems as $orderItem) {
                           $revenue += $orderItem->getTotalPrice();
                        }
                        $revenue += $order->getShippingFee();
                        $date = $order->getCreatedDate();
                        $month = date('m', strtotime($date));




                           if (in_array($month, $months)) {
                              if (isset($revenues[$month])) {
                                 $revenues[$month] += $revenue;
                              } else {
                                 $revenues[$month] = $revenue;
                              }
                           }


                    endforeach



                     ?>




                        <div class="card mb-3">
                           <div class="card-header">
                              <i class="fas fa-chart-area"></i>
                              Doanh thu
                           </div>
                           <div class="card-body">
                              <canvas id="myChart" width="100%" height="30">




















                              </canvas>





                           </div>
                           <div class="card-footer small text-muted ngay">
                              Updated yesterday at 11:59 PM
                           </div>


                        </div>


                        <!-- tạo id myChart cho canvas
                        -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js.map"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js.map"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js.map"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js.map"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js.map"></script>

                     <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var date = new Date();
                     // lấy ra danh sách các tháng trong năm
                     var months = <?=json_encode($months)?>;
                     // lấy ra danh sách doanh thu của các tháng trong năm
                     var revenues = <?=json_encode($revenues)?>;
               //   thêm giá trị vào đối tượng revenues



                     thuat =revenues;
                     // cover object to array
                     var monthsz = Object.values(months);
                     var revenuesz = Object.values(revenues);
                     console.log(monthsz);
                     console.log(revenuesz);
                     var danhthu = [100, 200, 300, 400, 500, 600,700,800,900,...revenuesz];
                     var danhthu1 = [100, 200, 300, 400, 500, 600,700,800,900,...revenuesz];

                     console.log(danhthu);
                     // nếu danh thu bằng 10 phần tử thì thêm 2 phần tử vào đầu mảng danh thu
                     if (danhthu.length == 10) {
                        danhthu.unshift(0, 0);
                     }




                     // tạo biểu đồ
                     var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                           labels: months,
                           datasets: [{
                              label: 'Doanh thu',
                              data: danhthu,

                              backgroundColor: [
                                 'rgba(255, 99, 132, 0.2)',
                                 'rgba(54, 162, 235, 0.2)',
                                 'rgba(255, 206, 86, 0.2)',
                                 'rgba(75, 192, 192, 0.2)',
                                 'rgba(153, 102, 255, 0.2)',
                                 'rgba(255, 159, 64, 0.2)'
                              ],
                              borderColor: [
                                 'rgba(255, 99, 132, 1)',
                                 'rgba(54, 162, 235, 1)',
                                 'rgba(255, 206, 86, 1)',
                                 'rgba(75, 192, 192, 1)',
                                 'rgba(153, 102, 255, 1)',
                                 'rgba(255, 159, 64, 1)'
                              ],
                              borderWidth: 1
                           }]
                        },
                        options: {
                           scales: {
                              yAxes: [{
                                 ticks: {
                                    beginAtZero: true
                                 }
                              }]



                           }




                        }
                     });

                     // function inrabieu() {
                     //    var printContents = document.getElementById('myChart').innerHTML;
                     //    var originalContents = document.body.innerHTML;
                     //    document.body.innerHTML = printContents;
                     //    window.print();
                     //    document.body.innerHTML = originalContents;
                     // }
                     // setInterval(() => {
                     //    inrabieu();


                     // }, 5000);


                     </script>


                  </div>

            <!-- /#wrapper -->


            <!-- Scroll to Top Button-->

            <!-- Bootstrap core JavaScript-->

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->

            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Page level plugin JavaScript-->

            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Custom scripts for all pages-->

            <script src="js/sb-admin.min.js"></script>

            <!-- Demo scripts for this page-->

            <script src="js/demo/chart-area-demo.js"></script>

            <script src="js/demo/chart-bar-demo.js"></script>

            <script src="js/demo/chart-pie-demo.js"></script>
                 <?php  include "layout/footer.php"; ?>