/* IE7 version 0.7.2 (alpha) 2004/08/22 */
if(window.IE7)IE7.addModule("ie7-box-model",function(){var NUMERIC="\x5cs*:\x5cs*\x5cd[\x5cw%]*",UNIT=/^\d\w*$/,PERCENT=/^\d+%$/,PIXEL=/^\d+(px)?$/;var MATCH=(appVersion<6)?/\b(min|max)-(width|height)\s*:\s*\d/gi:/\b(min|max)-width\s*:\s*\d/gi;var ie7_tmp=tmpElement();push(IE7.recalcs,function removeTempElement(){if(ie7_tmp.parentElement)ie7_tmp.parentElement.removeChild(ie7_tmp)});CSSFixes.addFix(MATCH,function(match){return match.slice(0,3)+match.charAt(4).toUpperCase()+match.slice(5)});var scrollParent=(quirksMode)?document.body:documentElement;function fixWidth(HEIGHT){fixWidth=function(element,value){if(!element.runtimeStyle.fixedWidth&&(!isHTML||element.tagName!="HR")){if(!value)value=element.currentStyle.width;element.runtimeStyle.fixedWidth=(UNIT.test(value))?Math.max(0,getFixedWidth(element,value)):value;element.runtimeStyle.width=element.runtimeStyle.fixedWidth;boxSizing(element)}};if(quirksMode)CSSFixes.addRecalc("width\x5cs*:\x5cs*\x5cd\x5cw*[^%]",fixWidth);var getFixedWidth=(quirksMode)?function(element,value){return getPixelWidth(element,value)+getBorderWidth(element)+getPaddingWidth(element)}:function(element,value){return getPixelWidth(element,value)};function getBorderWidth(element){return element.offsetWidth-element.clientWidth};function getPaddingWidth(element){return getPixelWidth(element,element.currentStyle.paddingLeft)+getPixelWidth(element,element.currentStyle.paddingRight)};function getMarginWidth(element){return((element.currentStyle.marginLeft=="auto")?0:getPixelLeft(element,element.currentStyle.marginLeft))+((element.currentStyle.marginRight=="auto")?0:getPixelLeft(element,element.currentStyle.marginRight))};function minWidth(element){minWidth[minWidth.count++]=element;if(element.currentStyle.minHeight=="auto")element.runtimeStyle.minHeight=0;fixWidth(element);boxSizing(element);resizeWidth(element)};minWidth.count=0;CSSFixes.addRecalc("min-width"+NUMERIC,minWidth);eval(String(minWidth).replace(/min/g,"max"));maxWidth.count=0;CSSFixes.addRecalc("max-width"+NUMERIC,maxWidth);function resizeWidth(element){var rect=element.getBoundingClientRect();var width=rect.right-rect.left;if(element.currentStyle.maxWidth&&width>=getFixedWidth(element,element.currentStyle.maxWidth))element.runtimeStyle.width=getFixedWidth(element,element.currentStyle.maxWidth);else if(element.currentStyle.minWidth&&width<=getFixedWidth(element,element.currentStyle.minWidth))element.runtimeStyle.width=getFixedWidth(element,element.currentStyle.minWidth);else element.runtimeStyle.width=element.runtimeStyle.fixedWidth};function fixRight(element){if((element.currentStyle.position=="absolute"||element.currentStyle.position=="fixed")&&element.currentStyle.left!="auto"&&element.currentStyle.right!="auto"&&element.currentStyle.width=="auto"){fixRight[fixRight.count++]=element;resizeRight(element)}};fixRight.count=0;CSSFixes.addRecalc("right"+NUMERIC,fixRight);function resizeRight(element){element.runtimeStyle.width="";var parentElement=element.offsetParent;while(parentElement&&!hasLayout(parentElement))parentElement=element.offsetParent;if(parentElement.contains(document.body))parentElement=scrollParent;var width=parentElement.clientWidth-getPixelWidth(element,element.currentStyle.right)-getPixelWidth(element,element.currentStyle.left)-getMarginWidth(element);if(!quirksMode)width-=getBorderWidth(element)+getPaddingWidth(element);if(HEIGHT||element.offsetWidth<width){element.runtimeStyle.fixedWidth=width;element.runtimeStyle.width=width}};var clientWidth=documentElement.clientWidth;addEventHandler(window,"onresize",function(){var i,wider=(clientWidth<documentElement.clientWidth);clientWidth=documentElement.clientWidth;for(i=0;i<minWidth.count;i++){var element=minWidth[i];var fixedWidth=(element.runtimeStyle.width==element.currentStyle.minWidth);if(wider&&fixedWidth)element.runtimeStyle.width="";if(wider==fixedWidth)resizeWidth(element)}for(i=0;i<maxWidth.count;i++){var element=maxWidth[i];var fixedWidth=(element.runtimeStyle.width==element.currentStyle.maxWidth);if(!wider&&fixedWidth)element.runtimeStyle.width="";if(wider!=fixedWidth)resizeWidth(element)}for(i=0;i<fixRight.count;i++)resizeRight(fixRight[i]);removeTempElement()});function getPixelWidth(element,value){if(PIXEL.test(value))return parseInt(value);if(PERCENT.test(value))return parseInt(parseFloat(value)/100*element.offsetParent.clientWidth);var parentElement=(element.canHaveChildren)?element:element.parentElement;parentElement.appendChild(ie7_tmp);ie7_tmp.style.width=value;return ie7_tmp.offsetWidth};function getPixelLeft(element,value){if(PIXEL.test(value))return parseInt(value);element.parentElement.appendChild(ie7_tmp);ie7_tmp.style.left=value;return ie7_tmp.offsetLeft}};eval(String(fixWidth).replace(/Width/g,"Height").replace(/width/g,"height").replace(/Left/g,"Top").replace(/left/g,"top").replace(/Right/g,"Bottom").replace(/right/g,"bottom"));fixWidth();fixHeight(true)});
