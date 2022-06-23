function handleGalleryInputChange(input) {
  const regex = new RegExp('kacf-filter-' + input.value)
  jQuery('.kacf-filter').hide()
  jQuery('.kacf-filter')
    .filter(function () {
      return this.className.match(regex)
    })
    .show()
}

jQuery(document).ready(function () {
  const $popover = jQuery('#kacf-popover')
  let popoverInfos = {
    active: false,
    width: 100,
    height: 100,
  }
  jQuery('.kacf-filter').on({
    mouseenter: function () {
      const $this = jQuery(this)
      const reference = $this.data('reference')
      $popover.addClass('active')
      $popover.html(reference)
      popoverInfos.active = true
      popoverInfos.width = $popover.width()
      popoverInfos.height = $popover.height()
    },
    mouseleave: function () {
      $popover.removeClass('active')
      popoverInfos.active = false
    },
  })

  jQuery(document).mousemove(function (e) {
    if (!popoverInfos.active) return
    $popover.css('left', `${e.pageX}px`)
    $popover.css('top', `${e.pageY}px`)
  })
})
