<?php
/*
  Plugin Name: Bookingmood
  Plugin URI: https://bookingmood.com/plugins/wordpress
  description: Embed Bookingmood booking calendars into your Wordpress website
  Version: 1.1.1
  Author: Bookingmood
  Author URI: https://bookingmood.com
*/

function bookingmood_wp_head()
{
?>
<script>
(function () {
  window.addEventListener("message", function (event) {
    try {
      const height = JSON.parse(event.data).height;
      if (!(height > 0)) return;
      const frames = document.getElementsByTagName("iframe");
      for (const frame of frames) {
        const frameWindow =
          frame.contentWindow || frame.contentDocument.defaultView;
        if (frameWindow === event.source) frame.height = height;
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
