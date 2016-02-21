<?php
    namespace AppBundle\Controller\Admin;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Bundle\SecurityBundle\Tests\Functional\app\AppKernel;
    use Symfony\Component\HttpFoundation\Request;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Doctrine\Common\Util\Debug;
    use AppBundle\Entity\ShipmentAddress;
    use AppBundle\Form\Type\ShipmentAddressFormType;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Address controller.
     *
     * @Route("/admin/excel")
     */
    class ExcelController extends Controller
    {
        /**
         * Lists all Address entities.
         *
         * @Route("", name="admin_excel")
         * @Method("POST")
         * @param Request $request
         * @return
         */
        public function indexAction(Request $request)
        {
            $ids = $request->get('export');
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
            $phpExcelObject->getProperties()->setCreator("liuggio")->setLastModifiedBy("Admin")->setTitle("订单详情")->setSubject("订单详情导出表")->setDescription("订单详情导出表")->setKeywords("订单 丰盛湾")->setCategory("订单");
            $sheet = $phpExcelObject->setActiveSheetIndex(0);
            $sheet = $this->setSheetTitle($sheet);
            $sheet = $this->setSheetContent($ids, $sheet);
            $phpExcelObject->getActiveSheet()->setTitle('Simple');
            $phpExcelObject->setActiveSheetIndex(0);
            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
            $response = $this->setResponse($writer);
            return $response;
        }

        /**
         * @param $id
         * @return mixed
         */
        private function getOneOrder($id)
        {
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('AppBundle:UserOrder')->find($id);
            $user = $order->getUser();
            $address = $order->getShipmentAddress();
            $products = $order->getOrderProducts();
            $result = $this->getSingleResult($order, $user, $address, $products);
            return $result;
        }

        /**
         * @param $sheet
         */
        private function setSheetTitle($sheet)
        {
            $sheet->setCellValue('A1', '订单号')->setCellValue('B1', '会员号')->setCellValue('C1', '联系电话')->setCellValue('D1', '联系人')->setCellValue('E1', '地址')->setCellValue('F1', '邮编')->setCellValue('G1', '身份证号')->setCellValue('H1', '备注')->setCellValue('I1', '商品详情')->setCellValue('J1', '总价')->setCellValue('K1', '运费')->setCellValue('L1', '下单时间')->setCellValue('M1', '支付时间')->setCellValue('N1', '订单状态')->setCellValue('O1', '身份证正面')->setCellValue('P1', '身份证背面');
            return $sheet;
        }

        /**
         * @param $ids
         * @param $sheet
         */
        private function setSheetContent($ids, $sheet)
        {
            foreach ($ids as $num => $id) {
                $result = $this->getOneOrder($id);
                foreach ($result as $key => $value) {
                    $sheet->setCellValue($key . ($num + 2), $value);
                }
            }
            return $sheet;
        }

        /**
         * @param $order
         * @param $result
         * @param $user
         * @param $address
         * @param $products
         * @return mixed
         */
        private function getSingleResult($order, $user, $address, $products)
        {
            $result['A'] = $order->getOrderId();
            $result['B'] = $user->getUserName();
            $result['C'] = $address->getContactNo();
            $result['D'] = $address->getName();
            $result['E'] = $address->__toString();
            $result['F'] = $address->getPostCode();
            $result['G'] = $address->getIdNo();
            $result['H'] = $address->getComment();
            $result['I'] = '';
            foreach ($products as $product) {
                $product_name = $product->getProduct()->getName();
                $product_count = $product->getCount();
                $result['I'] .= ($product_name . 'x' . $product_count);
            }
            $result['J'] = $order->getTotalPrice();
            $result['K'] = $order->getPostFee();
            if ($order->getCreateAt()) {
                $result['L'] = $order->getCreateAt()->format('Y-m-d H:i:s');
            } else {
                $result['L'] = '';
            }
            if ($order->getPaidAt()) {
                $result['M'] = $order->getPaidAt()->format('Y-m-d H:i:s');
            } else {
                $result['M'] = '';
            }
            switch ($order->getStatus()) {
                case '0':
                    $result['N'] = '未付款';
                    break;
                case '1':
                    $result['N'] = '待发货';
                    break;
                case '2':
                    $result['N'] = '已发货';
                    break;
                case '3':
                    $result['N'] = '已收货';
                    break;
                case '4':
                    $result['N'] = '已取消';
                    break;
                default:
                    $result['N'] = '未知状态';
                    break;
            }
            $result['O'] = $this->getIdScanPath() . $address->getIdBack();
            $result['P'] = $this->getIdScanPath() . $address->getIdFront();
            return $result;
        }


        private function getIdScanPath()
        {
            return $this->generateUrl('homepage', array(), true) . $this->get('kernel')->getIdScanDir();
        }

        /**
         * @param $writer
         * @return mixed
         */
        private function setResponse($writer)
        {
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=订单详情.xls');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            return $response;
        }

    }