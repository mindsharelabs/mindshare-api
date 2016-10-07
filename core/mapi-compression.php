<?php
/**
 * Mindshare Theme API HTML COMPRESSION, formerly "mCMS Compression"
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mcms-compresion.php
 *             Changelog:
 *             - rewrote based on http://www.svachon.com/wp-html-compression/
 *             - changed to strip comments + whitespace
 *             - Removes HTML comments, leaving in IE Conditional Comments, by removing comments that start with " <!--&nbsp;"
 *             - initial release
 *             Usage:
 *             <code>
 *             <?php mapi_toggle_html_compression(); ?>
 *             ... code/HTML content here is left alone, other HTML is compressed, whitespace adn comments are stipped ...
 *             <?php mapi_toggle_html_compression(); ?>
 *             </code>
 */

/**
 * Class mapi_compression
 * Handles compression of inline HTML, JS and CSS. This class is called directly by the Theme API. Typically there is
 * no reason to use it directly.
 */
class mapi_compression {

	/**
	 * @var bool Should CSS be compressed?
	 */
	protected $compress_css = TRUE;

	/**
	 * @var bool should JS also be compressed? Disabled due to prevalent syntax errors.
	 */
	protected $compress_js = FALSE;

	/**
	 * @var bool Should the informational HTML comment be appended to the doc? Disabled because it's annoying.
	 */
	protected $info_comment = FALSE;

	/**
	 * @var bool Should comments be stripped?
	 */
	protected $remove_comments = TRUE;

	protected $html;

	public function __construct($html) {
		$this->compress_js = apply_filters('mapi_compress_js', FALSE);
		$this->info_comment = apply_filters('mapi_compress_info', FALSE);

		if(!empty($html)) {
			$this->parse_html($html);
		}
	}

	public function __toString() {
		return $this->html;
	}

	/**
	 * Add a comment to the bottom of the source code
	 *
	 * @param $raw
	 * @param $compressed
	 *
	 * @return string
	 */
	protected function btm_comment($raw, $compressed) {
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		$savings = ($raw - $compressed) / $raw * 100;
		$savings = round($savings, 2);

		return '<!-- ' . MAPI_PLUGIN_NAME . ' crunched this document by ' . $savings . '%. The file was ' . $raw . ' bytes, but is now ' . $compressed . ' bytes -->';
	}

	/**
	 * Minify the HTML
	 *
	 * @param $html
	 *
	 * @return string
	 */
	protected function minify_html($html) {
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = FALSE;
		$raw_tag = FALSE;
		// Variable reused for output
		$html = '';
		foreach ($matches as $token) {
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : NULL;
			$content = $token[0];
			if(is_null($tag)) {
				if(!empty($token['script'])) {
					$strip = $this->compress_js;
				} else {
					if(!empty($token['style'])) {
						$strip = $this->compress_css;
					} else {
						if($content == mapi_toggle_html_compression(FALSE)) {
							$overriding = !$overriding;
							// Don't print the comment
							continue;
						} else {
							if(apply_filters('mapi_compress_strip_html_comments', $this->remove_comments)) {
								if(!$overriding && $raw_tag != 'textarea') {
									// Remove any HTML comments, except MSIE conditional comments
									$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
								}
							}
						}
					}
				}
			} else {
				if($tag == 'pre' || $tag == 'textarea') {
					$raw_tag = $tag;
				} else {
					if($tag == '/pre' || $tag == '/textarea') {
						$raw_tag = FALSE;
					} else {
						if($raw_tag || $overriding) {
							$strip = FALSE;
						} else {
							$strip = TRUE;
							// Remove any empty attributes, except: action, alt, content, src
							//$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
							// Remove any space before the end of self-closing XHTML tags
							// JavaScript excluded
							$content = str_replace(' />', '/>', $content);
						}
					}
				}
			}
			if($strip) {
				$content = $this->strip_whitespace($content);
			}
			$html .= $content;
		}

		return $html;
	}

	/**
	 * Parse the HTML
	 *
	 * @param $html
	 */
	public function parse_html($html) {
		$this->html = $this->minify_html($html);
		$comment_override = apply_filters('mapi_compress_comment', FALSE);
		if($this->info_comment || $comment_override) {
			$this->html .= "\n" . $this->btm_comment($html, $this->html);
		}
	}

	/**
	 * Removes whitespace
	 *
	 * @param $str
	 *
	 * @return mixed
	 */
	protected function strip_whitespace($str) {
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n", '', $str);
		$str = str_replace("\r", '', $str);
		while(stristr($str, '  ')) {
			$str = str_replace('  ', ' ', $str);
		}

		return $str;
	}
}

/**
 * Callback function
 * Can be filtered using the 'mapi_html_compression' hook.
 * Accepts output buffer string, returns output buffer string.
 *
 * @param $html
 *
 * @return mapi_compression
 */
function mapi_compress_finish($html) {
	return apply_filters('mapi_html_compression', new mapi_compression($html));
}

/**
 * Starts the output buffer
 */
function mapi_compress_start() {
	ob_start('mapi_compress_finish');
}

/**
 * Outputs an HTML comment to turn off HTML/CSS/JS compression.
 */
function mapi_stop_compression() {
	mapi_toggle_html_compression(TRUE);
}

/**
 * Outputs an HTML comment to turn on HTML/CSS/JS compression after
 * it was turned off using mapi_stop_compression().
 */
function mapi_start_compression() {
	mapi_toggle_html_compression(TRUE);
}

/**
 * Outputs an HTML comment to disable HTML compression
 * (until this function is called again). Only relevant
 * when HTML compression is enabled in Developer Settings >
 * Performance Tuning > Minify HTML.
 *
 * @param bool $echo Whether to echo or return the HTML comment. Default is TRUE.
 *
 * @return string
 */
function mapi_toggle_html_compression($echo = TRUE) {
	$comment = '<!--compression-none-->';
	if($echo) {
		echo $comment;
	} else {
		return $comment;
	}
}
