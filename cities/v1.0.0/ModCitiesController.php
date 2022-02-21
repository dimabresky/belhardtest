<?php

require_once DOC_ROOT . 'core2/inc/classes/Common.php';
require_once DOC_ROOT . 'core2/inc/classes/class.list.php';
require_once DOC_ROOT . 'core2/inc/classes/class.edit.php';
require_once DOC_ROOT . 'core2/inc/classes/class.tab.php';
require_once DOC_ROOT . 'core2/inc/classes/Alert.php';
require_once DOC_ROOT . 'core2/inc/Interfaces/File.php';
require_once DOC_ROOT . 'core2/inc/classes/Panel.php';

/**
 * Controller of cities module
 *
 * @author dimabresky
 */
class ModCitiesController extends Common implements File {

    function action_index() {

        require_once "classes/View.php";

        if (!$this->auth->ADMIN) {
            throw new Exception(911);
        }


        if (isset($_GET['data'])) {
            try {
                switch ($_GET['data']) {
                    // Войти под пользователем
                    case 'login_user':
                        $users = new Admin\Users\Users();
                        $users->loginUser($_POST['user_id']);

                        return json_encode([
                            'status' => 'success',
                        ]);
                        break;
                }
            } catch (Exception $e) {
                return json_encode([
                    'status' => 'error',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }
        $app = "index.php?module=cities&action=index";
        
        $view = new Cities\View();
        $panel = new Panel();

        ob_start();

        try {
            if (isset($_GET['edit'])) {
                if (empty($_GET['edit'])) {
                    $panel->setTitle($this->_("Создание нового города"), '', $app);
                    echo $view->getEdit($app, 0);
                } else {
                    $panel->setTitle("", $this->_('Редактирование города'), $app);
                    echo $view->getEdit($app, intval($_GET['edit']));
                }
            } else {
                $panel->setTitle($this->_("Справочник городов системы"));
                echo $view->getList($app);
            }
        } catch (\Exception $e) {
            echo Alert::danger($e->getMessage(), 'Ошибка');
        }

        $panel->setContent(ob_get_clean());
        return $panel->render();
    }

    public function action_filehandler($context, $table, $id): bool {
        return true;
    }

}
