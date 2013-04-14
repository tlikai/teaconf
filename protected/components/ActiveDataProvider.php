<?php
/**
 * description
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */
class ActiveDataProvider extends CActiveDataProvider
{
    public function getPagination($className = 'CPagination')
    {
        $pagination = parent::getPagination($className);
        $pagination->pageVar = 'page';
        $pagination->pageSize = intval(isset($_REQUEST['limit']) ? ($_REQUEST['limit'] > 200 ? 200 : $_REQUEST['limit']) : 10);
        $pagination->currentPage = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
        return $pagination;
    }

    protected function fetchData()
    {
        $data = parent::fetchData();
        return array(
            'limit' => intval($this->pagination->pageSize),
            'total' => intval($this->pagination->itemCount),
            'data' => $data,
        );
    }
}
