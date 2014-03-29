module.exports = {
	"Media Query Test" : function (browser) {
		browser.mediaQuery = {};

		/**
		 * Retrieves a random integer in a specified range.
		 *
		 * @param   {Integer}  min  The minimum integer value.
		 * @param   {Integer}  max  The maximum integer value.
		 *
		 * @return  {Integer}       The random integer in the specified range
		 */
		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		} // getRandomInt()

		/**
		 * Outputs a banner with specified message to the console.
		 *
		 * @return  {void}  [description]
		 */
		browser.mediaQuery.bannerLarge = function(msg) {
			console.log('\n==============================================');
			console.log(msg);
			console.log('==============================================');
		}; // browser.mediaQuery.bannerLarge()

		/**
		 * Outputs a banner with specified message to the console.
		 *
		 * @return  {void}  [description]
		 */
		browser.mediaQuery.bannerSmall = function(msg) {
			console.log('\n====== ' + msg + ' ======' );
		}; // browser.mediaQuery.bannerSmall()

		/**
		 * Handles setting up the snapshot directories for testing.
		 *
		 * @return  {Void}
		 */
		browser.mediaQuery.directoryHelper = function() {
			var fs                = require('fs');
			var snapShotDirBase   = browser.mediaQuery.snapShotDirBase;
			var snapShotDirNew    = browser.mediaQuery.snapShotDirNew;
			var snapShotDirOld    = browser.mediaQuery.snapShotDirOld;
			var snapShotDirRandom = browser.mediaQuery.snapShotDirRandom;
			// var files             = browser.mediaQuery.files;
			var random            = browser.mediaQuery.random;


			// Make directory for snapshots if they do not exist
			if ( ! fs.existsSync(snapShotDirBase) ) {
				fs.mkdirSync(snapShotDirBase);
			} // if()

			// Setup random directory
			if ( ! fs.existsSync(snapShotDirRandom) && random ) {
				fs.mkdirSync(snapShotDirRandom);
			} // if()

			// Clean up random directory
			if ( random ) {
				fs.readdirSync(snapShotDirRandom).forEach(function(fileName) {
					fs.unlinkSync(snapShotDirRandom + fileName);
				});
			} // if()

			if ( !random ) {
				// Remove old directory
				if ( fs.existsSync(snapShotDirOld) ) {
					fs.readdirSync(snapShotDirOld).forEach(function(fileName) {
						fs.unlinkSync(snapShotDirOld + fileName);
					});

					fs.rmdirSync(snapShotDirOld);
				} // if()

				// Setup new snapshots folder
				if ( ! fs.existsSync(snapShotDirNew) ) {
					fs.mkdirSync(snapShotDirNew);
				} else {
					fs.renameSync(snapShotDirNew, snapShotDirOld);
					fs.mkdirSync(snapShotDirNew);
				} // if/else()
			} // if()

			return;
		};

		/**
		 * Compares the snapshots.
		 *
		 * @param   {string}  size  The size of snapshots to compare.
		 *
		 * @return  {Boolean}  Comparison of snapshots
		 */
		browser.mediaQuery.compareSnapShots = function(fileName, url, section, callback) {
			if ( browser.mediaQuery.random ) {
				return;
			} // if()

			section     = (typeof section === 'undefined') ? '' : section;
			var newFile  = browser.mediaQuery.snapShotDirNew + fileName;
			var oldFile  = browser.mediaQuery.snapShotDirOld + fileName;
			var fs       = require('fs');

			// Can't Diff what isn't there...
			if ( !fs.existsSync(newFile) || !fs.existsSync(oldFile) ) {
				return;
			} // if()

			// Compare images
			var gm = require('gm');
			gm.compare(newFile, oldFile, function(err, isEqual, equality, raw){
				if (err)  {
					throw err;
				} // if()

				var compareMsg;
				if ( ! isEqual ) {
					compareMsg = '✖   ' + section + ' has changed by ' + equality + '%';
					console.error(compareMsg);
				} else {
					compareMsg = '✔   No change in '  + url + ' ' + section;
					console.error(compareMsg);
				} // if/else()

				browser.mediaQuery.testCallback(callback);

				return true;
			});
		};

		/**
		 * Handles the setup of properties needed.
		 *
		 * @param   {Object}    page      The page configuration values.
		 *
		 * @return  {Void}
		 */
		browser.mediaQuery.init = function(page) {
			// var _ = require('underscore');

			browser.mediaQuery.sizes = {
				large     : (typeof page.sizes.large === 'undefined') ? false : page.sizes.large,
				medium    : (typeof page.sizes.medium === 'undefined') ? false : page.sizes.medium,
				small     : (typeof page.sizes.small === 'undefined') ? false : page.sizes.small,
				xSmallMid : (typeof page.sizes.xSmallMid === 'undefined') ? false : page.sizes.xSmallMid,
				xSmall    : (typeof page.sizes.xSmall === 'undefined') ? false : page.sizes.xSmall,
			};

			browser.mediaQuery.files = [
				'large.png',
				'large-footer.png',
				'medium.png',
				'medium-footer.png',
				'small.png',
				'small-footer.png',
				'x-small-mid.png',
				'x-small-mid-footer.png',
				'x-small.png',
				'x-small-footer.png',
			];


			browser.mediaQuery.url                = page.url;
			browser.mediaQuery.random             = (typeof page.random === 'undefined') ? false : page.random;
			browser.mediaQuery.snapShotDirBase    = 'tests/nightwatch/snapshots/' + page.folder;
			browser.mediaQuery.snapShotDirNew     = browser.mediaQuery.snapShotDirBase + '/new/';
			browser.mediaQuery.snapShotDirOld     = browser.mediaQuery.snapShotDirBase + '/old/';
			browser.mediaQuery.snapShotDirRandom  = browser.mediaQuery.snapShotDirBase + '/random/';
			browser.mediaQuery.snapShotSaveDir    = (browser.mediaQuery.random) ? browser.mediaQuery.snapShotDirRandom : browser.mediaQuery.snapShotDirNew;

			return;
		};

		browser.mediaQuery.test = function(browser, url, testSize, sizePrefix, bannerMsg, widths, callback) {
			// var sizes           = browser.mediaQuery.sizes;

			if (!testSize) {
				browser.mediaQuery.testCallback(callback);
				return;
			} // if()

			var random          = browser.mediaQuery.random;
			var screenWidth     = (random) ? getRandomInt(widths.min, widths.max) : widths.min;
			var snapShotSaveDir = browser.mediaQuery.snapShotSaveDir;
			var suffixWidth     = (random) ? '-' + screenWidth : '';
			var headerImage     = sizePrefix + suffixWidth + '.png';
			var footerImage     = sizePrefix + suffixWidth + '-footer.png';


			// Header
			browser.resizeWindow(screenWidth, 1000, function() {
				browser.mediaQuery.bannerSmall(bannerMsg);

				browser.moveToElement("body", 0, 0, function() {
					browser.waitForElementVisible('body', 1000, function() {
						browser.saveScreenshot(snapShotSaveDir + headerImage, function() {
							// Footer
							browser.moveToElement(".content-info", 0, 0, function() {
								browser.waitForElementVisible('.content-info', 1000, function() {
									browser.saveScreenshot(snapShotSaveDir + footerImage, function() {
										browser.mediaQuery.compareSnapShots(headerImage, url, sizePrefix + ' header', function() {
											browser.mediaQuery.compareSnapShots(footerImage, url, sizePrefix + ' footer', function() {
												browser.mediaQuery.testCallback(callback);
											}); // browser.mediaQuery.compareSnapShots()
										}); // browser.mediaQuery.compareSnapShots()
									}); // browser.saveScreenshot()
								}); // browser.waitForElementVisible()
							}); // browser.moveToElement()
						}); // browser.saveScreenshot()
					}); // browser.waitForElementVisible()
				}); // browser.moveToElement()
			}); // browser.resizeWindow()
		}; // browser.mediaQuery.test()

		browser.mediaQuery.testMedium = function(browser, url, testSize, sizePrefix, bannerMsg, widths, callback) {
			// var sizes           = browser.mediaQuery.sizes;

			if (!testSize) {
				browser.mediaQuery.testCallback(callback);
				return;
			} // if()

			var random          = browser.mediaQuery.random;
			var screenWidth     = (random) ? getRandomInt(widths.min, widths.max) : widths.min;
			var snapShotSaveDir = browser.mediaQuery.snapShotSaveDir;
			var suffixWidth     = (random) ? '-' + screenWidth : '';
			var headerImage     = sizePrefix + suffixWidth + '.png';
			var footerImage     = sizePrefix + suffixWidth + '-footer.png';


			// Header
			browser.resizeWindow(screenWidth, 1000, function() {
				console.log('browser.resizeWindow(screenWidth)');
				browser.mediaQuery.bannerSmall(bannerMsg);
				console.log('browser.mediaQuery.bannerSmall(bannerMsg)');
				browser.moveToElement("body", 0, 0, function() {
					console.log('browser.moveToElement("body")');
					browser.waitForElementVisible('body', 1000, function() {
						console.log('browser.waitForElementVisible(body)');
						browser.saveScreenshot(snapShotSaveDir + headerImage, function() {
							console.log('browser.saveScreenshot(snapShotSaveDir + headerImage)');
							// Footer
							browser.moveToElement(".content-info", 0, 0, function() {
								console.log('browser.moveToElement(".content-info")');
								browser.waitForElementVisible('.content-info', 1000, function() {
									console.log('browser.waitForElementVisible(.content-info)');
									browser.saveScreenshot(snapShotSaveDir + footerImage, function() {
										console.log('browser.saveScreenshot(snapShotSaveDir + footerImage)');
										browser.mediaQuery.compareSnapShots(headerImage, url, sizePrefix + ' header', function() {
											console.log('browser.mediaQuery.compareSnapShots(headerImage)');
											browser.mediaQuery.compareSnapShots(footerImage, url, sizePrefix + ' footer', function() {
												console.log('browser.mediaQuery.compareSnapShots(footerImage)');
												browser.mediaQuery.testCallback(callback);
											}); // browser.mediaQuery.compareSnapShots()
										}); // browser.mediaQuery.compareSnapShots()
									}); // browser.saveScreenshot()
								}); // browser.waitForElementVisible()
							}); // browser.moveToElement()
						}); // browser.saveScreenshot()
					}); // browser.waitForElementVisible()
				}); // browser.moveToElement()
			}); // browser.resizeWindow()
		}; // browser.mediaQuery.test()

		browser.mediaQuery.testCallback = function(callback) {
			if (typeof callback === "function") {
				callback.call();
			} // if()
		}; // browser.mediaQuery.testCallback()

		browser.hmm = function() { console.log('hmm'); };

		/**
		 * Handles taking the snapshots.
		 *
		 * @param   {Object}    page      The page configuration values.
		 * @param   {Function}  callback  The callback to execute once complete.
		 *
		 * @return  {Void}
		 */
		browser.mediaQuerySnapshots = function(page, callback) {
			if (typeof page.url === 'undefined' || page.url === '' || !page.url) {
				return;
			} // if()

			browser.mediaQuery.init(page);

			var self            = this;
			var url             = browser.mediaQuery.url;
			var sizes           = browser.mediaQuery.sizes;

			// Large Size >1200px
			var largeWidths     = { min: 1201, max: 1400, };
			var largeBannerMsg  = 'Testing Large Size width > 1200px';
			var largeSizePrefix = 'large';
			var largeReturn     = (sizes.large && !sizes.medium && !sizes.small && !sizes.xSmallMid && !sizes.xSmall );
			var largeTest       = sizes.large;

			// Medium Size >992px
			var mediumWidths     = { min: 993, max: 1200, };
			var mediumBannerMsg  = 'Testing Medium Size width > 992px';
			var mediumSizePrefix = 'medium';
			var mediumReturn     = (sizes.medium && !sizes.small && !sizes.xSmallMid && !sizes.xSmall );
			var mediumTest       = sizes.medium;

			// Small Size >768px
			var smallWidths     = { min: 769, max: 992, };
			var smallBannerMsg  = 'Testing Medium Size width > 992px';
			var smallSizePrefix = 'medium';
			var smallReturn     = (sizes.small && !sizes.xSmallMid && !sizes.xSmall );
			var smallTest       = sizes.small;

			// X-small Middle Size >480px
			var xSmallMidWidths     = { min: 481, max: 768, };
			var xSmallMidBannerMsg  = 'Testing X-small Mid Size width > 480px';
			var xSmallMidSizePrefix = 'x-small-mid';
			var xSmallMidReturn     = (sizes.xSmallMid && !sizes.xSmall );
			var xSmallMidTest       = sizes.xSmallMid;

			// X-small Size <480px
			var xSmallWidths     = { min: 300, max: 479, };
			var xSmallBannerMsg  = 'Testing X-small Size width < 480px';
			var xSmallSizePrefix = 'x-small';
			var xSmallReturn     = (sizes.xSmall );
			var xSmallTest       = sizes.xSmall;

			// Set the directories up.
			browser.mediaQuery.directoryHelper();

			// Browser location
			browser
			.url(url)
			.waitForElementVisible('body', 1000);

			// Large Size >1200px
			browser.mediaQuery.test(browser, url, largeTest, largeSizePrefix, largeBannerMsg, largeWidths, function() {
				if (largeReturn) {
					if (typeof callback === "function") {
						callback.call(self, true);
					} // if()

					return this;
				} // if()

				return this;
			});

			browser.pause(4000);

			browser.mediaQuery.test(browser, url, mediumTest, mediumSizePrefix, mediumBannerMsg, mediumWidths, function() {
				if (mediumReturn) {
					if (typeof callback === "function") {
						callback.call(self, true);
					} // if()

					return this;
				} // if()
			});

			browser.pause(4000);

			// Small Size >768px
			browser.mediaQuery.test(browser, url, smallTest, smallSizePrefix, smallBannerMsg, smallWidths, function() {
				if (smallReturn) {
					if (typeof callback === "function") {
						callback.call(self, true);
					} // if()

					return this;
				} // if()
			});


			browser.pause(4000);

			// X-small Middle Size >480px
			browser.mediaQuery.test(browser, url, xSmallMidTest, xSmallMidSizePrefix, xSmallMidBannerMsg, xSmallMidWidths, function() {
				if (xSmallMidReturn) {
					if (typeof callback === "function") {
						callback.call(self, true);
					} // if()

					return this;
				} // if()
			});

			browser.pause(4000);

			// X-small Size <480px
			browser.mediaQuery.test(browser, url, xSmallTest, xSmallSizePrefix, xSmallBannerMsg, xSmallWidths, function() {
				console.log(typeof callback === "function");
				if (typeof callback === "function") {
					callback.call(self, true);
				} // if()

				return this;
			});
		}; // browser.mediaQuerySnapshots()

		var _       = require('underscore');
		var siteURL = 'http://mdgbase.dev';
		var pages   = {
			frontPage : {
				folder : 'front-page', // Snapshots parent directory name.
				url    : siteURL,      // URL to test.
				random : false,        // Use random sizes.
				sizes  : {
					large     : false, // >1200px
					medium    : false, // >992px
					small     : true,  // >768px
					xSmallMid : true,  // >480px
					xSmall    : true,  // <480px
				},
			},
		};

		// Loop over all the pages
		_.each(pages, function(value) {
			browser.mediaQuerySnapshots(value, function(){
				console.log('test');
				browser.end();
			});
		});
	}
};