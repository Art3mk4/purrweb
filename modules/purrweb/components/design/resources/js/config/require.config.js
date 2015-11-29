
requirejs.config({

	baseUrl: "webroot/js",

	deps: ["init"],

	paths: {

		// Components
		"app":         "components/app",
		"templates":   "components/templates",
		"boilerplate": "components/boilerplate",
		"router":      "components/router",

		// Libs
		"jquery":       "libs/jquery-1.8.3.min",
		"underscore":   "libs/underscore-min",
		"backbone":     "libs/backbone",
		"validation":   "libs/jquery.validate",
		"select": 		"libs/chosen.jquery.min",

		// Plugins
		"jqueryUi":     "libs/jquery-ui-1.10.3.custom",
		"html5": 		"libs/html5"

		// Models

		// Collections

	},

	shim: {
		"app": {
			deps: ["boilerplate"],
		},
		"jquery": {
			exports: "$"
		},
		"underscore": {
			exports: "_"
		},
		"backbone": {
			deps: ["jquery", "underscore"],
			exports: "Backbone"
		},
		"templates": {
			deps: ["underscore", "text"]
		},
		"router": {
			deps: ["templates"]
		}
	}

});