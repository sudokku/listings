/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/listing-info/block.json":
/*!****************************************!*\
  !*** ./blocks/listing-info/block.json ***!
  \****************************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"listings/listing-info","version":"1.0.0","title":"Listing Info","category":"widgets","icon":"admin-home","description":"Display information about a single listing.","attributes":{"listingId":{"type":"number","default":0},"showTitle":{"type":"boolean","default":true},"showPrice":{"type":"boolean","default":true},"showImage":{"type":"boolean","default":true},"showExcerpt":{"type":"boolean","default":true},"showRooms":{"type":"boolean","default":true},"showArea":{"type":"boolean","default":true}},"supports":{"html":false},"textdomain":"listings","editorScript":"file:./index.js","editorStyle":"file:./editor.css","style":"file:./style.css","render":"file:./render.php"}');

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**************************************!*\
  !*** ./blocks/listing-info/index.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./block.json */ "./blocks/listing-info/block.json");







(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_6__.name, {
  edit: function Edit({
    attributes,
    setAttributes
  }) {
    const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps)();
    const {
      listingId,
      showTitle,
      showPrice,
      showImage,
      showExcerpt,
      showRooms,
      showArea
    } = attributes;

    // Fetch all listings for the dropdown
    const listings = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
      return select('core').getEntityRecords('postType', 'listing', {
        per_page: -1,
        _embed: true
      });
    }, []);

    // Fetch selected listing with meta fields
    const listing = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => {
      if (!listingId) return null;
      return select('core').getEntityRecord('postType', 'listing', listingId, {
        _embed: true,
        _fields: ['id', 'title', 'excerpt', 'meta', '_embedded']
      });
    }, [listingId]);
    if (!listingId) {
      return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        ...blockProps
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "components-placeholder"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "components-placeholder__label"
      }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Listing Info', 'listings')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "components-placeholder__instructions"
      }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Please select a listing to display its information.', 'listings')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Select a listing', 'listings'),
        value: listingId,
        options: [{
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Select a listing', 'listings'),
          value: 0
        }, ...(listings || []).map(listing => ({
          label: listing.title.rendered,
          value: listing.id
        }))],
        onChange: value => setAttributes({
          listingId: parseInt(value)
        })
      })));
    }
    if (!listing) {
      return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        ...blockProps
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Spinner, null));
    }

    // Safely access meta fields with fallbacks
    console.log(listing);
    const meta = listing.meta || {};
    const {
      _listing_price = '',
      _listing_sale_price = '',
      _listing_rooms = '',
      _listing_area = ''
    } = meta;
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Listing Settings', 'listings')
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Select a listing', 'listings'),
      value: listingId,
      options: [{
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Select a listing', 'listings'),
        value: 0
      }, ...(listings || []).map(listing => ({
        label: listing.title.rendered,
        value: listing.id
      }))],
      onChange: value => setAttributes({
        listingId: parseInt(value)
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Title', 'listings'),
      checked: showTitle,
      onChange: () => setAttributes({
        showTitle: !showTitle
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Price', 'listings'),
      checked: showPrice,
      onChange: () => setAttributes({
        showPrice: !showPrice
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Image', 'listings'),
      checked: showImage,
      onChange: () => setAttributes({
        showImage: !showImage
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Excerpt', 'listings'),
      checked: showExcerpt,
      onChange: () => setAttributes({
        showExcerpt: !showExcerpt
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Rooms', 'listings'),
      checked: showRooms,
      onChange: () => setAttributes({
        showRooms: !showRooms
      })
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.ToggleControl, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show Area', 'listings'),
      checked: showArea,
      onChange: () => setAttributes({
        showArea: !showArea
      })
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      ...blockProps
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-info-block"
    }, showImage && listing._embedded?.['wp:featuredmedia']?.[0] && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-image"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: listing._embedded['wp:featuredmedia'][0].source_url,
      alt: listing.title.rendered
    })), showTitle && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
      className: "listing-title"
    }, listing.title.rendered), showPrice && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-price"
    }, _listing_sale_price ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "sale-price"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Sale Price:', 'listings'), " $", _listing_sale_price), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "original-price"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Original Price:', 'listings'), " $", _listing_price)) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "regular-price"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Price:', 'listings'), " $", _listing_price)), showExcerpt && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-excerpt"
    }, listing.excerpt.rendered), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-details"
    }, showRooms && _listing_rooms && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-rooms"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Rooms:', 'listings')), _listing_rooms), showArea && _listing_area && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "listing-area"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Area:', 'listings')), _listing_area, " m\xB2")))));
  },
  save: function Save() {
    return null; // Dynamic block, render handled by PHP
  }
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map