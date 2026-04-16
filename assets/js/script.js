(function(){
    // Copy IP (with fallback)
    function fallbackCopy(text){
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly','');
        ta.style.position = 'absolute';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try{
            var ok = document.execCommand('copy');
            document.body.removeChild(ta);
            return ok;
        }catch(e){
            document.body.removeChild(ta);
            return false;
        }
    }

    function setupCopy(){
        var btn = document.getElementById('copy-ip-btn');
        if(!btn) return;
        var ip = btn.dataset.ip || 'play.survival-craft.sk';

        btn.addEventListener('click', function(){
            if(navigator.clipboard && navigator.clipboard.writeText){
                navigator.clipboard.writeText(ip).then(function(){
                    showFeedback(btn, 'Skopírované!');
                }, function(){
                    var ok = fallbackCopy(ip);
                    showFeedback(btn, ok ? 'Skopírované!' : 'Kopírovanie zlyhalo');
                });
            } else {
                var ok = fallbackCopy(ip);
                showFeedback(btn, ok ? 'Skopírované!' : 'Kopírovanie zlyhalo');
            }
        });

        function showFeedback(el, msg){
            var original = el.textContent;
            el.textContent = msg;
            el.setAttribute('aria-pressed','true');
            setTimeout(function(){
                el.textContent = original;
                el.removeAttribute('aria-pressed');
            }, 1800);
        }

        // clickable IP text (in hero) — show tooltip with confirmation
        var textBtn = document.getElementById('copy-ip-text');
        if(textBtn){
            var ipText = textBtn.dataset.ip || ip;
            textBtn.addEventListener('click', function(){
                if(navigator.clipboard && navigator.clipboard.writeText){
                    navigator.clipboard.writeText(ipText).then(function(){
                        showTooltip(textBtn, 'skopírované');
                    }, function(){
                        var ok = fallbackCopy(ipText);
                        showTooltip(textBtn, ok ? 'skopírované' : 'Kopírovanie zlyhalo');
                    });
                } else {
                    var ok = fallbackCopy(ipText);
                    showTooltip(textBtn, ok ? 'skopírované' : 'Kopírovanie zlyhalo');
                }
            });
        }

        function showTooltip(targetEl, msg){
            try{
                var tip = document.createElement('div');
                tip.className = 'copy-tooltip';
                tip.textContent = msg;
                document.body.appendChild(tip);
                // compute position after appended so we can read size
                var rect = targetEl.getBoundingClientRect();
                var tipW = tip.offsetWidth;
                var tipH = tip.offsetHeight;
                var left = rect.left + window.scrollX + (rect.width - tipW)/2;
                var top = rect.top + window.scrollY - tipH - 10;
                if(left < 6) left = 6;
                tip.style.left = left + 'px';
                tip.style.top = top + 'px';
                // show with transition
                requestAnimationFrame(function(){ tip.classList.add('show'); });
                setTimeout(function(){ tip.classList.remove('show'); setTimeout(function(){ try{ document.body.removeChild(tip); }catch(e){} }, 180); }, 1400);
            }catch(e){}
        }
    }

    // Nav toggle for mobile
    function setupNavToggle(){
        document.querySelectorAll('.site-nav').forEach(function(nav){
            var toggle = nav.querySelector('.nav-toggle');
            var list = nav.querySelector('.nav-list');
            if(!toggle || !list) return;
            toggle.addEventListener('click', function(){
                var open = list.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if(open) document.body.classList.add('nav-open'); else document.body.classList.remove('nav-open');
            });
        });

        // close on outside click
        document.addEventListener('click', function(e){
            document.querySelectorAll('.site-nav .nav-list.open').forEach(function(openList){
                var nav = openList.closest('.site-nav');
                if(nav && !nav.contains(e.target)){
                    openList.classList.remove('open');
                    var toggle = nav.querySelector('.nav-toggle');
                    if(toggle) toggle.setAttribute('aria-expanded','false');
                    document.body.classList.remove('nav-open');
                }
            });
        });
    }

    // Add subtle background to navbar when page is scrolled
    function setupNavScroll(){
        var nav = document.querySelector('.site-nav');
        if(!nav) return;
        var threshold = 12; // px 
        var ticking = false;

        function update(){
            var sc = window.scrollY || window.pageYOffset || 0;
            if(sc > threshold){
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', function(){
            if(!ticking){
                window.requestAnimationFrame(function(){ update(); ticking = false; });
                ticking = true;
            }
        }, {passive: true});

        // run once on init to set correct state
        update();
    }

    // VIP mode switcher
    function setupModeSwitch(){
        var modeButtons = document.querySelectorAll('.mode-btn');
        if(modeButtons.length === 0) return;
        
        modeButtons.forEach(function(btn){
            btn.addEventListener('click', function(){
                var mode = this.dataset.mode;
                console.log('Switching to mode:', mode);
                
                // Remove active class from all buttons
                modeButtons.forEach(function(b){ b.classList.remove('active'); });
                // Add active class to clicked button
                this.classList.add('active');
                
                // Hide all vip grids
                var survivalGrid = document.getElementById('survival-vip');
                var skyblockGrid = document.getElementById('skyblock-vip');
                
                if(mode === 'survival'){
                    if(survivalGrid) survivalGrid.classList.remove('hidden');
                    if(skyblockGrid) skyblockGrid.classList.add('hidden');
                } else if(mode === 'skyblock'){
                    if(survivalGrid) survivalGrid.classList.add('hidden');
                    if(skyblockGrid) skyblockGrid.classList.remove('hidden');
                }
            });
        });
    }

    // Popular hover behavior: move 'popular' class to hovered card and restore defaults on leave
    function setupPopularHover(){
        var grids = document.querySelectorAll('.vip-grid');
        if(!grids.length) return;

        // store default popular cards per grid (may be multiple)
        var defaultsMap = new Map();
        grids.forEach(function(grid){
            var defaults = Array.prototype.slice.call(grid.querySelectorAll('.vip-card.popular'));
            defaultsMap.set(grid, defaults);

            // when pointer enters a card, make it the only popular inside this grid
            grid.querySelectorAll('.vip-card').forEach(function(card){
                card.addEventListener('pointerenter', function(){
                    grid.querySelectorAll('.vip-card').forEach(function(c){ c.classList.remove('popular'); });
                    this.classList.add('popular');
                });
            });

            // when pointer leaves the grid, restore the original default popular cards
            grid.addEventListener('pointerleave', function(){
                grid.querySelectorAll('.vip-card').forEach(function(c){ c.classList.remove('popular'); });
                var defs = defaultsMap.get(grid) || [];
                defs.forEach(function(d){ if(d) d.classList.add('popular'); });
            });
        });
    }

    // Slideshow for hero (uses images from assets/img/galery)
    function setupSlideshow(){
        var container = document.querySelector('.hero-slideshow');
        if(!container) return;
        var slides = Array.prototype.slice.call(container.querySelectorAll('.slide'));
        var prev = container.querySelector('.slide-prev');
        var next = container.querySelector('.slide-next');
        var indicators = container.querySelector('.slide-indicators');
        var current = slides.findIndex(function(s){ return s.classList.contains('active'); });
        if(current < 0) current = 0;
        var autoplay = true;
        var interval = 4500;
        var timer = null;

        // build indicators
        slides.forEach(function(_, i){
            var btn = document.createElement('button');
            btn.type = 'button';
            if(i === current) btn.classList.add('active');
            btn.addEventListener('click', function(){ goTo(i); resetTimer(); });
            indicators.appendChild(btn);
        });

        function update(){
            slides.forEach(function(s, i){ s.classList.toggle('active', i === current); });
            var dots = indicators.querySelectorAll('button');
            dots.forEach(function(d, i){ d.classList.toggle('active', i === current); });
        }

        function goTo(i){
            current = (i + slides.length) % slides.length;
            update();
        }

        function nextSlide(){ goTo(current + 1); }
        function prevSlide(){ goTo(current - 1); }

        function resetTimer(){
            if(timer) clearInterval(timer);
            if(autoplay) timer = setInterval(nextSlide, interval);
        }

        if(next) next.addEventListener('click', function(){ nextSlide(); resetTimer(); });
        if(prev) prev.addEventListener('click', function(){ prevSlide(); resetTimer(); });

        container.addEventListener('mouseenter', function(){ autoplay = false; if(timer) clearInterval(timer); });
        container.addEventListener('mouseleave', function(){ autoplay = true; resetTimer(); });

        // start
        update();
        resetTimer();
    }

    // init
    // Language switcher: accordion with flags, changes prices and stores preference
    function setupLanguageSwitcher(){
        var accordions = document.querySelectorAll('.lang-accordion');
        if(!accordions.length) return;

        function applyLangToAll(lang){
            document.querySelectorAll('.lang-btn').forEach(function(b){ b.classList.toggle('active', b.dataset.lang === lang); });
            // update flag icon in each toggle - change class from fi-sk to fi-cz or vice versa
            document.querySelectorAll('.lang-toggle .fi').forEach(function(flagEl){
                flagEl.classList.remove('fi-sk', 'fi-cz');
                flagEl.classList.add(lang === 'cz' ? 'fi-cz' : 'fi-sk');
            });
            // mark each accordion with current language
            document.querySelectorAll('.lang-accordion').forEach(function(acc){
                acc.dataset.lang = lang;
            });
            document.documentElement.lang = (lang === 'cz') ? 'cs' : 'sk';
            // update prices
            document.querySelectorAll('.price[data-price-sk]').forEach(function(el){
                var sk = el.dataset.priceSk;
                var cz = el.dataset.priceCz;
                el.textContent = (lang === 'cz' && cz) ? cz : (sk || el.textContent);
            });
            // update VIP buttons (text and href)
            document.querySelectorAll('.vip-btn').forEach(function(btn){
                var textSk = btn.dataset.textSk;
                var textCz = btn.dataset.textCz;
                var hrefSk = btn.dataset.hrefSk;
                var hrefCz = btn.dataset.hrefCz;
                if(lang === 'cz'){
                    if(textCz) btn.textContent = textCz;
                    if(hrefCz) btn.href = hrefCz;
                } else {
                    if(textSk) btn.textContent = textSk;
                    if(hrefSk) btn.href = hrefSk;
                }
            });
            // update all elements with data-text-sk/cz
            document.querySelectorAll('[data-text-sk]').forEach(function(el){
                var textSk = el.dataset.textSk;
                var textCz = el.dataset.textCz;
                var text = (lang === 'cz' && textCz) ? textCz : textSk;
                // only update if element has no child elements with content (simple text nodes)
                if(text && el.children.length === 0){
                    el.textContent = text;
                } else if(text && el.tagName !== 'A'){
                    // for elements with children, only update visible text
                    var firstNode = el.childNodes[0];
                    if(firstNode && firstNode.nodeType === 3){
                        firstNode.textContent = text;
                    }
                }
            });
            // update aria-labels for buttons
            document.querySelectorAll('[data-aria-sk]').forEach(function(el){
                var ariaSk = el.dataset.ariaSk;
                var ariaCz = el.dataset.ariaCz;
                var aria = (lang === 'cz' && ariaCz) ? ariaCz : ariaSk;
                if(aria){
                    el.setAttribute('aria-label', aria);
                }
            });
            try{ localStorage.setItem('siteLang', lang); }catch(e){}
        }

        // wire each accordion
        accordions.forEach(function(acc){
            var toggle = acc.querySelector('.lang-toggle');
            var options = acc.querySelector('.lang-options');
            if(!toggle || !options) return;

            // open/close accordion
            toggle.addEventListener('click', function(e){
                var open = options.classList.toggle('open');
                options.setAttribute('aria-hidden', open ? 'false' : 'true');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });

            // option click
            options.querySelectorAll('.lang-btn').forEach(function(btn){
                btn.addEventListener('click', function(){
                    var lang = this.dataset.lang;
                    applyLangToAll(lang);
                    // close options
                    options.classList.remove('open');
                    options.setAttribute('aria-hidden','true');
                    if(toggle) toggle.setAttribute('aria-expanded','false');
                });
            });

            // close on outside click
            document.addEventListener('click', function(e){
                if(!acc.contains(e.target)){
                    options.classList.remove('open');
                    options.setAttribute('aria-hidden','true');
                    toggle.setAttribute('aria-expanded','false');
                }
            });
        });

        // init language from storage
        var stored = null;
        try{ stored = localStorage.getItem('siteLang'); }catch(e){}
        applyLangToAll(stored === 'cz' ? 'cz' : 'sk');
    }

    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', function(){ setupCopy(); setupNavToggle(); setupNavScroll(); setupModeSwitch(); setupPopularHover(); setupLanguageSwitcher(); setupSlideshow(); setupFeedbackForm(); });
    } else {
        setupCopy(); setupNavToggle(); setupNavScroll(); setupModeSwitch(); setupPopularHover(); setupLanguageSwitcher(); setupSlideshow(); setupFeedbackForm();
    }
})();

