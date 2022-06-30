if (typeof window['handleGalleryInputChange'] !== 'function') {
    /**
     * Filter blocks according to the input value
     * @param {DOM} input
     */
    function handleGalleryInputChange(input) {
        const regex = new RegExp('kacf-filter-' + input.value);
        // hide blocks
        jQuery('.kacf-filter').hide();
        // show blocks respecting the regex
        let nbBlocksVisibles = 0;
        jQuery('.kacf-filter')
            .filter(function () {
                const isVisible = this.className.match(regex);
                if (isVisible) nbBlocksVisibles++;
                return isVisible;
            })
            .show();
        jQuery('.kacf-result-count__count').html(nbBlocksVisibles);
    }

    jQuery(document).ready(function () {
        const $popover = jQuery('.kacf-popover');
        let popoverInfos = {
            active: false,
            width: 100,
            height: 100,
        };
        // set actions on mouse enter and leave blocks
        jQuery('.kacf-filter').on({
            mouseenter: function () {
                const $this = jQuery(this);
                const reference = $this.data('reference');
                $popover.addClass('active');
                $popover.html(reference);
                popoverInfos.active = true;
                popoverInfos.width = $popover.width();
                popoverInfos.height = $popover.height();
            },
            mouseleave: function () {
                $popover.removeClass('active');
                popoverInfos.active = false;
            },
        });

        // update popover position on mouse move
        jQuery(document).mousemove(function (e) {
            if (!popoverInfos.active) return;
            $popover.css('left', `${e.pageX}px`);
            $popover.css('top', `${e.pageY}px`);
        });
    });
}

/**
 * Create a new encapsulate shadow block
 */
class ShadowBlock {
    constructor(sharedCss, blockData) {
        // get the wrapper
        const $wrapper = document.getElementById(blockData.wrapper);
        if (!$wrapper) {
            console.error('KACF Gallery Block not found by ID');
            return;
        }

        // attach the shadow
        this.shadow = $wrapper.attachShadow({ mode: 'open' });

        // add the html
        this.insertHTML(blockData.content);

        // add the root css (gonna be load from cache)
        sharedCss.map((css) => this.insertCSS(css));

        // add the css
        this.insertCSS(blockData.css);

        // add the js
        this.insertCSS(blockData.js);
    }

    /**
     * Add the HTML content in the shadow
     * @param {string} content
     */
    insertHTML(content) {
        this.shadow.innerHTML = content;
    }

    /**
     * Add the CSS link in the shadow
     * @param {string} href
     */
    insertCSS(href) {
        const $css = document.createElement('link');
        $css.setAttribute('rel', 'stylesheet');
        $css.setAttribute('type', 'text/css');
        $css.setAttribute('href', href);

        this.shadow.append($css);
    }

    /**
     * Add the JS script in the shadow
     * @param {string} href
     */
    insertJS(src) {
        const $js = document.createElement('script');
        $js.setAttribute('type', 'text/javascript');
        $js.setAttribute('src', src);

        this.shadow.append($js);
    }
}

jQuery(document).ready(function () {
    if (!galleryBlocks) return;

    // loop through the global variable glleryBlocks to create encapsulated blocks
    galleryBlocks.blocks.map(
        (block) => new ShadowBlock(galleryBlocks.css, block)
    );
});
