# [MDG Base](http://base.matchboxdesigngroup.com/)

MDG Base is a WordPress starter theme based on [Roots](http://roots.io), which uses [HTML5 Boilerplate](http://html5boilerplate.com/) & [Bootstrap](http://getbootstrap.com/).  It's here to help make better themes.

* Source: [https://github.com/matchboxdesigngroup/mdg-base](https://github.com/matchboxdesigngroup/mdg-base)

===
###Quick Start Prerequisites
- Node [http://nodejs.org/](http://nodejs.org/)
- Bower Package Manager `npm install -g bower` [http://bower.io/](http://bower.io/)
- Composer `curl -sS https://getcomposer.org/installer | php` [http://getcomposer.org/](http://getcomposer.org/)

###Quick Start
1. cd /path/to/mdg-base/
2. chmod +x dev-assets/init.sh
3. ./init.sh

#Folder Sturcutre
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