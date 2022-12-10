<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
   <thead>
      <tr>
         <th>Mã</th>
         <th>Tên khách hàng</th>
         <th>Điện thoai</th>
         <th>Email</th>
         <th style= 'background: green'>Trạng Thái</th>
         <th>Ngày đặt hàng</th>
         <th>Phương thức thanh toán</th>
         <th>Người nhận</th>
         <th>Số điện thoại nhận</th>
         <th>Ngày giao hàng</th>
         <th>Phí giao hàng</th>
         <th>Tạm tính</th>
         <th>Tổng cộng</th>
         <th>Địa chỉ giao hàng</th>
         <th>Nhân viên phụ trách</th>
         <th></th>
         <th></th>
         <th></th>
      </tr>
   </thead>
   <tbody >
      <?php foreach($orders as $order): 
         $customer = $order->getCustomer();
         $staff = $order->getStaff();
         $orderStatus = $order->getStatus();
         $ward = $order->getShippingWard();
         $district = $ward->getDistrict();
         $province = $district->getProvince();
         ?>
         <tr>
            <td ><?=$order->getId()?></td>
            <td><?=$customer->getName()?></td>
            <td><?=$customer->getMobile()?></td>
            <td><?=$customer->getEmail()?></td>
            <td><?=$orderStatus->getDescription()?></td>
            <td><?=$order->getCreatedDate()?> </td>
            <td><?=$order->getPaymentMethod() == 0 ? "Trả tiền khi nhận hàng": "Bank"?></td>
            <td><?=$order->getShippingFullname()?></td>
            <td><?=$order->getShippingMobile()?></td>
            <td><?=$order->getDeliveredDate()?></td>

            <td><?=number_format($order->getShippingFee())?> đ</td>
            <td><?=number_format($order->getTotalPrice())?> đ</td>
            <td><?=number_format($order->getTotalPrice() + $order->getShippingFee())?> đ</td>
            <td><?=$order->getShippingHousenumberStreet()?>, <?=$ward->getName()?>, <?=$district->getName()?>, <?=$province->getName()?></td>
            <td ><?=!empty($staff) ? $staff->getName() : ""?></td>
            <td > 
               <?php if ($order->getStatusId() == 1): ?>
               <a class="btn btn-primary btn-primary" href="index.php?c=order&a=confirm&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xác nhận đơn hàng này phải không?')">Xác nhận</a>
               <?php endif?>
            </td>
            <td > 
               <?php if ($order->getStatusId() == 2): ?>
               <a class="btn btn-primary btn-secondary" href="index.php?c=order&a=confirm&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xác nhận Đóng gói đơn hàng này phải không?')">Đóng gói</a>
               <?php endif?>
            </td>
            <td > 
               <?php if ($order->getStatusId() == 3): ?>
               <a class="btn btn-primary btn-info" href="index.php?c=order&a=confirm&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xác nhận vận chuyển đơn hàng này phải không?')">Giao Hàng</a>
               <?php endif?>
            </td>
            <td > 
               <?php if ($order->getStatusId() == 4): ?>
               <a class="btn btn-primary btn-warning" href="index.php?c=order&a=confirm&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xác nhận đang vận chuyển đơn hàng này phải không?')">Đang giao hàng</a>
               <?php endif?>
            </td>
            <td > 
               <?php if ($order->getStatusId() == 5): ?>
               <a class="btn btn-primary btn-success" href="index.php?c=order&a=confirm&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xác nhận  đã giao đơn hàng này phải không?')">Đã giao hàng</a>
               <?php endif?>
            </td>
            
            <td > <input type="button" onclick="alert('hỗ trợ sau')" value="Sửa" class="btn btn-warning btn-sm"></td>
            <td > 
               <a class="btn btn-danger btn-sm" href="index.php?c=order&a=delete&order_id=<?=$order->getId()?>" onclick="return confirm('Bạn muốn xóa đơn hàng này phải không?')">Xóa</a>
            </td>
         </tr>
      <?php endforeach ?>
   </tbody>
</table>