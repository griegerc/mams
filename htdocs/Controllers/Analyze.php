<?php

class Controllers_Analyze extends Controllers_Abstract
{
    /**
     * @return void
     */
    public function indexAction()
    {
    }

    /**
     * @return void
     */
    public function gamesAction()
    {
        $this->layout = null;
        $this->env['games'] = $this->_db()->inquiry('getGames');
    }

    /**
     * @return void
     */
    public function selectGameIdAction()
    {
        $this->layout = null;
        $this->renderView = false;
        $_SESSION['gameId'] = (int)$this->_getParam('gameId');
    }

    /**
     * @return void
     */
    public function measureTypesAction()
    {
        $this->layout = null;
        $this->env['measureTypes'] = $this->_db()->inquiry('getMeasureTypes', $this->_getParam('gameId'));
    }

    /**
     * @return void
     */
    public function measureDataAction()
    {
        $this->layout = null;
        $_SESSION['measureTypeId'] = (int)$this->_getParam('measureTypeId');
        $_SESSION['range'] = (int)$this->_getParam('range');

        $params = array(
            (int)$this->_getParam('measureTypeId'),
            (time() - (int)$this->_getParam('range'))
        );
        $this->env['measureData'] = $this->_db()->inquiry('getMeasureData', $params);
    }
}