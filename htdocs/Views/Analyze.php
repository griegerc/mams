<?php

class Views_Analyze extends Views_Abstract
{
    /**
     * @return void
     */
    public function index()
    {
        ?>
            <div id="boxGames" class="boxGames jsAction jsEvent:getGames"></div>
            <div id="boxMeasureTypes" class="boxMeasureTypes jsAction jsEvent:getMeasureTypes"></div>
            <div id="boxData" class="boxData jsAction jsEvent:getMeasureData"></div>
        <?php
    }

    /**
     * @return void
     */
    public function games()
    {
        $gameId = (int)$this->_getParam('gameId');

        ?>
        <form action="" method="get" class="jsForm jsEvent:submitSelectGameId">
            <label for="gameId"><?php print $this->t->get('labelGameId'); ?></label>
            <select id="gameId" name="gameId" class="jsField">
                <?php
                foreach ($this->_getParam('games') as $game) {
                    $selected = '';
                    if ($gameId == $game['gameId']) {
                        $selected = ' selected="selected"';
                    }
                    print '<option'.$selected.'>';
                    print $game['gameId'];
                    print '</option>';
                }
                ?>
            </select>
            <input type="submit" value="<?php print $this->t->get('buttonNext'); ?>"/>
        </form>
        <?php
    }

    /**
     * @return void
     */
    public function measureTypes()
    {
        $gameId = (int)$this->_getParam('gameId');
        if ($gameId <= 0) {
            return;
        }

        ?>
        <form action="" method="get" class="jsForm jsEvent:submitMeasureType">
            <label for="measureTypeId"><?php print $this->t->get('labelMetric'); ?></label>
            <select id="measureTypeId" name="measureTypeId" class="jsField">
                <?php
                foreach ($this->_getParam('measureTypes') as $key) {
                    print '<option value="'.$key['measureTypeId'].'">';
                    print $key['measureKey'];
                    print '</option>';
                }
                ?>
            </select>
            <input type="hidden" name="range" class="jsField" value="3600"/>
            <input type="submit" value="<?php print $this->t->get('buttonOk'); ?>"/>
        </form>
        <?php
    }

    /**
     * @return void
     */
    public function measureData()
    {
        $measureTypeId = (int)$this->_getParam('measureTypeId');
        if ($measureTypeId <= 0) {
            return;
        }

        $ranges = array(
            array(3600, $this->t->get('optionRange1h')),
            array(14400, $this->t->get('optionRange4h')),
            array(28800, $this->t->get('optionRange8h')),
            array(86400, $this->t->get('optionRange24h')),
            array(86400 * 2, $this->t->get('optionRange48h')),
            array(86400 * 7, $this->t->get('optionRange7d')),
            array(86400 * 14, $this->t->get('optionRange14d')),
            array(86400 * 30, $this->t->get('optionRange30d')),
            array(86400 * 90, $this->t->get('optionRange90d')),
        );

        ?>
        <form action="" method="get" class="jsForm jsEvent:submitMeasureType">
            <input type="hidden" name="measureTypeId" class="jsField"
                   value="<?php print $measureTypeId; ?>"/>
            <label for="range"><?php print $this->t->get('labelRange'); ?></label>
            <select id="range" name="range" class="jsField">
                <?php
                    foreach ($ranges as $r) {
                        $selected = '';
                        if ($this->_getParam('range') == $r[0]) {
                            $selected = ' selected="selected"';
                        }
                        print '<option value="'.$r[0].'"'.$selected.'>';
                        print $r[1];
                        print '</option>';
                    }
                ?>
            </select>
            <input type="submit" value="<?php print $this->t->get('buttonOk'); ?>"/>
        </form>
        <br/>
        <canvas id="boxChart" width="600" height="300"></canvas>
        <script type="text/javascript">
            var ctx = document.getElementById("boxChart").getContext("2d");
            moment.locale('<?php print strtolower(Gpf_Config::get('LANGUAGE')); ?>');
            var myChart = new Chart(ctx, {
                type: "line",
                data:
                    {
                        datasets: [{
                            fill: "start",
                            borderColor: "#3b853b",
                            backgroundColor: "#96cc96",
                            data: [
                                <?php
                                    foreach ($this->_getParam('measureData') as $set){
                                        print '{
                                            x: new Date('.$set['dataTime'].'000),
                                            y: '.$set['value'].'
                                        },';
                                    }
                                ?>
                            ]
                        }]
                    },
                options: {
                    legend: false,
                    scales: {
                        xAxes: [{
                            type: "time",
                            time: {
                                unit: "day"
                            }
                        }]
                    },
                    elements: {
                        line: {
                            tension: 0, // disables bezier curves
                        }
                    }
                }
            });
        </script>
        <?php
    }
}