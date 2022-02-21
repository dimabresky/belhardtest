<?php


require_once(DOC_ROOT . "core2/inc/ajax.func.php");



/**
 * ModAjax class for ajax processing
 *
 * @author dimabresky
 */
class ModAjax extends ajaxFunc{

    /**
     * @param xajaxResponse $res
     */
    public function __construct(xajaxResponse $res) {
        parent::__construct($res);
        $this->module = 'cities';
    }

    function axSaveCity($data) {
        
        $save = [
            'name' => trim(strip_tags($data['control']['name'])),
            'country_name' => trim(strip_tags($data['control']['country_name'])),
            'population' => floatval($data['control']['population'])
        ];

        if ($this->ajaxValidate($data, [
            'name' => 'req',
            'country_name' => 'req',
            'population' => 'req',
        ])) {
            return $this->response;
        }
        
        $this->db->beginTransaction();
        try {

            if (!isset($data['params']['edit']) || $data['params']['edit'] <= 0) {
                $this->db->insert('cities', $save);
            } else {
                $where = $this->db->quoteInto('id = ?', intval($data['params']['edit']));
                $this->db->update('cities', $save, $where);
            }
            $this->db->commit();
        } catch (Exception $ex) {
            $this->db->rollback();
            $this->error[] = $ex->getMessage();
        }

        $this->done($data);
        return $this->response;
    }

}