// Hide the page loader overlay when the full window has loaded (images, fonts, etc.)
(function(){
    function hideLoader(){
        var l = document.getElementById('site-loader');
        if(!l) return;
        try{
            l.classList.add('hidden');
            l.setAttribute('aria-hidden','true');
            // remove from DOM after transition
            setTimeout(function(){ if(l && l.parentNode) l.parentNode.removeChild(l); }, 700);
        }catch(e){}
    }

    if(document.readyState === 'complete'){
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader);
        // also hide after a fallback timeout (in case load event doesn't fire)
        setTimeout(hideLoader, 8000);
    }
})();

function setupFeedbackForm(){
    var form = document.getElementById('feedback-form');
    if(!form) return;
    var email = form.querySelector('input[type="email"]');
    var message = form.querySelector('textarea[name="message"]');
    var errorEl = form.querySelector('.form-error');
    var consent = form.querySelector('#fb-consent');

    // language for inline messages (sk / cz)
    var siteLang = (function(){ try{ return localStorage.getItem('siteLang') }catch(e){} return null })() || (document.documentElement.lang === 'cs' ? 'cz' : 'sk');
    var messages = {
        sk: {
            invalidEmail: 'Zadajte platný e-mail.',
            noMessage: 'Správa je povinná.',
            noConsent: 'Je potrebný súhlas so spracovaním údajov.'
        },
        cz: {
            invalidEmail: 'Zadejte platný e-mail.',
            noMessage: 'Zpráva je povinná.',
            noConsent: 'Je potřeba souhlas se zpracováním údajů.'
        }
    };

    function isValidEmail(v){
        if(!v) return false;
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    form.addEventListener('submit', function(ev){
        ev.preventDefault();
        if(errorEl) errorEl.textContent = '';
        var val = email ? email.value.trim() : '';
        var msg = message ? message.value.trim() : '';
        if(!isValidEmail(val)){
            if(errorEl) errorEl.textContent = messages[siteLang].invalidEmail;
            if(email) email.focus();
            return;
        }
        if(!msg){
            if(errorEl) errorEl.textContent = messages[siteLang].noMessage;
            if(message) message.focus();
            return;
        }
        if(!consent || !consent.checked){
            if(errorEl) errorEl.textContent = messages[siteLang].noConsent;
            if(consent) consent.focus();
            return;
        }

        try{ sessionStorage.setItem('feedback-name', (form.querySelector('#fb-name')||{value:''}).value || ''); }catch(e){}
        window.location.href = 'thankyou.html';
    });
}


