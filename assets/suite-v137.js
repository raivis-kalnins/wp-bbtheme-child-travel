(function(W,D){
  'use strict';
  var cfg=W.wpbbSuiteV137||{};
  var heroUrls=Array.isArray(cfg.heroUrls)?cfg.heroUrls.filter(Boolean):[];
  var fallback=Array.isArray(cfg.fallbackCards)?cfg.fallbackCards:[];
  var theme=String(cfg.themeKey||'sector');
  function q(s,r){try{return (r||D).querySelector(s);}catch(e){return null;}}
  function qa(s,r){try{return Array.prototype.slice.call((r||D).querySelectorAll(s));}catch(e){return [];}}
  function kids(n){return n?Array.prototype.slice.call(n.children||[]):[];}
  function txt(n){return String(n&&n.textContent||'').replace(/\s+/g,' ').trim();}
  function norm(s){return String(s||'').toLowerCase().replace(/[^a-z0-9]+/g,' ').replace(/\s+/g,' ').trim();}
  function hide(n){if(n&&n.classList)n.classList.add('wpbb-v137-hidden');}
  function mark(){if(D.body){D.body.classList.add('wpbb-v137','wpbb-v137-theme-'+theme.replace(/[^a-z0-9_-]/gi,'-'));}}

  function removeMalformedBlockText(){
    var main=q('#wp-theme-main');if(!main||!D.createTreeWalker)return;
    var walker=D.createTreeWalker(main,NodeFilter.SHOW_TEXT),n,remove=[];
    while((n=walker.nextNode())){
      var t=String(n.nodeValue||'');
      if(/wp:wpbb\/icon-card|svgCode|wpbb-sector-proof-card/.test(t)&&(/<!--|<!–|wp:wpbb/.test(t)))remove.push(n);
    }
    remove.forEach(function(x){if(x.parentNode)x.parentNode.removeChild(x);});
  }

  function heroBlocks(){
    return qa('#wp-theme-main .wpbb-swiper--hero,#wp-theme-main .wp-theme-sector-hero .swiper,#wp-theme-main .wp-theme-hero .swiper').filter(function(b,i,a){
      return a.indexOf(b)===i&&(!b.closest('.wpbb-swiper--hero')||b.classList.contains('wpbb-swiper--hero'));
    });
  }
  function heroShell(block){return block&&block.closest('.wp-theme-sector-hero,.wp-theme-hero,.wp-theme-section-shell,section')||block&&block.parentElement||block;}
  function heroSlides(block){return qa('.swiper-slide',block).filter(function(s){return !s.classList.contains('swiper-slide-duplicate');});}
  function heroMedia(slide){return q('.wpbb-swiper-slide__media,.wp-theme-hero__media,.wpbb-hero-media',slide);}
  function ensureHeroImage(slide,url,index){
    if(!slide||!url)return;
    var media=heroMedia(slide)||slide;
    var img=q('img',media);
    if(!img){img=D.createElement('img');img.className='wpbb-v137-hero-image';media.appendChild(img);}
    img.src=url;img.removeAttribute('srcset');img.removeAttribute('sizes');img.removeAttribute('width');img.removeAttribute('height');
    img.loading='eager';img.decoding='async';try{img.fetchPriority=index===0?'high':'auto';}catch(e){}
    if(media.style)media.style.removeProperty('background-image');
  }
  function repairHero(){
    var blocks=heroBlocks();if(!blocks.length)return;
    blocks.forEach(function(block,i){
      var shell=heroShell(block);
      if(i>0){hide(shell||block);return;}
      block.classList.add('wpbb-v137-hero');
      if(shell)shell.classList.add('wpbb-v137-hero-shell');
      var ss=heroSlides(block);
      ss.forEach(function(s,idx){if(heroUrls.length)ensureHeroImage(s,heroUrls[idx%heroUrls.length],idx);});
      var host=shell||block.parentElement||block;
      qa('.wpbb-v135-hero-pagination,.wpbb-v134-hero-pagination,.wpbb-v133-hero-pagination,.wpbb-v128-hero-pagination,.wpbb-v127-hero-pagination,.wpbb-v126-hero-pagination,.swiper-pagination',host).forEach(hide);
      var count=Math.max(1,Math.min(3,heroUrls.length||ss.length||3));
      var pager=q('.wpbb-v137-hero-pagination',host);
      if(!pager){
        pager=D.createElement('div');pager.className='wpbb-v137-hero-pagination';pager.setAttribute('aria-label','Hero slides');host.appendChild(pager);
        for(var bi=0;bi<count;bi++)(function(index){
          var b=D.createElement('button');b.type='button';b.className='wpbb-v137-hero-bullet';b.setAttribute('aria-label','Go to slide '+(index+1));
          b.addEventListener('click',function(){
            var node=block.classList.contains('swiper')?block:(q('.swiper',block)||block),sw=node&&node.swiper||block.swiper;
            if(sw&&typeof sw.slideToLoop==='function')sw.slideToLoop(index);else if(sw&&typeof sw.slideTo==='function')sw.slideTo(index);
            paint();
          });pager.appendChild(b);
        })(bi);
      }
      function paint(){
        var node=block.classList.contains('swiper')?block:(q('.swiper',block)||block),sw=node&&node.swiper||block.swiper,idx=0;
        if(sw&&typeof sw.realIndex==='number')idx=((sw.realIndex%count)+count)%count;
        else{var a=q('.swiper-slide-active',block),arr=heroSlides(block),p=arr.indexOf(a);if(p>=0)idx=p%count;}
        qa('.wpbb-v137-hero-bullet',pager).forEach(function(b,j){b.classList.toggle('is-active',j===idx);});
      }
      paint();
      var node=block.classList.contains('swiper')?block:(q('.swiper',block)||block),sw=node&&node.swiper||block.swiper;
      if(sw&&typeof sw.on==='function'&&!block.__wpbbV137Bound){block.__wpbbV137Bound=true;sw.on('slideChange',paint);sw.on('transitionEnd',paint);}
    });
  }

  function processData(){
    var out=[];for(var i=0;i<3;i++){
      var f=fallback[i]||[];
      out.push([String(f[0]||('0'+(i+1))).replace(/^([1-9])$/,'0$1'),String(f[1]||('Step '+(i+1))),String(f[2]||'')]);
    }return out;
  }
  function findProcessSections(){
    var out=[];
    qa('#wp-theme-main .wp-theme-process-section').forEach(function(s){if(out.indexOf(s)<0)out.push(s);});
    qa('#wp-theme-main .wp-theme-sector-process-grid,#wp-theme-main [class*="process-grid"]').forEach(function(g){
      var s=g.closest('.wp-theme-process-section,section,.wp-theme-section-shell');if(s&&out.indexOf(s)<0)out.push(s);
    });
    if(!out.length){
      qa('#wp-theme-main section,#wp-theme-main .wp-theme-section-shell').forEach(function(s){
        var h=norm(txt(q('.wp-theme-section-heading,h2,h3',s)));
        if(/delivery model|simple process|how it works|how we work|choose .* describe|find .* compare .* book|choose .* learn .* check|choose .* request .* confirm/.test(h))out.push(s);
      });
    }
    return out;
  }
  function cloneHeading(section){
    var h=q('.wp-theme-section-heading',section);if(h)return h.cloneNode(true);
    var eyebrow=q('.wp-theme-sector-eyebrow,.wp-theme-eyebrow,[class*="eyebrow"]',section),title=q('h2,h3',section),wrap=D.createElement('div');
    wrap.className='wp-theme-section-heading';
    if(eyebrow)wrap.appendChild(eyebrow.cloneNode(true));
    if(title)wrap.appendChild(title.cloneNode(true));
    return wrap.children.length?wrap:null;
  }
  function rebuildProcess(){
    findProcessSections().forEach(function(section){
      if(section.dataset.wpbbV137Owned==='1')return;
      var heading=cloneHeading(section),shell=D.createElement('div'),grid=D.createElement('div');
      shell.className='wpbb-v137-process-shell';grid.className='wpbb-v137-process-grid';
      if(heading)shell.appendChild(heading);
      processData().forEach(function(item){
        var card=D.createElement('article');card.className='wpbb-v137-process-card';
        var badge=D.createElement('span');badge.className='wpbb-v137-process-badge';badge.textContent=item[0];
        var h=D.createElement('h3');h.textContent=item[1];var p=D.createElement('p');p.textContent=item[2];
        card.appendChild(badge);card.appendChild(h);card.appendChild(p);grid.appendChild(card);
      });
      shell.appendChild(grid);
      while(section.firstChild)section.removeChild(section.firstChild);
      section.appendChild(shell);section.classList.add('wpbb-v137-process-section');section.dataset.wpbbV137Owned='1';
    });
  }

  function repairStats(){
    qa('#wp-theme-main .wp-theme-sector-proof,#wp-theme-main .wp-theme-home-stats').forEach(function(scope){
      var cards=qa('.wp-theme-sector-proof__item,.wpbb-fun-fact',scope).filter(function(c,i,a){return a.indexOf(c)===i;});if(cards.length<2)return;
      var host=cards[0].parentElement;
      while(host&&host!==scope&&host!==D.body){var direct=kids(host).filter(function(k){return cards.some(function(c){return k===c||k.contains(c);});});if(direct.length>=2)break;host=host.parentElement;}
      host=host||scope;host.classList.add('wpbb-v137-stats-grid');
      kids(host).forEach(function(c){if(cards.some(function(x){return c===x||c.contains(x);})){c.classList.add('wpbb-v137-grid-cell');}});
      cards.forEach(function(c){c.classList.add('wpbb-v137-stat-card');});
    });
  }

  function repairCommonGrids(){
    var selectors=[
      '.wpbb-v62-card-grid','.wp-theme-sector-services','.wp-theme-sector-industries',
      '.wp-theme-case-grid','.wp-theme-case-studies-grid','.wp-theme-insights-grid','.wp-theme-blog-grid',
      '.wp-theme-blog-preview .wp-block-post-template','.wp-theme-insights-section .wp-block-post-template',
      '.wp-theme-home-product-catalogue','.wp-theme-products-grid','.wp-theme-sector-cards',
      '.wp-theme-feature-grid','.wp-theme-card-grid','.wpbb-sector-proof-band .row','.wpbb-sector-grid'
    ];
    qa('#wp-theme-main '+selectors.join(',#wp-theme-main ')).forEach(function(g){
      if(g.closest('.swiper,.wpbb-swiper--hero')||g.classList.contains('swiper-wrapper')||g.classList.contains('wpbb-v137-stats-grid'))return;
      var cs=kids(g).filter(function(c){
        if(c.classList.contains('wpbb-v137-hidden'))return false;
        if(c.matches&&c.matches('script,style,template,.swiper-pagination,.wpbb-v137-hero-pagination'))return false;
        return !!(txt(c)||q('img,article,.card,.wpbb-icon-card,.wp-theme-sector-card,.wp-theme-blog-card',c));
      });
      var n=cs.length;if(n<2||n>12)return;
      var cols=(g.classList.contains('wpbb-sector-grid')||g.classList.contains('wp-theme-blog-grid')||g.classList.contains('wp-block-post-template'))?3:(n>=4?4:(n===3?3:2));
      g.classList.remove('wpbb-v137-cols-2','wpbb-v137-cols-3','wpbb-v137-cols-4');
      g.classList.add('wpbb-v137-grid','wpbb-v137-cols-'+cols);
      cs.forEach(function(c){c.classList.add('wpbb-v137-grid-cell');});
    });
  }

  function normalizeSectionImages(){
    var exclude='.wpbb-v137-hero,.wp-theme-partners-section,.wp-theme-site-header,.wp-theme-footer,.wp-theme-language-switcher,.wp-theme-card-icon,.wpbb-icon-card__media,.avatar,.custom-logo-link';
    qa('#wp-theme-main img').forEach(function(img){
      if(img.closest(exclude))return;
      if(img.width&&img.height&&img.width<=96&&img.height<=96)return;
      img.classList.add('wpbb-v137-section-image');
      img.decoding='async';
      if(!img.hasAttribute('loading')&&!img.closest('.wp-theme-sector-hero,.wp-theme-hero'))img.loading='lazy';
      if(img.hasAttribute('srcset')){
        var split=img.closest('.wp-theme-sector-media-text,.wp-theme-about-section,.wp-theme-about-page-intro');
        img.setAttribute('sizes',split?'(min-width: 1040px) 50vw, 100vw':'(min-width: 1040px) 25vw, (min-width: 720px) 50vw, 100vw');
      }
    });
  }

  function alignSections(){
    qa('#wp-theme-main section,#wp-theme-main .wp-theme-section-shell,#wp-theme-main .wpbb-v67-section-shell,#wp-theme-main .wp-theme-home-cta,#wp-theme-main .wp-theme-sector-finder,#wp-theme-main .wp-theme-insights-section,#wp-theme-main .wp-theme-partners-section,#wp-theme-main .wpbb-sector-proof-band').forEach(function(s){
      if(!s.classList.contains('wpbb-v137-hero-shell'))s.classList.add('wpbb-v137-align-section');
    });
  }

  function cleanupDuplicateHeroLikeSections(){
    var main=q('#wp-theme-main');if(!main)return;
    var primary=heroBlocks()[0];
    qa('#wp-theme-main .wp-theme-sector-hero,#wp-theme-main .wp-theme-hero').forEach(function(s){if(primary&&!s.contains(primary)&&q('.swiper,.wpbb-swiper--hero',s))hide(s);});
  }

  function run(){mark();removeMalformedBlockText();repairHero();cleanupDuplicateHeroLikeSections();rebuildProcess();repairStats();repairCommonGrids();normalizeSectionImages();alignSections();}
  var pending=false;function schedule(){if(pending)return;pending=true;W.setTimeout(function(){pending=false;run();},50);}
  if(D.readyState==='loading')D.addEventListener('DOMContentLoaded',schedule,{once:true});else schedule();
  W.addEventListener('load',function(){run();W.setTimeout(run,300);W.setTimeout(run,1000);});
  if(W.MutationObserver)new MutationObserver(function(ms){if(ms.some(function(m){return m.addedNodes&&m.addedNodes.length;}))schedule();}).observe(D.documentElement,{childList:true,subtree:true});
})(window,document);
