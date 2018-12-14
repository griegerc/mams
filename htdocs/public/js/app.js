"use strict";

$(document).ready(function()
{
    initBindings();
    initActions();
});

function getGames()
{
    loadAjaxResult("analyze", "games", false, "boxGames");
}

function submitSelectGameId(gameId)
{
    if (gameId < 0) {
        return;
    }
    executeAjax("analyze", "selectGameId", {gameId: gameId}, "getMeasureTypes");
}

function getMeasureTypes()
{
    loadAjaxResult("analyze", "measureTypes", false, "boxMeasureTypes");
}

function submitMeasureType(measureTypeId, range)
{
    loadAjaxResult("analyze", "measureData", { measureTypeId:measureTypeId, range:range}, "boxData");
}