<?php
/*
  Plugin Name: Bookingmood
  Plugin URI: https://bookingmood.com/plugins/wordpress
  description: Easily embed Bookingmood widgets into your Wordpress website
  Version: 1.0.2
  Author: Bookingmood
  Author URI: https://bookingmood.com
*/

function bookingmood_wp_head()
{
?>
  <script>
    function onMessage(event) {
      if (!event.source || event.data?.operation !== "resize") return;
      const iframes = document.querySelectorAll("iframe");
      iframes.forEach(iframe => {
        if (iframe.src === event.data.src) {
          const height = event.data.height + 1;
          iframe.height = height;
          iframe.style.setProperty("height", `${height}px`, "important");
        }
      });
    }

    window.addEventListener("message", onMessage);
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
