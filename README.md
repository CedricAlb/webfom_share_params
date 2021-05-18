# Description

A Drupal (8, 9) module to override the Webform Share share.js script and pass the parent page query parameters into the iframe 

# Usage

- copy/paste the code to embed your form using Javascript method (via the "Share" tab of the webform)
- in the pasted code replace `share.js` with `share_params.js`
- now if you display the embeding page with a query parameter like `?utm_campaign=webform_share_params_test` you have it in the iframe too (and you could use it to prepopulate a field)
