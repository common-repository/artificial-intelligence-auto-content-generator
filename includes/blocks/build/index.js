/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _momo_auto_content_generator_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./momo-auto-content-generator.js */ "./src/momo-auto-content-generator.js");

/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */
//import { TextControl } from '@wordpress/components';
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

/**
 * Icons
 */




/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {WPElement} Element to render.
 */
const {
  Button,
  Notice,
  ToggleControl,
  Placeholder,
  PanelBody,
  PanelRow,
  Heading,
  SelectControl,
  TextControl,
  Spinner
  /* ServerSideRender, */
} = wp.components;

const {
  Fragment
} = wp.element;
function Edit(_ref) {
  let {
    attributes,
    setAttributes
  } = _ref;
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)();
  const {
    language,
    title,
    noOfPara,
    headingsYesNo,
    headingsWrapper,
    writingStyle,
    introductionYesNo,
    conclusionYesNo,
    imageYesNo,
    hyperlinkYesNo,
    hyperlinkText,
    anchorLink,
    generatedContent,
    isGenerating,
    contentGenerated,
    generatedResult,
    cannotGenerateContent,
    errorMessage
  } = attributes;
  /* const {
      isGenerating,
  } = useState(); */
  const languagearr = Object.entries(momoacg_block_admin.language);
  const writingS = Object.entries(momoacg_block_admin.writing_style);
  /*  setAttributes({cannotGenerateContent : false});
   setAttributes({errorMessage : ''}); */
  let languages = [];
  let writings = [];
  let ajaxMessage, ajaxStatus;
  for (const lang of languagearr) {
    languages.push({
      label: lang[1],
      value: lang[0]
    });
  }
  for (const ws of writingS) {
    writings.push({
      label: ws[1],
      value: ws[0]
    });
  }
  let noofpara = [];
  for (let i = 1; i <= 10; i++) {
    noofpara.push({
      label: i,
      value: i
    });
  }
  const handleGenerateContent = button => {
    setAttributes({
      isGenerating: true
    });
    let options = {};
    options.language = language;
    options.title = title;
    options.noOfPara = noOfPara;
    options.headingsYesNo = headingsYesNo;
    options.headingsWrapper = headingsWrapper;
    options.writingStyle = writingStyle;
    options.introductionYesNo = introductionYesNo;
    options.conclusionYesNo = conclusionYesNo;
    options.imageYesNo = imageYesNo;
    options.hyperlinkYesNo = hyperlinkYesNo;
    options.hyperlinkText = hyperlinkText;
    options.anchorLink = anchorLink;
    console.log(options);
    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4___default()({
      path: "/momoacg/v1/openai-contents/",
      method: "POST",
      data: options
    }).then(res => {
      ajaxStatus = res.status;
      ajaxMessage = res.msg;
      console.log(res);
      if ('good' === ajaxStatus) {
        let content = res.content;
        setAttributes({
          generatedContent: content
        });
        setAttributes({
          contentGenerated: true
        });
        setAttributes({
          cannotGenerateContent: false
        });
      } else {
        setAttributes({
          errorMessage: ajaxMessage
        });
        setAttributes({
          cannotGenerateContent: true
        });
      }
      setAttributes({
        isGenerating: false
      });
    });
  };
  let oldContent = false;
  if (true === contentGenerated) {
    oldContent = true;
  } else {
    oldContent = false;
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
    icon: _icons_js__WEBPACK_IMPORTED_MODULE_3__["default"].content,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Auto Content Generator', 'momoacg'),
    instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select appropriate settings and click generate content button.', 'momoacg')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select Language', 'momoacg'),
    value: language,
    default: 'english',
    options: languages,
    onChange: val => {
      setAttributes({
        language: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Title', 'momoacg'),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Artificial Inteligence', 'momoacg'),
    onChange: val => setAttributes({
      title: val
    }),
    value: title
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Number of Paragraphs', 'momoacg'),
    default: '1',
    value: noOfPara,
    options: noofpara,
    onChange: val => {
      setAttributes({
        noOfPara: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add headings to paragraph', 'momoacg'),
    checked: headingsYesNo,
    onChange: val => {
      setAttributes({
        headingsYesNo: val
      });
    }
  }), true === headingsYesNo && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Wrap heading with', 'momoacg'),
    value: 'h1',
    options: [{
      label: 'H1',
      value: 'h1'
    }, {
      label: 'H2',
      value: 'h2'
    }, {
      label: 'H3',
      value: 'h3'
    }, {
      label: 'H4',
      value: 'h4'
    }, {
      label: 'H5',
      value: 'h5'
    }, {
      label: 'H6',
      value: 'h6'
    }],
    onChange: val => {
      setAttributes({
        headingsWrapper: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Writing Styles', 'momoacg'),
    value: 'informative',
    options: writings,
    onChange: val => {
      setAttributes({
        writingStyle: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Introduction', 'momoacg'),
    checked: introductionYesNo,
    onChange: val => {
      setAttributes({
        introductionYesNo: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Conclusion', 'momoacg'),
    checked: conclusionYesNo,
    onChange: val => {
      setAttributes({
        conclusionYesNo: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Generate Image', 'momoacg'),
    checked: imageYesNo,
    onChange: val => {
      setAttributes({
        imageYesNo: val
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Hyperlink to selected text', 'momoacg'),
    checked: hyperlinkYesNo,
    onChange: val => {
      setAttributes({
        hyperlinkYesNo: val
      });
    }
  }), true === hyperlinkYesNo && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search Text', 'momoacg'),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Artificial Inteligence', 'momoacg'),
    onChange: val => setAttributes({
      hyperlinkText: val
    })
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Anchor Text', 'momoacg'),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('https://', 'momoacg'),
    onChange: val => setAttributes({
      anchorLink: val
    }),
    value: anchorLink
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    variant: "primary",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Generate Content', 'momoacg'),
    onClick: handleGenerateContent,
    disabled: isGenerating
  }, true === isGenerating ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Generating Content', 'momoacg')) : true === oldContent ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Regenerate Content', 'momoacg') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Generate Content', 'momoacg'))))), false === oldContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, {
    icon: _icons_js__WEBPACK_IMPORTED_MODULE_3__["default"].content,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Auto Content Generator', 'momoacg'),
    instructions: momoacg_block_admin.block_help,
    isColumnLayout: true
  }), true === oldContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
    value: generatedContent
    /* allowedFormats={ [ 'core/bold', 'core/italic' ] } */,
    onChange: content => setAttributes({
      generatedContent: content
    }),
    disabled: isGenerating
  }));
}

/***/ }),

/***/ "./src/icons.js":
/*!**********************!*\
  !*** ./src/icons.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const icons = {};
const styles = {
  fill: 'rgba(0, 0, 0, 1)'
};
icons.content = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "24",
  height: "24",
  viewBox: "0 0 24 24",
  style: styles
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
  d: "M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-1 4v2h-5V7h5zm-5 4h5v2h-5v-2zM4 19V5h7v14H4z"
}));
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (icons);

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor. All other files
 * get applied to the editor only.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */



/**
 * Internal dependencies
 */




/**
 * Icons
 */

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_6__.name, {
  title: _block_json__WEBPACK_IMPORTED_MODULE_6__.title,
  description: _block_json__WEBPACK_IMPORTED_MODULE_6__.description,
  icon: _icons_js__WEBPACK_IMPORTED_MODULE_7__["default"].content,
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Content', 'momoacg'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Auto', 'momoacg'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('MoMo', 'momoacg'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('ACG', 'momoacg'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Generator', 'momoacg')],
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_5__["default"]
});

/***/ }),

/***/ "./src/momo-auto-content-generator.js":
/*!********************************************!*\
  !*** ./src/momo-auto-content-generator.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _icons_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./icons.js */ "./src/icons.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);


const {
  Placeholder
} = wp.components;

/**
 * Icons
 */

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

class MoMoAutoContentGenerator extends _wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Component {
  constructor(props, context, attributes) {
    super(props, context);
    this.content = '';
  }
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    console.log(attributes);
    let oldContent = false;
    let options = this.props.options;
    let message = momoacg_block_admin.block_help;
    if ('contentGenerated' in options && true === options.contentGenerated) {
      oldContent = true;
    } else {
      oldContent = false;
    }
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, false === oldContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, {
      icon: _icons_js__WEBPACK_IMPORTED_MODULE_2__["default"].content,
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Auto Content Generator', 'momoacg'),
      instructions: message,
      isColumnLayout: true
    }), true === oldContent && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText, {
      value: options.generatedContent,
      allowedFormats: ['core/bold', 'core/italic'],
      onChange: content => this.setAttributes({
        generatedContent,
        content
      })
    }));
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (MoMoAutoContentGenerator);

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */


/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 * @return {WPElement} Element to render.
 */
function save(_ref) {
  let {
    attributes
  } = _ref;
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps.save();
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    class: "momo-block-generated-content"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText.Content, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({}, blockProps, {
    value: attributes.generatedContent
  }))); // Saves <h2>Content added in the editor...</h2> to the database for frontend display
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["apiFetch"];

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

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ _extends)
/* harmony export */ });
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"momo/acg-block","version":"1.0.0","title":"Auto Content Generator","category":"text","description":"A Gutenberg block to auto generate content from given topic.","attributes":{"message":{"type":"string","source":"text","selector":"div"}},"supports":{"html":false},"textdomain":"momoacg","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkmomo_acg_block"] = globalThis["webpackChunkmomo_acg_block"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map