<?php


class Compta_Calendar_Adminhtml_Calendar_IndexController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('calendar/calendar')
            ->_addBreadcrumb(
                Mage::helper('compta_calendar')->__('Disponibilités'),
                Mage::helper('compta_calendar')->__('Disponibilités')
            );

        return $this;
    }

    public function indexAction()
    {

        $this->_initAction()
            ->renderLayout();

    }

    public function saveAction()
    {
        $post = $this->getRequest()->getPost();
        if ($post && isset($post['date-ymd'])) {
            try {

                foreach($post['hours'] as $customerId => $nbHour) {

                    $nbHour = (int)$nbHour;

                    $calendarObject = Mage::getModel('compta_calendar/calendar')->load($customerId, 'customer_id');

                    if($nbHour > 0) {
                        $dateValues = array((string)$post['date-ymd'] =>$nbHour);
                    }

                    if($calendarObject->getValues()) {
                        $dateValues =$calendarObject->getValues();
                        $dateValues = (array)Mage::helper('core')->jsonDecode($dateValues);

                        if(isset($dateValues[$post['date-ymd']])) {
                            $dateValues[$post['date-ymd']] = $nbHour;
                        } else {
                            if($nbHour > 0) {
                                $dateValues[$post['date-ymd']] = $nbHour;
                            }
                        }

                    }

                    if(!empty($dateValues)) {
                        $calendarObject->setCustomerId($customerId)
                            ->setValues(Mage::helper('core')->jsonEncode($dateValues))
                            ->save();
                    }

                    $dateValues = null;
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('Enregistrement réalisé avec succès')
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $e->getMessage()
                );
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                $this->__('Une erreur est survenue')
            );
        }
        $this->_redirectReferer();
    }

}
