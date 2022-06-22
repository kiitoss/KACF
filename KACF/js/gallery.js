function handleGalleryInputChange(input) {
  const regex = new RegExp('kacf-filter-' + input.value)
  jQuery('.kacf-filter').hide()
  jQuery('.kacf-filter')
    .filter(function () {
      return this.className.match(regex)
    })
    .show()
}
