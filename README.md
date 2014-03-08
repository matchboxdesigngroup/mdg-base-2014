# [MDG Base](http://base.matchboxdesigngroup.com/)

MDG Base is a WordPress starter theme based on [Roots](http://roots.io), which uses [HTML5 Boilerplate](http://html5boilerplate.com/) & [Bootstrap](http://getbootstrap.com/).  It's here to help make better themes.

* Source: [https://github.com/matchboxdesigngroup/mdg-base](https://github.com/matchboxdesigngroup/mdg-base)

===
###All Theme Dependencies/Tools Install Info
####[Node.js](http://nodejs.org/)
- [Bower](http://bower.io/) `npm install -g bower`
- [Uglify](https://github.com/mishoo/UglifyJS2) `npm install -g uglify-js`
- [JSCS](https://github.com/mdevils/node-jscs) `npm install -g jscs`
- [JSHint](http://www.jshint.com/docs/) `npm install -g jshint`
- [Grunt-CLI](http://gruntjs.com/) `npm install -g grunt-cli`
- [Browser Sync](https://github.com/shakyShane/browser-sync) `npm install -g browser-sync`
- [JSDoc](https://github.com/jsdoc3/jsdoc) (work in progress)

####[Growl/Growl Notify](http://growl.info/) ( for grunt-notify )

####[Homebrew](http://brew.sh/)
- [Homebrew PHP](https://github.com/josegonzalez/homebrew-php/)
- PHP 5.5 `brew php55`
- [Composer](http://getcomposer.org/) `brew composer`
- [PHPDocumentor](http://www.phpdoc.org/) `brew phpdocumentor`
	
####[RVM/Ruby](http://rvm.io/)
- [SASS](http://sass-lang.com/install) `gem install sass`
- [SCSSLint](https://github.com/causes/scss-lint) `gem install scss-lint`

===

###Quick Start Prerequisites
- Node.js
- Bower
- Composer

###Quick Start
1. cd /path/to/mdg-base/
2. chmod +x dev-assets/init.sh
3. ./init.sh

===
####PHP Documentation (work in progress)
docs/php/index.html

===
####JSDocs (work in progress)

===
####Setup vHost (MAMP)
1. Create file `/Applications/MAMP/conf/apache/vhosts.conf`
2. Add a vHost to `/Applications/MAMP/conf/apache/vhosts.conf`

	```
	# NOTE: Change *:80 to *:8888 if not using default apache ports
	# NOTE: Change Sitename to your sitename.extension, I suggest using sitename.dev 
	<VirtualHost *:80>  
	ServerName sitename.dev
	DocumentRoot /Applications/MAMP/htdocs/sitename
	<Directory /Applications/MAMP/sitename/>
	Options Indexes FollowSymLinks MultiViews
	AllowOverride All
	Order allow,deny
	allow from all
	</Directory>
	</VirtualHost>
	```
3. Include `vhosts.conf` in `/Applications/MAMP/conf/apache/http.conf`

	```
	# NOTE: Change *:80 to *:8888 if not using default apache ports
	NameVirtualHost *:80
	Include /Applications/MAMP/conf/apache/vhosts.conf
	```
4. Add site to `/etc/hosts` with nano, vim, or other editor `127.0.0.1 sitename.dev` 
5. Restart server
6. Access site at http://sitename.dev
7. To add more sites duplicate steps 2(add vHost) and 4(add site to hosts)

===
####Query Examples

#####Default WP_Query
```
$custom_query_args = array(
	'post_type'      => $this->post_type,
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'order'          => 'DESC',
	'orderby'        => 'date',
);
$custom_query = new WP_Query( $custom_query_args );
$custom       = $custom_query->get_posts();
```
#####MDG_Custom_Post_Type Query
- Builds in transient caching
- Returns the exact same data as the default WP_Query above.
- Should not be used with orderby random or if you are using a drag/drop sorting plugin when using orderly menu_order 

```
// Default
global $mdg_custom_post_type;
$custom_query_args = array();
$custom            = $mdg_custom_post_type->get_posts( $custom_query_args );

// Custom Arguments (Accepts anything that WP_Query does)
$custom_query_args = array(
	'posts_per_page' = 10,
);
$custom = $mdg_custom_post_type->get_posts( $custom_query_args ); // Returns the last 10 posts
```

===
####Custom Meta Example(work in progress)

===

###Folder Sturcutre
```
├── assets  
│   ├── bower_components (Bower componenets)
│   ├── css (Minified production CSS files)
│   │   └── scss
│   │       ├── admin (SCSS for wp-admin styles)
│   │       ├── plugins (SCSS for plugins not managed by bower)
│   │       └── site (SCSS for front end styles)
│   ├── fonts (@font-face fonts)
│   ├── img (Front end images)
│   │   ├── admin (Images for use in wp-admin)
│   │   └── plugins (Images for plugins not managed by bower)
│   └── js (Minified production JavaScript files)
│       ├── src (All JavaScript source files)
│       │   ├── admin (JavaScript for wp-admin)
│       │   ├── plugins (JavaScript/jQuery plugins/libs not maintained by bower)
│       │   └── site (JavaScript for the front end)
│       └── vendor (External Javascript not concatenated into site.min.js)
├── classes (Post Type base classes and other helper classes)
├── dev-assets (Storage for files used during development)
├── lang (Language local files)
├── lib (Configuration)
└── templates (Content templates)
```