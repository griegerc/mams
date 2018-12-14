"use strict";

function initActions()
{
    var elem = $(".jsAction");
    elem.removeClass("jsAction");
    $.each(elem, function(key, value) {
        executeAction(value);
    });
}

function initBindings()
{
    var elem = $(".jsClick");
    elem.unbind("click");
    elem.click(function(event) {
        processBinding(event);
    });

    elem = $(".jsChange");
    elem.unbind("change");
    elem.change(function(event) {
        processBinding(event);
    });

    elem = $(".jsForm");
    elem.unbind("submit");
    elem.submit(function(event) {
        event.preventDefault();
        processBinding(event);
    });
}


function executeAction(elem)
{
    var classList = $(elem).attr("class").split(/\s+/);
    var param = "", callableEvent = "", paramList = [];
    $.each(classList, function(index, className) {
        param = className.split(/:/);

        if (param[0] === "jsEvent") {
            callableEvent = param[1];
        } else if (param[0] === "jsData") {
            paramList.push(param[1]);
        }
    });

    if(typeof window[callableEvent] === "function") {
        paramList.push(elem);
        window[callableEvent].apply(this, paramList);
    }
}

function processBinding(event)
{
    var classList = $(event.target).attr("class").split(/\s+/);
    var param = "", callableEvent = "", paramList = [];

    $.each(classList, function(index, className) {
        param = className.split(/:/);

        if (param[0] === "jsEvent") {
            callableEvent = param[1];
        } else if (param[0] === "jsData") {
            paramList.push(param[1]);
        }
    });

    // gather all form elements as parameters
    if (event.type === "submit") {
        var elem = $(event.target).find(".jsField");

        $.each(elem, function(index, element) {
            switch ($(element).attr("type")) {
                case "checkbox":
                default:
                    paramList.push($(element).val());
                    break;
            }
        });
    }

    if(typeof window[callableEvent] === "function") {
        paramList.push(event.target);
        window[callableEvent].apply(this, paramList);
    }
}


function getAjaxUrl(controller, action, params)
{
    var ajaxUrl = "/" + controller;
    if (action !== undefined) {
        ajaxUrl += "/" + action;
    }
    if (typeof params === "object") {
        $.each(params, function(paramKey, paramValue) {
            ajaxUrl += "/" + paramKey + "/" + encodeURIComponent(paramValue);
        });
    }
    return ajaxUrl;
}


function executeAjax(controller, action, params, callableEvent, paramList)
{
    var ajaxUrl = getAjaxUrl(controller, action, params);
    $.ajax({
        type: "GET",
        url: ajaxUrl,
        error: function(data) {
            return handleError(data);
        },
        success: function(data) {
            if (paramList === undefined) {
                paramList = [data];
            } else {
                paramList.push(data);
            }
            if(typeof window[callableEvent] === "function") {
                if (paramList === undefined) {
                    paramList = [];
                }
                window[callableEvent].apply(this, paramList);
            }
        }
    });
}


function loadAjaxResult(controller, action, params, resultElementId, callableEvent, paramList)
{
    var ajaxUrl = getAjaxUrl(controller, action, params);
    $.ajax({
        type: "GET",
        url: ajaxUrl,
        error: function(data) {
            return handleError(data);
        },
        success: function(data) {
            $("#"+resultElementId).html(data);
            initBindings();
            initActions();

            if(typeof window[callableEvent] === "function") {
                if (paramList === undefined) {
                    paramList = [];
                }
                window[callableEvent].apply(this, paramList);
            }
        }
    });
}


function handleError(ajaxData)
{
    if (ajaxData.status === 403) {
        window.location.href = "/";
    }
}
