<?php
/**
 * User: Kyeongdae
 * Date: 2019-02-12
 * Time: 오후 9:06
 */

class GoogleTagManagerAddOn {
	private $addon_info;
	private $includeAdmin;

	private $head =<<<html
<!-- Google Tag Manager -->
<script>
(function(w,d,s,l){
    w[l]=w[l]||[];
    w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
    var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
    j.async=true;
    j.src='https://www.googletagmanager.com/gtm.js?id={gtm_id}'+dl;
    f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer');
</script>
<!-- End Google Tag Manager -->
html;
	private $body=<<<html
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={gtm_id}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
html;

	/** @return Context */
	function context() { return Context::getInstance(); }

	public function setPath($addon_path) { $this->addon_path = $addon_path; }
	function setInfo($addon_info) {
		$this->addon_info = $addon_info;
		$this->includeAdmin = $addon_info->include_admin == 'Y';
	}

	/**
	 * @param ModuleHandler $moduleHandler
	 *
	 * @return bool
	 */
	function before_module_init($moduleHandler) {
		/** @var stdClass $logged_info */
		$logged_info = $this->context()->get('logged_info');
		$module = $this->context()->get('module');
		$act = $this->context()->get('act');

		$isAdmin = !$this->includeAdmin && ($logged_info->is_admin == 'Y' || $logged_info->is_site_admin);

		if ($isAdmin || $module == 'admin' || strpos($act, 'admin') !== false) {
			return false;
		}

		if($this->addon_info->gtm_id) {
			$this->context()->addHtmlHeader(str_replace('{gtm_id}', $this->addon_info->gtm_id, $this->head));
			$this->context()->addBodyHeader(str_replace('{gtm_id}', $this->addon_info->gtm_id, $this->body));
		} else {
			$this->context()->addHtmlHeader('<script>alert("gtm id is blank");</script>');
		}

	}
}