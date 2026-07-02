/*! instant.page v5.2.0 - (C) Alexandre Dieulot - MIT License */
(function() {
    let mouseoverTimer;
    let lastTouchTimestamp;
    
    const prefetcher = document.createElement('link');
    const isSupported = prefetcher.relList && prefetcher.relList.supports && prefetcher.relList.supports('prefetch');
    const isDataSaver = navigator.connection && (navigator.connection.saveData || (navigator.connection.effectiveType && navigator.connection.effectiveType.includes('2g')));
    
    if (!isSupported || isDataSaver) return;

    prefetcher.rel = 'prefetch';
    document.head.appendChild(prefetcher);

    document.addEventListener('touchstart', touchstartListener, {passive: true});
    document.addEventListener('mouseover', mouseoverListener, {passive: true});

    function touchstartListener(event) {
        lastTouchTimestamp = performance.now();
        const link = event.target.closest('a');
        if (!isEligible(link)) return;
        prefetch(link.href);
    }

    function mouseoverListener(event) {
        if (performance.now() - lastTouchTimestamp < 1111) return;
        const link = event.target.closest('a');
        if (!isEligible(link)) return;
        
        link.addEventListener('mouseout', mouseoutListener, {passive: true});
        mouseoverTimer = setTimeout(() => {
            prefetch(link.href);
            mouseoverTimer = undefined;
        }, 65);
    }

    function mouseoutListener(event) {
        if (event.relatedTarget && event.target.closest('a') === event.relatedTarget.closest('a')) return;
        if (mouseoverTimer) {
            clearTimeout(mouseoverTimer);
            mouseoverTimer = undefined;
        }
    }

    function isEligible(link) {
        if (!link || !link.href) return false;
        if (link.origin !== location.origin) return false;
        if (link.pathname === location.pathname && link.search === location.search) return false;
        if (link.hash) return false;
        if (link.getAttribute('download') !== null) return false;
        if (link.getAttribute('target') === '_blank') return false;
        if (link.href.includes('/admin') || link.href.includes('/signout') || link.href.includes('/logout') || link.href.includes('/checkout')) return false;
        return true;
    }

    function prefetch(url) {
        prefetcher.href = url;
    }
})();
