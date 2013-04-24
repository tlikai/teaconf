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
        $pagination->pageSize = intval(isset($_REQUEST['perpage']) ? ($_REQUEST['perpage'] > 200 ? 200 : $_REQUEST['perpage']) : 10);
        $pagination->currentPage = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
        return $pagination;
    }

    protected function fetchData()
    {
        $data = parent::fetchData();
        return array(
            'perpage' => intval($this->pagination->pageSize),
            'total' => intval($this->pagination->itemCount),
            'data' => $data,
        );
    }
}
