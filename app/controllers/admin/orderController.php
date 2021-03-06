<?php

include '../../services/connection.php';
include '../../viewModels/cartViewModel.php';
include '../../viewModels/orderInfoViewModel.php';
include '../../services/productService.php';
include '../../services/shippingService.php';
include '../../services/imageService.php';
include '../../services/orderService.php';

session_start();
$requestMethod = $_SERVER["REQUEST_METHOD"];
$orderService = new OrderService($conn);

switch ($requestMethod) {
    case 'GET':
        $id = $_GET["id"];
        $function = $_GET["function"];
        switch ($function) {
            case 'getCustomerInfo':
                $order = $orderService->get($id);

                $responseData = array(
                    "code" => $order["code"],
                    "customerName" => $order["customerName"],
                    "customerAddress" => $order["customerAddress"],
                    "customerMobile" => $order["customerMobile"],
                    "note" => $order["note"]
                );
                break;
            case 'getProducts':
                $ordersViewModel = $orderService->getWithProduct($id);
                $responseData = array(
                    "code" => $ordersViewModel->code,
                    "items" => $ordersViewModel->items,
                    "shippingMethod" => $ordersViewModel->shippingMethod,
                    "subtotal" => $ordersViewModel->getSubtotal(),
                    "total" => $ordersViewModel->getSubtotal() + $ordersViewModel->shippingMethod["cost"]
                );
                break;
        }
        break;
    case 'POST':
        break;
    case 'PUT':
        $id = $_GET["id"];
        $data = null;
        parse_str(file_get_contents("php://input"), $data);
        $function = $data["function"];
        switch ($function) {
            case 'changeShippingStatus':
                $error = !$orderService->update($id, $data);
                $responseData = array(
                    "error" => $error
                );
                break;
            case 'changeSeenStatus':
                $error = !$orderService->update($id, $data);
                $responseData = array(
                    "error" => $error,
                    "seenAt" => date("d-m-Y")
                );
                break;
            case 'changeCustomerInfo':
                $error = !$orderService->update($id, $data);
                $responseData = array(
                    "error" => $error
                );
                break;
            case 'changeOrderItems':
                $error = $orderService->updateOrderItems($id, $data);
                $responseData = array(
                    "error" => $error
                );
                break;
        }
        break;
    case 'DELETE':
        break;
}
echo json_encode($responseData);
?>