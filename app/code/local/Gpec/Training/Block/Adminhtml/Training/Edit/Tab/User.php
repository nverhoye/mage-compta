<?php

/**
 * Shop categories tab
 *
 * @category   Atecna
 * @package    Atecna_Shop
 * @author     Atecna <contact@atecna.fr>
 */
class Gpec_Training_Block_Adminhtml_Training_Edit_Tab_User
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('training_user_grid');
        $this->setDefaultSort('user_id');
        $this->setUseAjax(true);
        if ($this->_getTraining()->getId()) {
            $this->setDefaultFilter(array('in_user' => 1));
        }
    }

    /**
     * Add websites to sales rules collection
     * Set collection
     *
     * @return Mage_Adminhtml_Block_Promo_Quote_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('admin/user')->getCollection();
        $collection->getSelect()
            ->joinLeft('gpec_training_user', 'main_table.user_id = gpec_training_user.user_id')
            ->joinLeft('gpec_job_user', 'main_table.user_id = gpec_job_user.user_id')
            ->joinLeft('gpec_job', 'gpec_job_user.job_id = gpec_job.job_id', array('job_name' => 'gpec_job.name'))
            ->group('main_table.user_id');

        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Crosssell
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_user') {
            $userIds = $this->_getSelectedUser();
            if (empty($userIds)) {
                $userIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('main_table.user_id', array('in' => $userIds));
            } else {
                if ($userIds) {
                    $this->getCollection()->addFieldToFilter('main_table.user_id', array('nin' => $userIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareColumns()
    {

        $this->addColumn('in_user', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'field_name' => 'posted_user_ids[]',
            'values' => $this->_getSelectedUser(),
            'align' => 'center',
            'index' => 'user_id'
        ));

        $this->addColumn('s_firstname', array(
            'header' => Mage::helper('gpec_training')->__('Prénom'),
            'align' => 'left',
            'index' => 'firstname',
            'width' => '15%'
        ));

        $this->addColumn('s_lastname', array(
            'header' => Mage::helper('gpec_training')->__('Nom'),
            'align' => 'left',
            'index' => 'lastname',
            'width' => '15%'
        ));

        $this->addColumn('s_job_name', array(
            'header' => Mage::helper('gpec_training')->__('Poste'),
            'align' => 'left',
            'index' => 'job_name',
            'width' => '20%'
        ));

        $this->addColumn('s_email', array(
            'header' => Mage::helper('gpec_training')->__('Email'),
            'align' => 'left',
            'index' => 'email',
        ));



        parent::_prepareColumns();
        return $this;
    }

    protected function _getSelectedUser()
    {
        return array_keys($this->getSelectedUser());
    }

    public function getSelectedUser()
    {
        $selectedUser = array();

        if ($trainingId = $this->getRequest()->getParam('training_id', false)) {
            $training = Mage::getModel('gpec_training/training')->load($trainingId);
            foreach ($training->getUserIds() as $userId) {
                $selectedUser[$userId] = $userId;
            }
        }

        return $selectedUser;
    }

    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/usergrid', array('_current' => true));
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getTraining()
    {
        return Mage::registry('current_training');
    }


}
