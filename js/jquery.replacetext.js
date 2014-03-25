/* jQuery replaceText - v1.1 - 11/21/2009, (c)2009 Ben Alman http://benalman.com/about/license/ */
(function ($) {
	$.fn.replaceText = function (b, a, c) {
		return this.each(function () {
			var f = this.firstChild, g, e, d = [];
			if (f) {
				do {
					if (f.nodeType === 3) {
						g = f.nodeValue;
						e = g.replace(b, a);
						if (e !== g) {
							if (!c && /</.test(e)) {
								$(f).before(e);
								d.push(f)
							} else {
								f.nodeValue = e
							}
						}
					}
				} while (f = f.nextSibling)
			}
			d.length && $(d).remove()
		})
	}
})(jQuery);
