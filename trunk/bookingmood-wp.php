<?php
/*
  Plugin Name: Bookingmood
  Plugin URI: https://www.bookingmood.com/en-US/docs/widgets/website-builders/wordpress
  description: Embed Bookingmood widgets into your Wordpress website
  Version: 1.1.3
  Author: Bookingmood
  Author URI: https://bookingmood.com
*/

function bookingmood_wp_head()
{
?>
<script>
(function () {
  const s = new Set();
  window.addEventListener("message", function (event) {
    try {
      const m = JSON.parse(event.data);
      for (const f of document.getElementsByTagName("iframe")) {
        const w = f.contentWindow || f.contentDocument.defaultView;
        if (w !== event.source) continue;
        if (m.context === "iframe.resize" && m.height > 0) f.height = m.height;
        if (!s.has(w)) {
          w.postMessage({ search: window.location.search }, "*");
          s.add(w);
        }
      }
    } catch {}
  });
})();

</script>
<?php
}

function bookingmood_wp_init()
{
  wp_oembed_add_provider(
    '#https?://(www.)?bookingmood.com/embed/.*#i',
    'https://www.bookingmood.com/api/oembed',
    true
  );
}

add_action('init', 'bookingmood_wp_init');
add_action('wp_head', 'bookingmood_wp_head');
