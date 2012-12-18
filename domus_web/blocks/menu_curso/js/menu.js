var XXIEHV0 = { dummy: 0,
				    LAYER: false,
				    X: 0,
				    Y: 0,
				    VALIGN: 0,
				    IS_FLOATING: false,
				    CSS_PLACEMENT: 1,
				    ROLLOVER_HAS_BORDER: true,
				    SHOW_SELECTED: false,
				    STYLE: 2,
				    V_INTERVAL: 2,
				    MAIN_OPACITY: 100,
				    FLYOUT_OPACITY: 100,
				    OVERLAP: true,
				    Z_INDEX: 50,
				    PARENT_MO: true,
				    SHADOW_STYLE: 2,
				    OPEN_EVENT: 0,
				    OPEN_ANIMATION: 0,
				    CLOSE_ANIMATION: 0,
				    OPEN_SPEED: 10,
				    CLOSE_SPEED: 10,
				    SHOW_DELAY: 50,
				    AUTOCLOSE_DELAY: 150,
				    SEO_LINKS: 1,
				    TRANSFORM_PATHS: true,
				    BACKGROUND_COLOR: '#dedede',
				    SEPARATOR_COLOR: '#c0c0c0',
				    NORMAL_COLOR: '#dedede',
				    MOUSEOVER_COLOR: '#409db5',
				    MOUSEDOWN_COLOR: '#409db5',
				    SELECTED_COLOR: '#cdcdcd',
				    SELECTED_PARENT_COLOR: '',
				    NORMAL_BORDER_COLOR: '#c0c0c0',
				    MOUSEOVER_BORDER_COLOR: '',
				    MOUSEDOWN_BORDER_COLOR: '',
				    SELECTED_BORDER_COLOR: '',
				    SELECTED_PARENT_BORDER_COLOR: '',
				    TEXT_COLOR: '#409db5',
				    TEXT_MOUSEOVER_COLOR: '#ffffff',
				    TEXT_MOUSEDOWN_COLOR: '#FFFFFF',
				    TEXT_SELECTED_COLOR: '#409db5',
				    TEXT_SELECTED_PARENT_COLOR: '#409db5',
				    BORDER_COLOR: '',
				    FLYOUT_BORDER_COLOR: '',
				    CROSSFADE: 0,
				    ALIGN_MAIN_NORMAL: 0,
				    ALIGN_MAIN_HEADING: 0,
				    ALIGN_FO_NORMAL: 0,
				    ALIGN_FO_HEADING: 0,
				    RTL: false,
				    SUB_ARROW: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    SUB_ARROW_ROLLOVER: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    UP_ARROW: urlBase + "/blocks/menu_curso/img/up.gif",
				    UP_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/up_disabled.gif",
				    DOWN_ARROW: urlBase + "/blocks/menu_curso/img/down.gif",
				    DOWN_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/down_disabled.gif",
				    PREVIEW_BACKGROUND_COLOR: '#FFFFFF',
				    STREAM: [],
				    Browser: function() {
				        var ua = navigator.userAgent.toLowerCase();
				        this.opera = ua.indexOf('opera') >= 0;
				        this.safari = ua.indexOf('safari') >= 0;
				        this.ie = document.all && !this.opera;
				        this.macie = this.ie && ua.indexOf('mac') >= 0;
				        this.winie = this.ie && !this.macie;
				        this.ieCanvas = (this.ie && document.compatMode == "CSS1Compat") ? document.documentElement : document.body;
				        return this;
				    },
				    setPathAdjustment: function(id) {
				        var sl = '';
				        var sc = document.getElementsByTagName('script');
				        for (var i = 0; i < sc.length; i++) { if (sc[i].innerHTML.search(id) > -1) sl = sc[i].src; } this.SCRIPT_LOCATION = sl.substr(0, sl.lastIndexOf('/') + 1);
				    },
				    adjustPath: function(path) {
				        if (path.charAt(0) != '*') return path;
				        return this.SCRIPT_LOCATION + path.substr(1);
				    },
				    linkScripts: function(aNewScripts) {
				        var scripts = document.getElementsByTagName('script');
				        for (var i = 0; i < aNewScripts.length; i++) {
				            var bScriptLinked = false;
				            for (var j = 0; j < scripts.length; j++) { if (aNewScripts[i] == scripts[j].src) { bScriptLinked = true; break; } } if (!bScriptLinked) document.write("<script src='" + this.adjustPath(aNewScripts[i]) + "' type='text/javascript'><\/script>");
				        }
				    },
				    isCurrent: function(r) {
				        if (!r) return false;
				        var l = location.href;
				        if (r.search('//') == -1) {
				            if (r.charAt(0) == '/')
				                r = l.replace(/(.*\/\/[^\/]*).*/, '$1') + r;
				            else
				                r = l.replace(/[^\/]*$/, '') + r;
				        } do {
				            var r1 = r;
				            r = r1.replace(/[^\/]*\/\.\.\//, '');
				        } while (r != r1)
				        return r == l;
				    },
				    init: function(div,menu) {
				        var m = this;
				        //m.STREAM = strm;
				        //m.ID = PLVFOXXIEHV0;        
				        m.STREAM = menu;
				        m.ID = div;
				        m.br = new m.Browser();
				        m.setPathAdjustment('PLVFOMenu script ID:' + m.ID + ' ');
				        m.linkScripts(new Array());
				        m.addLoadEvent(m.onload);
				    },
				    onload: function() { XXIEHV0.start(); },
				    start: function() {
				        var m = this;
				        m.flyouts = new Array;
				        m.defaultFO = 0;
				        m.lastFoid = 0;
				        m.currentItem = null;
				        m.timeout = null;
				        m.interval = null;
				        m.scroll_start = 0;
				        m.scroll_time = 0;
				        m.scroll_delta = 0;
				        m.div = document.getElementById(this.ID + 'Div');
				        m.SUB_ARROW = m.adjustPath(m.SUB_ARROW);
				        m.SUB_ARROW_ROLLOVER = m.adjustPath(m.SUB_ARROW_ROLLOVER);
				        m.UP_ARROW = m.adjustPath(m.UP_ARROW);
				        m.UP_ARROW_DISABLED = m.adjustPath(m.UP_ARROW_DISABLED);
				        m.DOWN_ARROW = m.adjustPath(m.DOWN_ARROW);
				        m.DOWN_ARROW_DISABLED = m.adjustPath(m.DOWN_ARROW_DISABLED);
				        m.preload(m.SUB_ARROW_ROLLOVER);
				        m.preload(m.UP_ARROW);
				        m.preload(m.DOWN_ARROW_DISABLED);
				        m.flyouts[0] = new m.flyout(m, null, 0);
				        var i = 0, st = m.STREAM;
				        while (i < st.length) {
				            var index = st[i++];
				            var n = st[i++];
				            var cur = new Object;
				            i = m.readCurColors(cur, st, i);
				            var fo = m.flyouts[index].div;
				            if (!index) {
				                fo.onmouseover = m.onmouseover;
				                fo.onmouseout = m.onmouseout;
				            } var wraper;
				            var uss = "";
				            var dss = "";
				            if (fo.foid = index) {
				                fo.style.backgroundColor = cur.SecColor;
				                wraper = fo;
				                uss = this.getScroller(1, cur);
				                dss = this.getScroller(0, cur);
				            } else { wraper = m.div.getElementsByTagName('div')[0]; } var fos = "";
				            var ss = "";
				            var firstSection = 1;
				            var firstItem = 1;
				            for (var j = 0; j < n; j++) {
				                var type = st[i++];
				                if (type == 0) {
				                    var item = m.flyouts[index].links[j] = new m.link(m, index, j, firstItem, cur, st, i);
				                    ss += item.html;
				                    i = item.i;
				                    firstItem = 0;
				                } else if (type == 1) {
				                    var txt = st[i++];
				                    ss += "<li class=\"PLVFOHeading\" style=\"float:left;" + (index ? "" : "width:138px;") + "height:" + (index ? "32" : "32") + "px;" + (!firstItem ? "margin-top:2px;" : "") + "padding:" + (index ? "18" : "18") + "px 4px 0px 4px;\">" + txt + "</li>";
				                    firstItem = 0;
				                } else if (type == 2) {
				                    fos += m.wrapSection(ss, index, cur, firstSection);
				                    ss = "";
				                    i = m.readCurColors(cur, st, i);
				                    firstItem = 1;
				                    firstSection = 0;
				                }
				            } fos += m.wrapSection(ss, index, cur, firstSection);
				            if (index)
				                fos = uss + "<ul style=\"margin:0;padding:0;\">" + fos + "</ul>" + dss;
				            else
				                fos = "<ul style=\"float:left;margin:0 0 10px 0;padding:2px;background-color:#dedede;\">" + fos + "</ul>";
				            wraper.innerHTML = fos;
				            if (index) {
				                fo.upScrWrp = wraper.childNodes[0];
				                var upScr = fo.upScrWrp.getElementsByTagName("div")[0];
				                upScr.o = new Object;
				                fo.upArrow = fo.upScrWrp.getElementsByTagName("img")[0];
				                var scrollArea = wraper.childNodes[1];
				                fo.dwnScrWrp = wraper.childNodes[2];
				                var dwnScr = fo.dwnScrWrp.getElementsByTagName("div")[0];
				                dwnScr.o = new Object;
				                fo.downArrow = fo.dwnScrWrp.getElementsByTagName("img")[0];
				                var attr = new Array('ncolor', 'mocolor', 'brdcolor', 'bmocolor');
				                for (var a = 0; a < attr.length; a++) {
				                    eval('upScr.o.' + attr[a] + '=upScr.getAttribute("' + attr[a] + '")');
				                    eval('dwnScr.o.' + attr[a] + '=dwnScr.getAttribute("' + attr[a] + '")');
				                } dwnScr.foid = upScr.foid = index;
				            } var items = wraper.getElementsByTagName("li");
				            var w = 140;
				            for (var k = 0; k < items.length; k++) {
				                var e = items[k];
				                if ((e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') && e.offsetWidth > w) w = e.offsetWidth;
				                if (e.className == 'PLVFOLink') {
				                    e.o = m.flyouts[e.getAttribute("foi")].links[e.getAttribute("iti")];
				                    e.o.e = e;
				                    var attr = new Array('foid', 'cfoid', 'ref', 'targ', 'func', 'params', 'imgn', 'imgo', 'sel');
				                    for (var a = 0; a < attr.length; a++)
				                        eval('e.' + attr[a] + '=e.o.' + attr[a]);
				                    e.onmousedown = m.onmousedown;
				                    e.onmouseup = m.onmouseup;
				                    e.onclick = m.onclick;
				                    e.co = 0;
				                    if (e.className == 'PLVFOLink' && e.cfoid > 0) { m.flyouts[e.cfoid] = new m.flyout(m, e, e.cfoid); }
				                } if (e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') {
				                    if (e.className == 'PLVFOLink') {
				                        e.a = e.getElementsByTagName('a')[0];
				                        e.a.onfocus = function() { this.blur(); };
				                    } var imgs = e.getElementsByTagName('img');
				                    for (var j = 0; j < imgs.length; j++) {
				                        if (imgs[j].className == 'PLVFOIcon') e.img = imgs[j];
				                        if (imgs[j].className == 'PLVFOArrow') e.fo_arrow = imgs[j];
				                    }
				                }
				            } if (index) {
				                fo.style.width = w + 4 + 'px';
				                for (var k = 0; k < items.length; k++) {
				                    var e = items[k];
				                    e.style.width = w - (e.className == 'PLVFOLink' ? 2 : 8) + 'px';
				                } upScr.style.width = dwnScr.style.width = w - 2;
				                fo.scrollArea = scrollArea;
				                fo.style.zIndex = 50;
				                fo.style.display = 'none';
				            }
				        }
				    },
				    getScroller: function(up, cur) { return "<div style=\"padding:2px;\"><div class=\"PLVFO_" + (up ? "UP" : "DOWN") + "SCROLLER\" style=\"padding:2px 0px;text-align:center;border:solid 1px " + cur.BColor + ";" + (cur.Color ? "background-color:" + cur.Color + ";" : "") + "cursor:pointer;\" ncolor=\"" + cur.Color + "\" mocolor=\"" + cur.MOColor + "\" brdcolor=\"" + cur.BColor + "\" bmocolor=\"" + cur.BMOColor + "\"><img src=\"" + (up ? this.UP_ARROW_DISABLED : this.DOWN_ARROW) + "\"></div></div>"; },
				    wrapSection: function(s, index, cur, first) {
				        var ws = "";
				        if (!index) return s;
				        ws += "<li style=\"float:left;\"><ul style=\"float:left;" + (s == "" ? "height:0px;" : "") + "margin:0px;padding:" + (s == "" ? "0px " : "") + "2px;" + (s == "" ? "font-size:0px;" : "") + (cur.SecColor != "" ? "background-color:" + cur.SecColor + ";" : "") + (cur.sepColor != "" && !first ? "border-top:solid 1px " + cur.sepColor + ";" : "") + "\">" + s + "</ul></li>";
				        return ws;
				    },
				    readCurColors: function(cur, st, i) {
				        var bg = cur.SecColor = st[i++];
				        cur.sepColor = st[i];
				        cur.Color = st[++i];
				        cur.MOColor = st[++i];
				        cur.MDColor = st[++i];
				        cur.SelColor = st[++i];
				        cur.SelParColor = st[++i];
				        cur.BColor = st[++i] ? st[i] : bg;
				        cur.BMOColor = st[++i] ? st[i] : bg;
				        cur.BMDColor = st[++i] ? st[i] : bg;
				        cur.BSelColor = st[++i] ? st[i] : bg;
				        cur.BSelParColor = st[++i] ? st[i] : bg;
				        i++;
				        cur.TxtColor = st[i++];
				        cur.TMOColor = st[i++];
				        cur.TMDColor = st[i++];
				        cur.TSelColor = st[i++];
				        cur.TSelParColor = st[i++];
				        return i;
				    },
				    onmouseover: function(evt) {
				        var m = XXIEHV0;
				        var e = m.getSource(evt);
				        m.over(e);
				    },
				    over: function(e) {
				        var m = this;
				        m.lastFoid = e.foid;
				        if (e) {
				            window.clearTimeout(m.timeout);
				            if (e.cfoid) m.lastFoid = e.cfoid;
				            if (e.className == 'PLVFO_UPSCROLLER' || e.className == 'PLVFO_DOWNSCROLLER') {
				                m.showMO(e);
				                m.scroll_start = m.flyouts[e.foid].div.scrollArea.scrollTop;
				                m.scroll_time = m.getTime();
				                m.scroll_delta = e.className == 'PLVFO_UPSCROLLER' ? -0.15 : 0.15;
				                m.interval = window.setInterval('XXIEHV0.scroll(' + e.foid + ')', 35);
				            } else if (e.className == 'PLVFOLink') {
				                m.currentItem = e;
				                m.showMO(e);
				                m.timeout = window.setTimeout('XXIEHV0.updateFlyouts()', 50);
				            }
				        }
				    },
				    onmouseout: function(evt) {
				        var m = XXIEHV0;
				        var e = m.getSource(evt);
				        m.out(e);
				    },
				    out: function(e) {
				        var m = this;
				        m.lastFoid = 0;
				        if (e && ((e.className == 'PLVFO_UPSCROLLER') || (e.className == 'PLVFO_DOWNSCROLLER') || (e.className == 'PLVFOLink' && !e.co))) m.hideMO(e);
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.timeout = window.setTimeout('XXIEHV0.updateFlyouts()', 150);
				    },
				    onmousedown: function(evt) {
				        var m = XXIEHV0;
				        var e = m.getSource(evt);
				        e.style.borderColor = e.o.bmdcolor;
				        e.style.backgroundColor = e.o.mdcolor;
				        e.a.style.color = e.o.tmdcolor;
				    },
				    onmouseup: function(evt) {
				        var m = XXIEHV0;
				        var e = m.getSource(evt);
				        m.clicked(e);
				    },
				    clicked: function(e) {
				        var m = XXIEHV0;
				        m.showMO(e);
				        m.lastFoid = 0;
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.updateFlyouts();
				        if (e.func) eval(e.func + '("PLVFOMenu script ID:"+XXIEHV0.ID,"' + e.ref + '",' + e.params + ')');
				        else {
				            if (!e.ref) return;
				            if (e.targ) window.open(e.ref, e.targ);
				            else location = e.ref;
				        }
				    },
				    onclick: function(evt) { return false; },
				    showMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW_ROLLOVER + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.bmocolor;
				        e.style.backgroundColor = e.o.mocolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.tmocolor;
				            if (e.imgo) {
				                e.img.src = e.imgo;
				                e.img.style.visibility = '';
				            }
				        }
				    },
				    hideMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.brdcolor;
				        e.style.backgroundColor = e.o.ncolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.txtcolor;
				            if (e.imgn) e.img.src = e.imgn;
				            else if (e.imgo) e.img.style.visibility = 'hidden';
				        }
				    },
				    updateFlyouts: function() {
				        var m = this;
				        for (var i = 1; i < m.flyouts.length; i++) m.flyouts[i].show = false;
				        if (m.lastFoid == 0) m.lastFoid = m.defaultFO;
				        if (m.lastFoid > 0) {
				            var fo = m.flyouts[m.lastFoid];
				            while (fo.pfi) {
				                fo.show = true;
				                fo = m.flyouts[fo.pfi.foid];
				            }
				        } for (var i = 1; i < m.flyouts.length; i++) {
				            var foo = m.flyouts[i];
				            if (foo.index) {
				                if (foo.show && !foo.shown) foo.showFlyout(foo);
				                if (!foo.show && foo.shown) foo.removeFlyout();
				            }
				        }
				    },
				    scroll: function(foid) {
				        var m = this;
				        var offset = m.scroll_start + (m.getTime() - m.scroll_time) * m.scroll_delta;
				        var fo = m.flyouts[foid];
				        var fd = fo.div;
				        fd.scrollArea.scrollTop = offset;
				        fd.upArrow.src = offset <= 0 ? m.UP_ARROW_DISABLED : m.UP_ARROW;
				        fd.downArrow.src = offset >= fd.scrollArea.scrollHeight - fd.scrollArea.offsetHeight ? m.DOWN_ARROW_DISABLED : m.DOWN_ARROW;
				    },
				    getSource: function(evt) {
				        var e = this.br.ie ? event.srcElement : evt.target;
				        while (e && e.tagName != "DIV" && e.tagName != "LI")
				            e = e.parentNode;
				        return e;
				    },
				    getFoid: function(e) { while (e && (!e.foid)) { e = e.parentNode; } return e ? e.foid : 0; },
				    addLoadEvent: function(f) {
				        var done = 0;
				        function w() {
				            if (!done) {
				                done = 1;
				                f();
				            }
				        } if (document.addEventListener) { document.addEventListener('DOMContentLoaded', w, false); } if (this.br.ie && window == top) (function() {
				            try { document.documentElement.doScroll('left'); } catch (e) {
				                setTimeout(arguments.callee, 0);
				                return;
				            } w();
				        })();
				        var oldf = window.onload;
				        if (typeof oldf != 'function') { window.onload = w; } else { window.onload = function() { try { oldf(); } catch (e) { } w(); }; }
				    },
				    preload: function(img) {
				        if (!img) return;
				        if (!this.preloads) this.preloads = new Array;
				        var len = this.preloads.length;
				        var i = 0;
				        while (i < len) {
				            if (this.preloads[i].path == img) return;
				            i++;
				        } this.preloads[len] = new Object;
				        this.preloads[len].path = img;
				        this.preloads[len].img = new Image;
				        this.preloads[len].img.src = img;
				    },
				    getLeft: function(e, base) {
				        var m = this;
				        var left = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            left += e.offsetLeft;
				            e = e.offsetParent;
				            if (e && m.br.ie) {
				                var bw = parseInt(e.style.borderLeftWidth);
				                if (!bw) bw = 0;
				                left += bw;
				            }
				        } return left;
				    },
				    getTop: function(e, base) {
				        var m = this;
				        var top = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            top += e.offsetTop;
				            e = e.offsetParent;
				            if (e && !m.br.opera) {
				                var bw = parseInt(e.style.borderTopWidth);
				                if (!bw) bw = 0;
				                top += bw;
				            }
				        } return top;
				    },
				    getTime: function() {
				        var time = new Date();
				        return time.valueOf();
				    }
				};  
				
				XXIEHV0.flyout = function(m, parent, index) {
				    var f = this;
				    f.index = index;
				    if (index == 0) {
				        f.div = m.div;
				        f.shown = true;
				    } else {
				        f.div = document.createElement('div');
				        f.div.style.position = 'absolute';
				        f.div.baseOpacity = 100;
				        f.div.baseOpacity = f.horiz ? 100 : 100;
				        if (f.div.baseOpacity != 100) {
				            f.div.style.opacity = f.div.baseOpacity / 100;
				            f.div.style.filter = 'alpha(opacity=' + f.div.baseOpacity + ')';
				        } f.div.style.top = '-10000px';
				        m.div.appendChild(f.div);
				        f.shadows = new Array;
				        for (var s = 1; s <= 4; s++) {
				            f.shadows[s] = document.createElement('div');
				            m.div.appendChild(f.shadows[s]);
				        } f.pfi = parent;
				        f.show = false;
				        f.shown = false;
				        f.intr = false;
				    } f.links = new Array;
				    f.m = m;
				    f.div.obj = f;
				    f.obj = 'XXIEHV0.fo' + index;
				    eval(f.obj + '=f');
				};
				
				XXIEHV0.flyout.prototype = { showFlyout: function() {
				    var f = this;
				    var m = f.m;
				    var e = f.pfi;
				    var pfo = m.flyouts[e.foid];
				    var fo = f.div;
				    if (!fo) return;
				    e.co = 1;
				    if (f.intr) return;
				    f.intr = true;
				    fo.pfoid = e.foid;
				    fo.style.top = '-10000px';
				    fo.upScrWrp.style.display = 'none';
				    fo.dwnScrWrp.style.display = 'none';
				    fo.scrollArea.style.height = '';
				    fo.style.display = '';
				    var docTop = (m.br.ie ? m.br.ieCanvas.scrollTop : window.pageYOffset) - m.getTop(m.div, 2);
				    var docLeft = (m.br.ie ? m.br.ieCanvas.scrollLeft : window.pageXOffset) - m.getLeft(m.div, 2);
				    var docHeight = m.br.ie ? m.br.ieCanvas.clientHeight : window.innerHeight;
				    var docWidth = m.br.ie ? m.br.ieCanvas.offsetWidth : window.innerWidth;
				    var topLimit = docTop + 2;
				    var bottomLimit = docTop + docHeight - 6;
				    var foHeight = fo.offsetHeight;
				    if (m.br.winie) {
				        var avHeight = bottomLimit - topLimit;
				        if (foHeight > avHeight) foHeight = avHeight;
				        if (foHeight < fo.offsetHeight) {
				            fo.upScrWrp.style.display = '';
				            fo.dwnScrWrp.style.display = '';
				            fo.scrollArea.style.overflow = 'hidden';
				            var SAHeight = foHeight - fo.upScrWrp.offsetHeight - fo.dwnScrWrp.offsetHeight;
				            if (SAHeight < 0) SAHeight = 0;
				            fo.scrollArea.style.height = SAHeight + 'px';
				        }
				    } fo.baseHeight = foHeight;
				    fo.baseWidth = fo.offsetWidth;
				    fo.baseTop = m.getTop(e, 0) - 2;
				    if (e.foid > 0 && m.br.ie) fo.baseTop -= pfo.div.scrollArea.scrollTop;
				    fo.baseLeft = m.getLeft(e, 0) + parseInt(e.offsetWidth) - 3;
				    if (fo.baseTop < topLimit) fo.baseTop = topLimit;
				    if (foHeight + fo.baseTop > bottomLimit) {
				        var t = bottomLimit - foHeight;
				        fo.baseTop = t < topLimit ? topLimit : t;
				    } if (fo.baseLeft + fo.offsetWidth + 22 - docLeft > docWidth) fo.baseLeft = (e.foid == 0 ? docWidth - 22 + docLeft : m.flyouts[e.foid].div.baseLeft + 1) - fo.offsetWidth;
				    for (var i = 1; i <= 4; i++) {
				        var s = f.shadows[i];
				        var ss = s.style;
				        ss.display = 'none';
				        ss.position = 'absolute';
				        ss.backgroundColor = '#000000';
				        ss.zIndex = 50 - i;
				        var sp = new Array(-3, -2, -1, -3, 3, 2, 1, 4, 6, 4, 2, 6, -2, 0, 2, 0, 12, 18, 24, 10);
				        ss.left = (s.baseLeft = (fo.baseLeft + 5 + sp[i - 1])) + 'px';
				        ss.top = (s.baseTop = (fo.baseTop + sp[i + 3])) + 'px';
				        ss.width = (s.baseWidth = (fo.offsetWidth + sp[i + 7])) + 'px';
				        ss.height = (s.baseHeight = (fo.offsetHeight + sp[i + 11])) + 2 + 'px';
				        var opacity = fo.baseOpacity * sp[i + 15] / 100;
				        s.baseOpacity = opacity;
				        ss.filter = 'alpha(opacity=' + opacity + ')';
				        ss.opacity = opacity / 100;
				    } fo.style.display = 'none';
				    fo.style.top = fo.baseTop + 'px';
				    fo.style.left = fo.baseLeft + 3 + 'px';
				    f.animate = f.snap;
				    f.openAnimated(0);
				},
				    openAnimated: function(p) {
				        with (this) {
				            if (p > 100) p = 100;
				            var t = animate(div, p);
				            if (p == 0) div.style.display = '';
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				                if (p == 0) s.style.display = '';
				            } if (p == 100) { finishAnimation(true); } else if (t) { window.setTimeout(this.obj + '.openAnimated(' + (p + 10) + ')', 10); }
				        }
				    },
				    removeFlyout: function() {
				        var f = this;
				        f.pfi.co = 0;
				        f.m.hideMO(f.pfi);
				        if (f.intr) return;
				        f.intr = true;
				        f.animate = f.snap;
				        f.closeAnimated(100);
				    },
				    closeAnimated: function(p) {
				        with (this) {
				            if (p < 0) p = 0;
				            var t = animate(div, p);
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				            } if (p == 0) { finishAnimation(false); } else if (t) { window.setTimeout(this.obj + '.closeAnimated(' + (p - 10) + ')', 10); }
				        }
				    },
				    finishAnimation: function(open) {
				        with (this) {
				            if (!open) {
				                div.style.display = 'none';
				                for (var i = 1; i <= 4; i++) {
				                    var s = shadows[i];
				                    s.style.display = 'none';
				                } div.scrollArea.scrollTop = 0;
				                div.upArrow.src = m.UP_ARROW_DISABLED;
				                div.downArrow.src = m.DOWN_ARROW;
				            } shown = open;
				            intr = false;
				            if (show && !shown) showFlyout();
				            if (!show && shown) removeFlyout();
				        }
				    },
				    snap: function(o, p) {
				        this.finishAnimation(p ? false : true);
				        return false;
				    },
				    dummy: null
				};
				
				XXIEHV0.link = function(m, foi, iti, first, cur, st, i) {
				    var o = this;
				    o.cfoid = st[i++];
				    o.iti = iti;
				    o.txt = st[i++];
				    o.title = st[i++];
				    o.ref = m.adjustPath(st[i++]);
				    o.targ = st[i++];
				    o.func = '';
				    o.params = '';
				    if (o.targ.substr(0, 3) == '_PL') {
				        o.func = st[i++];
				        o.params = st[i++];
				    } o.imgn = m.adjustPath(st[i++]);
				    o.imgo = m.adjustPath(st[i++]);
				    o.imgh = st[i++];
				    o.imgw = st[i++];
				    m.preload(o.imgo);
				    o.sel = false;
				    o.foid = foi;
				    o.ncolor = (o.sel ? cur.SelColor : cur.Color);
				    o.mocolor = cur.MOColor;
				    o.mdcolor = cur.MDColor;
				    o.selpcolor = cur.SelParColor;
				    o.brdcolor = (o.sel ? cur.BSelColor : cur.BColor);
				    o.bmocolor = cur.BMOColor;
				    o.bmdcolor = cur.BMDColor;
				    o.bselcolor = cur.BSelColor;
				    o.bselpcolor = cur.BSelParColor;
				    o.txtcolor = (o.sel ? cur.TSelColor : cur.TxtColor);
				    o.tmocolor = cur.TMOColor;
				    o.tmdcolor = cur.TMDColor;
				    o.tselpcolor = cur.TSelParColor;
				    var is = "";
				    is += "<li class=\"PLVFOLink\" style=\"float:left;width:" + (foi ? "auto" : "138px") + ";height:" + (foi ? 50 : 50) + "px;" + (!first ? "margin-top:2px;" : "") + "text-align:center;border:solid 1px " + o.brdcolor + ";" + (o.cfoid > 0 && m.SUB_ARROW ? "background:" + o.ncolor + " url(" + m.SUB_ARROW + ") no-repeat " + "right" + " 85%" : (o.ncolor ? "background-color:" + o.ncolor : "")) + ";cursor:" + (o.sel ? "default" : "pointer") + ";\" foi=\"" + foi + "\" iti=\"" + iti + "\">";
				    if (o.imgn || o.imgo) { is += "<img class=\"PLVFOIcon\" src=\"" + (o.imgn ? o.imgn : o.imgo) + "\" width=\"" + o.imgw + "px\" height=\"" + o.imgh + "px\" style=\"float:left;margin-top:" + (Math.floor(((foi ? 50 : 50) - o.imgh) / 2) - 1) + "px;" + (o.imgn ? "" : "visibility:hidden;") + "\">"; } is += '<a href=\"' + (o.ref != '' ? o.ref : '#') + '\" target=\"' + o.targ + '\"' + (o.title != '' ? 'title=\"' + o.title + '\"' : '') + ' style=\"text-decoration:' + ((foi ? m.FLYOUT_UNDERLINE : m.MAIN_UNDERLINE) ? 'underline' : 'none') + ';color:' + o.txtcolor + ';\">' + o.txt + '</a>';
				    is += "</li>";
				    o.html = is;
				    o.i = i;
				};
			var XXIEHV1 = { dummy: 0,
				    LAYER: false,
				    X: 0,
				    Y: 0,
				    VALIGN: 0,
				    IS_FLOATING: false,
				    CSS_PLACEMENT: 1,
				    ROLLOVER_HAS_BORDER: true,
				    SHOW_SELECTED: false,
				    STYLE: 2,
				    V_INTERVAL: 2,
				    MAIN_OPACITY: 100,
				    FLYOUT_OPACITY: 100,
				    OVERLAP: true,
				    Z_INDEX: 50,
				    PARENT_MO: true,
				    SHADOW_STYLE: 2,
				    OPEN_EVENT: 0,
				    OPEN_ANIMATION: 0,
				    CLOSE_ANIMATION: 0,
				    OPEN_SPEED: 10,
				    CLOSE_SPEED: 10,
				    SHOW_DELAY: 50,
				    AUTOCLOSE_DELAY: 150,
				    SEO_LINKS: 1,
				    TRANSFORM_PATHS: true,
				    BACKGROUND_COLOR: '#dedede',
				    SEPARATOR_COLOR: '#c0c0c0',
				    NORMAL_COLOR: '#dedede',
				    MOUSEOVER_COLOR: '#409db5',
				    MOUSEDOWN_COLOR: '#409db5',
				    SELECTED_COLOR: '#cdcdcd',
				    SELECTED_PARENT_COLOR: '',
				    NORMAL_BORDER_COLOR: '#c0c0c0',
				    MOUSEOVER_BORDER_COLOR: '',
				    MOUSEDOWN_BORDER_COLOR: '',
				    SELECTED_BORDER_COLOR: '',
				    SELECTED_PARENT_BORDER_COLOR: '',
				    TEXT_COLOR: '#409db5',
				    TEXT_MOUSEOVER_COLOR: '#ffffff',
				    TEXT_MOUSEDOWN_COLOR: '#FFFFFF',
				    TEXT_SELECTED_COLOR: '#409db5',
				    TEXT_SELECTED_PARENT_COLOR: '#409db5',
				    BORDER_COLOR: '',
				    FLYOUT_BORDER_COLOR: '',
				    CROSSFADE: 0,
				    ALIGN_MAIN_NORMAL: 0,
				    ALIGN_MAIN_HEADING: 0,
				    ALIGN_FO_NORMAL: 0,
				    ALIGN_FO_HEADING: 0,
				    RTL: false,
				    SUB_ARROW: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    SUB_ARROW_ROLLOVER: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    UP_ARROW: urlBase + "/blocks/menu_curso/img/up.gif",
				    UP_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/up_disabled.gif",
				    DOWN_ARROW: urlBase + "/blocks/menu_curso/img/down.gif",
				    DOWN_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/down_disabled.gif",
				    PREVIEW_BACKGROUND_COLOR: '#FFFFFF',
				    STREAM: [],
				    Browser: function() {
				        var ua = navigator.userAgent.toLowerCase();
				        this.opera = ua.indexOf('opera') >= 0;
				        this.safari = ua.indexOf('safari') >= 0;
				        this.ie = document.all && !this.opera;
				        this.macie = this.ie && ua.indexOf('mac') >= 0;
				        this.winie = this.ie && !this.macie;
				        this.ieCanvas = (this.ie && document.compatMode == "CSS1Compat") ? document.documentElement : document.body;
				        return this;
				    },
				    setPathAdjustment: function(id) {
				        var sl = '';
				        var sc = document.getElementsByTagName('script');
				        for (var i = 0; i < sc.length; i++) { if (sc[i].innerHTML.search(id) > -1) sl = sc[i].src; } this.SCRIPT_LOCATION = sl.substr(0, sl.lastIndexOf('/') + 1);
				    },
				    adjustPath: function(path) {
				        if (path.charAt(0) != '*') return path;
				        return this.SCRIPT_LOCATION + path.substr(1);
				    },
				    linkScripts: function(aNewScripts) {
				        var scripts = document.getElementsByTagName('script');
				        for (var i = 0; i < aNewScripts.length; i++) {
				            var bScriptLinked = false;
				            for (var j = 0; j < scripts.length; j++) { if (aNewScripts[i] == scripts[j].src) { bScriptLinked = true; break; } } if (!bScriptLinked) document.write("<script src='" + this.adjustPath(aNewScripts[i]) + "' type='text/javascript'><\/script>");
				        }
				    },
				    isCurrent: function(r) {
				        if (!r) return false;
				        var l = location.href;
				        if (r.search('//') == -1) {
				            if (r.charAt(0) == '/')
				                r = l.replace(/(.*\/\/[^\/]*).*/, '$1') + r;
				            else
				                r = l.replace(/[^\/]*$/, '') + r;
				        } do {
				            var r1 = r;
				            r = r1.replace(/[^\/]*\/\.\.\//, '');
				        } while (r != r1)
				        return r == l;
				    },
				    init: function(div,menu) {
				        var m = this;
				        //m.STREAM = strm;
				        //m.ID = PLVFOXXIEHV1;        
				        m.STREAM = menu;
				        m.ID = div;
				        m.br = new m.Browser();
				        m.setPathAdjustment('PLVFOMenu script ID:' + m.ID + ' ');
				        m.linkScripts(new Array());
				        m.addLoadEvent(m.onload);
				    },
				    onload: function() { XXIEHV1.start(); },
				    start: function() {
				        var m = this;
				        m.flyouts = new Array;
				        m.defaultFO = 0;
				        m.lastFoid = 0;
				        m.currentItem = null;
				        m.timeout = null;
				        m.interval = null;
				        m.scroll_start = 0;
				        m.scroll_time = 0;
				        m.scroll_delta = 0;
				        m.div = document.getElementById(this.ID + 'Div');
				        m.SUB_ARROW = m.adjustPath(m.SUB_ARROW);
				        m.SUB_ARROW_ROLLOVER = m.adjustPath(m.SUB_ARROW_ROLLOVER);
				        m.UP_ARROW = m.adjustPath(m.UP_ARROW);
				        m.UP_ARROW_DISABLED = m.adjustPath(m.UP_ARROW_DISABLED);
				        m.DOWN_ARROW = m.adjustPath(m.DOWN_ARROW);
				        m.DOWN_ARROW_DISABLED = m.adjustPath(m.DOWN_ARROW_DISABLED);
				        m.preload(m.SUB_ARROW_ROLLOVER);
				        m.preload(m.UP_ARROW);
				        m.preload(m.DOWN_ARROW_DISABLED);
				        m.flyouts[0] = new m.flyout(m, null, 0);
				        var i = 0, st = m.STREAM;
				        while (i < st.length) {
				            var index = st[i++];
				            var n = st[i++];
				            var cur = new Object;
				            i = m.readCurColors(cur, st, i);
				            var fo = m.flyouts[index].div;
				            if (!index) {
				                fo.onmouseover = m.onmouseover;
				                fo.onmouseout = m.onmouseout;
				            } var wraper;
				            var uss = "";
				            var dss = "";
				            if (fo.foid = index) {
				                fo.style.backgroundColor = cur.SecColor;
				                wraper = fo;
				                uss = this.getScroller(1, cur);
				                dss = this.getScroller(0, cur);
				            } else { wraper = m.div.getElementsByTagName('div')[0]; } var fos = "";
				            var ss = "";
				            var firstSection = 1;
				            var firstItem = 1;
				            for (var j = 0; j < n; j++) {
				                var type = st[i++];
				                if (type == 0) {
				                    var item = m.flyouts[index].links[j] = new m.link(m, index, j, firstItem, cur, st, i);
				                    ss += item.html;
				                    i = item.i;
				                    firstItem = 0;
				                } else if (type == 1) {
				                    var txt = st[i++];
				                    ss += "<li class=\"PLVFOHeading\" style=\"float:left;" + (index ? "" : "width:138px;") + "height:" + (index ? "32" : "32") + "px;" + (!firstItem ? "margin-top:2px;" : "") + "padding:" + (index ? "18" : "18") + "px 4px 0px 4px;\">" + txt + "</li>";
				                    firstItem = 0;
				                } else if (type == 2) {
				                    fos += m.wrapSection(ss, index, cur, firstSection);
				                    ss = "";
				                    i = m.readCurColors(cur, st, i);
				                    firstItem = 1;
				                    firstSection = 0;
				                }
				            } fos += m.wrapSection(ss, index, cur, firstSection);
				            if (index)
				                fos = uss + "<ul style=\"margin:0;padding:0;\">" + fos + "</ul>" + dss;
				            else
				                fos = "<ul style=\"float:left;margin:0 0 10px 0;padding:2px;background-color:#dedede;\">" + fos + "</ul>";
				            wraper.innerHTML = fos;
				            if (index) {
				                fo.upScrWrp = wraper.childNodes[0];
				                var upScr = fo.upScrWrp.getElementsByTagName("div")[0];
				                upScr.o = new Object;
				                fo.upArrow = fo.upScrWrp.getElementsByTagName("img")[0];
				                var scrollArea = wraper.childNodes[1];
				                fo.dwnScrWrp = wraper.childNodes[2];
				                var dwnScr = fo.dwnScrWrp.getElementsByTagName("div")[0];
				                dwnScr.o = new Object;
				                fo.downArrow = fo.dwnScrWrp.getElementsByTagName("img")[0];
				                var attr = new Array('ncolor', 'mocolor', 'brdcolor', 'bmocolor');
				                for (var a = 0; a < attr.length; a++) {
				                    eval('upScr.o.' + attr[a] + '=upScr.getAttribute("' + attr[a] + '")');
				                    eval('dwnScr.o.' + attr[a] + '=dwnScr.getAttribute("' + attr[a] + '")');
				                } dwnScr.foid = upScr.foid = index;
				            } var items = wraper.getElementsByTagName("li");
				            var w = 140;
				            for (var k = 0; k < items.length; k++) {
				                var e = items[k];
				                if ((e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') && e.offsetWidth > w) w = e.offsetWidth;
				                if (e.className == 'PLVFOLink') {
				                    e.o = m.flyouts[e.getAttribute("foi")].links[e.getAttribute("iti")];
				                    e.o.e = e;
				                    var attr = new Array('foid', 'cfoid', 'ref', 'targ', 'func', 'params', 'imgn', 'imgo', 'sel');
				                    for (var a = 0; a < attr.length; a++)
				                        eval('e.' + attr[a] + '=e.o.' + attr[a]);
				                    e.onmousedown = m.onmousedown;
				                    e.onmouseup = m.onmouseup;
				                    e.onclick = m.onclick;
				                    e.co = 0;
				                    if (e.className == 'PLVFOLink' && e.cfoid > 0) { m.flyouts[e.cfoid] = new m.flyout(m, e, e.cfoid); }
				                } if (e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') {
				                    if (e.className == 'PLVFOLink') {
				                        e.a = e.getElementsByTagName('a')[0];
				                        e.a.onfocus = function() { this.blur(); };
				                    } var imgs = e.getElementsByTagName('img');
				                    for (var j = 0; j < imgs.length; j++) {
				                        if (imgs[j].className == 'PLVFOIcon') e.img = imgs[j];
				                        if (imgs[j].className == 'PLVFOArrow') e.fo_arrow = imgs[j];
				                    }
				                }
				            } if (index) {
				                fo.style.width = w + 4 + 'px';
				                for (var k = 0; k < items.length; k++) {
				                    var e = items[k];
				                    e.style.width = w - (e.className == 'PLVFOLink' ? 2 : 8) + 'px';
				                } upScr.style.width = dwnScr.style.width = w - 2;
				                fo.scrollArea = scrollArea;
				                fo.style.zIndex = 50;
				                fo.style.display = 'none';
				            }
				        }
				    },
				    getScroller: function(up, cur) { return "<div style=\"padding:2px;\"><div class=\"PLVFO_" + (up ? "UP" : "DOWN") + "SCROLLER\" style=\"padding:2px 0px;text-align:center;border:solid 1px " + cur.BColor + ";" + (cur.Color ? "background-color:" + cur.Color + ";" : "") + "cursor:pointer;\" ncolor=\"" + cur.Color + "\" mocolor=\"" + cur.MOColor + "\" brdcolor=\"" + cur.BColor + "\" bmocolor=\"" + cur.BMOColor + "\"><img src=\"" + (up ? this.UP_ARROW_DISABLED : this.DOWN_ARROW) + "\"></div></div>"; },
				    wrapSection: function(s, index, cur, first) {
				        var ws = "";
				        if (!index) return s;
				        ws += "<li style=\"float:left;\"><ul style=\"float:left;" + (s == "" ? "height:0px;" : "") + "margin:0px;padding:" + (s == "" ? "0px " : "") + "2px;" + (s == "" ? "font-size:0px;" : "") + (cur.SecColor != "" ? "background-color:" + cur.SecColor + ";" : "") + (cur.sepColor != "" && !first ? "border-top:solid 1px " + cur.sepColor + ";" : "") + "\">" + s + "</ul></li>";
				        return ws;
				    },
				    readCurColors: function(cur, st, i) {
				        var bg = cur.SecColor = st[i++];
				        cur.sepColor = st[i];
				        cur.Color = st[++i];
				        cur.MOColor = st[++i];
				        cur.MDColor = st[++i];
				        cur.SelColor = st[++i];
				        cur.SelParColor = st[++i];
				        cur.BColor = st[++i] ? st[i] : bg;
				        cur.BMOColor = st[++i] ? st[i] : bg;
				        cur.BMDColor = st[++i] ? st[i] : bg;
				        cur.BSelColor = st[++i] ? st[i] : bg;
				        cur.BSelParColor = st[++i] ? st[i] : bg;
				        i++;
				        cur.TxtColor = st[i++];
				        cur.TMOColor = st[i++];
				        cur.TMDColor = st[i++];
				        cur.TSelColor = st[i++];
				        cur.TSelParColor = st[i++];
				        return i;
				    },
				    onmouseover: function(evt) {
				        var m = XXIEHV1;
				        var e = m.getSource(evt);
				        m.over(e);
				    },
				    over: function(e) {
				        var m = this;
				        m.lastFoid = e.foid;
				        if (e) {
				            window.clearTimeout(m.timeout);
				            if (e.cfoid) m.lastFoid = e.cfoid;
				            if (e.className == 'PLVFO_UPSCROLLER' || e.className == 'PLVFO_DOWNSCROLLER') {
				                m.showMO(e);
				                m.scroll_start = m.flyouts[e.foid].div.scrollArea.scrollTop;
				                m.scroll_time = m.getTime();
				                m.scroll_delta = e.className == 'PLVFO_UPSCROLLER' ? -0.15 : 0.15;
				                m.interval = window.setInterval('XXIEHV1.scroll(' + e.foid + ')', 35);
				            } else if (e.className == 'PLVFOLink') {
				                m.currentItem = e;
				                m.showMO(e);
				                m.timeout = window.setTimeout('XXIEHV1.updateFlyouts()', 50);
				            }
				        }
				    },
				    onmouseout: function(evt) {
				        var m = XXIEHV1;
				        var e = m.getSource(evt);
				        m.out(e);
				    },
				    out: function(e) {
				        var m = this;
				        m.lastFoid = 0;
				        if (e && ((e.className == 'PLVFO_UPSCROLLER') || (e.className == 'PLVFO_DOWNSCROLLER') || (e.className == 'PLVFOLink' && !e.co))) m.hideMO(e);
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.timeout = window.setTimeout('XXIEHV1.updateFlyouts()', 150);
				    },
				    onmousedown: function(evt) {
				        var m = XXIEHV1;
				        var e = m.getSource(evt);
				        e.style.borderColor = e.o.bmdcolor;
				        e.style.backgroundColor = e.o.mdcolor;
				        e.a.style.color = e.o.tmdcolor;
				    },
				    onmouseup: function(evt) {
				        var m = XXIEHV1;
				        var e = m.getSource(evt);
				        m.clicked(e);
				    },
				    clicked: function(e) {
				        var m = XXIEHV1;
				        m.showMO(e);
				        m.lastFoid = 0;
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.updateFlyouts();
				        if (e.func) eval(e.func + '("PLVFOMenu script ID:"+XXIEHV1.ID,"' + e.ref + '",' + e.params + ')');
				        else {
				            if (!e.ref) return;
				            if (e.targ) window.open(e.ref, e.targ);
				            else location = e.ref;
				        }
				    },
				    onclick: function(evt) { return false; },
				    showMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW_ROLLOVER + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.bmocolor;
				        e.style.backgroundColor = e.o.mocolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.tmocolor;
				            if (e.imgo) {
				                e.img.src = e.imgo;
				                e.img.style.visibility = '';
				            }
				        }
				    },
				    hideMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.brdcolor;
				        e.style.backgroundColor = e.o.ncolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.txtcolor;
				            if (e.imgn) e.img.src = e.imgn;
				            else if (e.imgo) e.img.style.visibility = 'hidden';
				        }
				    },
				    updateFlyouts: function() {
				        var m = this;
				        for (var i = 1; i < m.flyouts.length; i++) m.flyouts[i].show = false;
				        if (m.lastFoid == 0) m.lastFoid = m.defaultFO;
				        if (m.lastFoid > 0) {
				            var fo = m.flyouts[m.lastFoid];
				            while (fo.pfi) {
				                fo.show = true;
				                fo = m.flyouts[fo.pfi.foid];
				            }
				        } for (var i = 1; i < m.flyouts.length; i++) {
				            var foo = m.flyouts[i];
				            if (foo.index) {
				                if (foo.show && !foo.shown) foo.showFlyout(foo);
				                if (!foo.show && foo.shown) foo.removeFlyout();
				            }
				        }
				    },
				    scroll: function(foid) {
				        var m = this;
				        var offset = m.scroll_start + (m.getTime() - m.scroll_time) * m.scroll_delta;
				        var fo = m.flyouts[foid];
				        var fd = fo.div;
				        fd.scrollArea.scrollTop = offset;
				        fd.upArrow.src = offset <= 0 ? m.UP_ARROW_DISABLED : m.UP_ARROW;
				        fd.downArrow.src = offset >= fd.scrollArea.scrollHeight - fd.scrollArea.offsetHeight ? m.DOWN_ARROW_DISABLED : m.DOWN_ARROW;
				    },
				    getSource: function(evt) {
				        var e = this.br.ie ? event.srcElement : evt.target;
				        while (e && e.tagName != "DIV" && e.tagName != "LI")
				            e = e.parentNode;
				        return e;
				    },
				    getFoid: function(e) { while (e && (!e.foid)) { e = e.parentNode; } return e ? e.foid : 0; },
				    addLoadEvent: function(f) {
				        var done = 0;
				        function w() {
				            if (!done) {
				                done = 1;
				                f();
				            }
				        } if (document.addEventListener) { document.addEventListener('DOMContentLoaded', w, false); } if (this.br.ie && window == top) (function() {
				            try { document.documentElement.doScroll('left'); } catch (e) {
				                setTimeout(arguments.callee, 0);
				                return;
				            } w();
				        })();
				        var oldf = window.onload;
				        if (typeof oldf != 'function') { window.onload = w; } else { window.onload = function() { try { oldf(); } catch (e) { } w(); }; }
				    },
				    preload: function(img) {
				        if (!img) return;
				        if (!this.preloads) this.preloads = new Array;
				        var len = this.preloads.length;
				        var i = 0;
				        while (i < len) {
				            if (this.preloads[i].path == img) return;
				            i++;
				        } this.preloads[len] = new Object;
				        this.preloads[len].path = img;
				        this.preloads[len].img = new Image;
				        this.preloads[len].img.src = img;
				    },
				    getLeft: function(e, base) {
				        var m = this;
				        var left = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            left += e.offsetLeft;
				            e = e.offsetParent;
				            if (e && m.br.ie) {
				                var bw = parseInt(e.style.borderLeftWidth);
				                if (!bw) bw = 0;
				                left += bw;
				            }
				        } return left;
				    },
				    getTop: function(e, base) {
				        var m = this;
				        var top = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            top += e.offsetTop;
				            e = e.offsetParent;
				            if (e && !m.br.opera) {
				                var bw = parseInt(e.style.borderTopWidth);
				                if (!bw) bw = 0;
				                top += bw;
				            }
				        } return top;
				    },
				    getTime: function() {
				        var time = new Date();
				        return time.valueOf();
				    }
				};  
				
				XXIEHV1.flyout = function(m, parent, index) {
				    var f = this;
				    f.index = index;
				    if (index == 0) {
				        f.div = m.div;
				        f.shown = true;
				    } else {
				        f.div = document.createElement('div');
				        f.div.style.position = 'absolute';
				        f.div.baseOpacity = 100;
				        f.div.baseOpacity = f.horiz ? 100 : 100;
				        if (f.div.baseOpacity != 100) {
				            f.div.style.opacity = f.div.baseOpacity / 100;
				            f.div.style.filter = 'alpha(opacity=' + f.div.baseOpacity + ')';
				        } f.div.style.top = '-10000px';
				        m.div.appendChild(f.div);
				        f.shadows = new Array;
				        for (var s = 1; s <= 4; s++) {
				            f.shadows[s] = document.createElement('div');
				            m.div.appendChild(f.shadows[s]);
				        } f.pfi = parent;
				        f.show = false;
				        f.shown = false;
				        f.intr = false;
				    } f.links = new Array;
				    f.m = m;
				    f.div.obj = f;
				    f.obj = 'XXIEHV1.fo' + index;
				    eval(f.obj + '=f');
				};
				
				XXIEHV1.flyout.prototype = { showFlyout: function() {
				    var f = this;
				    var m = f.m;
				    var e = f.pfi;
				    var pfo = m.flyouts[e.foid];
				    var fo = f.div;
				    if (!fo) return;
				    e.co = 1;
				    if (f.intr) return;
				    f.intr = true;
				    fo.pfoid = e.foid;
				    fo.style.top = '-10000px';
				    fo.upScrWrp.style.display = 'none';
				    fo.dwnScrWrp.style.display = 'none';
				    fo.scrollArea.style.height = '';
				    fo.style.display = '';
				    var docTop = (m.br.ie ? m.br.ieCanvas.scrollTop : window.pageYOffset) - m.getTop(m.div, 2);
				    var docLeft = (m.br.ie ? m.br.ieCanvas.scrollLeft : window.pageXOffset) - m.getLeft(m.div, 2);
				    var docHeight = m.br.ie ? m.br.ieCanvas.clientHeight : window.innerHeight;
				    var docWidth = m.br.ie ? m.br.ieCanvas.offsetWidth : window.innerWidth;
				    var topLimit = docTop + 2;
				    var bottomLimit = docTop + docHeight - 6;
				    var foHeight = fo.offsetHeight;
				    if (m.br.winie) {
				        var avHeight = bottomLimit - topLimit;
				        if (foHeight > avHeight) foHeight = avHeight;
				        if (foHeight < fo.offsetHeight) {
				            fo.upScrWrp.style.display = '';
				            fo.dwnScrWrp.style.display = '';
				            fo.scrollArea.style.overflow = 'hidden';
				            var SAHeight = foHeight - fo.upScrWrp.offsetHeight - fo.dwnScrWrp.offsetHeight;
				            if (SAHeight < 0) SAHeight = 0;
				            fo.scrollArea.style.height = SAHeight + 'px';
				        }
				    } fo.baseHeight = foHeight;
				    fo.baseWidth = fo.offsetWidth;
				    fo.baseTop = m.getTop(e, 0) - 2;
				    if (e.foid > 0 && m.br.ie) fo.baseTop -= pfo.div.scrollArea.scrollTop;
				    fo.baseLeft = m.getLeft(e, 0) + parseInt(e.offsetWidth) - 3;
				    if (fo.baseTop < topLimit) fo.baseTop = topLimit;
				    if (foHeight + fo.baseTop > bottomLimit) {
				        var t = bottomLimit - foHeight;
				        fo.baseTop = t < topLimit ? topLimit : t;
				    } if (fo.baseLeft + fo.offsetWidth + 22 - docLeft > docWidth) fo.baseLeft = (e.foid == 0 ? docWidth - 22 + docLeft : m.flyouts[e.foid].div.baseLeft + 1) - fo.offsetWidth;
				    for (var i = 1; i <= 4; i++) {
				        var s = f.shadows[i];
				        var ss = s.style;
				        ss.display = 'none';
				        ss.position = 'absolute';
				        ss.backgroundColor = '#000000';
				        ss.zIndex = 50 - i;
				        var sp = new Array(-3, -2, -1, -3, 3, 2, 1, 4, 6, 4, 2, 6, -2, 0, 2, 0, 12, 18, 24, 10);
				        ss.left = (s.baseLeft = (fo.baseLeft + 5 + sp[i - 1])) + 'px';
				        ss.top = (s.baseTop = (fo.baseTop + sp[i + 3])) + 'px';
				        ss.width = (s.baseWidth = (fo.offsetWidth + sp[i + 7])) + 'px';
				        ss.height = (s.baseHeight = (fo.offsetHeight + sp[i + 11])) + 2 + 'px';
				        var opacity = fo.baseOpacity * sp[i + 15] / 100;
				        s.baseOpacity = opacity;
				        ss.filter = 'alpha(opacity=' + opacity + ')';
				        ss.opacity = opacity / 100;
				    } fo.style.display = 'none';
				    fo.style.top = fo.baseTop + 'px';
				    fo.style.left = fo.baseLeft + 3 + 'px';
				    f.animate = f.snap;
				    f.openAnimated(0);
				},
				    openAnimated: function(p) {
				        with (this) {
				            if (p > 100) p = 100;
				            var t = animate(div, p);
				            if (p == 0) div.style.display = '';
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				                if (p == 0) s.style.display = '';
				            } if (p == 100) { finishAnimation(true); } else if (t) { window.setTimeout(this.obj + '.openAnimated(' + (p + 10) + ')', 10); }
				        }
				    },
				    removeFlyout: function() {
				        var f = this;
				        f.pfi.co = 0;
				        f.m.hideMO(f.pfi);
				        if (f.intr) return;
				        f.intr = true;
				        f.animate = f.snap;
				        f.closeAnimated(100);
				    },
				    closeAnimated: function(p) {
				        with (this) {
				            if (p < 0) p = 0;
				            var t = animate(div, p);
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				            } if (p == 0) { finishAnimation(false); } else if (t) { window.setTimeout(this.obj + '.closeAnimated(' + (p - 10) + ')', 10); }
				        }
				    },
				    finishAnimation: function(open) {
				        with (this) {
				            if (!open) {
				                div.style.display = 'none';
				                for (var i = 1; i <= 4; i++) {
				                    var s = shadows[i];
				                    s.style.display = 'none';
				                } div.scrollArea.scrollTop = 0;
				                div.upArrow.src = m.UP_ARROW_DISABLED;
				                div.downArrow.src = m.DOWN_ARROW;
				            } shown = open;
				            intr = false;
				            if (show && !shown) showFlyout();
				            if (!show && shown) removeFlyout();
				        }
				    },
				    snap: function(o, p) {
				        this.finishAnimation(p ? false : true);
				        return false;
				    },
				    dummy: null
				};
				
				XXIEHV1.link = function(m, foi, iti, first, cur, st, i) {
				    var o = this;
				    o.cfoid = st[i++];
				    o.iti = iti;
				    o.txt = st[i++];
				    o.title = st[i++];
				    o.ref = m.adjustPath(st[i++]);
				    o.targ = st[i++];
				    o.func = '';
				    o.params = '';
				    if (o.targ.substr(0, 3) == '_PL') {
				        o.func = st[i++];
				        o.params = st[i++];
				    } o.imgn = m.adjustPath(st[i++]);
				    o.imgo = m.adjustPath(st[i++]);
				    o.imgh = st[i++];
				    o.imgw = st[i++];
				    m.preload(o.imgo);
				    o.sel = false;
				    o.foid = foi;
				    o.ncolor = (o.sel ? cur.SelColor : cur.Color);
				    o.mocolor = cur.MOColor;
				    o.mdcolor = cur.MDColor;
				    o.selpcolor = cur.SelParColor;
				    o.brdcolor = (o.sel ? cur.BSelColor : cur.BColor);
				    o.bmocolor = cur.BMOColor;
				    o.bmdcolor = cur.BMDColor;
				    o.bselcolor = cur.BSelColor;
				    o.bselpcolor = cur.BSelParColor;
				    o.txtcolor = (o.sel ? cur.TSelColor : cur.TxtColor);
				    o.tmocolor = cur.TMOColor;
				    o.tmdcolor = cur.TMDColor;
				    o.tselpcolor = cur.TSelParColor;
				    var is = "";
				    is += "<li class=\"PLVFOLink\" style=\"float:left;width:" + (foi ? "auto" : "138px") + ";height:" + (foi ? 50 : 50) + "px;" + (!first ? "margin-top:2px;" : "") + "text-align:center;border:solid 1px " + o.brdcolor + ";" + (o.cfoid > 0 && m.SUB_ARROW ? "background:" + o.ncolor + " url(" + m.SUB_ARROW + ") no-repeat " + "right" + " 85%" : (o.ncolor ? "background-color:" + o.ncolor : "")) + ";cursor:" + (o.sel ? "default" : "pointer") + ";\" foi=\"" + foi + "\" iti=\"" + iti + "\">";
				    if (o.imgn || o.imgo) { is += "<img class=\"PLVFOIcon\" src=\"" + (o.imgn ? o.imgn : o.imgo) + "\" width=\"" + o.imgw + "px\" height=\"" + o.imgh + "px\" style=\"float:left;margin-top:" + (Math.floor(((foi ? 50 : 50) - o.imgh) / 2) - 1) + "px;" + (o.imgn ? "" : "visibility:hidden;") + "\">"; } is += '<a href=\"' + (o.ref != '' ? o.ref : '#') + '\" target=\"' + o.targ + '\"' + (o.title != '' ? 'title=\"' + o.title + '\"' : '') + ' style=\"text-decoration:' + ((foi ? m.FLYOUT_UNDERLINE : m.MAIN_UNDERLINE) ? 'underline' : 'none') + ';color:' + o.txtcolor + ';\">' + o.txt + '</a>';
				    is += "</li>";
				    o.html = is;
				    o.i = i;
				};
			var XXIEHV2 = { dummy: 0,
				    LAYER: false,
				    X: 0,
				    Y: 0,
				    VALIGN: 0,
				    IS_FLOATING: false,
				    CSS_PLACEMENT: 1,
				    ROLLOVER_HAS_BORDER: true,
				    SHOW_SELECTED: false,
				    STYLE: 2,
				    V_INTERVAL: 2,
				    MAIN_OPACITY: 100,
				    FLYOUT_OPACITY: 100,
				    OVERLAP: true,
				    Z_INDEX: 50,
				    PARENT_MO: true,
				    SHADOW_STYLE: 2,
				    OPEN_EVENT: 0,
				    OPEN_ANIMATION: 0,
				    CLOSE_ANIMATION: 0,
				    OPEN_SPEED: 10,
				    CLOSE_SPEED: 10,
				    SHOW_DELAY: 50,
				    AUTOCLOSE_DELAY: 150,
				    SEO_LINKS: 1,
				    TRANSFORM_PATHS: true,
				    BACKGROUND_COLOR: '#dedede',
				    SEPARATOR_COLOR: '#c0c0c0',
				    NORMAL_COLOR: '#dedede',
				    MOUSEOVER_COLOR: '#409db5',
				    MOUSEDOWN_COLOR: '#409db5',
				    SELECTED_COLOR: '#cdcdcd',
				    SELECTED_PARENT_COLOR: '',
				    NORMAL_BORDER_COLOR: '#c0c0c0',
				    MOUSEOVER_BORDER_COLOR: '',
				    MOUSEDOWN_BORDER_COLOR: '',
				    SELECTED_BORDER_COLOR: '',
				    SELECTED_PARENT_BORDER_COLOR: '',
				    TEXT_COLOR: '#409db5',
				    TEXT_MOUSEOVER_COLOR: '#ffffff',
				    TEXT_MOUSEDOWN_COLOR: '#FFFFFF',
				    TEXT_SELECTED_COLOR: '#409db5',
				    TEXT_SELECTED_PARENT_COLOR: '#409db5',
				    BORDER_COLOR: '',
				    FLYOUT_BORDER_COLOR: '',
				    CROSSFADE: 0,
				    ALIGN_MAIN_NORMAL: 0,
				    ALIGN_MAIN_HEADING: 0,
				    ALIGN_FO_NORMAL: 0,
				    ALIGN_FO_HEADING: 0,
				    RTL: false,
				    SUB_ARROW: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    SUB_ARROW_ROLLOVER: urlBase + "/blocks/menu_curso/img/fo_arrow.gif",
				    UP_ARROW: urlBase + "/blocks/menu_curso/img/up.gif",
				    UP_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/up_disabled.gif",
				    DOWN_ARROW: urlBase + "/blocks/menu_curso/img/down.gif",
				    DOWN_ARROW_DISABLED: urlBase + "/blocks/menu_curso/img/down_disabled.gif",
				    PREVIEW_BACKGROUND_COLOR: '#FFFFFF',
				    STREAM: [],
				    Browser: function() {
				        var ua = navigator.userAgent.toLowerCase();
				        this.opera = ua.indexOf('opera') >= 0;
				        this.safari = ua.indexOf('safari') >= 0;
				        this.ie = document.all && !this.opera;
				        this.macie = this.ie && ua.indexOf('mac') >= 0;
				        this.winie = this.ie && !this.macie;
				        this.ieCanvas = (this.ie && document.compatMode == "CSS1Compat") ? document.documentElement : document.body;
				        return this;
				    },
				    setPathAdjustment: function(id) {
				        var sl = '';
				        var sc = document.getElementsByTagName('script');
				        for (var i = 0; i < sc.length; i++) { if (sc[i].innerHTML.search(id) > -1) sl = sc[i].src; } this.SCRIPT_LOCATION = sl.substr(0, sl.lastIndexOf('/') + 1);
				    },
				    adjustPath: function(path) {
				        if (path.charAt(0) != '*') return path;
				        return this.SCRIPT_LOCATION + path.substr(1);
				    },
				    linkScripts: function(aNewScripts) {
				        var scripts = document.getElementsByTagName('script');
				        for (var i = 0; i < aNewScripts.length; i++) {
				            var bScriptLinked = false;
				            for (var j = 0; j < scripts.length; j++) { if (aNewScripts[i] == scripts[j].src) { bScriptLinked = true; break; } } if (!bScriptLinked) document.write("<script src='" + this.adjustPath(aNewScripts[i]) + "' type='text/javascript'><\/script>");
				        }
				    },
				    isCurrent: function(r) {
				        if (!r) return false;
				        var l = location.href;
				        if (r.search('//') == -1) {
				            if (r.charAt(0) == '/')
				                r = l.replace(/(.*\/\/[^\/]*).*/, '$1') + r;
				            else
				                r = l.replace(/[^\/]*$/, '') + r;
				        } do {
				            var r1 = r;
				            r = r1.replace(/[^\/]*\/\.\.\//, '');
				        } while (r != r1)
				        return r == l;
				    },
				    init: function(div,menu) {
				        var m = this;
				        //m.STREAM = strm;
				        //m.ID = PLVFOXXIEHV2;        
				        m.STREAM = menu;
				        m.ID = div;
				        m.br = new m.Browser();
				        m.setPathAdjustment('PLVFOMenu script ID:' + m.ID + ' ');
				        m.linkScripts(new Array());
				        m.addLoadEvent(m.onload);
				    },
				    onload: function() { XXIEHV2.start(); },
				    start: function() {
				        var m = this;
				        m.flyouts = new Array;
				        m.defaultFO = 0;
				        m.lastFoid = 0;
				        m.currentItem = null;
				        m.timeout = null;
				        m.interval = null;
				        m.scroll_start = 0;
				        m.scroll_time = 0;
				        m.scroll_delta = 0;
				        m.div = document.getElementById(this.ID + 'Div');
				        m.SUB_ARROW = m.adjustPath(m.SUB_ARROW);
				        m.SUB_ARROW_ROLLOVER = m.adjustPath(m.SUB_ARROW_ROLLOVER);
				        m.UP_ARROW = m.adjustPath(m.UP_ARROW);
				        m.UP_ARROW_DISABLED = m.adjustPath(m.UP_ARROW_DISABLED);
				        m.DOWN_ARROW = m.adjustPath(m.DOWN_ARROW);
				        m.DOWN_ARROW_DISABLED = m.adjustPath(m.DOWN_ARROW_DISABLED);
				        m.preload(m.SUB_ARROW_ROLLOVER);
				        m.preload(m.UP_ARROW);
				        m.preload(m.DOWN_ARROW_DISABLED);
				        m.flyouts[0] = new m.flyout(m, null, 0);
				        var i = 0, st = m.STREAM;
				        while (i < st.length) {
				            var index = st[i++];
				            var n = st[i++];
				            var cur = new Object;
				            i = m.readCurColors(cur, st, i);
				            var fo = m.flyouts[index].div;
				            if (!index) {
				                fo.onmouseover = m.onmouseover;
				                fo.onmouseout = m.onmouseout;
				            } var wraper;
				            var uss = "";
				            var dss = "";
				            if (fo.foid = index) {
				                fo.style.backgroundColor = cur.SecColor;
				                wraper = fo;
				                uss = this.getScroller(1, cur);
				                dss = this.getScroller(0, cur);
				            } else { wraper = m.div.getElementsByTagName('div')[0]; } var fos = "";
				            var ss = "";
				            var firstSection = 1;
				            var firstItem = 1;
				            for (var j = 0; j < n; j++) {
				                var type = st[i++];
				                if (type == 0) {
				                    var item = m.flyouts[index].links[j] = new m.link(m, index, j, firstItem, cur, st, i);
				                    ss += item.html;
				                    i = item.i;
				                    firstItem = 0;
				                } else if (type == 1) {
				                    var txt = st[i++];
				                    ss += "<li class=\"PLVFOHeading\" style=\"float:left;" + (index ? "" : "width:138px;") + "height:" + (index ? "32" : "32") + "px;" + (!firstItem ? "margin-top:2px;" : "") + "padding:" + (index ? "18" : "18") + "px 4px 0px 4px;\">" + txt + "</li>";
				                    firstItem = 0;
				                } else if (type == 2) {
				                    fos += m.wrapSection(ss, index, cur, firstSection);
				                    ss = "";
				                    i = m.readCurColors(cur, st, i);
				                    firstItem = 1;
				                    firstSection = 0;
				                }
				            } fos += m.wrapSection(ss, index, cur, firstSection);
				            if (index)
				                fos = uss + "<ul style=\"margin:0;padding:0;\">" + fos + "</ul>" + dss;
				            else
				                fos = "<ul style=\"float:left;margin:0 0 10px 0;padding:2px;background-color:#dedede;\">" + fos + "</ul>";
				            wraper.innerHTML = fos;
				            if (index) {
				                fo.upScrWrp = wraper.childNodes[0];
				                var upScr = fo.upScrWrp.getElementsByTagName("div")[0];
				                upScr.o = new Object;
				                fo.upArrow = fo.upScrWrp.getElementsByTagName("img")[0];
				                var scrollArea = wraper.childNodes[1];
				                fo.dwnScrWrp = wraper.childNodes[2];
				                var dwnScr = fo.dwnScrWrp.getElementsByTagName("div")[0];
				                dwnScr.o = new Object;
				                fo.downArrow = fo.dwnScrWrp.getElementsByTagName("img")[0];
				                var attr = new Array('ncolor', 'mocolor', 'brdcolor', 'bmocolor');
				                for (var a = 0; a < attr.length; a++) {
				                    eval('upScr.o.' + attr[a] + '=upScr.getAttribute("' + attr[a] + '")');
				                    eval('dwnScr.o.' + attr[a] + '=dwnScr.getAttribute("' + attr[a] + '")');
				                } dwnScr.foid = upScr.foid = index;
				            } var items = wraper.getElementsByTagName("li");
				            var w = 140;
				            for (var k = 0; k < items.length; k++) {
				                var e = items[k];
				                if ((e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') && e.offsetWidth > w) w = e.offsetWidth;
				                if (e.className == 'PLVFOLink') {
				                    e.o = m.flyouts[e.getAttribute("foi")].links[e.getAttribute("iti")];
				                    e.o.e = e;
				                    var attr = new Array('foid', 'cfoid', 'ref', 'targ', 'func', 'params', 'imgn', 'imgo', 'sel');
				                    for (var a = 0; a < attr.length; a++)
				                        eval('e.' + attr[a] + '=e.o.' + attr[a]);
				                    e.onmousedown = m.onmousedown;
				                    e.onmouseup = m.onmouseup;
				                    e.onclick = m.onclick;
				                    e.co = 0;
				                    if (e.className == 'PLVFOLink' && e.cfoid > 0) { m.flyouts[e.cfoid] = new m.flyout(m, e, e.cfoid); }
				                } if (e.className == 'PLVFOLink' || e.className == 'PLVFOHeading') {
				                    if (e.className == 'PLVFOLink') {
				                        e.a = e.getElementsByTagName('a')[0];
				                        e.a.onfocus = function() { this.blur(); };
				                    } var imgs = e.getElementsByTagName('img');
				                    for (var j = 0; j < imgs.length; j++) {
				                        if (imgs[j].className == 'PLVFOIcon') e.img = imgs[j];
				                        if (imgs[j].className == 'PLVFOArrow') e.fo_arrow = imgs[j];
				                    }
				                }
				            } if (index) {
				                fo.style.width = w + 4 + 'px';
				                for (var k = 0; k < items.length; k++) {
				                    var e = items[k];
				                    e.style.width = w - (e.className == 'PLVFOLink' ? 2 : 8) + 'px';
				                } upScr.style.width = dwnScr.style.width = w - 2;
				                fo.scrollArea = scrollArea;
				                fo.style.zIndex = 50;
				                fo.style.display = 'none';
				            }
				        }
				    },
				    getScroller: function(up, cur) { return "<div style=\"padding:2px;\"><div class=\"PLVFO_" + (up ? "UP" : "DOWN") + "SCROLLER\" style=\"padding:2px 0px;text-align:center;border:solid 1px " + cur.BColor + ";" + (cur.Color ? "background-color:" + cur.Color + ";" : "") + "cursor:pointer;\" ncolor=\"" + cur.Color + "\" mocolor=\"" + cur.MOColor + "\" brdcolor=\"" + cur.BColor + "\" bmocolor=\"" + cur.BMOColor + "\"><img src=\"" + (up ? this.UP_ARROW_DISABLED : this.DOWN_ARROW) + "\"></div></div>"; },
				    wrapSection: function(s, index, cur, first) {
				        var ws = "";
				        if (!index) return s;
				        ws += "<li style=\"float:left;\"><ul style=\"float:left;" + (s == "" ? "height:0px;" : "") + "margin:0px;padding:" + (s == "" ? "0px " : "") + "2px;" + (s == "" ? "font-size:0px;" : "") + (cur.SecColor != "" ? "background-color:" + cur.SecColor + ";" : "") + (cur.sepColor != "" && !first ? "border-top:solid 1px " + cur.sepColor + ";" : "") + "\">" + s + "</ul></li>";
				        return ws;
				    },
				    readCurColors: function(cur, st, i) {
				        var bg = cur.SecColor = st[i++];
				        cur.sepColor = st[i];
				        cur.Color = st[++i];
				        cur.MOColor = st[++i];
				        cur.MDColor = st[++i];
				        cur.SelColor = st[++i];
				        cur.SelParColor = st[++i];
				        cur.BColor = st[++i] ? st[i] : bg;
				        cur.BMOColor = st[++i] ? st[i] : bg;
				        cur.BMDColor = st[++i] ? st[i] : bg;
				        cur.BSelColor = st[++i] ? st[i] : bg;
				        cur.BSelParColor = st[++i] ? st[i] : bg;
				        i++;
				        cur.TxtColor = st[i++];
				        cur.TMOColor = st[i++];
				        cur.TMDColor = st[i++];
				        cur.TSelColor = st[i++];
				        cur.TSelParColor = st[i++];
				        return i;
				    },
				    onmouseover: function(evt) {
				        var m = XXIEHV2;
				        var e = m.getSource(evt);
				        m.over(e);
				    },
				    over: function(e) {
				        var m = this;
				        m.lastFoid = e.foid;
				        if (e) {
				            window.clearTimeout(m.timeout);
				            if (e.cfoid) m.lastFoid = e.cfoid;
				            if (e.className == 'PLVFO_UPSCROLLER' || e.className == 'PLVFO_DOWNSCROLLER') {
				                m.showMO(e);
				                m.scroll_start = m.flyouts[e.foid].div.scrollArea.scrollTop;
				                m.scroll_time = m.getTime();
				                m.scroll_delta = e.className == 'PLVFO_UPSCROLLER' ? -0.15 : 0.15;
				                m.interval = window.setInterval('XXIEHV2.scroll(' + e.foid + ')', 35);
				            } else if (e.className == 'PLVFOLink') {
				                m.currentItem = e;
				                m.showMO(e);
				                m.timeout = window.setTimeout('XXIEHV2.updateFlyouts()', 50);
				            }
				        }
				    },
				    onmouseout: function(evt) {
				        var m = XXIEHV2;
				        var e = m.getSource(evt);
				        m.out(e);
				    },
				    out: function(e) {
				        var m = this;
				        m.lastFoid = 0;
				        if (e && ((e.className == 'PLVFO_UPSCROLLER') || (e.className == 'PLVFO_DOWNSCROLLER') || (e.className == 'PLVFOLink' && !e.co))) m.hideMO(e);
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.timeout = window.setTimeout('XXIEHV2.updateFlyouts()', 150);
				    },
				    onmousedown: function(evt) {
				        var m = XXIEHV2;
				        var e = m.getSource(evt);
				        e.style.borderColor = e.o.bmdcolor;
				        e.style.backgroundColor = e.o.mdcolor;
				        e.a.style.color = e.o.tmdcolor;
				    },
				    onmouseup: function(evt) {
				        var m = XXIEHV2;
				        var e = m.getSource(evt);
				        m.clicked(e);
				    },
				    clicked: function(e) {
				        var m = XXIEHV2;
				        m.showMO(e);
				        m.lastFoid = 0;
				        window.clearInterval(m.interval);
				        window.clearTimeout(m.timeout);
				        m.updateFlyouts();
				        if (e.func) eval(e.func + '("PLVFOMenu script ID:"+XXIEHV2.ID,"' + e.ref + '",' + e.params + ')');
				        else {
				            if (!e.ref) return;
				            if (e.targ) window.open(e.ref, e.targ);
				            else location = e.ref;
				        }
				    },
				    onclick: function(evt) { return false; },
				    showMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW_ROLLOVER + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.bmocolor;
				        e.style.backgroundColor = e.o.mocolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.tmocolor;
				            if (e.imgo) {
				                e.img.src = e.imgo;
				                e.img.style.visibility = '';
				            }
				        }
				    },
				    hideMO: function(e) {
				        if (e.cfoid)
				            e.style.backgroundImage = "url(" + this.SUB_ARROW + ")";
				        if (e.sel) return;
				        e.style.borderColor = e.o.brdcolor;
				        e.style.backgroundColor = e.o.ncolor;
				        if (e.className == 'PLVFOLink') {
				            e.a.style.color = e.o.txtcolor;
				            if (e.imgn) e.img.src = e.imgn;
				            else if (e.imgo) e.img.style.visibility = 'hidden';
				        }
				    },
				    updateFlyouts: function() {
				        var m = this;
				        for (var i = 1; i < m.flyouts.length; i++) m.flyouts[i].show = false;
				        if (m.lastFoid == 0) m.lastFoid = m.defaultFO;
				        if (m.lastFoid > 0) {
				            var fo = m.flyouts[m.lastFoid];
				            while (fo.pfi) {
				                fo.show = true;
				                fo = m.flyouts[fo.pfi.foid];
				            }
				        } for (var i = 1; i < m.flyouts.length; i++) {
				            var foo = m.flyouts[i];
				            if (foo.index) {
				                if (foo.show && !foo.shown) foo.showFlyout(foo);
				                if (!foo.show && foo.shown) foo.removeFlyout();
				            }
				        }
				    },
				    scroll: function(foid) {
				        var m = this;
				        var offset = m.scroll_start + (m.getTime() - m.scroll_time) * m.scroll_delta;
				        var fo = m.flyouts[foid];
				        var fd = fo.div;
				        fd.scrollArea.scrollTop = offset;
				        fd.upArrow.src = offset <= 0 ? m.UP_ARROW_DISABLED : m.UP_ARROW;
				        fd.downArrow.src = offset >= fd.scrollArea.scrollHeight - fd.scrollArea.offsetHeight ? m.DOWN_ARROW_DISABLED : m.DOWN_ARROW;
				    },
				    getSource: function(evt) {
				        var e = this.br.ie ? event.srcElement : evt.target;
				        while (e && e.tagName != "DIV" && e.tagName != "LI")
				            e = e.parentNode;
				        return e;
				    },
				    getFoid: function(e) { while (e && (!e.foid)) { e = e.parentNode; } return e ? e.foid : 0; },
				    addLoadEvent: function(f) {
				        var done = 0;
				        function w() {
				            if (!done) {
				                done = 1;
				                f();
				            }
				        } if (document.addEventListener) { document.addEventListener('DOMContentLoaded', w, false); } if (this.br.ie && window == top) (function() {
				            try { document.documentElement.doScroll('left'); } catch (e) {
				                setTimeout(arguments.callee, 0);
				                return;
				            } w();
				        })();
				        var oldf = window.onload;
				        if (typeof oldf != 'function') { window.onload = w; } else { window.onload = function() { try { oldf(); } catch (e) { } w(); }; }
				    },
				    preload: function(img) {
				        if (!img) return;
				        if (!this.preloads) this.preloads = new Array;
				        var len = this.preloads.length;
				        var i = 0;
				        while (i < len) {
				            if (this.preloads[i].path == img) return;
				            i++;
				        } this.preloads[len] = new Object;
				        this.preloads[len].path = img;
				        this.preloads[len].img = new Image;
				        this.preloads[len].img.src = img;
				    },
				    getLeft: function(e, base) {
				        var m = this;
				        var left = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            left += e.offsetLeft;
				            e = e.offsetParent;
				            if (e && m.br.ie) {
				                var bw = parseInt(e.style.borderLeftWidth);
				                if (!bw) bw = 0;
				                left += bw;
				            }
				        } return left;
				    },
				    getTop: function(e, base) {
				        var m = this;
				        var top = 0;
				        while (e && ((base == 0 && e != m.div) || (base == 1 && ((e.style.position != 'absolute' && e.style.position != 'relative') || e == m.div)) || (base == 2))) {
				            top += e.offsetTop;
				            e = e.offsetParent;
				            if (e && !m.br.opera) {
				                var bw = parseInt(e.style.borderTopWidth);
				                if (!bw) bw = 0;
				                top += bw;
				            }
				        } return top;
				    },
				    getTime: function() {
				        var time = new Date();
				        return time.valueOf();
				    }
				};  
				
				XXIEHV2.flyout = function(m, parent, index) {
				    var f = this;
				    f.index = index;
				    if (index == 0) {
				        f.div = m.div;
				        f.shown = true;
				    } else {
				        f.div = document.createElement('div');
				        f.div.style.position = 'absolute';
				        f.div.baseOpacity = 100;
				        f.div.baseOpacity = f.horiz ? 100 : 100;
				        if (f.div.baseOpacity != 100) {
				            f.div.style.opacity = f.div.baseOpacity / 100;
				            f.div.style.filter = 'alpha(opacity=' + f.div.baseOpacity + ')';
				        } f.div.style.top = '-10000px';
				        m.div.appendChild(f.div);
				        f.shadows = new Array;
				        for (var s = 1; s <= 4; s++) {
				            f.shadows[s] = document.createElement('div');
				            m.div.appendChild(f.shadows[s]);
				        } f.pfi = parent;
				        f.show = false;
				        f.shown = false;
				        f.intr = false;
				    } f.links = new Array;
				    f.m = m;
				    f.div.obj = f;
				    f.obj = 'XXIEHV2.fo' + index;
				    eval(f.obj + '=f');
				};
				
				XXIEHV2.flyout.prototype = { showFlyout: function() {
				    var f = this;
				    var m = f.m;
				    var e = f.pfi;
				    var pfo = m.flyouts[e.foid];
				    var fo = f.div;
				    if (!fo) return;
				    e.co = 1;
				    if (f.intr) return;
				    f.intr = true;
				    fo.pfoid = e.foid;
				    fo.style.top = '-10000px';
				    fo.upScrWrp.style.display = 'none';
				    fo.dwnScrWrp.style.display = 'none';
				    fo.scrollArea.style.height = '';
				    fo.style.display = '';
				    var docTop = (m.br.ie ? m.br.ieCanvas.scrollTop : window.pageYOffset) - m.getTop(m.div, 2);
				    var docLeft = (m.br.ie ? m.br.ieCanvas.scrollLeft : window.pageXOffset) - m.getLeft(m.div, 2);
				    var docHeight = m.br.ie ? m.br.ieCanvas.clientHeight : window.innerHeight;
				    var docWidth = m.br.ie ? m.br.ieCanvas.offsetWidth : window.innerWidth;
				    var topLimit = docTop + 2;
				    var bottomLimit = docTop + docHeight - 6;
				    var foHeight = fo.offsetHeight;
				    if (m.br.winie) {
				        var avHeight = bottomLimit - topLimit;
				        if (foHeight > avHeight) foHeight = avHeight;
				        if (foHeight < fo.offsetHeight) {
				            fo.upScrWrp.style.display = '';
				            fo.dwnScrWrp.style.display = '';
				            fo.scrollArea.style.overflow = 'hidden';
				            var SAHeight = foHeight - fo.upScrWrp.offsetHeight - fo.dwnScrWrp.offsetHeight;
				            if (SAHeight < 0) SAHeight = 0;
				            fo.scrollArea.style.height = SAHeight + 'px';
				        }
				    } fo.baseHeight = foHeight;
				    fo.baseWidth = fo.offsetWidth;
				    fo.baseTop = m.getTop(e, 0) - 2;
				    if (e.foid > 0 && m.br.ie) fo.baseTop -= pfo.div.scrollArea.scrollTop;
				    fo.baseLeft = m.getLeft(e, 0) + parseInt(e.offsetWidth) - 3;
				    if (fo.baseTop < topLimit) fo.baseTop = topLimit;
				    if (foHeight + fo.baseTop > bottomLimit) {
				        var t = bottomLimit - foHeight;
				        fo.baseTop = t < topLimit ? topLimit : t;
				    } if (fo.baseLeft + fo.offsetWidth + 22 - docLeft > docWidth) fo.baseLeft = (e.foid == 0 ? docWidth - 22 + docLeft : m.flyouts[e.foid].div.baseLeft + 1) - fo.offsetWidth;
				    for (var i = 1; i <= 4; i++) {
				        var s = f.shadows[i];
				        var ss = s.style;
				        ss.display = 'none';
				        ss.position = 'absolute';
				        ss.backgroundColor = '#000000';
				        ss.zIndex = 50 - i;
				        var sp = new Array(-3, -2, -1, -3, 3, 2, 1, 4, 6, 4, 2, 6, -2, 0, 2, 0, 12, 18, 24, 10);
				        ss.left = (s.baseLeft = (fo.baseLeft + 5 + sp[i - 1])) + 'px';
				        ss.top = (s.baseTop = (fo.baseTop + sp[i + 3])) + 'px';
				        ss.width = (s.baseWidth = (fo.offsetWidth + sp[i + 7])) + 'px';
				        ss.height = (s.baseHeight = (fo.offsetHeight + sp[i + 11])) + 2 + 'px';
				        var opacity = fo.baseOpacity * sp[i + 15] / 100;
				        s.baseOpacity = opacity;
				        ss.filter = 'alpha(opacity=' + opacity + ')';
				        ss.opacity = opacity / 100;
				    } fo.style.display = 'none';
				    fo.style.top = fo.baseTop + 'px';
				    fo.style.left = fo.baseLeft + 3 + 'px';
				    f.animate = f.snap;
				    f.openAnimated(0);
				},
				    openAnimated: function(p) {
				        with (this) {
				            if (p > 100) p = 100;
				            var t = animate(div, p);
				            if (p == 0) div.style.display = '';
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				                if (p == 0) s.style.display = '';
				            } if (p == 100) { finishAnimation(true); } else if (t) { window.setTimeout(this.obj + '.openAnimated(' + (p + 10) + ')', 10); }
				        }
				    },
				    removeFlyout: function() {
				        var f = this;
				        f.pfi.co = 0;
				        f.m.hideMO(f.pfi);
				        if (f.intr) return;
				        f.intr = true;
				        f.animate = f.snap;
				        f.closeAnimated(100);
				    },
				    closeAnimated: function(p) {
				        with (this) {
				            if (p < 0) p = 0;
				            var t = animate(div, p);
				            for (var i = 1; i <= 4; i++) {
				                var s = shadows[i];
				                animate(s, p);
				            } if (p == 0) { finishAnimation(false); } else if (t) { window.setTimeout(this.obj + '.closeAnimated(' + (p - 10) + ')', 10); }
				        }
				    },
				    finishAnimation: function(open) {
				        with (this) {
				            if (!open) {
				                div.style.display = 'none';
				                for (var i = 1; i <= 4; i++) {
				                    var s = shadows[i];
				                    s.style.display = 'none';
				                } div.scrollArea.scrollTop = 0;
				                div.upArrow.src = m.UP_ARROW_DISABLED;
				                div.downArrow.src = m.DOWN_ARROW;
				            } shown = open;
				            intr = false;
				            if (show && !shown) showFlyout();
				            if (!show && shown) removeFlyout();
				        }
				    },
				    snap: function(o, p) {
				        this.finishAnimation(p ? false : true);
				        return false;
				    },
				    dummy: null
				};
				
				XXIEHV2.link = function(m, foi, iti, first, cur, st, i) {
				    var o = this;
				    o.cfoid = st[i++];
				    o.iti = iti;
				    o.txt = st[i++];
				    o.title = st[i++];
				    o.ref = m.adjustPath(st[i++]);
				    o.targ = st[i++];
				    o.func = '';
				    o.params = '';
				    if (o.targ.substr(0, 3) == '_PL') {
				        o.func = st[i++];
				        o.params = st[i++];
				    } o.imgn = m.adjustPath(st[i++]);
				    o.imgo = m.adjustPath(st[i++]);
				    o.imgh = st[i++];
				    o.imgw = st[i++];
				    m.preload(o.imgo);
				    o.sel = false;
				    o.foid = foi;
				    o.ncolor = (o.sel ? cur.SelColor : cur.Color);
				    o.mocolor = cur.MOColor;
				    o.mdcolor = cur.MDColor;
				    o.selpcolor = cur.SelParColor;
				    o.brdcolor = (o.sel ? cur.BSelColor : cur.BColor);
				    o.bmocolor = cur.BMOColor;
				    o.bmdcolor = cur.BMDColor;
				    o.bselcolor = cur.BSelColor;
				    o.bselpcolor = cur.BSelParColor;
				    o.txtcolor = (o.sel ? cur.TSelColor : cur.TxtColor);
				    o.tmocolor = cur.TMOColor;
				    o.tmdcolor = cur.TMDColor;
				    o.tselpcolor = cur.TSelParColor;
				    var is = "";
				    is += "<li class=\"PLVFOLink\" style=\"float:left;width:" + (foi ? "auto" : "138px") + ";height:" + (foi ? 50 : 50) + "px;" + (!first ? "margin-top:2px;" : "") + "text-align:center;border:solid 1px " + o.brdcolor + ";" + (o.cfoid > 0 && m.SUB_ARROW ? "background:" + o.ncolor + " url(" + m.SUB_ARROW + ") no-repeat " + "right" + " 85%" : (o.ncolor ? "background-color:" + o.ncolor : "")) + ";cursor:" + (o.sel ? "default" : "pointer") + ";\" foi=\"" + foi + "\" iti=\"" + iti + "\">";
				    if (o.imgn || o.imgo) { is += "<img class=\"PLVFOIcon\" src=\"" + (o.imgn ? o.imgn : o.imgo) + "\" width=\"" + o.imgw + "px\" height=\"" + o.imgh + "px\" style=\"float:left;margin-top:" + (Math.floor(((foi ? 50 : 50) - o.imgh) / 2) - 1) + "px;" + (o.imgn ? "" : "visibility:hidden;") + "\">"; } is += '<a href=\"' + (o.ref != '' ? o.ref : '#') + '\" target=\"' + o.targ + '\"' + (o.title != '' ? 'title=\"' + o.title + '\"' : '') + ' style=\"text-decoration:' + ((foi ? m.FLYOUT_UNDERLINE : m.MAIN_UNDERLINE) ? 'underline' : 'none') + ';color:' + o.txtcolor + ';\">' + o.txt + '</a>';
				    is += "</li>";
				    o.html = is;
				    o.i = i;
				};
			