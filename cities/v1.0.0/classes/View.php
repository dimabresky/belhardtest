<?php

namespace Cities;

require_once DOC_ROOT . 'core2/inc/classes/class.list.php';
require_once DOC_ROOT . 'core2/inc/classes/class.edit.php';
require_once DOC_ROOT . 'core2/inc/classes/Common.php';

/**
 */
class View extends \Common {

    private $app = "index.php?module=cities&action=index";

    /**
     * таблица с городами
     * @return false|string
     * @throws \Exception
     */
    public function getList($app) {

        $list = new \listTable('cities');

        $list->SQL = "
            select * from cities
        ";

        $list->addColumn($this->_("Название города"), "50", "TEXT");
        $list->addColumn($this->_("Страна"), "50", "TEXT");
        $list->addColumn($this->_("Население"), "50", "TEXT");

        $list->paintColor = "fafafa";
        $list->fontColor = "silver";

        $list->addURL = $app . "&edit=0";
        $list->editURL = $app . "&edit=TCOL_00";
        $list->deleteKey = "cities.id";

        $list->getData();

        ob_start();
        
        $list->showTable();
        return ob_get_clean();
    }

    /**
     * @param string    $app
     * @param int  $id
     * @return false|string
     * @throws \Zend_Db_Adapter_Exception
     * @throws \Zend_Exception
     */
    public function getEdit(string $app, int $id) {

        $edit = new \editTable('cities');

        $fields = [
            'id',
            'name',
            'country_name',
            'population'
        ];


        $implode_fields = implode(",\n", $fields);

        $edit->SQL = $this->db->quoteInto("
            SELECT {$implode_fields}
            FROM cities
               
            WHERE id = ?
        ", $id ?: 0);


        $edit->addControl($this->_("Название"), "TEXT", "maxlength=\"50\" style=\"width:385px\"", "", "", true);
        $edit->addControl($this->_("Страна"), "TEXT", "maxlength=\"50\" style=\"width:385px\"", "", "", true);
        $edit->addControl($this->_("Население"), "TEXT", "maxlength=\"50\" style=\"width:385px\"", "", "", true);


        $edit->back = $app;
        $edit->firstColWidth = '200px';
        $edit->addButton($this->_("Вернуться к списку городов"), "load('$app')");
        $edit->save("xajax_saveCity(xajax.getFormValues(this.id))");

        return $edit->render();
    }

}
