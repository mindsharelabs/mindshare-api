/**
 * search term highlighter
 *
 * @created 3/21/13 1:26 PM
 * @author Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link https://mindsharelabs.com/downloads/mindshare-theme-api/
 *
 */
jQuery.noConflict();jQuery(document).ready(function(){if(typeof(mapi_query)!="undefined"){var area;var i;var s;for(s in mapi_areas){area=jQuery(mapi_areas[s]);if(area.length!=0){for(var l=0;l<area.length;l++){for(i in mapi_query){area.eq(l).highlight(mapi_query[i],1,"highlight term-"+i);}}break;}}}});jQuery.fn.extend({highlight:function(term,insensitive,span_class){var regex=new RegExp("(<[^>]*>)|(\\b"+term.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1")+")",insensitive?"ig":"g");return this.html(this.html().replace(regex,function(a,b,c){return(a.charAt(0)=="<")?a:'<span class="'+span_class+'">'+c+"</span>";}));}});
